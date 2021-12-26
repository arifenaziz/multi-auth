var baseURL = $('body').data('baseurl');

var token_key=$('#token_key').val();

   
$("#addForm").validate({
    
    
        rules:{
    
            company_name:{
                required:true,
            },
            company_reg_no:{
                required:true,
                remote: {
                url: baseURL+"request/Company/company_regno_valid_process",
                type : "post"
                 },                
            },
            first_name:{
                required:true,
            },
            last_name:{
                required:true,
            },
            email:{
                required:true,
                email: true,
                maxlength:50,                
            },
            contact_number:{
                required:true,
            },
            country:{
                required:true,
            },
            number_of_employee:{
                required:true,
            },
            company_postcode:{
                required:true,
            },
            address:{
                required:true,
            },                        


   
        },
        messages:{
    
            company_name:
                {
                    required: 'Please type company name'
                },
            company_reg_no:
                {
                    required: 'Please type company reg no',
                    remote: 'This registration no is already exist',
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
            contact_number:
                {
                    required: 'Please type contact number'
                },
            country:
                {
                    required: 'Please select country'
                },
            number_of_employee:
                {
                    required: 'Please type number of employee'
                },
            company_postcode:
                {
                    required: 'Please type postcode'
                },
            address:
                {
                    required: 'Please type address'
                }                                                                                                                   

    
    
        },
    
    
        submitHandler: function(form) {
    
    
            $('.submit_button').css('cursor', 'wait');
            $('.submit_button').attr('disabled', true);

    
            $.ajax({
                url: baseURL + "request/Company/InsertCompanyInfoProcessing",
                type: "POST",
                data: $('#addForm').serialize(),
                dataType:'json',
                success: function(res) {
                        
    
                    var response_brought = res.response.indexOf('added_succcessfully');
                    if (response_brought != -1)
                    {
                        $("#addForm").trigger("reset");
    
                        swal({
                            title: "Added Successfully",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: 'swal-height'
    
                        });
    
                    }
    
                   
    
    
                }
            });
    
    
    
    
        },                                                // Do not change code below
        errorPlacement: function(error, element)
        {
            error.insertAfter(element.parent());
        }
    
    
    });