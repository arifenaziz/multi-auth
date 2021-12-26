<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;





class CategoryController extends Controller
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

        if (is_null($this->user) || !$this->user->can('category.view')) {
            abort(403, 'Sorry you are not authorized');
        }
        
        

        if($request->ajax()){
            $data=Category::select('category_id','category_name','slug','status');            
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = $this->edit_button();
                $btn = $btn.$this->delete_button();                    
                return $btn;
            })        
            ->rawColumns(['action'])            
            ->toJson();            
        }
        return view('backend.pages.main.category');

    }


    private function edit_button(){

        $edit_button="<a href='#viewModal' role='button' id='edit_button' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-tasks'></i> View</a>";

        if (is_null($this->user) || !$this->user->can('category.edit')) {
            $edit_button=null;
        }

        return $edit_button;
    }


    private function delete_button(){

        $delete_button="<a href='javascript:void(0)' role='button' id='view_delete' class='btn btn-danger btn-xs custom_btn'><i class='fa fa-close'></i> Delete </a></td>";

        if (is_null($this->user) || !$this->user->can('category.delete')) {
            $delete_button=null;
        }

        return $delete_button;

    }    

    
    public function store(Request $request){

        if (is_null($this->user) || !$this->user->can('category.create')) {
            return response()->json('Sorry you are not authorized',403); 
        }        

        $validate=$request->validate([
            'category_name' => 'required|unique:categories|max:255',            
            'slug' => 'required|unique:categories|max:255',            
        ]);       
        
        $data=array(
            'category_name' => $request->category_name,
            'slug' =>Str::slug($request->slug, '-')
        );
        $saved=Category::create($data);

        if($saved){            
            return response()->json([
                'success' => true,
                'message' => "Category Successfully Created",
            ]);          
        }
        else{
            return response()->json('Something went wrong',422);            
        }

    }

    public function destroy(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('category.delete')) {
            return response()->json('Sorry you are not authorized',403); 
        }  

        $validate=$request->validate([
            'category_id' => 'required',            
        ]); 

        $category_id=$request->get('category_id');        
        $query=DB::table('categories')->where('category_id',$category_id)->delete();
        if($query){
            return response()->json('Successfully deleted');
        }else{
            return response()->json('Error Occured',422);
        }
        
    }
    
    public function update(Request $request){

        // $validate=$request->validate([            
        //     //'category_name' => ['required',Rule::unique('users')->ignore($user->id)],             
        //     'category_name' => [
        //         'required',
        //         Rule::unique('categories')->ignore($request->category_name),
        //     ],
        //     'slug' => 'required|unique:categories|max:255',            
        // ]);      
        
        // $validator = Validator::make($request->all(), [
        //     'category_name' => 'required|unique:categories|max:255',
        //     'slug' =>  'required|unique:categories|max:255',  
        // ]);

        if (is_null($this->user) || !$this->user->can('category.edit')) {
            return response()->json('Sorry you are not authorized',403); 
        }          
        
        $request['slug'] = Str::slug($request->slug, '-');

        $validated = $request->validate([            
            'category_name' => 'required|max:255|unique:categories,category_name,' . $request->category_id.',category_id', 
            'slug' => 'required|max:255|unique:categories,slug,' . $request->category_id.',category_id',             
        ]);        
        
        $data=array(
            'category_name' => $request->category_name,
            'slug' =>Str::slug($request->slug, '-')
        );
        
        $category=Category::findorfail($request->category_id);
        $saved=$category->update($data);        

        if($saved){            
            return response()->json([
                'success' => true,
                'message' => "Category Successfully Updated",
            ]);          
        }
        else{
            return response()->json('Something went wrong',422);            
        }

    }    




}
