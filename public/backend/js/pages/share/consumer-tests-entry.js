var baseURL = $('body').data('baseurl');
var token_key=$('#token_key').val();


$(function() {
    getConsumerData();
});


function getConsumerData() {

    var items="";
    $.getJSON(baseURL+"request/Tests/consumersData",function(data){
        items+="<option value='' >-select a consumer-</option>";
        $.each(data,function(index,item)
        {
            items+="<option id='"+item.employee_id+"' value='"+item.full_name+"' >"+item.full_name+"</option>";
        });

        $(".patient_list").html(items);
    });

}
$("#retest_patient_button").keyup(function(event){
    if(event.keyCode == 13){

        if($('#retest_patient_button').attr('disabled')){

        }else{

            $("#retest_patient_button").click();

        }
    }
});

$(document).on('click', '#retest_patient_button', function(){

    var patient_key=$('#patient_type').val();
    var patient_id = $('#patient_id_datalist').find('option').filter(function()
        { return $.trim( $(this).text() ) === patient_key; }).attr('id');


    if(patient_id === undefined || patient_id === null || patient_id === ""){

        $("#addForm").trigger("reset");

        $('.retestRemoveReadonly').attr('readonly', 'readonly'); 

        swal({
            title: "Select a valid patient",
            type: "error",
            timer: 1500,
            showConfirmButton: false,
            customClass: 'swal-height'
        });

    }
    else{

        $.getJSON(baseURL+"request/Tests/singleConsumerData?employee_id="+ patient_id,function(data){

            $('.retestRemoveReadonly').removeAttr('readonly', 'readonly');
            $('#patient_type').val('');
            $('#firstname').val(data.firstname);
            $('#lastname').val(data.lastname);
            $('#middlename').val(data.middlename);
            $('#gender').val(data.gender);
            $('#date_of_birth').val(data.date_of_birth);
            $('#email').val(data.email);
            $('#contact_no').val(data.contact_no);
            $('#employee_no').val(data.employee_number);
            $('#payroll_no').val(data.payroll_number);
            $('#address').val(data.address);
            $('#post_code').val(data.post_code);
            $('#nin').val(data.nin);
            $('#nhs').val(data.nhs);
            $('#ethnicity').val(data.ethnicity);
            $('#gym_number').val(data.gym_number);
            $('#vaccination_status').val(data.vaccination_status);
            $('#driving_license').val(data.driving_license);
            $('#passport').val(data.passport);
            $('#idVal').val(data.employee_id);
        });
    }

});

var testTable = $('#testTable').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/TestsList/ConsumerTestsResponse/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;
    }
},           

"columns": [
    null,
    { "className": "center"},
    { "className": "center"},
    null,
    null,
    null,
    { "className": "center"},
    { "className": "center"},
    null,
    { "className": "right"},
    { "className": "right"},
    { "className": "center",searchable: false,orderable: false },
    ],  

"autoWidth": false,


"columnDefs": [ {
    "targets": -1,
    "data": null,
    "defaultContent": "<td align='center'><a href='#view_enquery' role='button' id='details' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-bars'></i> View</a> </td> "
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


$('#testTable tbody').on( 'click', '#details', function () {
  var data = testTable.row( $(this).parents('tr') ).data();
  
  $('#modal_firstname').val(data[18]);
  $('#modal_middlename').val(data[19]);
  $('#modal_lastname').val(data[20]);
  $('#modal_gender').val(data[13]);
  $('#modal_date_of_birth').val(data[14]);
  $('#modal_email').val(data[17]);
  $('#modal_contact_no').val(data[16]);
  $('#modal_address').val(data[15]);
  $('#modal_post_code').val(data[21]);
  $('#modal_test_date').val(data[1]);
  $('#modal_test_kit_type').val(data[4]);
  $('#modal_result').val(data[5]);
  $('#modal_specimen').val(data[6]);
  $('#modal_self_isolation_recomanded').val(data[7]);               
  $('#modal_rt_pcr').val(data[8]);
  $('#modal_retest').val(data[9]);
  $('#modal_retest_date').val(data[10]);
  $('#modal_nin').val(data[22]);
  $('#modal_nhs').val(data[23]);
  $('#modal_ethnicity').val(data[24]);
  $('#modal_gym_number').val(data[25]);
  $('#modal_vaccination_status').val(data[26]);
  $('#modal_driving_license').val(data[27]);
  $('#modal_passport').val(data[28]);
  $('#modal_symptoms').val(data[29]);
  $('#modal_temperature').val(data[30]);
  $('#modal_close_contact').val(data[31]);


  if(data[9]=="Yes"){
    $('#modal_retest_date_box').show();
}
else{
    $('#modal_retest_date_box').hide();
}
} ); 


$('#retest').on('change',function(){
    var retestValue=$('#retest').val();
    if(retestValue=='No'){
        $('#retest_date_box').slideUp();
    }
    else if(retestValue=='Yes'){
        $('#retest_date_box').slideDown();
    }
    else{
     $('#retest_date_box').slideUp();
 }
}) 




$.validator.addMethod( "phoneUK", function( phone_number, element ) {
  phone_number = phone_number.replace( /\(|\)|\s+|-/g, "" );
  return this.optional( element ) || phone_number.length > 9 &&
  phone_number.match( /^(?:(?:(?:00\s?|\+)44\s?)|(?:\(?0))(?:\d{2}\)?\s?\d{4}\s?\d{4}|\d{3}\)?\s?\d{3}\s?\d{3,4}|\d{4}\)?\s?(?:\d{5}|\d{3}\s?\d{3})|\d{5}\)?\s?\d{4,5})$/ );
}, "Please specify a valid phone number" );

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


$("#addForm").validate({

    rules:
    {
        firstname:{
            custom_required: true,
        },
        test_kit_type:
        {
            required: true,
        },
        test_date:
        {
            required: true,
        },
        result:
        {
            required: true,
        },
        specimen:
        {
            required: true,
        },
        self_isolation_recomanded:
        {
            required: true,
        },
        rt_pcr:
        {
            required: true,
        },
        retest:
        {
            required: true,
        },
        retest_date:{

            required: function(){

                return $("#retest").val()=="Yes";
            }
        }
    },

    messages:
    {
        firstname:{
            required: "",
        },
        test_kit_type:
        {
            required: "Please select test kit type",
        },
        test_date:
        {
            required: "Please type test date",
        },
        result:
        {
           required: "Please select a result",
       },
       specimen:
       {
        required: "Please select specimen",
    },
    self_isolation_recomanded:
    {
        required: "Please select recomaded or not",
    },
    rt_pcr:
    {
        required: "Please select a option",
    },
    retest:
    {
        required: "Please select retest or not",
    },
    retest_date:{
        required: "Please select retest date",   
    }
},

submitHandler: function(form) {

    $('.submit_button').css('cursor', 'wait');
    $('.submit_button').attr('disabled', true);

    $.ajax({
        url: baseURL + "request/Tests/testEntryProcess",
        type: 'POST',
        data: $('#addForm').serialize(),
        dataType:'json',
        success: function(res) {
            $('.open').trigger('click');

            var response_brought = res.response.indexOf('Test save successfully');


            if (response_brought != -1)
            {
             swal({
                title: "Test Added Successfully",
                type: "success",
                timer: 1500,
                showConfirmButton: false,
                customClass: 'swal-height'
            });

             $("#addForm").trigger("reset");
             testTable.ajax.reload();
             $('#retest_date_box').hide();
             $('#idVal').val('');
             $('#patient_type').val('');
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