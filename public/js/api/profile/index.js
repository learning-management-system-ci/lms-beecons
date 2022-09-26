$.ajax({
    type: "GET",
    url: "/api/profile",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        $('document').ready(function () {
            var resources = () => {
                return (`<div class="card">
                    <div class="row py-2 px-1">
                        <div class="col-12x">
                            <img src="image/auth-image.png" class="image-circle me-1" alt="">
                        </div>
                        <div class="col">
                            <div class="row px-5">
                                <div class="col-12 text-start">
                                    <h3>${data.fullname ? data.fullname : "Lengkapi Data!"}</h3>
                                </div>
                                <div class="col-12 text-start py-1">
                                    <h5 class="font-weight-light">${data.job_name ? data.job_name : "Lengkapi Data!"}</h5>
                                </div>
                                <div class="col-12 text-start py-1">
                                    <h5 class="font-weight-light">${data.address ? data.address : "Lengkapi Data!"}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pencil"></i></a>
                        </div>
                    </div>
                    <hr class="my-4 mb-3">
                        <div class="row ">
                            <div class="col-6">
                                <div class="row">
                                    <div class="text-start py-1">Tanggal Lahir</div>
                                    <div class="text-start py-1">No HP</div>
                                    <div class="text-start py-1">Email</div>
                                    <div class="text-start py-1">LinkedIn</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="text-end py-1">${data.date_birth ? data.date_birth : "Lengkapi Data!"}</div>
                                    <div class="text-end py-1">${data.phone_number ? data.phone_number : "Lengkapi Data!"}</div>
                                    <div class="text-end py-1">${data.email}</div>
                                    <div class="text-end py-1">${data.linkedin ? data.linkedin : "Lengkapi Data!"}</div>
                                </div>
                            </div>
                        </div>
                </div>`);
            };

            $("div.profile-data").html(resources);
        })
    }
});