$("#login").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        csrf_test_name_passed = $form.find("input[name='csrf_test_name']").val(),
        email_passed = $form.find("input[name='email']").val(),
        password_passed = $form.find("input[name='password']").val(),
        url = $form.attr("action");

    // Send the data using post
    var posting = $.post(url, { csrf_test_name: csrf_test_name_passed, email: email_passed, password: password_passed });

    posting.done(function (data) {
        res = $(data)
        localStorage.setItem('access_token', res[0].data[0]);
        document.cookie = 'access_token=' + res[0].data[0];
        $('#login').unbind("submit");

        $.ajax({
            type: "POST",
            url: "/login",
            data: JSON.stringify({
                "access_token": localStorage.getItem("access_token"),
            }),
            success: function () {
                window.location.reload();
            }
        });
    });
    posting.fail(function (status, error) {
        var error_message = status.responseJSON.messages.error;
        if (error_message != null) {
            $('document').ready(function () {
                $('.modal-header').addClass("bg-danger");
                $('.modal-title').html(error);
                $('#message').html(error_message);
                $('#message-modal').modal('toggle');
                window.location.reload();
            })
        }
    })
});