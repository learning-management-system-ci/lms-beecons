$(document).ready(function () {
    $('#forgot-password').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        }
    });

    if ($('button.btn').prop('disabled', true)) {
        $('button.btn').addClass('disable');
    }

    $('#forgot-password input').on('keyup blur', function () {
        if ($('#forgot-password').valid()) {
            $('button.btn').prop('disabled', false).addClass('active').removeClass('disable');
        } else {
            $('button.btn').prop('disabled', true).addClass('disable');
        }
    });

});