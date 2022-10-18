$('document').ready(function () {
    $('#loading').html("Logging in...");
})

$("#login").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        csrf_test_name_passed = $form.find("input[name='csrf_test_name']").val(),
        email_passed = $form.find("input[name='email']").val(),
        password_passed = $form.find("input[name='password']").val(),
        url = $form.attr("action");

    $('#loading-modal').modal('toggle');

    // Send the data using post
    var posting = $.post(url, { csrf_test_name: csrf_test_name_passed, email: email_passed, password: password_passed });

    posting.done(function (data) {
        res = $(data)
        Cookies.set('access_token', res[0].data[0], { expires: 1 / 24 });
        $('#login').unbind("submit");

        $.ajax({
            type: "POST",
            url: "/login",
            data: JSON.stringify({
                "access_token": Cookies.get("access_token"),
            }),
            success: function () {
                $('#loading-modal').modal('hide');
                $('#loading').html("Tunggu kami mengarahkan anda ke login...");
                $('#loading-modal').modal('toggle');
                window.location.reload();
            }
        });
    });
    posting.fail(function (status, error) {
        var error_message = status.responseJSON.messages.error;
        console.log(status, error);
        if (error_message != null) {
            $('#loading-modal').modal('hide');
            $(document).ready(function () {
                $('.modal-header').addClass("bg-danger");
                $('.modal-title').html(error);
                $('#message').html(error_message);
                $('#message-modal').modal('toggle');
            })
        }
    })
});