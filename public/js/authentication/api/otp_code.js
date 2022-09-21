$("#otp-code").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        csrf_test_name_passed = $form.find("input[name='csrf_test_name']").val(),
        otp_passed = $form.find("input[name='otp']").val(),
        url = $form.attr("action");

    // Send the data using post
    var posting = $.post(url, { csrf_test_name: csrf_test_name_passed, otp: otp_passed });

    posting.done(function (data) {
        console.log(data);
        var error_message = data.message;
        var error = data.status;
        console.log("error_msg", error_message);
        console.log("error", error);
        if (error_message != null) {
            $('document').ready(function () {
                $('.modal-header').addClass("bg-success");
                $('.modal-title').html(error);
                $('#message').html(error_message);
                $('#message-modal').modal('toggle');
            })
        }
        $.ajax({
            type: "POST",
            url: "/send-otp",
            data: {},
            success: function () {
                window.location.href = "/new-password";
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
            })
        }
    })
});