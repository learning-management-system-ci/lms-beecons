$.ajax({
    type: "GET",
    url: "/api/profile",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        var resources = () => {
            function getDayName(dateStr, locale) {
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
                        <img src="image/auth-image.png" class="image-circle me-1" alt="">
                    </div>
                    <div class="col">
                        <div class="row px-5">
                            <div class="col-12 text-start">
                                <h3>${data.fullname ? data.fullname : data.email}</h3 >
                            </div >
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
                                    <div class="text-end py-1"><a target="_blank" href="${data.linkedin ? link_ref : ""}" style="text-decoration: underline;">${data.linkedin && data.linkedin}</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
        `)
        };

        $("div.profile-data").html(resources);

        var modalresources = () => {
            return (`
            <label for= "email" class= "form-label"> Email</label>
            <input type="text" id="email" value="${data.email}" class="form-control" disabled aria-describedby="passwordHelpBlock">
            <label for="fullname" class="form-label">Nama Lengkap</label>
            <input type="text" id="fullname" name="fullname" value="${data.fullname ? data.fullname : ""}" class="form-control" aria-describedby="passwordHelpBlock">
            <label for="date" class="col-1 col-form-label">Date</label>
            <div class="input-group date" id="datepicker">
                <input type="date" class="form-control" id="date" name="date" value="${data.date_birth ? data.date_birth : ""}"/>
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
                <button type="submit" class="btn" id="editButton" disabled="disabled" style="border: 0;">Save changes</button>
            </div>
            `);
        };

        $("form#edit").html(modalresources);

        $('document').ready(function () {
            const tx = document.getElementsByTagName("textarea");
            for (let i = 0; i < tx.length; i++) {
                tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
                tx[i].addEventListener("input", OnInput, false);
            }

            function OnInput() {
                this.style.height = 0;
                this.style.height = (this.scrollHeight) + "px";
            }

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
                    },
                    linkedin: {
                        required: true,
                    },
                    date: {
                        required: true,
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
    }
});

$.ajax({
    type: "GET",
    url: "api/user-course",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: async function (data) {
        async function getCourseData(item, index) {
            const response = await $.ajax({
                type: "GET",
                url: `api/course/detail/${item.course_id}`,
                contentType: "application/json",
                headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
                success: function (data) {
                    return data;
                }
            })
            return await response;
        }

        const courseList = await Promise.all(
            data.map(getCourseData)
        );

        console.log(courseList);

        var coursesResource =
            courseList.map(({
                title, description
            }) => {
                return (`
                <div class="row">
                    <div class="col-12x">
                        <img src="image/auth-image.png" class="course-image me-1" alt="">
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
                <hr>
                `)
            })

        $("div#user-courses").html(coursesResource);
    }
})

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

var resources = pages.map((page) => {
    return (`
        <a class="btn profile-sidebar btn-grey-200 text-capitalize d-flex px-2" href="${page.url}">
            <img src="${page.imageUrl}" alt="icon" class="pe-2 profile-icon"/>
            ${page.page}
        </a>
    `)
})

$("div.side-bar").html(resources);