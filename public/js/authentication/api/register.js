$('document').ready(function () {
    $('#loading').html("Sedang Memproses");
})

$("#sign-up").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        csrf_test_name_passed = $form.find("input[name='csrf_test_name']").val(),
        email_passed = $form.find("input[name='email']").val(),
        password_passed = $form.find("input[name='password']").val(),
        password_confirm_passed = $form.find("input[name='password_confirm']").val(),
        url = $form.attr("action");

    $('#loading-modal').modal('toggle');

    // Send the data using post
    var posting = $.post(url, { csrf_test_name: csrf_test_name_passed, email: email_passed, password: password_passed, password_confirm: password_confirm_passed });

    posting.done(function (data) {
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
    });
    posting.fail(function (status, error) {
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
    })
});