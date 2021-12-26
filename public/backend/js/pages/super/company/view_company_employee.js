
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var ref_id=$('#ref_id').val();


var company_employee = $('#company_employee').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Company/CompanyEmployee/ajax_list",
    "type": "POST",
    data: function(d) {
        d.csrf_covicheck_mhc_secured = token_key;
        d.ref_id = ref_id;
    }
},           

"columns": [
null,
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
    "defaultContent": "<td align='center'><button role='button' id='view' class='btn btn-info btn-xs small_btn' data-toggle='tooltip' title='Print'><i class='fa fa-bars'></i> View</button> </td> ",
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




$('#company_employee tbody').on( 'click', '#view', function () {
    var data = company_employee.row($(this).parents('tr')).data();

    window.location.replace(baseURL+'super/viewConsumerDetails/'+data[8]);

});



