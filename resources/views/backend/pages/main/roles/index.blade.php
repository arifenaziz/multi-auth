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
                    <h6 class="m-b-0 text-white">Role List</h6>
                </div>

                <div class="card-body">
                @if (Auth::guard('admin')->user()->can('role.create'))    
                <a href="{{ route('admin.roles.create') }}" type="button" class="btn btn-info">Add New</a>
                @endif
                <div class="table-responsive">
                    <br>
                    <table class="table table-bordered table-striped" id="role_list" >
                        <thead>
                            <tr>
                                <th width="5%">#</th>                                
                                <th width="10%">Role Name</th>                                
                                <th width="40%">Permissons</th>
                                <th width="10%">Action</th>
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






<script>


var role_list = $('#role_list').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"{{ route('admin.roles') }}",
                "dataType":"json",
                "type":"GET",
                // "data":{"_token":"{{ csrf_token() }} "}
            },
            "columns":[
                {"data":"DT_RowIndex","className": "center", orderable: false, searchable: false},
                {"data":"name", "name":"name"},                                           
                { "data":"permissonList","name":"permissonList","className": "left",searchable: false,orderable: false,defaultContent:"",
                "render": function (data, type, row) {
                    var items="";
                    $.each(row.permissonList,function(index,item){
                        items+= "<span class='badge badge-primary mr-1 custom-badge'>"+item+"</span>";
                    
                });
                return items;
                }

                },                
                {data: 'action', name: 'action', "className": "center action", orderable: false, searchable: false}

            ],               


        });





        $('#role_list tbody').on( 'click', '#view_delete', function () {
            var data = role_list.row( $(this).parents('tr') ).data();
        
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
                    url:"{{route('admin.roles.destroy')}}",
                    data:{"id":data.id,"_method": 'delete', "_token": "{{ csrf_token() }}" },
                    success:function(response)
                    {
                        toastr.success(response);
                        role_list.ajax.reload();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {      

                        toastr.error(jqXHR.responseJSON);
                        role_list.ajax.reload();

                    }                    

                });



            });            
    


        } );   


</script>    

@stop