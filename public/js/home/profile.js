$.ajax({
    type: "GET",
    url: "/api/profile",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        var resources = () => {
            return (`
                    <img src="${data.profile_picture ? data.profile_picture : "image/auth-image.png"}" class="nav-profile me-1" alt="">
                `)
        };

        $("button#dropdown-profile").html(resources);
    }
});