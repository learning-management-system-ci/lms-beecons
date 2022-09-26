console.log('hellos')

var swiper = new Swiper(".newSwiper", {
    allowTouchMove: false,
    navigation: {
        nextEl: ".page-next",
        prevEl: ".page-back",
    },
    pagination: {
        el: ".pagination-number",
        clickable: true,
        renderBullet: function (index, className) {
            return '<span class="' + className + '">' + (index + 1) + "</span>";
        },
    }
});