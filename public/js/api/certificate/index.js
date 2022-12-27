if (window.location.search.slice(1).split("&")[0].split("=")[1] == "course") {
    $.ajax({
        type: "GET",
        url: `/api/resume/get-sertifikat/${window.location.search}`,
        contentType: "application/json",
        headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
        success: function (data) {
            const certificate = () => (`
                <h4 class="bold py-4" style="font-size: 40px; line-height: 50px;">${data.course[0].fullname}</h4>
                <h3 class="bold" style="color: #164520;">${data.course[0].course_title}</h3>
                <h3>Has Succesfuly completing Stufast Program </h3>
                <h3>From ${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(data.course[0].buy_at))} - ${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date())}</h3>
            `);

            $("#detail-certificate").html(certificate);

            const date = () => (`
                <h3 class="bold">${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date())}</h3>
                <hr style="border-width: 2px; opacity: 1;"/>
                <h3>Tanggal</h3>
            `);

            $("#date").html(date);

            const biodata = () => (`
                <h3 class="bold">${data.course[0].fullname}</h3>
                <h3 class="bold">${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(data.course[0].buy_at))}</h3>
                <h3 class="bold">${data.course[0].course_title}</h3>
                <h3 class="bold">${data.course[0].progress}</h3>
            `);

            $("#biodata").html(biodata);

            const video = data.course[0].video.map((props) => (`
                <div class="row pt-4">
                    <div class="col-3">
                        <h3>${props.course_title}</h3>
                    </div>
                    <div class="col-2">
                        <h3>${props.hasil_score == null ? props.hasil_score : props.hasil_score[0].score}</h3>
                    </div>
                    <div class="col">
                        <h3>${props.resume_video == null ? props.resume_video : props.resume_video[0].resume}</h3>
                    </div>
                </div>
                `)
            )

            $("#video").html(video);

            $("#final-score").html(`
                ${data.course[0].score}
            `);

            $("#tanggal").html(`
                Yogyakarta, ${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date())}
            `)

            var element = document.getElementById('htmlContent');

            var opt = {
                margin: 1,
                filename: `Sertifikat_${data.course[0].course_title}_${data.course[0].fullname}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' },
                pagebreak: { mode: 'avoid-all', before: '#raport' }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    });
}

if (window.location.search.slice(1).split("&")[0].split("=")[1] == "bundling") {
    $.ajax({
        type: "GET",
        url: `/api/resume/get-sertifikat/${window.location.search}`,
        contentType: "application/json",
        headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
        success: function (data) {
            const certificate = () => (`
                <h4 class="bold py-4" style="font-size: 40px; line-height: 50px;">${data.bundling[0].fullname}</h4>
                <h3 class="bold" style="color: #164520;">${data.bundling[0].bundling_title}</h3>
                <h3>Has Succesfuly completing Stufast Program </h3>
                <h3>From ${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(data.bundling[0].buy_at))} - ${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date())}</h3>
            `);

            $("#detail-certificate").html(certificate);

            const date = () => (`
                <h3 class="bold">${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date())}</h3>
                <hr style="border-width: 2px; opacity: 1;"/>
                <h3>Tanggal</h3>
            `);

            $("#date").html(date);

            const biodata = () => (`
                <h3 class="bold">${data.bundling[0].fullname}</h3>
                <h3 class="bold">${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(data.bundling[0].buy_at))}</h3>
                <h3 class="bold">${data.bundling[0].bundling_title}</h3>
                <h3 class="bold">${data.bundling[0].progress}</h3>
            `);

            $("#biodata").html(biodata);

            const video = data.bundling[0].coursebundling.map(({ course }) => {
                return course.map(({ video }) => {
                    return video.map((props) => (`
                        <div class="row pt-4">
                            <div class="col-3">
                                <h3>${props.title_video}</h3>
                            </div>
                            <div class="col-2">
                                <h3>${props.hasil_score == null ? props.hasil_score : props.hasil_score[0].score}</h3>
                            </div>
                            <div class="col">
                                <h3>${props.resume_video == null ? props.resume_video : props.resume_video[0].resume}</h3>
                            </div>
                        </div>
                    `))
                })
            })

            $("#video").html(video);

            $("#final-score").html(`
                ${data.bundling[0].score}
            `);

            $("#tanggal").html(`
                Yogyakarta, ${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date())}
            `)

            var element = document.getElementById('htmlContent');

            var opt = {
                margin: 1,
                filename: `Sertifikat_${data.bundling[0].bundling_title}_${data.bundling[0].fullname}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' },
                pagebreak: { mode: 'avoid-all', before: '#raport' }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    });
}