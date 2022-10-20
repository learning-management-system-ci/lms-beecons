$('document').ready(function () {
    $('#loading').html("Sedang Memproses");
})

$("#forgot-password").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        email_passed = $form.find("input[name='email']").val(),
        url = $form.attr("action");

    Cookies.set('email', email_passed, { expires: 1 / 96 });

    $('#loading-modal').modal('toggle');

    $.ajax({
        url: url,
        type: "post",
        data: {
            email: email_passed,
        },
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            "Accept": "aplication/json",
        },
        dataType: "json",
        success: function (data) {
            var error_message = data.message;
            var error = data.status;
            if (error_message != null) {
                $('#loading-modal').modal('hide');
                $('document').ready(function () {
                    $('.modal-header').addClass("bg-success");
                    $('.modal-title').html("Berhasil");
                    $('#message').html(error_message);
                    $('#message-modal').modal('toggle');
                })
            }
            if (error !== 500) {
                setTimeout(function () {
                    window.location.href = "/send-otp";
                }, 2000)
            }
        },
        error: function (status, error) {
            var error_message = status.responseJSON.messages.error;
            if (error_message != null) {
                $('#loading-modal').modal('hide');
                $('document').ready(function () {
                    $('.modal-header').addClass("bg-danger");
                    $('.modal-title').html("Gagal");
                    $('#message').html(error_message);
                    $('#message-modal').modal('toggle');
                })
            }
        },
    });
});