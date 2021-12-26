
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();
var ref_id=$('#ref_id').val();


var consumer_booking_list = $('#consumer_booking_list').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Consumer/ConsumerBookingList/ajax_list",
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
{ "className": "center",searchable: false,orderable: false },
], 

"autoWidth": false,


// "columnDefs": [ {
//     "targets": -1,
//     "data": null,
//     "defaultContent": "<td align='center'><a href='#view_pod' role='button' id='view' class='btn btn-primary btn-xs small_btn' title='Details' data-toggle='modal'><i class='fa fa-bars'></i> Edit</a> </td> "
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


