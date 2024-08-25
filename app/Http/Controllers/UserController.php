<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Roles;
use App\Models\Permissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Helpers\PermissionHelper;


use Validator;

class UserController extends Controller
{

    public function __construct()
    {
        //commented for development
        $this->middleware('auth');
    }

    public function index($id = '')
    {
        if ($id) {
            $users = User::find($id);
            return view('users.index', compact('users'));
        } else {
            $users = User::get();
            return view('users.index', compact('users'));
        }
    }

    public function userGroup()
    {
        $users = User::get();
        $users = json_encode($users);
        return view('users.users', compact('users'));
    }

    public function userAdmin()
    {
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        $groups = Group::get();
        $roles = Roles::get();
        $permissions = Permissions::get();
        $users = User::with(['roles', 'group'])->paginate(10);
        return view('userlist', compact('groups', 'roles', 'users', 'permissions', 'filteredPermissions'));
    }

    public function usersList(Request $request)
    {
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        $input = $request->all();
        if ($input['searchTerm']) {
            $search = $input['searchTerm'];
            $users = User::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $users = User::paginate(10);
        }
        $user = view('appendview.userlist')->with('users', $users)->with('filteredPermissions',$filteredPermissions)->render();
        return response()->json($user);
    }

    public function add()
    {
        $groups = Group::get();
        $roles = Roles::get();
        return view('users.add', compact('groups', 'roles'));
    }

    public function create(Request $request)
    {
        $duplicate = User::where('email', $request->email)->exists();
        if ($duplicate == 1) {
            return  redirect()->route('useradmin')->with('user-exist', 'test');
        }
        if(preg_replace('/^[A-Za-z0-9 ]+$/', '', $request->name)){
                return  redirect()->route('useradmin')->with('user-special', '');
            }

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $input = $request->all();
            $input['ip_address'] =  $request->ip();
            $input['password'] = Hash::make($request->password);
            $user = User::create($input);
            if ($user) {
                $username = $input['name'];
                $email = $user->email;
                $url = url('/') . '/login?username=' . $username;
                $password = $request->password;
                Mail::send('mail-templates.register', compact('url', 'user', 'password'), function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Welcome to Dots');
                });

                if (!File::exists(storage_path('app/root/' . base64UrlDecode($username)))) {
                    File::makeDirectory(storage_path('app/root/' . base64UrlDecode($username)), 0755, true);
                }
                $basePath = storage_path('app/root/' . base64UrlDecode($username));
                $folders = ['Desktop', 'Documents', 'Downloads', 'Gallery', 'Recyclebin'];

                // Create the folders
                foreach ($folders as $folder) {
                    $folderPath = $basePath . '/' . $folder;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, 0755, true);
                    }
                }
            }
            DB::commit();
            return redirect()->route('useradmin')->with('success', '');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit(Request $request)
    {
        $groups = Group::get();
        $roles = Roles::get();

        $id = $request->id;
        $user = User::find($id);
        $users = view('appendview.editusers')->with('user', $user)->with('groups', $groups)->with('roles', $roles)->render();
        return response()->json($users);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        $input = request()->except(['_token']);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $updated = User::where('id', $id)->update($input);

        return redirect()->route('useradmin')->with('success-update', 'User updated successfully!');
    }

    public function destroy(string $id)
    {

        User::where('id', $id)->delete();
        return redirect()->route('useradmin');
    }


    public function suspend(string $id)
    {
        $user = User::find($id);
        if ($user->status == 1) {
            $update = array('status' => 0);
            User::where('id', $id)->update($update);
            return redirect('useradmin')->with('success-suspend', 'User suspended successfully!');
        } else {
            $update = array('status' => 1);
            User::where('id', $id)->update($update);
            return redirect()->route('useradmin')->with('success-active', 'User activated successfully!');;
        }
    }

    public function importUsers(Request $request)
    {
        try {
            $uploadedFiles = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $extension = $file->extension();
                    if($extension != 'xlsx'){
                        return response()->json(['success' => false, 'message' => 'Wrong file type only excel sheet allowed']);
                    }
                    $originalName = $file->getClientOriginalName();
                    $filePath = $file->store('imports');

                    $importer = new UsersImport();
                    $test =  $importer->import(storage_path('app/' . $filePath));
                    $uploadedFiles[] = [
                        'name' => $originalName,
                        'size' => $file->getSize()
                    ];
                }
            }

            if ($test && !is_array($test) ) {
                return response()->json(['success' => true, 'files' => $uploadedFiles, 'test' => $test]);
            } elseif(is_array($test)){
                return response()->json(['success' => false, 'message' => 'Email already exists', 'test' => $test]);
            }else {
                return response()->json(['success' => false, 'message' => 'Roles or Group not found']);
            }
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            //\Log::error('Error importing users: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function ProfilePic(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user();
            $old = $user->avatar;
            $type = $request->profile->getClientMimeType();
            if (in_array($type, ['image/jpeg', 'image/jpeg', 'image/png'])) {
                $FileName = time() . '.' . $request->profile->getClientOriginalExtension();;
                $request->profile->move(public_path('storage/userprofile'), $FileName);
                $user->avatar = 'public/storage/userprofile/' . $FileName;
                $user->save();
                if (File::exists(base_path($old))) {
                    File::delete(base_path($old));
                }
                return redirect()->back()->with('success', 'Profile updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Invalid image type! Select jpeg,png,jpg.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function voice(Request $request)
    {
        dd($request);
    }
}
