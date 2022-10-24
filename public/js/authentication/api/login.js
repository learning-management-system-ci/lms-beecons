$('document').ready(function () {
    $('#loading').html("Logging in...");
})

$("#login").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        email_passed = $form.find("input[name='email']").val(),
        password_passed = $form.find("input[name='password']").val(),
        url = $form.attr("action");

    $('#loading-modal').modal('toggle');

    $.ajax({
        url: url,
        type: "post",
        data: {
            email: email_passed,
            password: password_passed
        },
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            "Accept": "aplication/json",
        },
        dataType: "json",
        success: function (data) {
            res = $(data)
            Cookies.set('access_token', res[0].data[0], { expires: 1 / 24 });
            $('#login').unbind("submit");
            var error = data.status;
            if (error != null) {
                $('#loading-modal').modal('hide');
                $('document').ready(function () {
                    $('.modal-header').addClass("bg-success");
                    $('.modal-title').html("Berhasil");
                    $('#message').html("Tunggu kami mengarahkan anda ke halaman profile...");
                    $('#message-modal').modal('toggle');
                })
            };
            if (error !== 500) {
                setTimeout(function () {
                    window.location.reload();
                }, 2000)
            }
        },
        error: function (status, error) {
            var error_message = status.responseJSON.messages.error;
            if (error_message != null) {
                $('#loading-modal').modal('hide');
                $(document).ready(function () {
                    $('.modal-header').addClass("bg-danger");
                    $('.modal-title').html("Gagal");
                    $('#message').html(error_message);
                    $('#message-modal').modal('toggle');
                })
            }
        },
    });
});