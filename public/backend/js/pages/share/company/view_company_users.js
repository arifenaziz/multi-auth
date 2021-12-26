
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var hash_id=$('#hash_id').val();



$(document).on('click','.generate_users', function () {


    $('.generate_users').css('cursor', 'wait');
    $('.generate_users').attr('disabled', true);


    var infoData = '&hash_id=' + hash_id +'&csrf_covicheck_mhc_secured=' + token_key;

    $.ajax({
        type: "POST",
        url: baseURL + "request/Company/generateUsersProcessing",
        data:infoData,
        dataType:'json',
        cache: false,
        success: function (res) {


            var response_brought = res.response.indexOf('added_succcessfully');

            if (response_brought != -1)
            {
                swal({
                    title: "User Generated Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });

                $("#generate_users").hide();
                $('.top-button').html("<button type=\"button\" class=\"btn btn-info open\" data-toggle=\"collapse\" data-target=\"#add\">Add New User</button>");
                company_user_list.ajax.reload();
            }
            else{



                swal({
                    title: "Problem Occur",
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'

                });

            }




        }


    })




});


var company_user_list = $('#company_user_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Company/CompanyUsers/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;
        d.hash_id=hash_id;
    }
},           

"columns": [
null,
null,
null,
null,
{ "className": "center"},
{ "className": "center",searchable: false,orderable: false },
], 

"autoWidth": false,


"columnDefs": [ {
    "targets": -1,
    "data": null,
    "defaultContent": "<td align='center'><a href='#view_user' role='button' id='view' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-bars'></i> Edit</a> </td> "
} ],

"aLengthMenu": [
[10, 25, 50, -1],
[10, 25, 50, "All"]
],
    // set the initial value
    "iDisplayLength": 10,
    "bFilter" : true,               
    "bLengthChange": true,
    "bInfo": true,
    "bPaginate": true,     
    "aaSorting": [[ 0, "asc" ]], 

} );


$('#company_user_list tbody').on( 'click', '#view', function () {
  var data = company_user_list.row( $(this).parents('tr') ).data();


  $('#first_name').val(data[1]);
  $('#last_name').val(data[2]);
  $('#email').val(data[3]);
  $('#status').val(data[4]);
  $('#id').val(data[5]);


} );  



$("#addUsers").validate({

    rules:
    {
        first_name:
        {
            required: true,
        },
        last_name:
        {
            required: true,
        },
        email:
        {
            required: true,
            email: true,
            maxlength:50,
            remote: {
                url: baseURL+"request/Company/company_user_email_valid_process",
                data:{'hash_id':hash_id},
                type : "post"
            },
        },
        password:
        {
                required: true,
        },
    },

    messages:
    {
        first_name:
        {
            required: "Please type first name",
        },
        last_name:
        {
            required: "Please type last Name",
        },
        email:
        {
            required: "Please type email address",
            email: 'Please enter a Valid email address',
            remote:'This email address is already exits'
        },
        password:
            {
                required: "Please type password",
            },
    },

    submitHandler: function(form) {

        $('.submit_button').css('cursor', 'wait');
        $('.submit_button').attr('disabled', true);

        $.ajax({
            url: baseURL + "request/Company/UserInsertProcessing",
            type: 'POST',
            data: $('#addUsers').serialize(),
            dataType:'json',
            success: function(res) {

                $('.open').trigger('click');
                var response_brought = res.response.indexOf('added_succcessfully');

                if (response_brought != -1)
                {
                 swal({
                    title: "User Added Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });

                 $("#addUsers").trigger("reset");
                    company_user_list.ajax.reload();
                }
                else{



                    swal({
                        title: "Problem Occur",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: 'swal-height'

                    });

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
            first_name:
                {
                    required: true,
                },
            last_name:
                {
                    required: true,
                },
            email:
                {
                    required: true,
                    email: true,
                    maxlength:50,
                },
            status:
                {
                    required: true,
                },
        },

    messages:
        {
            first_name:
                {
                    required: "Please type first name",
                },
            last_name:
                {
                    required: "Please type last Name",
                },
            email:
                {
                    required: "Please type email address",
                    email: 'Please enter a Valid email address',
                },
            status:
                {
                    required: "Please select a status",
                },
        },

    submitHandler: function(form) {

        $('.update_button').css('cursor', 'wait');
        $('.update_button').attr('disabled', true);

        $.ajax({
            url: baseURL + "request/Company/UserUpdateProcessing",
            type: 'POST',
            data: $('#updateForm').serialize()+'&csrf_covicheck_mhc_secured=' + token_key,
            dataType:'json',
            success: function(res) {

               
                $('#view_user').modal('hide');

                var response_brought = res.response.indexOf('update_succcessfully');

                if (response_brought != -1)
                {
                 swal({
                    title: "User Updated Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });

                 $("#updateForm").trigger("reset");
                    company_user_list.ajax.reload();
                }
                else{


            swal({
                title: "Problem Occur",
                type: "error",
                timer: 1500,
                showConfirmButton: false,
                customClass: 'swal-height'

            });

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