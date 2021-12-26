@extends('backend.layouts.backend')
@section('content')

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row ">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h6 class="m-b-0 text-white">Admin Role Assign</h6>
                </div>

                <div class="card-body">

                    @if (Auth::guard('admin')->user()->can('admin.create'))

                    <button type="button" class="btn btn-info open" data-toggle="collapse" data-target="#add">Add New</button>

                    <div id="add" class="collapse">
                        <div class="row justify-content-md-center">
                            <div class="col col-md-6">
                                <form class="form-material" id="addForm">
                                    
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Admin Name</label>
                                                <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Admin Name">
                                            </div>
                                            <label id="name-error" class="error name_error custom-label" for="name"></label>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Admin Email</label>
                                                <input type="email" name="email" class="form-control" autocomplete="off" placeholder="Admin Email">
                                            </div>
                                            <label id="email-error" class="error email_error custom-label" for="email"></label>
                                        </div>                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Admin Username</label>
                                                <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Admin Usrname">
                                            </div>
                                            <label id="username-error" class="error username_error custom-label" for="username"></label>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Assign Roles</label>
                                                 <select class="select2 form-control custom-select roles" id="role" name="roles[]" multiple="multiple" data-placeholder="Choose roles" style="width: 100%; height:36px;">                                                                    
                                                </select>      

                                            </div>
                                        </div>                                        
                                    </div>     
                                    
                                    
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password" id="password">
                                            </div>
                                            <label id="password-error" class="error password_error custom-label" for="password"></label> 
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form-control" autocomplete="off" placeholder="Confirm Password" id="cpassword">
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                    
                                @csrf                                
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info submit_button"><i class="fa fa-check"></i> Submit</button>
                                    <button type="reset" class="btn btn-inverse reset_button">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <div class="table-responsive">
                    <br>
                    <table class="table table-bordered table-striped" id="admin_list" >
                        <thead>
                            <tr>
                                <th width="5%">#</th>                                
                                <th width="10%">Admin Name</th>
                                <th width="12%">Email</th>
                                <th width="10%">Username</th>                                
                                <th width="15%">Roles</th>                                
                                <th width="8%">Status</th>
                                <th width="12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <!-- ============================================================== -->
</div>

</div>



@if (Auth::guard('admin')->user()->can('admin.edit'))
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="z-index:1049">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Edit Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="updateForm" class="form-material">
                <div class="modal-body">



                <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Admin Name</label>
                                                <input type="text" name="name" id="name" class="form-control" autocomplete="off" placeholder="Admin Name">
                                            </div>
                                            <label id="name-error" class="error name_error custom-label" for="name"></label>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Admin Email</label>
                                                <input type="email" name="email" id="email" class="form-control" autocomplete="off" placeholder="Admin Email">
                                            </div>
                                            <label id="email-error" class="error email_error custom-label" for="email"></label>
                                        </div>                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Admin Username</label>
                                                <input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="Admin Usrname">
                                            </div>
                                            <label id="username-error" class="error username_error custom-label" for="username"></label>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Assign Roles</label>
                                                 <select class="select2 form-control custom-select roles" id="roles" name="roles[]" multiple="multiple" data-placeholder="Choose roles" style="width: 100%; height:36px;">                                                                    
                                                </select>      

                                            </div>
                                        </div>                                        
                                    </div>     
                                    
                                    
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password" id="password_edit">
                                            </div>
                                            <label id="password-error" class="error password_error custom-label" for="password"></label> 
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form-control" autocomplete="off" placeholder="Confirm Password" id="cpassword_edit">
                                            </div>
                                        </div>                                        
                                    </div>


                </div>
                <input type="hidden" name="id" id="id" readonly>
                @csrf
                @method('PUT')

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary update_button">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endif


<script>


$(".select2").select2();


$(function() {

getRoleList();

});


function getRoleList() {

var items="";
$.getJSON("{{ route('admin.adminList.roles') }}",function(data){
    //items+="<option id='' value='Select a Category'></option>";
    $.each(data,function(index,item)
    {
        items+="<option value='"+item.name+"' >"+item.name+"</option>";
    });

    $(".roles").html(items);
});

}

var admin_list = $('#admin_list').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"{{ route('admin.adminList') }}",
                "dataType":"json",
                "type":"GET",
                // "data":{"_token":"{{ csrf_token() }} "}
            },
            "columns":[
                {"data":"DT_RowIndex","className": "center", orderable: false, searchable: false},
                {"data":"name"},              
                {"data":"email"},              
                {"data":"username"},
                { "data":"roleList","name":"roleList","className": "left",searchable: false,orderable: false,defaultContent:"",
                "render": function (data, type, row) {
                    var items="";
                    $.each(row.roleList,function(index,item){
                        items+= "<span class='badge badge-primary mr-1 custom-badge'>"+item+"</span>";
                    
                });
                return items;
                }

                },                                
                {"data":"status","className": "center"},
                {data: 'action', name: 'action', "className": "center action", orderable: false, searchable: false}

            ],




        });




jQuery.validator.addMethod("alphanumeric", function(value, element) {
     return this.optional(element) || /^[a-z0-9\\]+$/i.test(value);
}, "Letters, numbers, and underscores only please");

jQuery.validator.addMethod("alpha", function(value, element) {
     return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
}, "Letters, numbers, and underscores only please");


$("#addForm").validate({

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
            url: "{{route('admin.store.adminList')}}",
            type: "POST",
            data: $(form).serialize(),
            dataType:'json',
            success: function(res) {                                                      
                         
            if(res.success){
            $('.open').trigger('click');
            toastr.success(res.message);
            $('#role').val(null).trigger('change');
            $(form).trigger("reset");   
            admin_list.ajax.reload();          
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
        // Do not change code below
        errorPlacement: function(error, element)
        {
           error.insertAfter(element.parent());
       }

   });



let category_id=$('#category_id').val();



$("#updateForm").validate({

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
        minlength: 3,               
    },
    password_confirmation:
    {        
        minlength: 3,
        equalTo : "#password_edit"               
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
        minlength: "Minimum password length need to be 3",
        equalTo : "Password missmatch"        
    },    
},

submitHandler: function(form) {

    $('.update_button').css('cursor', 'wait');
    $('.update_button').attr('disabled', true);

        $.ajax({
            url: "{{route('admin.update.adminList')}}",
            type: "PUT",
            data: $(form).serialize(),
            dataType:'json',
            success: function(res) {                                                      
                         
            if(res.success){
            $('#viewModal').modal('hide');
            toastr.success(res.message);
            $(form).trigger("reset");   
            admin_list.ajax.reload();        
            }                                           

         $('.update_button').css('cursor', 'pointer');
         $('.update_button').removeAttr('disabled');

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
        
        $('#password_edit').val('');
        $('#cpassword_edit').val('');
        $('.update_button').css('cursor', 'pointer');
        $('.update_button').removeAttr('disabled');        
        
    }
 });
        }, 
        // Do not change code below
        errorPlacement: function(error, element)
        {
           error.insertAfter(element.parent());
       }

   });




   $('#admin_list tbody').on( 'click', '#edit_button', function () {
            var data = admin_list.row( $(this).parents('tr') ).data();
            $("#name").val(data.name);
            $("#email").val(data.email);
            $("#username").val(data.username);
            $("#name").val(data.name);            
            $('#roles').val([...data.roleList]);
            $('#roles').trigger('change');            
            $("#id").val(data.id);                       
        } );


        $('#admin_list tbody').on( 'click', '#view_delete', function () {
            var data = admin_list.row( $(this).parents('tr') ).data();
        
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            }, function () {

                $.ajax({
                    type:"POST",
                    url:"{{route('admin.destroy.adminList')}}",
                    data:{"id":data.id,"_method": 'delete', "_token": "{{ csrf_token() }}" },
                    success:function(response)
                    {
                        toastr.success(response);
                        admin_list.ajax.reload();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {      

                        toastr.error(jqXHR.responseJSON);
                        admin_list.ajax.reload();

                    }                    

                });



            });            
    


        } );   


</script>    

@stop