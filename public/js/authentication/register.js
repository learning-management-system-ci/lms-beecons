$(document).ready(function () {
    $('#sign-up').validate({
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.appendTo(element.parent());
        },
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            password_confirm: {
                required: true,
                equalTo: '#password',

            },
            terms: {
                required: true,
            }
        }
    });



    // if ($('#button-submit').prop('disabled', true)) {
    //     $('#button-submit').addClass('disable');
    //     // $('#show-password').prop('disabled', false)
    //     // $('#show-confirm').prop('disabled', false)

    // }

    // $('#sign-up input').on('keyup blur', function () {
    //     if ($('#sign-up').valid()) {
    //         $('#button-submit').prop('disabled', false).addClass('active').removeClass('disable');
    //     } else {
    //         //$('#password', '#password_confir').removeClass('error')
    //         $('span.error').remove()
    //         $('#button-submit').prop('disabled', true).addClass('disable');
    //     }
    // });

    if ($('button#button').prop('disabled', true)) {
        $('button#button').addClass('disable');
    }

    $('#sign-up input').on('keyup blur', function () {
        if ($('#sign-up').valid()) {
            $('button#button').prop('disabled', false).addClass('active').removeClass('disable');
        } else {
            $('button#button').prop('disabled', true).addClass('disable');
        }
    });

    $('#show-password').on('click', function (e) {
        see_password('password')
    })
    $('#show-confirm').on('click', function () {
        see_password('password_confirm')
    })

});




function see_password(param) {
    if ($('#' + param).attr("type") == 'password') {
        $('#' + param).attr("type", 'text')
        $('#eye-icon-' + param).removeClass('bi-eye').addClass('bi-eye-slash')
    }
    else {
        $('#' + param).attr("type", 'password')
        $('#eye-icon-' + param).removeClass('bi-eye-slash').addClass('bi-eye')
    }
}