var expand_faq = ".content > .hide";
$(expand_faq).on('click', function () {
    var color = $(this)
    if (color.hasClass("expand")) {
        $(this).removeClass("expand");
        $(".collapse").addClass("show");
    }
    else {
        $(this).addClass("expand");
        $(".collapse").removeClass("show");
    }
})

$.ajax({
    type: "GET",
    url: "api/referral",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        var referralresources = () => {
            return (`
            ${data.referral_code}
            `);
        };

        $(".referral-code").html(referralresources);
    }
})

$.ajax({
    type: "GET",
    url: "api/voucher",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        var vouchers = () => (
            data.length + " Voucher"
        );
        $(".voucher-total").html(vouchers);

        var voucherresources = data.map((page) => {
            return (`
            <div class="col mb-4 voucher">
                <img style="height: inherit;" src="image/profile/voucher.png" alt="">
            </div>
            `)
        });

        $(".vouchers").html(voucherresources);
    }
})

