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
  // Stop form from submitting normally
  event.preventDefault();

  // Get some values from elements on the page:
  var $form = $(this),
    csrf_test_name_passed = $("input[name='csrf_test_name']").val(),
    name_passed = $("input[name='fullname']").val(),
    address_passed = $("textarea[name='address']").val(),
    phone_number_passed = $("input[name='phone_number']").val(),
    linkedin_passed = $("input[name='linkedin']").val(),
    date_passed = $("input[name='date']").val(),
    url = $form.attr("action"),
    job_passed = $("#job_id").find(":selected").val();

  $("#loading-modal").modal("toggle");

  $.ajax({
    type: "PUT",
    url: url,
    headers: {
      Authorization: "Bearer " + Cookies.get("access_token"),
    },
    data: {
      fullname: name_passed,
      address: address_passed,
      phone_number: phone_number_passed,
      linkedin: linkedin_passed,
      job: job_passed,
      profile_picture: "something",
      date_birth: date_passed,
    },
    success: function (data) {
      console.log(data);
      var error = data.status;
      if (error != null) {
        $("#loading-modal").modal("hide");
        $(".modal-header").addClass("bg-success");
        $(".modal-title").html("Berhasil");
        $("#message").html("Mohon tunggu untuk memperbarui pembaruan");
        $("#message-modal").modal("toggle");
      }
      setTimeout(function () {
        window.location.reload();
      }, 2000);
    },
    error: function (status, error) {
      var error_message = status.responseJSON.messages.error;
      if (error_message != null) {
        $("#loading-modal").modal("hide");
        $("document").ready(function () {
          $(".modal-header").addClass("bg-danger");
          $(".modal-title").html("Gagal");
          $("#message").html(error_message);
          $("#message-modal").modal("toggle");
        });
      }
    },
  });
});
