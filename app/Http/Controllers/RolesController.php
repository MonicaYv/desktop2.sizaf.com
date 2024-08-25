<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;
use App\Models\Permissions;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Helpers\PermissionHelper;

class RolesController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the roles.
     */
    public function index($id ='')
    {
       if($id){
        $role = Roles::find($id);
        return view('roles.index',compact('role'));

       }else{
        $roles = Roles::get();
        return view('roles.index',compact('roles'));
        }
    }

    public function roles()
    {
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        $permissions = Permissions::get();
        $roles = Roles::paginate(10);
        return view('roles.roles',compact('roles','permissions','filteredPermissions'));
    }

    public function rolesList(Request $request)
    {
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());
        $input = $request->all();
        if($input['searchTerm']){
            $search = $input['searchTerm'];
            $roles = Roles::where('name','LIKE','%'.$search.'%')->get();
        }else{
        $roles = Roles::paginate(10);
        }
        $role = view('appendview.roleslist')->with('roles',$roles)->with('filteredPermissions', $filteredPermissions)->render();
        return response()->json($role);
    }

    public function add()
    {
       return view('roles.add');
    }

    public function edit(Request $request)
    {
       // $role = Roles::find($id);
       // $role->file_manage_settings = explode(",", $role->file_manage_settings);
       // $role->user_settings = explode(",", $role->user_settings);
       // return view('roles.edit',compact('role'));

        $id = $request->id;
        $role = Roles::find($id);
        $role->file_manage_settings = explode(',',$role->file_manage_settings);
        $role->user_settings = explode(',',$role->user_settings);
        $permissions = Permissions::get();
        $roles = view('appendview.editroles')->with('role',$role)->with('permissions',$permissions)->render();
        return response()->json($roles);
    }

    public function create(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['name'] = preg_replace('/[^A-Za-z0-9 ]/', '', $input['name']);
        $role = Roles::create($input);
         return redirect()->route('rolesadmin')->with('success', 'Roles created successfully!');
           
    }

     public function update(Request $request, string $id)
    {

       // Access and prepare data from the request
        $data = request()->except(['_token']);
        if(!empty($data['file_manage_settings']))
        $data['file_manage_settings'] = implode(',', $data['file_manage_settings']);
        if(!empty($data['user_settings']))
        $data['user_settings'] = implode(',', $data['user_settings']);

        $updated = Roles::where('id', $id)->update($data);
        $role = Roles::find($id);

        if ($updated) {
            return redirect()->route('rolesadmin')->with('success-update', 'Roles updated successfully!');;
        } else {
            // Handle update failure (e.g., log the error or return a specific error message)
            return redirect()->route('rolesadmin')->with('error', 'Roles updated failed!');
        }
    }

     public function destroy(string $id)
    {
        
        Roles::where('id', $id)->delete();
        User::where('roleID', $id)->delete();
        return redirect()->route('rolesadmin');
         
    
    }
}
