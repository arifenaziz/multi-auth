
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var ref_id=$('#ref_id').val();


var consumer_login_activity = $('#consumer_login_activity').DataTable( {
   "processing": true,
   "serverSide": true,
   "deferRender": true,
   "ajax":{
    "url": baseURL + "tableResponse/Consumer/ConsumerLoginActivity/ajax_list",
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
{ "className": "center details-control",searchable: false,orderable: false,
    "render": function (data, type, row) {
        return '<a class="platform">' +row["6"]+ ' <i class="mdi mdi-information"></i></a>';
    }

},
{ "className": "center country_name details-control",searchable: false,orderable: false,
    "render": function (data, type, row) {
        return '<div class="flag" id="' +row["8"]+ '" ></div> ' +row["7"]+ '';
    }

},
], 

"autoWidth": false,


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




function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Platform:</td>'+
            '<td>'+d[6]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Browser:</td>'+
            '<td>'+d[9]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Browser Version:</td>'+
            '<td>'+d[10]+'</td>'+
        '</tr>'+
    '</table>';
}


    $('#consumer_login_activity tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = consumer_login_activity.row( tr );        
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );



$('#consumer_login_activity tbody').on( 'click', '#view', function () {
    var data = consumer_login_activity.row($(this).parents('tr')).data();

    window.location.replace(baseURL+'super/viewConsumerDetails/'+data[8]);

});



