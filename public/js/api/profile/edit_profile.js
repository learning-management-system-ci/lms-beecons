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
        url = $form.attr("action"),
        job_passed = $('#job_id').find(":selected").val();
    
    $.ajax({
        type: "PUT",
        url: url,
        headers: {
            "Authorization": "Bearer " + Cookies.get("access_token"),
        },
        data: {
            fullname: name_passed,
            address: address_passed,
            phone_number: phone_number_passed,
            linkedin: linkedin_passed,
            job: job_passed,
            profile_picture: "something",
            password: "testPassword",
            date_birth: "2015-03-25",
            password_confirm: "testPassword"
        },
        success: function () {
            window.location.reload();
        },
        error: function (data, status) {
            console.log(data, status)
        }
    });
});