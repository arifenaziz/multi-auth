@extends('backend.layouts.auth_layout')

@section('content')
<div class="login-register" style="background-image:url({{asset('public/backend') }}/images/background/introducer.jpg)">
            <div class="login-box card">
                <div class="card-body">

                    <form class="form-horizontal form-material" id="registrationform" autocomplete="none-off">
                        <h3 class="box-title m-b-20">Sign Up</h3>



                        <div class="form-group login-property">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="name" placeholder="Name"> 
                            </div>
                            <label id="name-error" class="error name_error custom-label" for="name"></label>
                        </div>    
                        
                        <div class="form-group login-property">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" placeholder="Username"> 
                            </div>
                            <label id="username-error" class="error username_error custom-label" for="username"></label>
                        </div>                         

                        <div class="form-group login-property">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="email" placeholder="Email"> 
                            </div>                                
                                <label id="email-error" class="error email_error custom-label" for="email"></label>
                        </div>
                            

                        <div class="form-group login-property">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" placeholder="Password" id="password">
                                <label id="password-error" class="error password_error custom-label" for="password"></label> 
                            </div>
                        </div>

                        <div class="form-group login-property">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" id="cpassword"> 
                            </div>
                            <label id="password_confirmation-error" class="error password_confirmation_error custom-label" for="password_confirmation"></label>
                        </div>                        


                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <!-- <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> Remember me </label>
                                </div>  -->
                            </div>
                                
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light submit_button" type="submit">Sign Up</button>
                            </div>
                        </div>

                        @csrf

                        <div class="form-group m-t-20">
                            <div class="col-sm-12 text-center">
                                <div>Already have an account?? <a href="{{ route('admin.login') }}" class="text-info m-l-5"><b>Sign In</b></a></div>
                            </div>
                        </div>
                    </form>
              
                </div>
            </div>
        </div>


<script>


jQuery.validator.addMethod("alphanumeric", function(value, element) {
     return this.optional(element) || /^[a-z0-9\\]+$/i.test(value);
}, "Letters, numbers, and underscores only please");

jQuery.validator.addMethod("alpha", function(value, element) {
     return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
}, "Letters, numbers, and underscores only please");


$("#registrationform").validate({

rules:
{

    name:
    {
        required: true,
        minlength: 3,
        alpha:true                             
    }, 
    username:
    {
        required: true,
        minlength: 5,
        alphanumeric:true                              
    },         
    email:
    {
        required: true,
        email: true,                                
    },
    password:
    {
        required: true,
        minlength: 3,               
    },
    password_confirmation:
    {
        required: true,
        minlength: 3,
        equalTo : "#password"               
    },    
},

messages:
{

    name:
    {
        required: "Please type your name",
        minlength: "Minimum name length need to be 3",
        alpha: "The name must only contain letters and space"      
    },
    username:
    {
        required: "Please type your username",
        minlength: "Minimum name length need to be 5",
        alphanumeric: "The username must only contain letters and numbers"       
    },        
    email:
    {
        required: "Please type your email",
        email: "Please type valid email",        
    },    
    password:
    {
        required: "Please type your password",
        minlength: "Minimum password length need to be 5",        
    },
    password_confirmation:
    {
        required: "Please type confirm password",
        minlength: "Minimum password length need to be 3",
        equalTo : "Password missmatch"        
    },    
},

submitHandler: function(form) {

    $('.submit_button').css('cursor', 'wait');
    $('.submit_button').attr('disabled', true);

        $.ajax({
            url: "{{route('admin.registration.process')}}",
            type: "POST",
            data: $(form).serialize(),
            dataType:'json',
            success: function(res) {                                                      
                         
            if(res.success){
            toastr.success(res.message);
            $(form).trigger("reset");             
            }                                           

         $('.submit_button').css('cursor', 'pointer');
         $('.submit_button').removeAttr('disabled');

     },
     error: function(jqXHR, textStatus, errorThrown) {      
        
        if(jqXHR.responseJSON.errors){
        $.each(jqXHR.responseJSON.errors, function(prefix,val){
        $(form).find('label.'+prefix+'_error').html(val[0]).show();
        console.log(prefix);
        });
        toastr.error(jqXHR.responseJSON.message);
        }

        if(!jqXHR.responseJSON.errors){
            toastr.error(jqXHR.responseJSON);
        }
        
        $('#password').val('');
        $('#cpassword').val('');
        $('.submit_button').css('cursor', 'pointer');
        $('.submit_button').removeAttr('disabled');        
        
    }
 });
        }, 
        //errorElement: "span",                                               // Do not change code below
        errorPlacement: function(error, element)
        {
           error.insertAfter(element.parent());
       }

   });


</script>

@endsection        