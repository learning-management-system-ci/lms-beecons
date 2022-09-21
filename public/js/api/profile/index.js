$.ajax({
    type: "GET",
    url: "/api/profile",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        console.log(data);
        $('document').ready(function () {
            $('div.col.profile > div.row > div.col > div > div.row.py-2.px-1 > div.col > div > div:nth-child(1) > h4').html(data.email);
            $('div.col.profile > div.row > div.col > div > div:nth-child(3) > div:nth-child(2) > div > div:nth-child(1)').html(data.phone_number);
            $('div.col.profile > div.row > div.col > div > div:nth-child(3) > div:nth-child(2) > div > div:nth-child(2)').html(data.phone_number);
            $('div.col.profile > div.row > div.col > div > div:nth-child(3) > div:nth-child(2) > div > div:nth-child(3)').html(data.email);
            $('div.col.profile > div.row > div.col > div > div:nth-child(3) > div:nth-child(2) > div > div:nth-child(4)').html(data.phone_number);
        })
    }
});