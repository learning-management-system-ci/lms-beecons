$('document').ready(function () {
    $('#loading').html("Sedang Memproses");
})

$("#forgot-password").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        csrf_test_name_passed = $form.find("input[name='csrf_test_name']").val(),
        email_passed = $form.find("input[name='email']").val(),
        url = $form.attr("action");

    Cookies.set('email', email_passed, { expires: 1 / 96 });

    $('#loading-modal').modal('toggle');

    // Send the data using post
    var posting = $.post(url, { csrf_test_name: csrf_test_name_passed, email: email_passed });

    posting.done(function (data) {
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
    });
    posting.fail(function (status, error) {
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
    })
});