<script src="{{ asset('public/backend') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('public/backend') }}/plugins/bootstrap/js/popper.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('public/backend') }}/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="{{ asset('public/backend') }}/js/waves.js"></script>
<!--Menu sidebar -->
<script src="{{ asset('public/backend') }}/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="{{ asset('public/backend') }}/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="{{ asset('public/backend') }}/js/custom.min.js"></script>
<!--Sweetalertjs -->
<script src="{{ asset('public/backend') }}/plugins/sweetalert/sweetalert.min.js"></script>
<!-- This is data table -->
<script src="{{ asset('public/backend') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/backend') }}/plugins/select2/dist/js/select2.full.min.js"></script>
<!-- start - This is for export functionality only -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>


<!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script> -->

<!-- end - This is for export functionality only -->
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="{{ asset('public/backend') }}/plugins/styleswitcher/jQuery.style.switcher.js"></script>
<script src="{{ asset('public/backend') }}/js/jquery.validate.min.js"></script>
<script src="{{ asset('public/backend') }}/js/jquery-additional-methods.js"></script>
<script src="{{ asset('public/backend') }}/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script>
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight:'TRUE',
        autoclose: true,
    }).on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });
    
</script>
