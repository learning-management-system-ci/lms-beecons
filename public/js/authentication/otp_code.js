$(document).ready(function () {
    $('#otp-code').validate({
        rules: {
            otp: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6
            },
        }
    });

    if ($('button.btn').prop('disabled', 'disabled')) {
        $('button.btn').css({
            'background-color': '#B9B9B9'
        })
    }

    $('#otp-code input').on('keyup blur', function () {
        if ($('#otp-code').valid()) {
            $('button.btn').prop('disabled', false).css({
                'background-color': '#002B5B'
            });
        } else {
            $('button.btn').prop('disabled', 'disabled').css({
                'background-color': '#B9B9B9'
            });
        }
    });

});