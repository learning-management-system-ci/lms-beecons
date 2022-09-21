$(document).ready(function () {
    $('#login').validate({
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

    if ($('button.btn').prop('disabled', 'disabled')) {
        $('button.btn').css({
            'background-color': '#B9B9B9'
        })
    }

    $('#login input').on('keyup blur', function () {
        if ($('#login').valid()) {
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