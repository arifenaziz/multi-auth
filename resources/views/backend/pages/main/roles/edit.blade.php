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
                    <h6 class="m-b-0 text-white">Update Role | {{ $role->name }} </h6>
                </div>

                <div class="card-body">
                                      
                    
                        <div class="row justify-content-md-center">

                            <div class="col col-md-12">

                                <form class="form-material" id="updateForm">
                                    
                                    <div class="row">
                                        <div class="col-md-4 col-4">
                                            <div class="form-group">
                                                <label class="control-label">Role Name</label>
                                                <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Role Name" value="{{ $role->name }}">
                                            </div>
                                            <label id="name-error" class="error name_error custom-label" for="name"></label>
                                        </div>                                                                               
                                    </div>

                                    <div class="row m-t-20 m-b-10">
                                        <div class="col-md-4 col-4">
                                            <div class="form-group">
                                                <label class="control-label">Permisson</label>                                                
                                                <input type="checkbox" id="checkAllPermisson" class="filled-in"
                                                {{ App\Models\Admin::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}
                                                />
                                                <label for="checkAllPermisson">All</label>                                                                                                
                                            </div>
                                        </div>                                                                               
                                    </div>
                                    
                                    
                                    <div class="permisson-items">
                                    @php $i = 1; @endphp
                                    @foreach($permission_groups as $group)

                                    @php
                                    $j =1;        
                                    $permissions=App\Models\Admin::getpermissionsByGroupName($group->name);
                                    @endphp

                                    <div class="row row-border">
                                        <div class="col-lg-3 row-heading">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">                                                
                                                <input type="checkbox" id="group_{{$i}}" value="{{ $group->name }}" class="filled-in"
                                                onclick="checkGroupPermisson('group_{{$i}}_permissions',this)"
                                                {{ App\Models\Admin::roleHasPermissions($role, $permissions) ? 'checked' : '' }}/>
                                                <label for="group_{{$i}}" class="group-name">{{ $group->name }}</label>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="col-lg-9 group_{{$i}}_permissions">

                                            <div class="row row-items">

                                         @foreach($permissions as $permission)   
                                        <div class="col-md-3 col-12">
                                        <div class="form-group">

                                        <input type="checkbox" id="item_{{$permission->id}}" value="{{ $permission->name }}" name="permissions[]" class="filled-in" 
                                        onclick="checkSinglePermisson('group_{{$i}}_permissions','group_{{$i}}','{{ count($permissions) }}')"
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                        />
                                        <label for="item_{{$permission->id}}">{{ $permission->name }}</label>                                        

                                        </div>
                                        </div>
                                        @php $j++; @endphp
                                        @endforeach

                                        </div>                                        

                                        </div>


                                        
                                        
                                    </div>
                                    
                                    @php  $i++; @endphp 
                                    @endforeach

                                    
                                    
                                </div>         

                                <p class="permisson_message">Minimum one permisson need to be selected</p>                          

                                    

                                    
                                @csrf
                                @method('PUT')
                                
                                
                                <div class="text-xs-right m-t-20">
                                    <button type="submit" class="btn btn-info submit_button"><i class="fa fa-check"></i> Submit</button>
                                    <button type="reset" class="btn btn-inverse reset_button">Reset</button>
                                </div>
                               


                            </form>

                        </div>

                    </div>
               
                                 

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
</div>

</div>

@section('scripts')
     @include('backend.pages.main.roles.partials.internal-scripts')
@endsection

<script>



    
$("#updateForm").validate({

rules:
{


    role_name:
    {
        required: true,
        minlength: 3,               
                
    },
    'permissions[]':
    {
        required: true,                      
    },
},

messages:
{

    role_name:
    {
        required: "Please type role name",
        minlength: "Minimum length need to be 3",        
    },
    'permissions[]':
    {
        required: "",                
    },
},

submitHandler: function(form) {

    $('.submit_button').css('cursor', 'wait');
    $('.submit_button').attr('disabled', true);

        $.ajax({
            url: "{{route('admin.roles.update',$role->id)}}",
            type: "PUT",
            data: $(form).serialize(),
            dataType:'json',
            success: function(res) {      
                
            if(res.success){
            toastr.success(res.message);                        
            } 
           

         $('.submit_button').css('cursor', 'pointer');
         $('.submit_button').removeAttr('disabled');

     },
     error: function(jqXHR, textStatus, errorThrown) {      

        if(jqXHR.responseJSON.errors){
        $.each(jqXHR.responseJSON.errors, function(prefix,val){
        $(form).find('label.'+prefix+'_error').html(val[0]).show();        
        });
        toastr.error(jqXHR.responseJSON.message);
        }


        if(!jqXHR.responseJSON.errors){
            toastr.error(jqXHR.responseJSON);
        }

        
        $('.submit_button').css('cursor', 'pointer');
        $('.submit_button').removeAttr('disabled');        
        
    }
 });
        },                                                // Do not change code below
        errorPlacement: function(error, element)
        {
           error.insertAfter(element.parent());
       }

   });





</script>



@stop