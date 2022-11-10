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

function copyFunction() {
    var copyText = document.getElementById("myInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
}

function outFunc() {
}

$.ajax({
    type: "GET",
    url: "api/referral",
    contentType: "application/json",
    headers: { "Authorization": "Bearer " + Cookies.get("access_token"), "Content-Type": "application/json" },
    success: function (data) {
        var referralresources = () => (
            data.referral_code
        );

        $(".referral-code").val(referralresources);

        var referralusers = () => (
            data.referral_user + " Orang"
        );

        $(".referral-users").html(referralusers);

        var vouchers = () => (
            data.referral_voucher.length + " Voucher"
        );

        $(".voucher-total").html(vouchers);

        var voucherresources = data.referral_voucher.map(() => {
            return (`
                <div class="col mb-4 voucher">
                    <img style="height: inherit;" src="image/profile/voucher.png" alt="">
                </div>
            `)
        });

        $(".vouchers").html(voucherresources);
    }
})
