<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Filefunctions;
use App\Models\File as FileModel ;
use App\Models\User;
use App\Models\LightApp;
use App\Models\ContextType;
use App\Models\App;
use App\Models\RecycleBin;
use App\Helpers\PermissionHelper;




class FileManagerController extends Controller
{
    protected $filefunctions;
    public function __construct(Filefunctions $filefunctions)
    {
        $this->filefunctions = $filefunctions;
        $this->middleware('auth');
         $user = User::find(auth()->id());
        $this->username = ($user) ? $user->name : '';
    }

    public function index($path=null)
    {
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        //$path = $path ? base64UrlDecode($path) : '/';
        $contextTypes = ContextType::with(['contextOptions' => function($query) {
            $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
        }])
        ->where('display_header', 1)
        ->where('function','createFileFunction')
        ->orderBy('sort_order', 'asc') // Sort context types by sort_order
        ->get();
        $resizecontextTypes = ContextType::with(['contextOptions' => function($query) {
            $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
        }])
        ->where('display_header', 1)
        ->where('function','resizeFunction')
        ->orderBy('sort_order', 'asc') // Sort context types by sort_order
        ->get();
        $sortcontextTypes = ContextType::with(['contextOptions' => function($query) {
            $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
        }])
        ->where('display_header', 1)
        ->where('function','sortFunction')
        ->orderBy('sort_order', 'asc') // Sort context types by sort_order
        ->get();
        $path = $path ? $path : '/';
        return view('filemanager',compact('path','contextTypes','resizecontextTypes','sortcontextTypes'));
    }
    
    public function recyclebin($path=null)
    {
        //$path = $path ? base64UrlDecode($path) : '/';
        $path = $path ? $path : '/';

        return view('filemanager',compact('path'));
    }
    public function editfile($fileid){
        $file = FileModel::find(base64UrlDecode($fileid));
        $options = [];
        if($file){
        $fileExt = $file->extension;
        $fileName = $file->name;
       // $callbackUrl = route('savedocument');
        $fileUrl = url(Storage::url('app/root/'.$file->path));
        $token = $fileid.base64UrlEncode($file->extension);
        $user = User::find(auth()->id());
        $userName = "admin";
        if ($user) {
            $userName = $user->name;
        }

        $options = [
            'document' => [
                'fileType' => $this->filefunctions->fileTypeAlias($fileExt),
                'key' => $token,
                'title' => $fileName,
                'url' => $fileUrl,
                'permissions' => [
                    'download' => true,
                    'edit' => true,
                    'print' => true,
                ],
                'version' => true,
            ],
            'documentType' => $this->filefunctions->getDocumentType($fileExt),
            'type' => 'desktop',
            'editorConfig' => [
                'callbackUrl' => '',
                'lang' =>"en",
                'mode' => 'edit',
                'user' => [
                    'id' => auth()->id(),
                    'name' => $userName,
                ],
                'customization' => [
                    'autosave' => true,
                    'chat' =>  true,
                    'commentAuthorOnly' => true,
                    'comments' =>  true,
                    'compactHeader' => false,
                    'compactToolbar' => false,
                    'help' =>  false,
                    'toolbarNoTabs' => true,
                    'hideRightMenu' => true,
                ],
            ],
            'height' => "100%",
            'width' => "100%"
        ];
        
        }
        return view('editor',compact('options'));
    }
    public function createFolder(Request $request){
        $filemanager = App::where('name','Filmanager')->where('status',1)->first();;
        $parentFolder = base64UrlDecode($request->input('parentFolder'));
        $childFolder = 'New Folder';
        $parentFolderPath = Storage::disk('root')->path($parentFolder);    
        $childFolderPath = $parentFolderPath . '/' . $childFolder;
        $actualpath = $parentFolder.'/'.$childFolder;
        if (!File::exists($parentFolderPath)) {
            return response()->json(['status' => false, 'message' => 'Path does not exist.']);
        }
    
        $counter = 1;
        $originalChildFolderPath = $childFolderPath;
    
        // Check if the child folder already exists and append a number if necessary
        while (File::exists($childFolderPath)) {
            $childFolderPath = $originalChildFolderPath . ' (' . $counter . ')';
            $actualpath = $parentFolder.'/'.$childFolder. ' (' . $counter . ')';;
            $counter++;
        }
    
        
        $newFolder = new FileModel();
        $newFolder->folder = 1;
        $newFolder->extension = 'folder';
        $newFolder->name = basename($childFolderPath);
        $newFolder->parentpath = $parentFolder;
        $newFolder->path = $actualpath;
        $newFolder->openwith = ($filemanager) ? $filemanager->id : '';
        $newFolder->sort_order = 0; // Adjust as needed
        $newFolder->status = 1; // Assuming 1 means active
        $newFolder->created_by = auth()->id(); // Assuming you want to save the ID of the authenticated user
        if ($newFolder->save()) {
            File::makeDirectory($childFolderPath, 0755, true);
        }
       
    
        return response()->json(['status' => true,'message' => 'Folder sucessfully created', 'folderName' => basename($childFolderPath)]);

    }
    
    public function createFile(Request $request)
    {
        $fileatype = $request->input('filetype');
        $destinationParentPath = base64UrlDecode($request->input('destination')); // 
        $resultarr = $this->filefunctions->createNewFile($fileatype, $destinationParentPath);
        if($resultarr){
            return response()->json(['status' => true, 'message' => 'File sucessfully created','fileName' =>$resultarr['filename'],'filekey'=>$resultarr['filekey']]);

        }else{
            return response()->json(['status' => false, 'message' => 'Path does not exist']);

        }
    }
    
     public function pathfiledetail(Request $request){
         // Get the updated app list HTML
            $filepath = base64UrlDecode($request->input('path'));
            $parentPath = empty($filepath) ? '/' : $filepath ; // Adjust this path as needed
            $defaultfolders = array();
            $files = array();
            $sortby= !empty($request->input('sort_by')) ? $request->input('sort_by') : 'id';
            $sortorder= !empty($request->input('sort_order')) ? $request->input('sort_order') : 'asc';
            if($filepath != 'RecycleBin'){
                $defaultfolders = App::where('parentpath',$parentPath)->where('filemanager_display', 1)->where('status', 1)->orderBy('name')->get();
                $files = FileModel::where('parentpath', $parentPath)->where('status', 1)->where('created_by', auth()->id())->orderBy($sortby, $sortorder)->get();
            }else{
                $files = RecycleBin::where('tablename', 'file')->where('file_created_by', auth()->id())->get();
            }
            $html = view('appendview.pathview')->with('defaultfolders', $defaultfolders)->with('files', $files)->render();
        return response()->json(['html' => $html,'parentPath'=>$parentPath]);

    }
    
   public function upload(Request $request)
    {
        $uploadDirectorypath = base64UrlDecode($request->header('Upload-Directory'));

        $uploadedFiles = [];
        $uploadDirectory =  Storage::disk('root')->path($uploadDirectorypath); // Directory to store uploaded files
    
        // Create the directory if it doesn't exist
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }
    
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $filePath = $uploadDirectory . DIRECTORY_SEPARATOR . $originalName;
                $actualpath = $uploadDirectorypath . DIRECTORY_SEPARATOR . $originalName;
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                // Check if file with same name already exists
                $count = 1;
                while (file_exists($filePath)) {
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                    $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $originalName = $fileName . " ($count)." . $fileExtension;
                    $filePath = $uploadDirectory . DIRECTORY_SEPARATOR . $originalName;
                    $actualpath = $uploadDirectorypath . DIRECTORY_SEPARATOR . $originalName;
                    $count++;
                }
    
                // Move the file to the upload directory
                if (move_uploaded_file($file->getPathname(), $filePath)) {
                    $filetype = $this->filefunctions->getFiletype($filePath);
                    $newFile = new FileModel();
                    $newFile->name = $originalName;
                    $newFile->extension = $fileExtension;
                    $newFile->filetype = $filetype;
                    $newFile->parentpath = $uploadDirectorypath;
                    $newFile->path = $actualpath;
                    $newFile->size = $file->getSize();
                    $newFile->status = 1; // Assuming 1 means active
                    $newFile->created_by = auth()->id(); // Assuming you want to save the ID of the authenticated user
                    if ($newFile->save()) {
                    
                        $uploadedFiles[] = [
                            'name' => $originalName,
                            'size' => $file->getSize(),
                            'path' => $actualpath
                        ];
                    }
                }
            }
        }
    
        return response()->json(['files' => $uploadedFiles]);
    }

    
    
    public function copyFile(Request $request)
    {
        $file = array('filepath'=>$request->filepath,'type'=>$request->type,'filekey'=>$request->filekey,'filetype'=>$request->filetype);
         Session::put('copyfilepath', $file);

        return response()->json(['message' => 'File '.$request->type.' successfully!', 'file_path' => $request->filepath,'status'=>true]);
    }

    public function pasteFile(Request $request)
    { 
        $destination = base64UrlDecode($request->path);
        
        if(Session::has('copyfilepath')){
              $sessionarr = Session::get('copyfilepath');
              $activefiletype = $sessionarr['filetype'];
              $id = base64UrlDecode($sessionarr['filekey']);
              $sourcepath = base64UrlDecode($sessionarr['filepath']);
              $destinationPath = Storage::disk('root')->path($destination);
              $sourcePath = Storage::disk('root')->path($sourcepath);
              $renamesource = storage_path('root/'.$destination);
              $renamedestination = storage_path('root/'.$destination);
              //print_r($sourcepath);exit;
              if (file_exists($sourcePath)) {
                  $filename = pathinfo($sourcePath, PATHINFO_BASENAME);
                          if($sessionarr['type'] == 'copy'){
                            $newFileName = File::name($filename).' - Copy';
                            $count = 1;
                            $destinationfile = $destination.'/'.$newFileName;
                            $destinationPath = $destinationPath.'/'.$newFileName;
                            while (file_exists($destinationPath)) {
                               
                                $newFileName = File::name($filename).' - copy ('.($count).')';
                                $destinationfile = $destination.'/'.$newFileName;
                                $destinationPath = $destinationPath.'/'.$newFileName;
                                $count++;
                            }
                            if($activefiletype !='folder'){
                                $newFileName = $newFileName.'.'.File::extension($filename);
                                $copyfiles = Storage::disk('root')->copy($sourcepath, $destinationfile.'.'.pathinfo($sourcepath, PATHINFO_EXTENSION));
                            }else{
                                $newFileName = $newFileName;
                                $copyfiles = File::copyDirectory($sourcePath, $destinationPath);

                            }
                            if($copyfiles){
                            //if (copy($sourcePath, $destinationPathname)) {
                                $fileatype = pathinfo($sourcePath, PATHINFO_EXTENSION);
                                 if($activefiletype !='folder'){
                                        if($fileatype=='pptx'){
                                            $checkapp = 'PPT';
                                        }else if( $fileatype=='xlsx'){
                                            $checkapp = 'EXCEL';
                                        }else{
                                            $checkapp = 'Docx';
                                        }
                                    $lightapp = LightApp::where('name',$checkapp)->where('status',1)->first();;
                                    $filetype = File::extension($filename);
                                    $newFile = new FileModel();
                                    $newFile->name = $newFileName;
                                    $newFile->extension = $fileatype;
                                    $newFile->filetype = $filetype;
                                    $newFile->parentpath = $destination;
                                    $newFile->path = $destination.'/'.$newFileName;
                                    $newFile->openwith = ($lightapp) ? $lightapp->id : '';
                                    $newFile->status = 1; // Assuming 1 means active
                                    $newFile->created_by = auth()->id(); 
                                    $newFile->save();
                                 }else{
                                        $filemanager = App::where('name','Filmanager')->where('status',1)->first();
                                        $newFolder = new FileModel();
                                        $newFolder->folder = 1;
                                        $newFolder->extension = 'folder';
                                        $newFolder->name = $newFileName;
                                        $newFolder->parentpath = $destination;
                                        $newFolder->path = $destination.'/'.$newFileName;
                                        $newFolder->openwith = ($filemanager) ? $filemanager->id : '';
                                        $newFolder->sort_order = 0; // Adjust as needed
                                        $newFolder->status = 1; // Assuming 1 means active
                                        $newFolder->created_by = auth()->id(); 
                                        $newFolder->save();
                                        $folderallfiles = FileModel::where('parentpath', $sourcepath)->get();
                                        if ($folderallfiles->isNotEmpty()) {
                                            foreach ($folderallfiles as $allfiles) {
                                                $newRow = $allfiles->replicate(); 
                                                $newRow->parentpath = $destination.'/'.$newFileName;
                                                $newRow->path = $destination.'/'.$newFileName.$allfiles->name;
                                                $newRow->created_at = now();
                                                $newRow->save();
                                            }
                                        
                                        }
                                 }
                                
                                return response()->json(['message'=>'Pasted Successfully','status' => true]);
                    
                            }else{
                                return response()->json(['message' => 'Failed to paste!','status'=>false]);

                            }
                        }else{
                            
                            if(rename($sourcePath, $destinationPath.'/'.basename($sourcePath))) {
                                    FileModel::where('id', $id)->update([
                                        'path' => $destination.'/'.basename($sourcePath),
                                        'parentpath' => $destination,
                                    ]);
                                
                                return response()->json(['message'=>'Pasted Successfully','status' => true]);
                            }
                        }
                  
              }
              
        }

        return response()->json(['message' => 'Failed to paste file!','status'=>false]);
    }
    
    
    public function downloadFile($id)
    {
        $id = base64UrlDecode($id);
        $file = FileModel::findOrFail($id);
        $filePath = Storage::disk('root')->path($file->path);
        $fileName = basename($filePath);
        return response()->download($filePath, $fileName,['Content-Disposition' => 'attachment']);
    }
    
    public function renameFile(Request $request){
        $type = $request->input('filetype');
       
        $id = base64UrlDecode($request->input('filekey'));
        $newName = $request->input('name');
        if(empty($newName)){
             return response()->json(['message' => 'Please enter something to rename.','status'=>false]);
        }else{

            $exists = FileModel::where('name', $newName)->exists();
            if ($exists) {
                return response()->json(['message' => 'A file with this name already exists.','status'=>false]);
            }
            
            $file = FileModel::findOrFail($id);
            if($file){
                $destination = $file->path;
                $destinationPath = Storage::disk('root')->path($destination);
                $sourcePath = Storage::disk('root')->path($file->parentpath);
                if($type != 'folder') {
                    $fileExtension = pathinfo($destinationPath, PATHINFO_EXTENSION);
                    $newfileextension  = pathinfo($newName, PATHINFO_EXTENSION);
                    $finalname = ($newfileextension) ? $newName : $newName.'.'.$fileExtension;
                    if(rename($destinationPath, $sourcePath.'/'. $finalname)) {
                        $file->name = $finalname;
                        $file->path = $file->parentpath.'/'.$finalname;
                        $file->save();
                    }
                }else{
                    if(rename($destinationPath, $sourcePath.'/'.$newName)) {
                        $file->name = $newName;
                        $file->path = $file->parentpath.'/'.$newName;
                        $file->save();
                     }
                }
            }
    }

        return response()->json(['message' => 'Renamed successfully.','status'=>true]);

        
    }
    
     public function deleteFile(Request $request){
         
         // Assume the condition value is passed as a request parameter
        $type = $request->input('filetype');
        $id = base64UrlDecode($request->input('filekey')); 
            $file = FileModel::where('id', $id)->get();
            if($file){
                $transformedData = $file->map(function ($item) {
                    return [
                        'folder' => $item->folder,
                        'name' => $item->name,
                        'extension' => $item->extension,
                        'filetype' => $item->filetype,
                        'parentpath' => $item->parentpath,
                        'path' => $item->path,
                        'openwith' => $item->openwith,
                        'tablename' => 'file',
                        'file_created_by' => $item->created_by,
                        'created_by' => auth()->id(),
                        'file_created_at' => $item->created_at,
                        'file_updated_at' => $item->updated_at,
                    ];
                });
            }
    
        $deleteddata = RecycleBin::insert($transformedData->toArray());
        if($deleteddata){
                FileModel::where('id', $id)->delete();
            
            return response()->json(['message' => 'File deleted Successfully','status'=>true]);

        }else{
            return response()->json(['message' => 'Something went wrong try again','status'=>false]);

        }

     }
    
    

    public function contextMenu(Request $request){
        $clicktype = $request->input('type');
        if($clicktype=='rightclick'){
        $contextTypes = ContextType::with(['contextOptions' => function($query) {
            $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
        }])
        ->where('show_on', 'rightclick')
        ->orderBy('sort_order', 'asc') // Sort context types by sort_order
        ->get();
        }else{
            $contextTypes = ContextType::with(['contextOptions' => function($query) {
                $query->orderBy('sort_order', 'asc'); // Sort options by sort_order
            }])
            ->whereIn('show_on', [$clicktype, 'all'])
            ->orderBy('sort_order', 'asc') // Sort context types by sort_order
            ->get();
        }
        $html = view('appendview.clickoption')->with('contextTypes', $contextTypes)->with('type',$clicktype)->render();
        return response()->json(['html' => $html]);
    }
    
}