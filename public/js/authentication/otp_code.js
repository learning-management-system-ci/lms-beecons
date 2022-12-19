$(document).ready(function () {
    $('#otp-code').validate({
        rules: {
            otp: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6
            },
        },
        messages: {
            otp: {
                required: "Masukkan kode OTP anda",
                digits: "Kode OTP salah",
                minlength: "",
                maxlength: ""
            },
        }
    });

    if ($('button.btn').prop('disabled', true)) {
        $('button.btn').addClass('disable');
    }

    $('#otp-code input').on('keyup blur', function () {
        if ($('#otp-code').valid()) {
            $('button.btn').prop('disabled', false).addClass('active').removeClass('disable');
        } else {
            $('button.btn').prop('disabled', true).addClass('disable');
        }
    });

});