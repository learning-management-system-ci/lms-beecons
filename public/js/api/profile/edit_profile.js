$("document").ready(function () {
    $("#loading").html("Sedang Memproses");
});

$(document).on("show.bs.modal", ".modal", function () {
    const zIndex = 1040 + 10 * $(".modal:visible").length;
    $(this).css("z-index", zIndex);
    setTimeout(() =>
        $(".modal-backdrop")
            .not(".modal-stack")
            .css("z-index", zIndex - 1)
            .addClass("modal-stack")
    );
});

$("#edit").submit(function (event) {
    console.log($("input[type='file']")[0].files)
    // Stop form from submitting normally
    event.preventDefault();

    // Get some values from elements on the page:
    var $form = $(this),
        csrf_test_name_passed = $("input[name='csrf_test_name']").val(),
        name_passed = $("input[name='fullname']").val(),
        address_passed = $("textarea[name='address']").val(),
        phone_number_passed = $("input[name='phone_number']").val(),
        linkedin_passed = $("input[name='linkedin']").val(),
        date_passed = $("input[name='date_birth']").val(),
        profile_picture_passed = $("input[type='file']")[0].files[0],
        url = $form.attr("action"),
        job_passed = $("#job_id").find(":selected").val();

    $("#loading-modal").modal("toggle");

    let formData = new FormData();
    formData.append("fullname", name_passed);
    formData.append("address", address_passed);
    formData.append("phone_number", phone_number_passed);
    formData.append("linkedin", linkedin_passed);
    formData.append("date_birth", date_passed);
    formData.append("profile_picture", profile_picture_passed);
    formData.append("job_id", job_passed);

    console.log(formData);

    $.ajax({
        type: "POST",
        url: url,
        contentType: false,
        processData: false,
        headers: {
            "Authorization": "Bearer " + Cookies.get("access_token"),
        },
        data: formData,
        success: function (data) {
            console.log(data);
            var error = data.status;
            if (error != null) {
                $('#loading-modal').on('hide.bs.modal', function () { });
                $('#loading-modal').hide();
                $('.modal-backdrop').remove();
                new swal({
                    title: "Berhasil!",
                    text: "Mohon tunggu untuk memperbarui pembaruan",
                    icon: "success",
                    timer: 0,
                    showConfirmButton: false
                })
            }
            setTimeout(function () {
                // window.location.reload();
            }, 5000)
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
        }
    });
});
