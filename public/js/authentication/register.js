$(document).ready(function () {
    $('#sign-up').validate({
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
                equalTo: '#password'
            },
            terms: {
                required: true,
            }
        }
    });

    if ($('button.btn').prop('disabled', 'disabled')) {
        $('button.btn').css({
            'background-color': '#B9B9B9'
        })
    }

    $('#sign-up input').on('keyup blur', function () {
        if ($('#sign-up').valid()) {
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