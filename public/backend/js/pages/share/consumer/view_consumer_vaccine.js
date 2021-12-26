
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var ref_id=$('#ref_id').val();



var consumer_vaccine_list = $('#consumer_vaccine_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Consumer/ConsumerVaccineList/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;     
        d.ref_id=ref_id   
    }
},           

"columns": [
null,
null,
null,
null,
null,
null,
{ "className": "center",searchable: false,orderable: false },
], 

"autoWidth": false,


"columnDefs": [ {
    "targets": -1,
    "data": null,
    "defaultContent": "<a href='#edit_vaccine_modal' role='button' id='vaccine_edit' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-edit'></i> Edit</a> </td> "
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


$('#consumer_vaccine_list tbody').on( 'click', '#vaccine_edit', function () {
    var data = consumer_vaccine_list.row( $(this).parents('tr') ).data();      

      $('#edit_vaccine_date').val(data[3]);
      $('#edit_batch_no').val(data[4]);
      $('#vhash_id').val(data[6]);
        
  });




$('#type').on('change', function(){
   var name = $(this).val();
    $('#set').html('<option value="" disabled="" selected="">-select a option-</option>');
    if(name=='vaccine'){
        $('#set').append('<option value="first vaccine">First Vaccine</option><option value="second vaccine">Second Vaccine</option>');
    }else{
        $('#set').append('<option value="antibody booster">Antibody Booster</option>');
    }
});


$("#vaccineAddForm").validate({

    rules:
    {

        type:
        {
            required: true,
        },
        set:
        {
            required: true,
        },
        vaccine_entry_date:
        {
            required: true,
        },
        vaccine_batch_no:
        {
            required: true,
        },
        list_vaccine_name:{
           required: true, 
       },      
    },

    messages:
    {
        type:
        {
            required: "Please select a option",
        },
        set:
        {
            required: "Please select a option",
        },
        vaccine_entry_date:
        {
            required: "Please select a date",
        },
        vaccine_batch_no:
        {
            required: "Please type batch no",
        },
        list_vaccine_name:{
            required: "Please select a vaccine name",
        }
        },

    submitHandler: function(form) {

        $('.vaccine_submit_button').css('cursor', 'wait');
        $('.vaccine_submit_button').attr('disabled', true);

        $.ajax({
            url: baseURL + "request/Consumer/vaccineEntryProcess",
            type: 'POST',
            data: $('#vaccineAddForm').serialize()+'&csrf_covicheck_mhc_secured='+token_key,
            dataType:'json',
            success: function(res) {
                                

                var response_brought = res.response.indexOf('Insert successfully');
                var no_vaccine = res.response.indexOf('No Vaccine Data');
                var no_does = res.response.indexOf('No second does');
                var data_exits = res.response.indexOf('Data Exists');


                if (response_brought != -1)
                {

                $('.vaccine_open').trigger('click');                    
                
                 swal({
                    title: "Added Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });
                 
                 $("#vaccineAddForm").trigger("reset");
                 consumer_vaccine_list.ajax.reload();                   

                 
              }else if(no_vaccine != -1){

                 swal({
                    title: "No Vaccine Data Found",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });                  

              }else if(no_does != -1){

                 swal({
                    title: "No Second Does",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });                  

              }else if(data_exits != -1){

                 swal({
                    title: "Data Already Exits",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });                  

              }else{


            swal({
                title: "Problem Occur",
                type: "error",
                timer: 1500,
                showConfirmButton: false,
                customClass: 'swal-height'

            });

            $("#vaccineAddForm").trigger("reset");


              }

             $('.vaccine_submit_button').css('cursor', 'pointer');
             $('.vaccine_submit_button').removeAttr('disabled');

         }
        });
        },                                                // Do not change code below
        errorPlacement: function(error, element)
        {
           error.insertAfter(element.parent());
       }

       });


$("#vaccineUpdateForm").validate({

    rules:
    {

        edit_vaccine_date:
        {
            required: true,
        },
        edit_batch_no:
        {
            required: true,
        },
             
    },

    messages:
    {
        edit_vaccine_date:
        {
            required: "Please select a vaccine date",
        },
        edit_batch_no:
        {
            required: "Please type batch no",
        },
        },

    submitHandler: function(form) {

        $('.vaccine_update_button').css('cursor', 'wait');
        $('.vaccine_update_button').attr('disabled', true);

        $.ajax({
            url: baseURL + "request/Consumer/vaccineUpdateProcess",
            type: 'POST',
            data: $('#vaccineUpdateForm').serialize()+'&csrf_covicheck_mhc_secured='+token_key,
            dataType:'json',
            success: function(res) {
                                
                $('#edit_vaccine_modal').modal('hide');

                var response_brought = res.response.indexOf('Update successfully');


                if (response_brought != -1)
                {
                                
                
                 swal({
                    title: "Updated Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });
                                  
                 consumer_vaccine_list.ajax.reload();                    
                 
              }else{


            swal({
                title: "Problem Occur",
                type: "error",
                timer: 1500,
                showConfirmButton: false,
                customClass: 'swal-height'

            });
            

            }

             $('.vaccine_update_button').css('cursor', 'pointer');
             $('.vaccine_update_button').removeAttr('disabled');

         }
        });
        },                                                // Do not change code below
        errorPlacement: function(error, element)
        {
           error.insertAfter(element.parent());
       }

       });