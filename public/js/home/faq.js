var expand_faq = ".faq-title > a";
$(expand_faq).on('click', function () {
    var color = $(this).css('background-image');
    if (color.includes("expand")) {
        $(this).css({
            'backgroundImage': "url('../../image/faq/close.png')",
            'transform': "scale(0.8) rotate(180deg)",
        })
    }
    else {
        $(this).css({
            'backgroundImage': "url('../../image/faq/expand.png')",
            'transform': "scale(0.8) rotate(0deg)",
        })
    }
})
