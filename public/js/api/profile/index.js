$.ajax({
    type: "GET",
    url: "/api/profile",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        var resources = () => {
            function getDayName(dateStr, locale) {
                if (dateStr == "0000-00-00") {
                    return date = "-"
                }
                var date = new Date(dateStr);
                return date.toLocaleDateString(locale, { day: 'numeric', month: 'long', year: 'numeric' });
            }
            function phone(str) {
                str.length >= 12 ? str = str.replace(/(\d{4})(\d{4})(\d{4})/gi, '$1-$2-$3') : str = str.replace(/(\d{3})(\d{4})(\d{4})/gi, '$1-$2-$3');
                return str;
            }
            function linkedin(str) {
                str.includes("https://") ? str = str : str = "https://" + str;
                return str;
            }

            var day = getDayName(data.date_birth, "id-ID");
            var phone_num = phone(data.phone_number);
            var link_ref = linkedin(data.linkedin);
            return (`
            <div class="card">
                <div class="row py-2 px-1">
                    <div class="col-12x">
                        <img src="${data.profile_picture ? data.profile_picture : "image/auth-image.png"}" class="image-circle me-1" alt="">
                    </div>
                    <div class="col">
                        <div class="row px-5">
                            <div class="col-12 text-start">
                                <h3>${data.fullname ? data.fullname : data.email.split("@")[0]}</h3 >
                            </div>
                            <div class="col-12 text-start py-1">
                                <h5 class="font-weight-light">${data.job_name ? data.job_name : "-"}</h5>
                            </div>
                            <div class="col-12 text-start py-1">
                                <h5 class="font-weight-light">${data.address ? data.address : "-"}</h5>
                            </div>
                        </div >
                    </div >
                    <div class="col-1">
                        <a type="button" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pencil"></i></a>
                    </div>
                </div >
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
                                    <div class="text-end py-1">${data.date_birth ? day : day}</div>
                                    <div class="text-end py-1">${data.phone_number ? phone_num : "-"}</div>
                                    <div class="text-end py-1">${data.email}</div>
                                    <div class="text-end py-1">${data.linkedin ? `<a target="_blank" href="${link_ref}" style="text-decoration: underline;">${data.linkedin && data.linkedin}</a>` : "-"}</div>
                                </div>
                            </div>
                        </div>
                    </div>
        `)
        };

        $("div.profile-data").html(resources);

        var modalresources = () => {
            return (`
            <input id="profile_picture" name="profile_picture" type="file" class="file" />
            <label for= "email" class= "form-label"> Email</label>
            <input type="text" id="email" value="${data.email}" class="form-control" disabled aria-describedby="passwordHelpBlock">
            <label for="fullname" class="form-label">Nama Lengkap</label>
            <input type="text" id="fullname" name="fullname" value="${data.fullname ? data.fullname : ""}" class="form-control" aria-describedby="passwordHelpBlock">
            <label for="date" class="col-1 col-form-label">Date</label>
            <div class="input-group date" id="datepicker">
                <input type="date" class="form-control" id="date_birth" name="date_birth" value="${data.date_birth ? data.date_birth : ""}"/>
            </div>
            <label for="job" class="form-label">Pekerjaan</label>
            <select class="form-select form-select-sm" id="job_id" aria-label=".form-select-sm example">
                <option selected>Open this select menu</option>
            </select>
            <label for="address" class="form-label">Alamat</label>
            <textarea class="form-control expand" name="address" rows="1" id="address" value="" required>${data.address ? data.address : ""}</textarea>
            <label for="phone_number" class="form-label">Nomor HP</label>
            <input type="text" id="phone_number" name="phone_number" value="${data.phone_number ? data.phone_number : ""}" class="form-control" aria-describedby ="passwordHelpBlock" >
            <label for="linkedin" class="form-label">LinkedIn</label>
            <input type="text" id="linkedin" name="linkedin" value="${data.linkedin ? data.linkedin : ""}" class="form-control" aria-describedby="passwordHelpBlock">
            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="app-btn btn" id="editButton" disabled="disabled" style="border: 0;">Save changes</button>
            </div>
            `);
        };

        $("form#edit").html(modalresources);

        var coursesResource =
            data.course.map(({
                title, description, thumbnail, course_id, score
            }) => {
                return (`
                    <div class="row">
                        <div class="col">
                        <a href="/course/${course_id}">
                        <div class="row">
                        <div class="col-20">
                            <img src="${thumbnail}" class="course-image me-1" alt="">
                        </div>
                        <div class="d-flex col text-start align-items-center body">
                            <div>
                                <h5>
                                    ${title}
                                </h5>
                                <p>
                                    ${description}
                                </p>
                            </div>
                        </div>
                        </div>
                        </a>
                        </div>
                        <div class="col-20">
                        <div class="row">
                        <div class="col">
                        <div>
                            <h5>
                                Total Nilai
                            </h5>
                            <div class="row">
                            <div class="col">
                            <h5>
                                ${score}/100
                            </h5>
                            </div>
                            <div class="col">
                            <a href="/course/${course_id}">Detail</a>
                            </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                    </div>
                    <hr>
                `)
            })

        $("div#user-courses").html(coursesResource);

        $('document').ready(function () {
            $.ajax({
                type: "GET",
                url: "/api/jobs",
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer " + Cookies.get("access_token"),
                    "Content-Type": "application/json"
                },
                success: function (data) {
                    var resources = data
                        .sort((a, b) => a.job_id - b.job_id)
                        .map(({
                            job_id,
                            job_name,
                        }) => {
                            return (`
                                    <option value="${job_id}">${job_name}</option>
                                `);
                        });

                    $("select.form-select").html(resources);
                }
            });
            $("#profile_picture").fileinput({
                uploadAsync: false,
                showCaption: true,
                dropZoneEnabled: true,
                allowedFileExtensions: ["jpg", "png", "gif", "svg", "webp"],
                overwriteInitial: true,
                initialPreview: data.profile_picture,
                initialPreviewAsData: true,
                initialPreviewFileType: "image",
            });

            const tx = document.getElementsByTagName("textarea");
            for (let i = 0; i < tx.length; i++) {
                tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
                tx[i].addEventListener("input", OnInput, false);
            }

            function OnInput() {
                this.style.height = 0;
                this.style.height = (this.scrollHeight) + "px";
            }

            $.validator.addMethod("link", (value, element) => {
                let url;
                try {
                    url = new URL(value)
                    url.protocol === "http://" || url.protocol === "https://"
                    return true;
                } catch (_) {
                    return false;
                }
            }, "Link tidak valid");

            $('#edit').validate({
                rules: {
                    fullname: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    phone_number: {
                        required: true,
                        number: true,
                    },
                    linkedin: {
                        required: true,
                        link: true,
                    },
                    date: {
                        required: true,
                    },
                },
                messages: {
                    fullname: {
                        required: "Nama tidak boleh kosong"
                    },
                    address: {
                        required: "Alamat tidak boleh kosong"
                    },
                    phone_number: {
                        required: "Nomor telepon tidak boleh kosong",
                        number: "Hanya menerima angka",
                    },
                    linkedin: {
                        required: "Linkedin tidak boleh kosong"
                    },
                    date: {
                        required: "Tanggal lahir tidak boleh kosong"
                    },
                }
            });

            if ($('button#editButton').prop('disabled', true)) {
                $('button#editButton').addClass('disable');
            }

            $('#edit input').on('keyup blur', function () {
                if ($('#edit').valid()) {
                    $('button#editButton').prop('disabled', false).addClass('active').removeClass('disable');
                } else {
                    $('button#editButton').prop('disabled', true).addClass('disable');
                }
            });
        })
        $('document').ready(function () {
            $.ajax({
                type: "GET",
                url: "/api/users/progress",
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer " + Cookies.get("access_token"),
                    "Content-Type": "application/json"
                },
                success: function (data) {
                    let completedAll = 0;
                    let totalAll = 0;
                    data.progress
                        .map(({
                            completed,
                            total,
                        }) => {
                            completedAll = completedAll + completed;
                            totalAll = totalAll + total;
                        });
                    $(".progress").html(`
                        <div class="progress-bar bg-warning" role="progressbar" style="width: ${ Math.round((completedAll / totalAll) * 100) }%;"
                            aria-valuenow="${ Math.round((completedAll / totalAll) * 100) }" aria-valuemin="0" aria-valuemax="100"></div>
                    `);
                    $(".progress-percent").html(`${ Math.round((completedAll / totalAll) * 100) }%`);
                }
            });
        })
    }
});

const pages = [{
    page: "profile",
    url: "/profile",
    imageUrl: "image/profile/profile-icon.svg",
},
{
    page: "referral code",
    url: "/referral-code",
    imageUrl: "image/profile/referral-icon.svg",
}
]

if (JSON.parse(atob(Cookies.get("access_token").split('.')[1], 'base64')).role == "admin") {
    pages.push({
        page: "dashboard",
        url: "/admin",
        imageUrl: "image/profile/referral-icon.svg",
    })
}

var resources = pages.map((page) => {
    return (`
        <a class="btn profile-sidebar btn-grey-200 text-capitalize d-flex px-2 ${window.location.href.includes(page.url) ? "active" : "" }" href="${page.url}">
            <img src="${page.imageUrl}" alt="icon" class="pe-2 profile-icon"/>
            ${page.page}
        </a>
    `)
})

$("div.side-bar").html(resources);