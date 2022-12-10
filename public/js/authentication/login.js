$(document).ready(function () {
    $('#login').validate({
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
            }
        }
    });

    if ($('button.btn').prop('disabled', true)) {
        $('button.btn').addClass('disable');
    }

    $('#login input').on('keyup blur', function () {
        if ($('#login').valid()) {
            $('button.btn').prop('disabled', false).addClass('active').removeClass('disable');
        } else {
            $('button.btn').prop('disabled', true).addClass('disable');
        }
    });

    $('#show-password').on('click', function () {
        if ($('#password').attr("type") == 'password') {
            $('#password').attr("type", 'text')
            $('#eye-icon').removeClass('bi-eye').addClass('bi-eye-slash')
        }
        else {
            $('#password').attr("type", 'password')
            $('#eye-icon').removeClass('bi-eye-slash').addClass('bi-eye')
        }
    })

});

