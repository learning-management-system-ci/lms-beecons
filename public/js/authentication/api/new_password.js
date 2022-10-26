$('document').ready(function () {
    $('#loading-modal').on('hide.bs.modal', function () {
        return false
    });
})

$("#new-password").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        password_passed = $form.find("input[name='password']").val(),
        password_confirm_passed = $form.find("input[name='password_confirm']").val(),
        url = $form.attr("action");

    var email_passed = Cookies.get("email")

    $('#loading-modal').modal('toggle');

    $.ajax({
        url: url,
        type: "post",
        data: {
            password: password_passed,
            password_confirm: password_confirm_passed,
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
                $('#loading-modal').on('hide.bs.modal', function () { });
                $('#loading-modal').hide();
                $('.modal-backdrop').remove();
                new swal({
                    title: "Berhasil!",
                    text: error_message,
                    icon: "success",
                    timer: 0,
                    showConfirmButton: false
                })
            };
            if (error !== 500) {
                setTimeout(function () {
                    window.location.href = "/login";
                }, 2000)
            }
        },
        error: function (status, error) {
            var error_message = status.responseJSON.messages.error;
            if (error_message != null) {
                $('#loading-modal').on('hide.bs.modal', function () { });
                $('#loading-modal').hide();
                $('.modal-backdrop').remove();
                new swal({
                    title: 'Gagal',
                    text: error_message,
                    showConfirmButton: true
                })
            }
        },
    });
});