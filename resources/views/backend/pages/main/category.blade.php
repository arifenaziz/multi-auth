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
                    <h6 class="m-b-0 text-white">Category Entry</h6>
                </div>

                <div class="card-body">

                    @if (Auth::guard('admin')->user()->can('category.create'))

                    <button type="button" class="btn btn-info open" data-toggle="collapse" data-target="#add">Add New</button>

                    <div id="add" class="collapse">
                        <div class="row justify-content-md-center">
                            <div class="col col-md-4">
                                <form class="form-material" id="addForm">
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Category Name</label>
                                                <input type="text" name="category_name" class="form-control" autocomplete="off" placeholder="Category Name">
                                            </div>
                                            <label id="category_name-error" class="error category_name_error custom-label" for="category_name"></label>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label">Slug</label>
                                                <input type="text" name="slug" class="form-control" autocomplete="off" placeholder="Category Slug">
                                            </div>
                                            <label id="slug-error" class="error slug_error custom-label" for="slug"></label>
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
                    <table class="table table-bordered table-striped" id="category_list" >
                        <thead>
                            <tr>
                                <th>#</th>                                
                                <th>Category Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
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



@if (Auth::guard('admin')->user()->can('category.edit'))

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
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Category Name:</label>
                                <input type="text" name="category_name" id="category_name" class="form-control" autocomplete="category-name" placeholder="Category Name">
                            </div>
                            <label id="category_name-error" class="error category_name_error custom-label" for="category_name"></label>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Slug:</label>
                                <input type="text" name="slug" id="slug" class="form-control" autocomplete="county-name" placeholder="Category Slug">
                            </div>
                            <label id="slug-error" class="error slug_error custom-label" for="slug"></label>
                        </div>                        

                    </div>
                </div>
                <input type="hidden" name="category_id" id="category_id" readonly>
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


var category_list = $('#category_list').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"{{ route('admin.category') }}",
                "dataType":"json",
                "type":"GET",
                // "data":{"_token":"{{ csrf_token() }} "}
            },
            "columns":[
                {"data":"DT_RowIndex","className": "center", orderable: false, searchable: false},
                {"data":"category_name"},
                // { "className": "left",searchable: false,orderable: false,
                // "render": function (data, type, row) {
                // return row.category_id!='22'? '---'+row.category_name : row.category_name;
                // }

                // },                
                {"data":"slug"},                
                {"data":"status","className": "center"},
                {data: 'action', name: 'action', "className": "center action", orderable: false, searchable: false}

            ],




        });




$("#addForm").validate({

rules:
{


    category_name:
    {
        required: true,
        minlength: 3,      
                
    },
    slug:
    {
        required: true,
        minlength: 3,
      
    },
},

messages:
{

    category_name:
    {
        required: "Please type category name",
        minlength: "Minimum length need to be 3",        
    },
    slug:
    {
        required: "Please type slug name",
        minlength: "Minimum length need to be 3",        
    },
},

submitHandler: function(form) {

    $('.submit_button').css('cursor', 'wait');
    $('.submit_button').attr('disabled', true);

        $.ajax({
            url: "{{route('admin.store.category')}}",
            type: "POST",
            data: $(form).serialize(),
            dataType:'json',
            success: function(res) {      
                


            if(res.success){
                $('.open').trigger('click');
                $(form).trigger("reset");    
                toastr.success(res.message);
                category_list.ajax.reload();           
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
    category_name:
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
    category_name:
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

    $.ajax({
        url: "{{ route('admin.update.category') }}",
        type: 'PUT',
        data: $(form).serialize(),
        dataType:'json',
        success: function(res) {        
        


         if(res.success){
         
         $('#viewModal').modal('hide');
         category_list.ajax.reload();
         toastr.success(res.message);
         $(form).trigger("reset"); 

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


   $('#category_list tbody').on( 'click', '#edit_button', function () {
            var data = category_list.row( $(this).parents('tr') ).data();
            $("#category_name").val(data.category_name);
            $("#slug").val(data.slug);
            $("#category_id").val(data.category_id);                       
        } );


        $('#category_list tbody').on( 'click', '#view_delete', function () {
            var data = category_list.row( $(this).parents('tr') ).data();
        
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
                    url:"{{route('admin.destroy.category')}}",
                    data:{"category_id":data.category_id,"_method": 'delete', "_token": "{{ csrf_token() }}" },
                    success:function(response)
                    {
                        toastr.success(response);
                        category_list.ajax.reload();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {      

                        toastr.error(jqXHR.responseJSON);
                        category_list.ajax.reload();

                    }                    

                });



            });            
    


        } );   


</script>    

@stop