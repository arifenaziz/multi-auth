
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var city_list = $('#city_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/CityList/CityResponse/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;
    }
},           

"columns": [
null,
null,
null,
{ "className": "center",searchable: false,orderable: false },
], 

"autoWidth": false,


"columnDefs": [ {
    "targets": -1,
    "data": null,
    "defaultContent": "<td align='center'><a href='#view_city' role='button' id='view' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-bars'></i> Edit</a> </td> "
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


$('#city_list tbody').on( 'click', '#view', function () {
  var data = city_list.row( $(this).parents('tr') ).data();


  $('#city_name').val(data[1]);
  $('#county_name').val(data[2]);
  $('#id').val(data[3]);


} );



$("#addForm").validate({

    rules:
    {


        city_name:
        {
            required: true,
        },
        county_name:
        {
            required: true,
        },
    },

    messages:
    {

        city_name:
        {
            required: "Please type city name",
        },
        county_name:
        {
            required: "Please type county name",
        },
    },

    submitHandler: function(form) {

        $('.submit_button').css('cursor', 'wait');
        $('.submit_button').attr('disabled', true);

            $.ajax({
                url: baseURL + "request/City/CityInsertProcessing",
                type: "POST",
                data: $('#addForm').serialize(),
                dataType:'json',
                success: function(res) {        

                $('.open').trigger('click');
                var response_brought = res.response.indexOf('save_succcessfully');

                if (response_brought != -1)
                {
                 swal({
                    title: "City Added Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });

                 $("#addForm").trigger("reset");
                 city_list.ajax.reload();
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
        city_name:
        {
            required: true,
        },
        county_name:
        {
            required: true,            
        }        
    },

    messages:
    {
        city_name:
        {
            required: "Please type city name",
        },
        county_name:
        {
            required: "Please type county quantity",
        }       
    },

    submitHandler: function(form) {

        $('.update_button').css('cursor', 'wait');
        $('.update_button').attr('disabled', true);


        $.ajax({
            url: baseURL + "request/City/CityUpdateProcessing",
            type: 'POST',
            data: $('#updateForm').serialize()+'&csrf_covicheck_mhc_secured=' + token_key,
            dataType:'json',
            success: function(res) {        

               
                $('#view_city').modal('hide');

                var response_brought = res.response.indexOf('update_succcessfully');

                if (response_brought != -1)
                {
                 swal({
                    title: "City Updated Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });

                 $("#updateForm").trigger("reset");
                 city_list.ajax.reload();
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