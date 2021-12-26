<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

        
        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry you are not authorized');
        }

        if($request->ajax()){
            $data=Admin::all();
            //$data=SubCategory::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('roleList', function($row) {
                $output=null;
                foreach ($row->roles as $perm){
                    $output[]="$perm->name";                                                                                         
                }
                return $output;            
            })
            ->addColumn('action', function($row){
                $btn = $this->edit_button();
                $btn = $btn.$this->delete_button();                    
                return $btn;
            })                   
            ->rawColumns(['roleList','action'])
            ->make(true);            
        }

        return view('backend.pages.main.admin');
    }



    private function edit_button(){

        $edit_button="<a href='#viewModal' role='button' id='edit_button' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-tasks'></i> View</a>";

        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            $edit_button=null;
        }

        return $edit_button;
    }


    private function delete_button(){

        $delete_button="<a href='javascript:void(0)' role='button' id='view_delete' class='btn btn-danger btn-xs custom_btn'><i class='fa fa-close'></i> Delete </a></td>";

        if (is_null($this->user) || !$this->user->can('admin.delete')) {
            $delete_button=null;
        }

        return $delete_button;

    }

    public function getRoleData(Request $request){
        if($request->ajax()){
        $data = Role::select('id','name')            
            //->where('status','active')
            ->get();

        return $data;   
        }     
    }


    public function store(Request $request){

        if (is_null($this->user) || !$this->user->can('admin.create')) {
            return response()->json('Sorry you are not authorized',403); 
        } 

        $request->validate([
            'name'=>'required|min:3|max:20',
            'username'=>'required|min:5|alpha_num|unique:admins,username',
            'email'=>'required|email|unique:admins,email',
            'password'=>'required|confirmed|min:5|max:30'
         ],[
             'username.unique'=>'This username is already taken',
             'email.unique'=>'This email is already taken'
         ]);

         $admin= new Admin();
         $admin->name=$request->name;
         $admin->username=$request->username;
         $admin->email=$request->email;
         $admin->password=Hash::make($request->password);
         $saved = $admin->save();

         if ($request->roles) {
            $admin->assignRole($request->roles);
        }         

         if($saved){

         return response()->json([
            'success' => true,
            'message' => "Admin Created Successfully",
        ]);

    }else{
        return response()->json('Something went wrong',422);
    }

    }


    public function update(Request $request){

        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            return response()->json('Sorry you are not authorized',403); 
        }        

        $request->validate([
            'name'=>'required|min:3|max:20',
            'username'=>'required|min:5|alpha_num|unique:admins,username,' . $request->id,
            'email'=>'required|email|unique:admins,email,' . $request->id,
            'password'=>'nullable|confirmed|min:5|max:30'
         ],[
             'username.unique'=>'This username is already taken',
             'email.unique'=>'This email is already taken'
         ]);

         $admin = Admin::findorfail($request->id);
         //$admin= new Admin();
         $admin->name=$request->name;
         $admin->username=$request->username;
         $admin->email=$request->email;

         if ($request->password) {
            $admin->password = Hash::make($request->password);
         }                  
         $saved = $admin->save();

         $admin->roles()->detach();
         if ($request->roles) {
             $admin->assignRole($request->roles);
         }         
      
        if($saved){

         return response()->json([
            'success' => true,
            'message' => "Admin Updated Successfully",
        ]);

    }else{
        return response()->json('Something went wrong',422);
    }

    }

    public function destroy(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('admin.delete')) {
            return response()->json('Sorry you are not authorized',403); 
        } 

        $validate=$request->validate([
            'id' => 'required',            
        ]);         

        $admin = Admin::find($request->id);
        if (!is_null($admin)) {
            $admin->roles()->detach();
            $saved=$admin->delete();
            
        }

        if($saved){

        return response()->json('Successfully deleted'); 
   
       }else{
           return response()->json('Something went wrong',422);
       }

    }



}
