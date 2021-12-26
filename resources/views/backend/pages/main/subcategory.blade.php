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
                    <h6 class="m-b-0 text-white">SubCategory Entry</h6>
                </div>

                <div class="card-body">

                    @if (Auth::guard('admin')->user()->can('subcategory.create'))                

                    <button type="button" class="btn btn-info open" data-toggle="collapse" data-target="#add">Add New</button>

                    <div id="add" class="collapse">
                        <div class="row justify-content-md-center">
                            <div class="col col-md-4">
                                <form class="form-material" id="addForm">
                                    
                                    <div class="row">
                                    <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Category Name</label>                                            
                                                <input type="text" class="form-control" name="category_id" placeholder="Category Name" value="" list="category_id-datalist" autocomplete="off">
                                                    <datalist id="category_id-datalist" class="category">

                                                    </datalist>                                                
                                            </div>
                                        </div>                                        
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label">SubCategory Name</label>
                                                <input type="text" name="subcategory_name" class="form-control" autocomplete="off" placeholder="SubCategory Name">
                                            </div>
                                            <label id="subcategory_name-error" class="error subcategory_name_error custom-label" for="subcategory_name"></label>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Slug</label>
                                                <input type="text" name="slug" class="form-control" autocomplete="off" placeholder="SubCategory Slug">
                                            </div>
                                            <label id="slug-error" class="error slug_error custom-label" for="slug"></label>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Image</label>                                                
                                                <input type="file" name="image" class="dropify" data-height="100" data-max-file-size="1M" 
                                                data-allowed-file-extensions="jpg jpeg png"/>
                                            </div>
                                            <label id="image-error" class="error image_error custom-label" for="image"></label>
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
                    <table class="table table-bordered table-striped" id="subcategory_list" >
                        <thead>
                            <tr>
                                <th>#</th>                                
                                <th>Category Name</th>
                                <th>SubCategory Name</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th width="20%">Action</th>
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



@if (Auth::guard('admin')->user()->can('subcategory.edit'))
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="z-index:1049">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Edit SubCategory</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="updateForm" class="form-material">
                <div class="modal-body">

                    <div class="row">

                    <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Category Name</label>                                            
                                                <input type="text" class="form-control" name="category_id" id="category_id" placeholder="Category Name" value="" list="category_id-datalist_edit" autocomplete="off">
                                                    <datalist id="category_id-datalist_edit" class="category">

                                                    </datalist>                                                
                                            </div>
                    </div>                   
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">SubCategory Name:</label>
                                <input type="text" name="subcategory_name" id="subcategory_name" class="form-control" autocomplete="subcategory-name" placeholder="SubCategory Name">
                            </div>
                            <label id="subcategory_name-error" class="error subcategory_name_error custom-label" for="subcategory_name"></label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Slug:</label>
                                <input type="text" name="slug" id="slug" class="form-control" autocomplete="subcategory-slug" placeholder="SubCategory Slug">
                            </div>
                            <label id="slug-error" class="error slug_error custom-label" for="slug"></label>
                        </div>                                            
                    </div>

                <div class="row">

                <div class="col-md-8 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Image</label>                                                
                                                <input type="file" name="image" class="dropify" data-height="100" data-max-file-size="1M" 
                                                data-allowed-file-extensions="jpg jpeg png"/>
                                            </div>                                        <label id="image-error" class="error image_error custom-label" for="image"></label>                                            
                </div> 

                <div class="col-md-4 col-12">

                <div class="form-group">
                <label class="control-label">Current Image</label>
                
                <div id="image_place"></div>

                </div>

                </div>

                </div>

                </div>
                @csrf

                <input type="hidden" name="id" id="id" readonly>
                <input type="hidden" name="current_image" id="current_image" readonly>
                
               

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

$('.dropify').dropify();

$(function() {

getCategoryList();

});


function getCategoryList() {

var items="";
$.getJSON("{{ route('admin.categorylist.subcategory') }}",function(data){
    //items+="<option id='' value='Select a Category'></option>";
    $.each(data,function(index,item)
    {
        items+="<option id='"+item.category_id+"' value='"+item.category_name+"' >"+item.category_name+"</option>";
    });

    $(".category").html(items);
});

}


var subcategory_list = $('#subcategory_list').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"{{ route('admin.subcategory') }}",
                "dataType":"json",
                "type":"GET",
                "data":{"_token":"{{ csrf_token() }} "}                
            },
            "columns":[
                {"data":"DT_RowIndex","className": "center", orderable: false, searchable: false},
                {"data":"category_name"},
                {"data":"subcategory_name"},                              
                {"data":"slug"},                
                { "className": "center",searchable: false,orderable: false,
                "render": function (data, type, row) {
                return "<img class='img-responsive product-image' src='{{ asset('public/upload/category') }}/"+row.image+ "' />"
                }

                },                
                {"data":"status","className": "center"},
                {data: 'action', name: 'action', "className": "center action", orderable: false, searchable: false}

            ],




        });


$.validator.addMethod('category_required', function (value, element , param) {   
    var id = $(param).find('option').filter(
        function(){ return $.trim( $(this).text() ) === value; }).attr('id');                                     

    if (id) {
        return true;
    } else {
        return false;
    }
}, "");


$("#addForm").validate({
rules:
{

    category_id:
    {
        required: true,
        category_required:'#category_id-datalist',                                      
    },
    subcategory_name:
    {
        required: true,
        minlength: 3,                
                
    },
    slug:
    {
        required: true,
        minlength: 3,                
    },
    image:
    {
        required: true,                       
    },    
},

messages:
{
    category_id:
    {
        required: "Please select a category name",
        category_required: "Please select valid category name"

    },
    subcategory_name:
    {
        required: "Please type subcategory name",
        minlength: "Minimum length need to be 3",
    },
    slug:
    {
        required: "Please type slug name",
        minlength: "Minimum length need to be 3",        
    },
    image:
    {
        required: "Please upload image",

    },    
},

submitHandler: function(form) {

    $('.submit_button').css('cursor', 'wait');
    $('.submit_button').attr('disabled', true);

    var category_id_key=$('input[name="category_id"]').val();
    var category_id = $('#category_id-datalist').find('option').filter(function()
    { return $.trim( $(this).text() ) === category_id_key; }).attr('id');    

    var formData = new FormData($('#addForm')[0]);
    formData.append('category_id', category_id);

        $.ajax({
            url: "{{route('admin.store.subcategory')}}",
            type: "POST",
            data: formData,
            dataType:'json',
            cache:false,
            contentType: false,
            processData: false,            
            success: function(res) {      
                
                if(res.success){
                $('.open').trigger('click');
                $(form).trigger("reset");
                $('.dropify-clear').trigger("click"); 
                toastr.success(res.message);
                subcategory_list.ajax.reload();
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



$("#updateForm").validate({

rules:
{
    category_id:
    {
        required: true,
        category_required:'#category_id-datalist_edit',                                      
    },    
    subcategory_name:
    {
        required: true,
        minlength: 3,               
                  
    },
    slug:
    {
        required: true,
        minlength: 3,                            
    }        
},

messages:
{
    category_id:
    {
        required: "Please select a category name",
        category_required: "Please select valid category name"

    },    
    subcategory_name:
    {
        required: "Please type category name",
        minlength: "Minimum length need to be 3",
        remote: 'This category is already exist',
      
    },
    slug:
    {
        required: "Please type slug name",
        minlength: "Minimum length need to be 3",
        remote: 'This slug is already exist',
    }       
},

submitHandler: function(form) {

    $('.update_button').css('cursor', 'wait');
    $('.update_button').attr('disabled', true);

    var category_id_key=$('input[id="category_id"]').val();
    var category_id = $('#category_id-datalist_edit').find('option').filter(function()
    { return $.trim( $(this).text() ) === category_id_key; }).attr('id');    

    var updateData = new FormData($('#updateForm')[0]);
    updateData.append('category_id', category_id);



    $.ajax({
        url: "{{ route('admin.update.subcategory') }}",
        type: "POST",        
        data: updateData,
        dataType:'json',
        cache:false,
        contentType: false,
        processData: false,   
        success: function(res) {        
        
        if(res.success){
         $('#viewModal').modal('hide');
         subcategory_list.ajax.reload();
         toastr.success(res.message);
         $("#updateForm").trigger("reset");
         $('.dropify-clear').trigger("click");
        }

         $('.update_button').css('cursor', 'pointer');
         $('.update_button').removeAttr('disabled');

     },
     error: function(jqXHR, textStatus, errorThrown) {      
        
        if(jqXHR.responseJSON.errors){
        $.each(jqXHR.responseJSON.errors, function(prefix,val){
        $(form).find('label.'+prefix+'_error').html(val[0]).show();        
        });
        toastr.error(jqXHR.responseJSON.message);
        }


        if(!jqXHR.responseJSON.errors){
            $('#viewModal').modal('hide');
            toastr.error(jqXHR.responseJSON);
        }

         $('.update_button').css('cursor', 'pointer');
         $('.update_button').removeAttr('disabled');       

}     
 });
        },                                                // Do not change code below
        errorPlacement: function(error, element)
        {
           error.insertAfter(element.parent());
       }

   });   


   $('#subcategory_list tbody').on( 'click', '#edit_button', function () {
            var data = subcategory_list.row( $(this).parents('tr') ).data();
            $("#category_id").val(data.category_name);
            $("#subcategory_name").val(data.subcategory_name.replace("&amp;", "&"));
            $("#slug").val(data.slug);
            $("#id").val(data.id);                       
            $("#current_image").val(data.image);                       
            $("#image_place").html("<img class='img-responsive product-image-mid' src='{{ asset('public/upload/category') }}/"+data.image+ "' />");                       

        } );


        $('#subcategory_list tbody').on( 'click', '#view_delete', function () {
            var data = subcategory_list.row( $(this).parents('tr') ).data();
        
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
                    url:"{{route('admin.destroy.subcategory')}}",
                    data:{"id":data.id,"_method": 'delete', "_token": "{{ csrf_token() }}" },
                    success:function(response)
                    {
                        toastr.success(response);
                        subcategory_list.ajax.reload();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {      

                        toastr.error(jqXHR.responseJSON);
                        subcategory_list.ajax.reload();

                    }                    

                });



            });            
    


        } );   


</script>    

@stop