
var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

var hash_id=$('#hash_id').val();



$(function() {
    company_info();    
});


function company_info() {
 
 var parameter = '&hash_id=' + hash_id +'&csrf_covicheck_mhc_secured=' + token_key;

        $.ajax({
            url: baseURL + "request/Company/getCompanyInfoProcessing",
            type: 'POST',
            data: parameter,
            dataType:'json',
            success: function(response) {



              
                    $(".company_name_text").html(response.company_name);
                    $(".contact_name_text").html(response.first_name + ' ' + response.last_name);
                    $(".email_text").html(response.email);
                    $(".number_text").html(response.contact_number);
                    $(".address_text").html(response.address);

                    

                    $("#company_name").val(response.company_name);
                    $("#company_reg_no").val(response.company_reg_no);
                    $("#first_name").val(response.first_name);
                    $("#last_name").val(response.last_name);
                    $("#email").val(response.email);
                    $("#contact_number").val(response.contact_number);
                    $("#country").val(response.country);
                    $("#number_of_employee").val(response.number_of_employee);
                    $("#address").val(response.address);
                    $("#status").val(response.status);

                   

      }

    })


}





$("#company_form").validate({
      
           
      rules:{
        

            company_name:
                {
                    required: true,
                },
            first_name:
                {
                    required: true,
                    maxlength:50,
                },
            last_name:
                {
                    required: true,
                    maxlength:50,                    
                },
            email:
                {
                    required: true,
                    email: true,
                    maxlength:50,
                },
            contact_number:
                {
                    required: true,
                },
            country:{
                    required: true,  
            },
            number_of_employee:{
                required: true,
            },
            status:{
            required:true,
            },            

        },

    messages:
        {

            company_name:
                {
                    required: 'Please type company name'
                },
            first_name:
                {
                    required: 'Please type first name'
                },
            last_name:
                {
                    required: 'Please type last name'
                },                
            email:
                {
                    required: 'Please type email address',
                    email: 'Please enter a Valid email address',
                },
            contact_number:{
              required: 'Please type contact number'
            },
            country:
                {
                    required: 'Please type country',

                },
            number_of_employee:
                {
                    required: 'Please type number of employee'
                },
            status:{
                required: 'Please select statys',
            },
          },
                    
              submitHandler: function(form) {

            $('.form_button').css('cursor', 'wait');
            $('.form_button').attr('disabled', true);

           

        $.ajax({
           url: baseURL + "request/Company/PostCompanyInfoProcessing",
            type: 'POST',
            data: $('#company_form').serialize(),
            dataType:'json',
            success: function(res) {
               

        var response_brought = res.response.indexOf('update_succcessfully');
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



                    var company=$("#company_name").val();
                    var com_reg_no=$("#company_reg_no").val();
                    var first_name=$("#first_name").val();
                    var last_name=$("#last_name").val();
                    var email=$("#email").val();
                    var contact=$("#contact_number").val();
                    var address=$("#address").val();


                    $(".company_name_text").html(company);
                    $(".company_name_top_text").html(company);
                    $(".contact_name_text").html(first_name + ' ' + last_name);
                    $(".email_text").html(email);
                    $(".email_top_text").html(email);
                    $(".number_text").html(contact);
                    $(".address_text").html(address);
                    $(".reg_top_text").html(com_reg_no);

}