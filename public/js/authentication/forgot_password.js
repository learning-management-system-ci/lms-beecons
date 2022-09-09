$(document).ready(function () {
    $('#forgot-password').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        }
    });

    if ($('button.btn').prop('disabled', 'disabled')) {
        $('button.btn').css({
            'background-color': '#B9B9B9'
        })
    }

    $('#forgot-password input').on('keyup blur', function () {
        if ($('#forgot-password').valid()) {
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