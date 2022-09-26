$(document).ready(() => {
    // handle search
    $('.nav-search-input').eq(0).hide(200)

    $('#nav-btn-search').on('click', (e) => {
        e.preventDefault()
        $('.nav-search-input').eq(0).show(200)
        $('#nav-btn-search').hide()
    })

    $('#nav-btn-search-x').on('click', (e) => {
        e.preventDefault()
        $('.nav-search-input').eq(0).hide()
        $('#nav-btn-search').show(200)
    })

    $('.nav-search-input form').on('submit', (e) => {
        e.preventDefault()
        let search = $('.nav-search-input form input').val()
        // console.log(search)
    })

    // testimoni slider
    $('.testimoni-slick').slick({
        dots: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        touchMove: true,
        // autoplay: true,
    })

    // handle search
    $('#nav-btn-search-x').on('click', (e) => {
        $('.nav-item-search .dropdown-menu.show').removeClass('show')
    })
})