
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();



var approved_consumers_list = $('#approved_consumers_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Consumer/ConsumerApprovedList/ajax_list",
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
null,
null,
{ "className": "center"},
{ "className": "center",searchable: false,orderable: false },
], 

"autoWidth": false,


"columnDefs": [ {
    "targets": -1,
    "data": null,
    "defaultContent": "<td align='center'><button role='button' id='view' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-bars'></i> View</button> </td> "
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


$('#approved_consumers_list tbody').on( 'click', '#view', function () {
  var data = approved_consumers_list.row( $(this).parents('tr') ).data();
    window.location.replace(baseURL+'super/viewConsumerDetails/'+data[7]);
}); 





var pending_consumers_list = $('#pending_consumers_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Consumer/ConsumerList/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;  
        d.flag=1      
    }
},           

"columns": [
null,
null,
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
    "defaultContent": "<td align='center'><button role='button' id='approval' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-check-square'></i> Approval</button> </td> "
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


$('#pending_consumers_list tbody').on( 'click', '#approval', function () {
  var data = pending_consumers_list.row( $(this).parents('tr') ).data();

  swal({
       title: "Are you sure for approval?",
       type: "warning",
       showCancelButton: true,
       confirmButtonColor: "#DD6B55",
       confirmButtonText: "Yes",
       closeOnConfirm: false
        }, function () {

$(".confirm").attr('disabled', 'disabled');
$(".cancel").attr('disabled', 'disabled');

if(data[7]){
var infoData = '&selectedData=' + data[7] +'&csrf_covicheck_mhc_secured=' + token_key;

        $.ajax({
            type: "POST",
            url: baseURL + "request/Consumer/ConsumerApprovalProcessing",
            data:infoData,
            dataType:'json',
            cache: false,
            success: function (response) {

            var response_brought = response.response.indexOf('Update successfully');

            if (response_brought != -1)
            {

            swal({
            title: "Approved",
            type: "success",
            timer: 1500,
            showConfirmButton: false,
            customClass: 'swal-height'
            });         
            
            pending_consumers_list.ajax.reload();

            
            }else{

            swal({
                title: "Problem Occur",
                type: "error",
                timer: 1500,
                showConfirmButton: false,
                customClass: 'swal-height'

            });
            


            }
          
          $('.confirm').removeAttr('disabled');
          $('.cancel').removeAttr('disabled');


            }

});

}





})




});  



var unverified_consumers_list = $('#unverified_consumers_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Consumer/ConsumerList/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;  
        d.flag=0      
    }
},           

"columns": [
null,
null,
null,
null,
null,
null,
{ "className": "center"},
// { "className": "center",searchable: false,orderable: false },
], 

"autoWidth": false,


// "columnDefs": [ {
//     "targets": -1,
//     "data": null,
//     "defaultContent": "<td align='center'><button role='button' id='view' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-bars'></i> View</button> </td> "
// } ],

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


$('#unverified_consumers_list tbody').on( 'click', '#view', function () {
  var data = unverified_consumers_list.row( $(this).parents('tr') ).data();
    window.location.replace(baseURL+'super/viewCompanyDetails/'+data[7]);
});


