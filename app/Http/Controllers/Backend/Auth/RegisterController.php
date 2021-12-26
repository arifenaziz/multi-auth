<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    
    public function registrationForm(){
        return view('backend.auth.registration');
    }

    public function registrationProcess(Request $request){

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

         if($saved){

         return response()->json([
            'success' => true,
            'message' => "Registration Successfully Done",
        ]);

    }else{
        return response()->json('Something went wrong',422);
    }



    }


}
