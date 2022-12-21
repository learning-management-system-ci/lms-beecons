$.ajax({
    type: "GET",
    url: `/api/resume/get-sertifikat/${window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)}`,
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        const biodata = () => (`
            <h3 class="bold">${data.course[0].fullname}</h3>
            <h3 class="bold">${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(data.course[0].created_at))}</h3>
            <h3 class="bold">${data.course[0].title}</h3>
            <h3 class="bold">${data.course[1].progress}</h3>
        `);
        
        $("#biodata").html(biodata);

        const video = data.course[0].video.map((props) => (`
            <div class="row pt-4">
                <div class="col-3">
                    <h3>${props.title}</h3>
                </div>
                <div class="col-2">
                    <h3>${props.hasil_score == null ? props.hasil_score : props.hasil_score[0].score}</h3>
                </div>
                <div class="col">
                    <h3>${props.resume_video}</h3>
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
    }
});