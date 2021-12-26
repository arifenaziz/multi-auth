6
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var hash_id=$('#hash_id').val();



$(function() {
    consumer_info();    
});


function consumer_info() {
 
 var parameter = '&hash_id=' + hash_id +'&csrf_covicheck_mhc_secured=' + token_key;

        $.ajax({
            url: baseURL + "request/Consumer/getConsumerInfoProcessing",
            type: 'POST',
            data: parameter,
            dataType:'json',
            success: function(response) {


                    $('#vaccination_area').hide();
              
                    // $(".company_name_text").html(response.company_name);
                    $(".consumer_name_text").html(response.firstname + ' ' + response.lastname);
                    $(".email_text").html(response.email);
                    $(".mobile_text").html(response.contact_no);
                    $(".address_text").html(response.address);

                    

                    $("#firstname").val(response.firstname);
                    $("#middlename").val(response.middlename);
                    $("#lastname").val(response.lastname);
                    $("#gender").val(response.gender);
                    $("#date_of_birth").val(response.date_of_birth);
                    $("#email").val(response.email);
                    $("#contact_no").val(response.contact_no);
                    $("#driving_license").val(response.driving_license);
                    $("#passport_no").val(response.passport);
                    $("#nin").val(response.nin);
                    $("#nhs").val(response.nhs);
                    $("#ethnicity").val(response.ethnicity);
                    $("#gym_number").val(response.gym_number);

                    $("#vaccination_status").text(response.vaccination_status);

                    $("#address").val(response.address);
                    $("#post_code").val(response.post_code);

      


                   

      }

    })


}



jQuery.validator.addMethod('mobileUK', function(phone_number, element) {
    return this.optional(element) || phone_number.length > 9 &&
         //phone_number.match(/^((0|\+44)7(0|4|5|6|7|8|9){1}\d{2}\s?\d{6})$/);
phone_number.match(/^((\+44\s?|0)7([45789]\d{2}|624)\s?\d{3}\s?\d{3})$/);         
}, 'Please specify a valid mobile number');


$('#contact_no').on('blur keyup change',function(){
    var msg=$('#contact_no-error').text();
    if(msg=='Please specify a valid mobile number'){
       $('.mobile-error').slideDown();
    }
    else{
        $('.mobile-error').slideUp();        
    }
});

$("#consumer_form").validate({
      
           
      rules:{
        

        firstname:
        {
            required: true,
        },
        lastname:
        {
            required: true,
        },
        gender:
        {
            required: true,
        },
        date_of_birth:
        {
            required: true,
        },
        email:
        {
            required: true,
            email: true,                    
        },
        contact_no:
        {
            required: true,
            maxlength:20,
            mobileUK:true,
        },
        nin:{
           required: true, 
       },
       
        address:
        {
            required: true,
        },
        post_code:
        {
            required: true,
        },
      
   },

    messages:
        {

            firstname:
        {
            required: "Please type patient's first name",
        },
        lastname:
        {
            required: "Please type patient's last name",
        },
        gender:
        {
            required: "Please select a gender",
        },
        date_of_birth:
        {
            required: "Please select date of birth",
        },
        email:
        {
            required: "Please type email address",
            email: 'Please type a valid email address',            
        },
        contact_no:
        {
            required: "Please type contact number",
            maxlength:'Please type <em>valid</em> no',
        },
        nin:{
            required: "Please type national insurence number",
        },      
        address:
        {
            required: "Please type patient's address",
        },
        post_code:
        {
            required: "Please type patient's post code",
        },
          },
                    
              submitHandler: function(form) {

            $('.form_button').css('cursor', 'wait');
            $('.form_button').attr('disabled', true);

           

        $.ajax({
           url: baseURL + "request/Consumer/PostConsumerInfoProcessing",
            type: 'POST',
            data: $('#consumer_form').serialize(),
            dataType:'json',
            success: function(res) {
               

        var response_brought = res.response.indexOf('Update successfully');
        if (response_brought != -1) 
        {          

            swal({
                    title: "Successfully Update Data",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'
            });

            valuePlace();




      }

      else{

                 swal({
                    title: "Problem Occured",
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: 'swal-height'                
                });        


      }

         
        $('.form_button').css('cursor', 'pointer');
        $('.form_button').removeAttr('disabled');


            }            
        });




    },                                                // Do not change code below
                            errorPlacement: function(error, element)
                            {
                                error.insertAfter(element.parent());
                            }
          
      
    }); 



function valuePlace (){

                    var first_name=$("#firstname").val();
                    var last_name=$("#lastname").val();
                    var email=$("#email").val();
                    var contact=$("#contact_no").val();
                    var address=$("#address").val();

                    $(".consumer_name_text").html(first_name + ' ' + last_name);
                    $(".email_text").html(email);
                    $(".mobile_text").html(contact);
                    $(".address_text").html(address);
}