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
