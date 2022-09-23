window.onload = function () {
    google.accounts.id.initialize({
        client_id: "229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com", // Replace with your Google Client ID
        login_uri: "http://localhost:8080/login/loginWithGoogle/submit" // We choose to handle the callback in server side, so we include a reference to a endpoint that will handle the response
    });
    // You can skip the next instruction if you don't want to show the "Sign-in" button
    google.accounts.id.renderButton(
        document.getElementById(
            "buttonDiv"), // Ensure the element exist and it is a div to display correcctly
        {
            theme: "outline",
            size: "large"
        } // Customization attributes
    );
    google.accounts.id.prompt(); // Display the One Tap dialog
}

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
        Cookies.set('access_token', res[0].data[0], { expires: 1 / 24 });
        $('#login').unbind("submit");

        $.ajax({
            type: "POST",
            url: "/login",
            data: JSON.stringify({
                "access_token": Cookies.get("access_token"),
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