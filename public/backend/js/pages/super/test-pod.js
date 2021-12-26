
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();


$(function() {
    getAllCities();
});



function getAllCities() {

    var items="";
    $.getJSON(baseURL+"request/TestPod/getAllCitiesData",function(data){
        items+="<option value='' >-select a city-</option>";
        $.each(data,function(index,item)
        {
            items+="<option id='"+item.main_id+"' value='"+item.full_address+"' >"+item.full_address+"</option>";
        });

        $(".city_list").html(items);
    });

}


function getCityID(value){

    var getValue= $('#city_id_datalist').find('option').filter(function()
        { return $.trim( $(this).text() ) === value; }).attr('id');

    return getValue;

}


function getEditCityID(value){

    var getValue= $('#city_id_datalist_edit').find('option').filter(function()
        { return $.trim( $(this).text() ) === value; }).attr('id');

    return getValue;

}


var pod_list = $('#pod_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/PodList/PodResponse/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;
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
    "defaultContent": "<td align='center'><a href='#view_pod' role='button' id='view' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-bars'></i> Edit</a> </td> "
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


$('#pod_list tbody').on( 'click', '#view', function () {
  var data = pod_list.row( $(this).parents('tr') ).data();


  $('#pod_name').val(data[1]);
  $('#city_type_edit').val(data[2]);
  $('#address').val(data[3]);
  $('#status').val(data[5]);
  $('#id').val(data[6]);


} );


$.validator.addMethod('custom_required', function (value, element) {
    if (value == "") {
        swal({
            title: "Select a Patient",
            type: "error",
            timer: 1500,
            showConfirmButton: false,
            customClass: 'swal-height'
        });
        $('label.error').hide();
        return false;


    } else {
        $('label.error').hide();
        return true;
    }
}, "");


$.validator.addMethod('valid_city_required', function (value, element) {
    
    var hold_city_id = getCityID(value);

    if(hold_city_id === undefined || hold_city_id === null || hold_city_id === ""){

        return false;

    }else{

        return true;

    }

    
}, "");


$("#addForm").validate({

    rules:
    {

        pod_name:
        {
            required: true,
        },
        city_type:
        {
            required: true,
            valid_city_required:true
        },
        address:
        {
            required: true,
        },
    },

    messages:
    {


        pod_name:
        {
            required: "Please type pod name",
        },
        city_type:
        {
            required: "Please select a city",
            valid_city_required: "Please select a valid city"
        },
        address:
        {
            required: "Please type address",
        },
    },

    submitHandler: function(form) {

        $('.submit_button').css('cursor', 'wait');
        $('.submit_button').attr('disabled', true);


                var city_type=$('#city_type').val();
                var city_id = getCityID(city_type);


            $.ajax({
                url: baseURL + "request/TestPod/PodInsertProcessing",
                type: "POST",
                data: $('#addForm').serialize()+'&city_id='+city_id,
                dataType:'json',
                success: function(res) {        

                $('.open').trigger('click');
                var response_brought = res.response.indexOf('save_succcessfully');

                if (response_brought != -1)
                {
                 swal({
                    title: "Test Pod Added Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });

                 $("#addForm").trigger("reset");
                 pod_list.ajax.reload();
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


$.validator.addMethod('valid_edit_city_required', function (value, element) {
    
    var hold_city_id = getEditCityID(value);

    if(hold_city_id === undefined || hold_city_id === null || hold_city_id === ""){

        return false;

    }else{

        return true;

    }

    
}, "");



$("#updateForm").validate({

     rules:
    {

        pod_name:
        {
            required: true,
        },
        city_type_edit:
        {
            required: true,
            valid_edit_city_required:true
        },
        address:
        {
            required: true,
        },
        status:
        {
            required: true,
        },        
    },

    messages:
    {


        pod_name:
        {
            required: "Please type pod name",
        },
        city_type_edit:
        {
            required: "Please select a city",
            valid_edit_city_required: "Please select a valid city"
        },
        address:
        {
            required: "Please type address",
        },
        status:
        {
            required: "Please select a status",
        },        
    },

    submitHandler: function(form) {

        $('.update_button').css('cursor', 'wait');
        $('.update_button').attr('disabled', true);

                var city_type=$('#city_type_edit').val();
                var city_id = getEditCityID(city_type);        


        $.ajax({
            url: baseURL + "request/TestPod/PodUpdateProcessing",
            type: 'POST',
            data: $('#updateForm').serialize()+'&csrf_covicheck_mhc_secured=' + token_key + '&city_id='+city_id,
            dataType:'json',
            success: function(res) {        

               
                $('#view_pod').modal('hide');

                var response_brought = res.response.indexOf('update_succcessfully');

                if (response_brought != -1)
                {
                 swal({
                    title: "Pod Updated Successfully",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
                });

                 $("#updateForm").trigger("reset");
                 pod_list.ajax.reload();
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