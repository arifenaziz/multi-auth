<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;


class SubCategoryController extends Controller
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

        if (is_null($this->user) || !$this->user->can('subcategory.view')) {
            abort(403, 'Sorry you are not authorized');
        }        

        if($request->ajax()){
            $data=SubCategory::select('category_id','id','subcategory_name','slug','image','status');
            //$data=SubCategory::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('category_name', function($row) {
                return $row->category->category_name;
            })            
            ->addColumn('action', function($row){
                $btn = $this->edit_button();
                $btn = $btn.$this->delete_button();                    
                return $btn;
            })        
            ->rawColumns(['category_name','action'])                 
            ->make(true);            
        }

        return view('backend.pages.main.subcategory');
    }



    


    public function getCategoryData(){

        $data = Category::select('category_id','category_name')            
            ->where('status','active')
            ->get();

        return $data;

    } 
    
    
    private function edit_button(){

        $edit_button="<a href='#viewModal' role='button' id='edit_button' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-tasks'></i> View</a>";

        if (is_null($this->user) || !$this->user->can('subcategory.edit')) {
            $edit_button=null;
        }

        return $edit_button;
    }


    private function delete_button(){

        $delete_button="<a href='javascript:void(0)' role='button' id='view_delete' class='btn btn-danger btn-xs custom_btn'><i class='fa fa-close'></i> Delete </a></td>";

        if (is_null($this->user) || !$this->user->can('subcategory.delete')) {
            $delete_button=null;
        }

        return $delete_button;

    }    
        
    
    public function store(Request $request){

        if (is_null($this->user) || !$this->user->can('subcategory.create')) {
            return response()->json('Sorry you are not authorized',403); 
        }         

        $validate=$request->validate([
            'category_id' => 'required',            
            'subcategory_name' => 'required|unique:sub_categories|max:255',            
            'slug' => 'required|unique:sub_categories|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',         
        ]);       

        $image = $request->file('image');
        $filename = uniqid().'-'.time().'.'.$image->getClientOriginalExtension();    
        
        Image::make($image)->resize(400, 400)->save('public/upload/category/'.$filename);
        
        $data=array(
            'category_id' => $request->category_id,
            'subcategory_name' => Str::of($request->subcategory_name)->trim(),
            'slug' =>Str::slug($request->slug, '-'),
            'image' =>$filename,
        );
        $saved=SubCategory::create($data);

        if($saved){            
            return response()->json([
                'success' => true,
                'message' => "SubCategory Successfully Created",
            ]);          
        }
        else{
            return response()->json('Something went wrong',422);            
        }

    }

    
    public function update(Request $request){


        if (is_null($this->user) || !$this->user->can('subcategory.edit')) {
            return response()->json('Sorry you are not authorized',403); 
        }           
        
        $request['slug'] = Str::slug($request->slug, '-');

        $validated = $request->validate([ 
            'category_id' => 'required',           
            'subcategory_name' => 'required|max:255|unique:sub_categories,subcategory_name,' . $request->id, 
            'slug' => 'required|max:255|unique:sub_categories,slug,' . $request->id,            
        ]);
        
        if($request->file('image')){

        $image = $request->file('image');
        $filename = uniqid().'-'.time().'.'.$image->getClientOriginalExtension();            
        Image::make($image)->resize(400, 400)->save('public/upload/category/'.$filename);

        }else{

            $filename=$request->current_image;

        }
        
        $data=array(
            'category_id' => $request->category_id,
            'subcategory_name' => Str::of($request->subcategory_name)->trim(),
            'slug' =>Str::slug($request->slug, '-'),
            'image' =>$filename,
        );        
        
        $getValue=SubCategory::findorfail($request->id);
        $saved=$getValue->update($data);        

        if($saved){            
            return response()->json([
                'success' => true,
                'message' => "SubCategory Successfully Updated",
            ]);          
        }
        else{
            return response()->json('Something went wrong',422);            
        }

    }      
    
    

    public function destroy(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('subcategory.delete')) {
            return response()->json('Sorry you are not authorized',403); 
        }          

        $validate=$request->validate([
            'id' => 'required',            
        ]); 

        $id=$request->get('id');

        $mData=DB::table('sub_categories')->select('image')->where('id',$id)->first();  
        

        if(File::exists(public_path('upload/category/'.$mData->image))){
            File::delete(public_path('upload/category/'.$mData->image));
        }                       

        $query=DB::table('sub_categories')->where('id',$id)->delete();
        if($query){
            return response()->json('Successfully deleted');
        }else{
            return response()->json('Error Occured',422);
        }
        
    }    

}
