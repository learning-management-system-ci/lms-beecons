//inisialisasi swiperjs untuk perpindahan halaman soal
var swiper = new Swiper(".myswiper", {
    navigation: {
        nextEl: ".quiz-next",
        prevEl: ".quiz-back"
    }
});

//inisialisasi progress bar untuk indikator pengerjaan soal
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
            bar.setText(Math.round(bar.value() * 100) + ' % Completed. Semangat !');
        else {
            bar.setText(Math.round(bar.value() * 100) + " % Completed. Kamu Hebat !");
        }

    }

});



//function untuk menambahkan tracking message yang mengikuti animasi progressbar
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

//parameter menerima value 0 sampai 100
//0 berarti belum mengerjakan sama sekali
//100 berarti selesai mengerjakan
loadingProgress(0)


//dropdown accordion untuk video category
$('#content-list').accordion({
    heightStyle: "content",
    collapsible: true,
    icons: {
        header: "bi-caret-right-fill",
        activeHeader: "bi-caret-down-fill"
    }
});

// Function agar tombol next berubah menjadi tombol finish ketika user
// selesai mengerjakan semua soal dan berada di soal terakhir.
function showFinishButton(status, checkedCount, barInit) {
    if (status) {
        if ((checkedCount * barInit) == 100 && $('.quiz-next').hasClass('swiper-button-disabled')) {
            $('.quiz-finish').removeClass("hide")
            return $('.quiz-next').addClass("hide")
        }
    }
    else {
        $('.quiz-next').removeClass("hide")
        return $('.quiz-finish').addClass("hide")
    }
}

$('.quiz-next').on('click', function (e) {
    let barInit = Math.round(100 / $('.swiper-slide').length)
    let checkedCount = $('input:checked').length
    showFinishButton(true, barInit, checkedCount)
})

$('.quiz-back').on('click', function (e) {
    showFinishButton(false)
})



//function untuk mememeriksa sejauh mana pengerjaan soal berlangsung
$('input').on('click', function () {
    let barInit = Math.round(100 / $('.swiper-slide').length)
    let checkedCount = $('input:checked').length
    loadingProgress(barInit * checkedCount)
    showFinishButton(true, barInit, checkedCount)
})


$('.quiz-finish').on('click', function () {
    console.log('finish')
    //kirim data jawaban ke server
})



//function untuk click toggle pada list video agar hanya aktif pada satu list card saja
$(".list-card-button").on('mouseup', function () {
    var check_image = $(this).find("button");
    if (check_image.css("background-image").includes("play")) {
        $(this).removeClass("list-card-button").addClass("list-active")
        $(this).siblings().addClass('list-card-button').removeClass("list-active")
        $(this).siblings().removeClass("list-active-quiz")
        $(this).siblings().removeClass("list-active-complete")
        return $(this).parent().siblings('.sub-chapter').children().addClass('list-card-button')
            .removeClass("list-active-complete list-active-quiz list-active")
    }
    if (check_image.css("background-image").includes("complete")) {
        $(this).addClass("list-active-complete").removeClass("list-card-button")
        $(this).siblings().addClass('list-card-button').removeClass("list-active-complete")
        $(this).siblings().removeClass("list-active-quiz")
        return $(this).parent().siblings('.sub-chapter').children().addClass('list-card-button')
            .removeClass("list-active-complete list-active-quiz list-active")
    }

    if (check_image.css("background-image").includes("button-quiz")) {
        $(this).addClass("list-active-quiz").removeClass("list-card-button")
        $(this).siblings().removeClass("list-active-complete")
        $(this).siblings().addClass('list-card-button').removeClass("list-active-quiz")
        return $(this).parent().siblings('.sub-chapter').children().addClass('list-card-button')
            .removeClass("list-active-complete list-active-quiz list-active")
    }
    // if (check_image.css("background-image").includes("pause")) {
    //     return $(this).addClass("list-card-button").removeClass("list-active")
    // }
})