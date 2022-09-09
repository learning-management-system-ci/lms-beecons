$(document).ready(function () {
    $('#new-password').validate({
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            password_confirm: {
                required: true,
                equalTo: '#password'
            }
        }
    });

    if ($('button.btn').prop('disabled', 'disabled')) {
        $('button.btn').css({
            'background-color': '#B9B9B9'
        })
    }

    $('#new-password input').on('keyup blur', function () {
        if ($('#new-password').valid()) {
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