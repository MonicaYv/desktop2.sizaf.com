<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\File;
use App\Models\Folder;
use App\Models\LightApp;
use App\Models\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Filefunctions;


class SearchController extends Controller
{
    protected $filefunctions;

    public function __construct(Filefunctions $filefunctions){
        $this->filefunctions = $filefunctions;
    }
    public function search(Request $request)
    {
        $apps = App::all();
        $query = $request->input('query');
        $createdBy = auth()->id();
        $files = File::select('extension', 'name', 'parentpath', 'path', 'filetype') // Select specific columns
            ->where('name', 'like', "%$query%")
            ->where('created_by', $createdBy)
            ->where('status', 1)
            ->where('folder', 0)
            ->orderBy('extension')
            ->orderBy('name') // Add secondary sorting by name
            ->get();
        $filesByExtension = [];
        foreach ($files as $file) {
            $filesByExtension[$file->extension][] = [
                'name' => $file->name,
                'extension' => $file->extension,
                'parentpath' => $file->parentpath,
                'path' => $file->path,
                'filetype' => $file->filetype,
            ];
        }
        $folders = File::where('name', 'like', "%$query%")
            ->where('created_by', $createdBy)
            ->where('status', 1)
            ->where('folder', 1)
            ->orderBy('name')
            ->get();
        $results = [
            'files' => $filesByExtension,
            'folders' => $folders
        ];
        $html = view('appendview.search')->with('results', $results)->render();
        return response()->json(['html' => $html]);
    }


    public function listalliframe(Request $request)
    {
        $iframearray = [];
        $filetype='';
        $filekey ='';
        if (!empty($request->input('appkey')) && !empty($request->input('filekey') && $request->input('filetype') && !empty($request->input('apptype')))) {
            $filekey = $request->input('filekey');
            $appkey = $request->input('appkey');
            $apptype = $request->input('apptype');
            $filetype = $request->input('filetype');
            $appdet = ($apptype == "app") ? App::find(base64UrlDecode($appkey)) : LightApp::find(base64UrlDecode($appkey));
            
            if($filetype =="file" || $filetype =="folder"){
                $file = File::find(base64UrlDecode($filekey));
            }else{
                $file = $appdet;
            }
            
            
            if(!empty($file) && !empty($appdet)){
                if($filetype =='file'){
                    $filegroup =  checkFileGroup($file->extension);
                    if($filegroup !='editor'){
                        $iframeurllink = url('dotsviewer/'.$filegroup.'/'.$filekey);
                    }else{
                        $iframeurllink = url('editfile/'.$filekey);
                    }
                    
                    
                }else if($filetype =='folder'){
                    $iframeurllink = url('filemanager',['path'=>base64UrlEncode($file->path)]);
                }else{
                    if($filetype =='app'){
                        if($appdet->type=='folder'){
                            $iframeurllink = url('filemanager',['path'=>base64UrlEncode($appdet->path)]);

                        }else{
                            $iframeurllink = url($appdet->link);
                        }
                    }else{
                        if($appdet->function=="createdocument"){
                            $newarr = $this->filefunctions->createNewFile($appdet->fileextension, 'Document');
                            if($newarr){
                                $file = File::find($newarr['filekey']);
                                $iframeurllink = $iframeurllink = url('editfile/'.base64UrlEncode($newarr['filekey']));
                                $filekey = base64UrlEncode($newarr['filekey']);
                            }else{
                                return response()->json(['status'=>false,'message'=> 'Something Went wrong try again']);
                            }
                          
                        }else{
                            $iframeurllink = $appdet->link;
                        }
                    }
                }
            }

            //print_r($apptype);die;
            $newArray = [
                'filekey' =>base64UrlEncode($file->id),
                'filetype' => $filetype,
                'appkey' => $appkey,
                'apptype' => $apptype,
                'appicon' => $appdet->icon,
                'filename' => $file->name,
                'appname' => $appdet->name,
                'iframeurl' => $iframeurllink
            ];
           
      if (Session::has('iframeapp')) {
            $iframearray = Session::get('iframeapp');
            if (isset($iframearray[$appkey])) {
                $appArray = $iframearray[$appkey];
                unset($iframearray[$appkey]);
                $iframearray = array_merge([$appkey => $appArray], $iframearray);
                $found = false;
                foreach ($iframearray[$appkey] as $key => $subArray) {
                    if ($subArray['filekey'] === $filekey) {
                        unset($iframearray[$appkey][$key]);
                        $iframearray[$appkey] = array_merge([$newArray], $iframearray[$appkey]);
                        $found = true;
                        break;
                    }
                }
        
                if (!$found) {
                    $iframearray[$appkey] = array_merge([$newArray], $iframearray[$appkey]);
                }
            } else {
                $iframearray[$appkey] = [$newArray];
            }

        }else{
            $iframearray[$appkey] = [$newArray];
        }
        Session::put('iframeapp', $iframearray);
        
        }
        $iframearray = Session::get('iframeapp');
        $html = view('appendview.iframe')->with('iframeapp', $iframearray)->render();
        $html2 = view('appendview.iframetab')->with('iframeapp', $iframearray)->render();
        $iframekey = 'iframepopup' . $filetype . $filekey;
        return response()->json(['status'=>true,'html' => $html, 'html2' => $html2, 'filekey' => $iframekey]);
    }


    public function closeiframe(Request $request)
    {
        if ($request->input('appkey')) {
            $filekey = $request->input('filekey');
            $appkey = $request->input('appkey');
            $filetype = $request->input('filetype');
            if (Session::has('iframeapp')) {
                $iframearray = Session::get('iframeapp');
    
                if (isset($iframearray[$appkey])) {
                    $currentApp = $iframearray[$appkey];
    
                    if (count($iframearray[$appkey]) == 1) {
                        unset($iframearray[$appkey]);
                    } else {
                            if ($iframearray[$appkey] == $appkey) {
                                foreach($iframearray[$appkey] as $appkey=>$appval){
                                    if($appval['filekey']==$filekey){
                                        // print_r($appval['filekey']);die;
                                        unset($iframearray[$appkey][$appkey]['filekey']);
                                        $iframearray = array_values($iframearray);
                                        break;
                                    }
                                    
                                }
                                
                            }
                        
                    }
    
                    if (empty($iframearray)) {
                        Session::forget('iframeapp');
                    } else {
                        Session::put('iframeapp', $iframearray);
                    }
                }
            }
        }

        $finalarray = (Session::has('iframeapp')) ? Session::get('iframeapp') : array();
        $html = view('appendview.iframe')->with('iframeapp', $finalarray)->render();
        $html2 = view('appendview.iframetab')->with('iframeapp', $finalarray)->render();

        return response()->json(['html' => $html, 'html2' => $html2]);
    }
}
