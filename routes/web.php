<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\RegisterController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[AdminController::class,'root']);

// Route::get('/', function () {

//     echo 'something';
//     //return view('welcome');
//     //return redirect()->route('admin.home');
// }); 

//Route::get('/',[AdminController::class,'root']);

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->name('admin.')->group(function(){

  Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::get('/login',[LoginController::class,'loginForm'])->name('login');    
        Route::post('/check',[LoginController::class,'loginProcess'])->name('login.check');
        Route::get('/registration',[RegisterController::class,'registrationForm'])->name('registration');    
        Route::post('/registrationProcess',[RegisterController::class,'registrationProcess'])->name('registration.process');
   
           
        //Route::view('/login','dashboard.admin.login')->name('login');
        //Route::post('/check',[AdminController::class,'check'])->name('check');
  });    

  Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
    //Route::view('/home','dashboard.admin.home')->name('home');
    Route::get('/home',[HomeController::class,'index'])->name('home');
    Route::post('/logout',[LoginController::class,'logout'])->name('logout.submit'); 

    Route::group(['prefix'=>'category'],function () {
      Route::get('/',[CategoryController::class,'index'])->name('category');    
      Route::post('/store',[CategoryController::class,'store'])->name('store.category');       
      Route::delete('/destroy',[CategoryController::class,'destroy'])->name('destroy.category');    
      Route::put('/update',[CategoryController::class,'update'])->name('update.category');            
  });
   
  Route::group(['prefix'=>'subcategory'],function () {
      Route::get('/',[SubCategoryController::class,'index'])->name('subcategory');             
      Route::get('/cateoryList',[SubCategoryController::class,'getCategoryData'])->name('categorylist.subcategory');    
      Route::post('/store',[SubCategoryController::class,'store'])->name('store.subcategory');       
      Route::delete('/destroy',[SubCategoryController::class,'destroy'])->name('destroy.subcategory');    
      Route::post('/update',[SubCategoryController::class,'update'])->name('update.subcategory');            
  });


  Route::group(['prefix'=>'roles'],function () {
    Route::get('/',[RolesController::class,'index'])->name('roles');    
    Route::get('/create',[RolesController::class,'create'])->name('roles.create');    
    Route::post('/store',[RolesController::class,'store'])->name('roles.store');    
    Route::get('{id}/edit',[RolesController::class,'edit'])->name('roles.edit');    
    Route::put('/update/{id}',[RolesController::class,'update'])->name('roles.update');    
    Route::delete('/destroy',[RolesController::class,'destroy'])->name('roles.destroy');             
  });
  
  Route::group(['prefix'=>'adminList'],function () {
    Route::get('/',[AdminController::class,'index'])->name('adminList');  
    Route::get('/roles',[AdminController::class,'getRoleData'])->name('adminList.roles');     
    Route::post('/store',[AdminController::class,'store'])->name('store.adminList');
    Route::put('/update',[AdminController::class,'update'])->name('update.adminList');    
    Route::delete('/destroy',[AdminController::class,'destroy'])->name('destroy.adminList');
});  


});


});
