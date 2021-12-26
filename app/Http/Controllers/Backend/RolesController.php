<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }    
    
    public function index(Request $request){

        if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'Sorry you are not authorized');
        } 
        
        if($request->ajax()){
        
        $data=Role::all();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('permissonList', function($row) {
            $output=null;
            foreach ($row->permissions as $perm){
                $output[]="$perm->name";                                                                                         
            }
            return $output;            
        })       
        ->addColumn('action', function($row){
            $showUrl = route('admin.roles.edit', $row->id);
            $btn = $this->edit_button($showUrl);
            $btn = $btn.$this->delete_button();                    
            return $btn;
        })        
        ->rawColumns(['permissonList','action'])
        ->make(true);
        //->toJson();
        
    }

       return view('backend.pages.main.roles.index');
    }


    private function edit_button($url){

        $edit_button="<a href='$url' role='button' id='edit_button' class='btn btn-primary btn-xs small_btn' title='Details'><i class='fa fa-tasks'></i> View</a>";

        if (is_null($this->user) || !$this->user->can('role.edit')) {
            $edit_button=null;
        }

        return $edit_button;
    }


    private function delete_button(){

        $delete_button="<a href='javascript:void(0)' role='button' id='view_delete' class='btn btn-danger btn-xs custom_btn'><i class='fa fa-close'></i> Delete </a></td>";

        if (is_null($this->user) || !$this->user->can('role.delete')) {
            $delete_button=null;
        }

        return $delete_button;

    }    



    public function create(){

        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry you are not authorized');
        } 

        $all_permissions  = Permission::all();
        $permission_groups=Admin::getpermissionGroups();        
        return view('backend.pages.main.roles.create',compact('all_permissions','permission_groups'));

    }

    public function store(Request $request){

        if (is_null($this->user) || !$this->user->can('role.create')) {
            return response()->json('Sorry you are not authorized',403); 
        }  

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.requried' => 'Please give a role name'
        ]);
        
        // Process Data
        $role = Role::create(['name' => $request->name, 'guard_name' => 'admin']);
        
        $permissions = $request->input('permissions');
        
        if (!empty($permissions)) {
            $saved=$role->syncPermissions($permissions);                            
        } 

        if($saved){            
            return response()->json([
                'success' => true,
                'message' => "Role Successfully Created",
            ]);             
        }
        else{
            return response()->json('Something went wrong',422);            
        }        
        

    }


        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry you are not authorized');
        } 

        $role = Role::findById($id, 'admin');
        $all_permissions  = Permission::all();
        $permission_groups=Admin::getpermissionGroups();        
        return view('backend.pages.main.roles.edit',compact('role','all_permissions','permission_groups'));
    }


/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (is_null($this->user) || !$this->user->can('role.edit')) {
            return response()->json('Sorry you are not authorized',403); 
        } 

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        $role = Role::findById($id, 'admin');
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->save();
            $saved=$role->syncPermissions($permissions);
        }

        if($saved){            
            return response()->json([
                'success' => true,
                'message' => "Role Successfully Updated",
            ]);             
        }
        else{
            return response()->json('Something went wrong',422);            
        }


    }   
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('role.delete')) {
            return response()->json('Sorry you are not authorized',403); 
        } 

        $validate=$request->validate([
            'id' => 'required',            
        ]); 

        $id=$request->get('id');

        $role = Role::findById($id, 'admin');
        if (!is_null($role)) {
         $saved=$role->delete();
        }
        if($saved){            
            return response()->json('Successfully deleted');            
        }
        else{
            return response()->json('Something went wrong',422);            
        }
    }




}
