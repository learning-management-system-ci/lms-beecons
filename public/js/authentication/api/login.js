$('document').ready(function () {
    $('#loading-modal').on('hide.bs.modal', function () {
        return false
    });
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
                $('#loading-modal').on('hide.bs.modal', function () { });
                $('#loading-modal').hide();
                $('.modal-backdrop').remove();
                new swal({
                    title: "Berhasil!",
                    text: "Tunggu kami mengarahkan anda ke halaman profile...",
                    icon: "success",
                    timer: 0,
                    showConfirmButton: false
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