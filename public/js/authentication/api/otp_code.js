$('document').ready(function () {
    $('#loading').html("Logging in...");
})

$("#otp-code").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        otp_passed = $form.find("input[name='otp']").val(),
        url = $form.attr("action");

    var email_passed = Cookies.get("email");

    $('#loading-modal').modal('toggle');

    $.ajax({
        url: url,
        type: "post",
        data: {
            otp: otp_passed,
            email: email_passed
        },
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            "Accept": "aplication/json",
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
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
                    window.location.href = "/new-password";
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