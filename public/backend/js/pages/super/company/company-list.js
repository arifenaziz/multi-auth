
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var active_company = $('#active_company').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Company/CompanyList/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;
        d.status = "active";
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


$('#active_company tbody').on( 'click', '#view', function () {
  var data = active_company.row( $(this).parents('tr') ).data();
    window.location.replace(baseURL+'super/viewCompanyDetails/'+data[7]);
});  




var deactive_company = $('#deactive_company').DataTable( {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax":{
     "url": baseURL + "tableResponse/Company/CompanyList/ajax_list",
     "type": "POST",
     data: function(d) {
         d.csrf_covicheck_mhc_secured = token_key;
         d.status = "deactive";
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
 
 
 $('#deactive_company tbody').on( 'click', '#view', function () {
   var data = deactive_company.row( $(this).parents('tr') ).data();
     window.location.replace(baseURL+'super/viewCompanyDetails/'+data[7]);
 });  


 
var cancelled_company = $('#cancelled_company').DataTable( {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax":{
     "url": baseURL + "tableResponse/Company/CompanyList/ajax_list",
     "type": "POST",
     data: function(d) {
         d.csrf_covicheck_mhc_secured = token_key;
         d.status = "cancelled";
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
 
 
 $('#cancelled_company tbody').on( 'click', '#view', function () {
   var data = cancelled_company.row( $(this).parents('tr') ).data();
     window.location.replace(baseURL+'super/viewCompanyDetails/'+data[7]);
 }); 


 var closed_company = $('#closed_company').DataTable( {
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "ajax":{
     "url": baseURL + "tableResponse/Company/CompanyList/ajax_list",
     "type": "POST",
     data: function(d) {
         d.csrf_covicheck_mhc_secured = token_key;
         d.status = "closed";
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
 
 
 $('#closed_company tbody').on( 'click', '#view', function () {
   var data = closed_company.row( $(this).parents('tr') ).data();
     window.location.replace(baseURL+'super/viewCompanyDetails/'+data[7]);
 }); 