<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Permissions;
use Illuminate\Support\Facades\Auth;
use Validator;

class GroupController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the groups.
     */
    public function index($id ='')
    {
       if($id){
        $group = Group::find($id);
        return view('groups.index',compact('group'));

       }else{
        $groups = Group::get();
        return view('groups.index',compact('groups'));
        }
    }

    public function add()
    {
       $permissions = Permissions::get();
       return view('groups.add',compact('permissions'));
    }

     public function create(Request $request)
    {

         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permissionID' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $role = Group::create($input);
        return redirect()->route('useradmin')->with('success-group', 'Group created successfully!');  
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $group = Group::find($id);
        $groups = view('appendview.editgroup')->with('group',$group)->render();
        return response()->json($groups);
    }

     public function update(Request $request, string $id)
    {

       // Access and prepare data from the request
        $data = request()->except(['_token']);
        $updated = Group::where('id', $id)->update($data);
        $role = Group::find($id);

        if ($updated) {
            return redirect()->route('useradmin')->with('group-update', 'Group updated successfully!');
        } else {
            // Handle update failure (e.g., log the error or return a specific error message)
            return redirect()->route('useradmin')->with('error', 'Group update failed!!');
        }
    }

     public function destroy(string $id)
    {
        
        Group::where('id', $id)->delete();
        return redirect()->route('groups')->with('success', 'Group delete successfully!');   
    
    }
}
