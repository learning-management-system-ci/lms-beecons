console.log('hello')

var swiper = new Swiper(".myswiper", {
    navigation: {
        nextEl: ".quiz-next",
        prevEl: ".quiz-back"
    }
});

var bar = new ProgressBar.Line(loading, {
    strokeWidth: 2,
    easing: 'easeInOut',
    duration: 1400,
    color: '#5446D0',
    trailColor: '#EDEDED',
    trailWidth: 1,
    svgStyle: { width: '100%', height: '100%' },
    text: {
        style: {
            fontSize: '11px',
            fontStyle: 'italic',
            color: 'white',
            position: 'absolute',
            top: '-30px',
            padding: '7px 0px 0px 0px',
            margin: '-6px',
            border: '1px solid black',
            transform: null
        },
        autoStyleContainer: false
    },
    from: { color: '#FFEA82' },
    to: { color: '#ED6A5A' },
    step: (state, bar) => {
        if (Math.round(bar.value() * 100) < 100)
            bar.setText(Math.round(bar.value() * 100) + ' % Completed. Keep it up !');
        else {
            bar.setText(Math.round(bar.value() * 100) + " % Completed. You're Great !");
        }

    }

});




function loadingProgress(value) {
    let textProgress = $(".progressbar-text")
    bar.animate(value / 100);

    function info_animate(style, duration, ease) {
        return textProgress.animate(style, {
            duration: duration
        }, ease)
    }

    info_animate({ opacity: 1 }, 10)
    let trackBar = 83 - value
    let fadeIn = setTimeout(() => {
        info_animate({ opacity: 0 }, 500, 'easein')
        if (value == 100) {
            textProgress.css('display', 'hide')
        }
    }, 2500)

    info_animate({ right: `${trackBar}%` }, 1300, 'easein')
}

loadingProgress(0)

$('input').on('click', function () {
    let barInit = Math.round(100 / $('.swiper-slide').length)
    let checkedCount = $('input:checked').length
    loadingProgress(barInit * checkedCount)
})


$(".list-card-button").on('mouseup', function () {
    var check_image = $(this).find("button");
    if (check_image.css("background-image").includes("play")) {

        $(this).removeClass("list-card-button").addClass("list-active")
        $(this).siblings().addClass('list-card-button').removeClass("list-active")
        $(this).siblings(".complete").removeClass("list-active-complete")
    }
    if (check_image.css("background-image").includes("pause")) {
        $(this).addClass("list-card-button").removeClass("list-active")
    }
    if (check_image.css("background-image").includes("complete")) {
        $(this).addClass("list-active-complete").removeClass("list-card-button")
        $(this).siblings().addClass('list-card-button')

    }
})