$(document).ready(function () {
    $('#new-password').validate({
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.appendTo(element.parent());
        },
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            password_confirm: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            password: {
                required: "Masukkan password anda",
                minlength: "Password minimal 8 karakter",
            },
            password_confirm: {
                required: "Konfirmasi password anda",
                equalTo: "Password tidak sama",
            },
        }
    });

    if ($('button.btn').prop('disabled', true)) {
        $('button.btn').addClass('disable');
    }

    $('#new-password input').on('keyup blur', function () {
        if ($('#new-password').valid()) {
            $('button.btn').prop('disabled', false).addClass('active').removeClass('disable');
        } else {
            $('button.btn').prop('disabled', true).addClass('disable');
        }
    });

    $('#show-password').on('click', function () {
        if ($('#password').attr("type") == 'text') {
            $('#password').attr("type", 'password')
            $('#eye-icon-password').removeClass('bi-eye').addClass('bi-eye-slash')
        }
        else {
            $('#password').attr("type", 'text')
            $('#eye-icon-password').removeClass('bi-eye-slash').addClass('bi-eye')
        }
    })
    $('#show-confirm').on('click', function () {
        if ($('#password_confirm').attr("type") == 'text') {
            $('#password_confirm').attr("type", 'password')
            $('#eye-icon-password_confirm').removeClass('bi-eye').addClass('bi-eye-slash')
        }
        else {
            $('#password_confirm').attr("type", 'text')
            $('#eye-icon-password_confirm').removeClass('bi-eye-slash').addClass('bi-eye')
        }
    })
});