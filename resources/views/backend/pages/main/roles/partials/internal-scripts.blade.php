<script>

$("#checkAllPermisson").click(function(){
             if($(this).is(':checked')){
                 // check all the permisson checkbox
                 $('input[type=checkbox]').prop('checked', true);
             }else{
                 // un-check all the permisson checkbox
                 $('input[type=checkbox]').prop('checked', false);
             }
});


        function checkGroupPermisson(groupPermission,groupID){

            const groupIDProcess =$('#'+groupID.id);
            const groupPermissonClass=$('.'+groupPermission+' input' );       

             if(groupIDProcess.is(':checked')){
                 // check all the permisson checkbox
                 groupPermissonClass.prop('checked', true);
             }else{
                 // un-check all the permisson checkbox
                 groupPermissonClass.prop('checked', false);
             }
             allPermissionCheck();
    }


    function checkSinglePermisson(groupPermissionClass,groupID,groupPermissonCount){
        
        const groupIdProcess = $('#'+groupID);

    if($('.'+groupPermissionClass+ ' input:checked').length == groupPermissonCount){
        groupIdProcess.prop('checked', true);
    }else{
        groupIdProcess.prop('checked', false);
    }
    allPermissionCheck();

    }


    function allPermissionCheck(){
        const totalPermisonCount = "{{ count($all_permissions) }}";
        const totalGroupCount = "{{ count($permission_groups) }}";

        console.log(parseInt(totalPermisonCount) + parseInt(totalGroupCount));
        console.log($('input[type="checkbox"]:checked').length);

        if($('input[type="checkbox"]:checked').length >= (parseInt(totalPermisonCount) + parseInt(totalGroupCount))){
                $("#checkAllPermisson").prop('checked', true);
        }else{
                $("#checkAllPermisson").prop('checked', false);
        }


    }


</script>