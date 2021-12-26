var baseURL = $('body').data('baseurl');
$('.page-alert').hide();

$('.page-alert .close').click(function(e) {
    e.preventDefault();
    $(this).closest('.page-alert').slideUp();
});
function notification (text){

    $('#notification').html('<strong>'+ text+'</strong>').slideDown().delay(2000).slideDown();

}

$("#master_sigin_form").validate({

    rules:
    {
        email:
        {
            required: true,
            email: true
        },
        password:
        {
            required: true,
            minlength: 5,
            maxlength: 20
        }
    },

    messages:
    {
        email:
        {
            required: 'Please enter your email address',
            email: 'Please enter a Valid email address'
        },
        password:
        {
            required: 'Please enter your password'
        }
    },

    submitHandler: function(form) {

        $('.signin_button').css('cursor', 'wait');
        $('.signin_button').attr('disabled', true);

        $.ajax({
            url: baseURL + "loginAuthentication",
            type: 'POST',
            data: $('#sigin_form').serialize(),
            dataType:'json',
            success: function(res) {


                $("html, body").scrollTop(0);
                $(".page-alerts").css('display','block');
                $('.page-alert').slideDown();

                var response_brought = res.response.indexOf('login_successfully=yes');


                if (response_brought != -1)
                {
                    notification('Please wait...');
                    window.location.replace(res.response);
                }

                else{
                    $('#password').val('');
                    notification('There is an problem with your email and or password. probably there is  mismatch');
                }

                $('.signin_button').css('cursor', 'pointer');
                $('.signin_button').removeAttr('disabled');

            }
        });
            },                                                // Do not change code below
            errorPlacement: function(error, element)
            {
             error.insertAfter(element.parent());
         }

     });