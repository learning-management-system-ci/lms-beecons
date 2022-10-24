$('document').ready(function () {
    $('#loading').html("Sedang Memproses");
})

$("#sign-up").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        email_passed = $form.find("input[name='email']").val(),
        password_passed = $form.find("input[name='password']").val(),
        password_confirm_passed = $form.find("input[name='password_confirm']").val(),
        url = $form.attr("action");

    $('#loading-modal').modal('toggle');

    $.ajax({
        url: url,
        type: "post",
        data: {
            email: email_passed,
            password: password_passed,
            password_confirm: password_confirm_passed
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
            };
            if (error !== 500) {
                setTimeout(function () {
                    window.location.href = "/login";
                }, 2000)
            }
        },
        error: function (status, error) {
            var error_message = status.responseJSON.messages.message.email;
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