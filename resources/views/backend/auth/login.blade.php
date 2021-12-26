@extends('backend.layouts.auth_layout')

@section('content')
<div class="login-register" style="background-image:url({{asset('public/backend') }}/images/background/introducer.jpg)">
            <div class="login-box card">
                <div class="card-body">

                    <form class="form-horizontal form-material" id="loginform" autocomplete="off">
                        <h3 class="box-title m-b-20">Sign In</h3>
                        <div class="form-group login-property">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="email" placeholder="Email"> 
                            </div>                                
                                <label id="email-error" class="error email_error custom-label" for="email" style="display: block !important"></label>
                            </div>
                            

                        <div class="form-group login-property">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" placeholder="Password" id="password"> </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <!-- <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> Remember me </label>
                                </div>  -->
                                
                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light submit_button" type="submit">Log In</button>
                            </div>
                        </div>

                        @csrf

                        <div class="form-group m-t-20">
                            <div class="col-sm-12 text-center">
                                <div>Don't have an account? <a href="{{ route('admin.registration') }}" class="text-info m-l-5"><b>Sign Up</b></a></div>
                            </div>
                        </div>
                    </form>
              
                </div>
            </div>
        </div>


<script>



$("#loginform").validate({

rules:
{
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
},

messages:
{
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
},

submitHandler: function(form) {

    $('.submit_button').css('cursor', 'wait');
    $('.submit_button').attr('disabled', true);

        $.ajax({
            url: "{{route('admin.login.check')}}",
            type: "POST",
            data: $(form).serialize(),
            dataType:'json',
            success: function(res) {                                                      
                         
            if(res.success){
            toastr.success('Please wait ...');
            window.location.href = "{{route('admin.home')}}"  
            }                                           

         //$('.submit_button').css('cursor', 'pointer');
         //$('.submit_button').removeAttr('disabled');

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