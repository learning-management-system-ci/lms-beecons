//inisialisasi swiperjs untuk perpindahan halaman soal
console.log('ehllosaojksihfsdjfuisdh')
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
        $(this).siblings().addClass('list-card-button').removeClass("list-active list-active-complete list-active-quiz")
        return $(this).parent().siblings('.sub-chapter').children().addClass('list-card-button')
            .removeClass("list-active-complete list-active-quiz list-active")
    }
    if (check_image.css("background-image").includes("complete")) {
        $(this).addClass("list-active-complete").removeClass("list-card-button")
        $(this).siblings().addClass('list-card-button').removeClass("list-active list-active-complete list-active-quiz")
        return $(this).parent().siblings('.sub-chapter').children().addClass('list-card-button')
            .removeClass("list-active-complete list-active-quiz list-active")
    }

    if (check_image.css("background-image").includes("button-quiz")) {
        $(this).addClass("list-active-quiz").removeClass("list-card-button")
        $(this).siblings().addClass('list-card-button').removeClass("list-active list-active-complete list-active-quiz")
        return $(this).parent().siblings('.sub-chapter').children().addClass('list-card-button')
            .removeClass("list-active-complete list-active-quiz list-active")
    }
    // if (check_image.css("background-image").includes("pause")) {
    //     return $(this).addClass("list-card-button").removeClass("list-active")
    // }
})

$(document).ready(() => {
    // get id from url last segment
    let url = window.location.href
    let course_id = url.substring(url.lastIndexOf('/') + 1)

    // get course data from server
    const getCourseData = async () => {
        try {
            let option = {
                url: `http://localhost:8080/api/course/detail/${course_id}`,
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    data = result
                }
            }
            if (Cookies.get("access_token") != undefined) {
                option['headers'] = {
                    'Authorization': `Bearer ${Cookies.get("access_token")}`
                }
            }
            let data
            await $.ajax(option)
            return data
        } catch (error) {
            console.log(error)
        }
    }

    courseData = getCourseData();

    // implement data
    courseData.then((data) => {
        // implement course title
        $('.course_title_content').html(data.title)

        // implement course type
        $('.course_type_content').html(data.type.name)
        // implement href course type
        $('a.course_type_content').attr('href', `http://localhost:8080/course/type/detail/${data.type.type_id}`)

        // implement course description
        $('.course_description_content').html(data.description)
        $('.course_description-keyTakeaway_content').html(data.key_takeaways)
        $('.course_description-suitableFor_content').html(data.suitable_for)

        // implement course video list
        let videoList = data.video
        let countVideo = videoList.length
        $('.course_videoCount_content').html(countVideo + ' video')

        // sort video list by order
        videoList.sort((a, b) => {
            return a.order - b.order
        })

        $('.course_videoList_content').html('')
        videoList.forEach((video, index) => {
            let isComplete = video.score ? 'complete' : ''

            let videoCard = `
            <div class="list-card-button ${isComplete} d-flex justify-content-between align-items-center p-3 mb-3">
                <div class="list-title d-flex align-items-center">
                    <button></button>
                    <p>${video.title}</p>
                </div>
                <p class="duration">${video.duration}</p>
            </div>`

            $('.course_videoList_content').append(videoCard)
        })

        console.log(data);
        // implement course quiz list

        // implement course Review
        $('.course-review-content').html('')
        data.review.forEach((review) => {
            let reviewCard = `
                <div class="review-card d-flex align-items-center ps-3">
                    <img class="user-image align-self-start" src="/image/course-detail/person.png" alt="">
                    <div class="review-data pe-4 d-flex flex-column">
                        <div class="top-section d-flex justify-content-between">
                            <div class="user-title d-flex">
                                <h6>${review.fullname}</h6>
                                <p>${review.job_name}</p>
                            </div>
                            <div class="user-score d-flex">
                                <div class="stars" style="--rating: ${review.score}"></div>
                                <h6>${review.score}</h6>
                            </div>
                        </div>
                        <p class="review-description">${textTruncate(review.feedback, 150)}</p>
                    </div>
                </div>`
            $('.course-review-content').append(reviewCard)
        })

        // implement pricing
        let data_detail_order = {
            price_before_discount: getRupiah(data.old_price),
            price_after_discount: getRupiah(data.new_price),
            discount: getRupiah(`${data.old_price - data.new_price}`),
            platform_fee: getRupiah('10000'),
            total: getRupiah(`${10000 + parseInt(data.new_price)}`)
        }
        console.log(data_detail_order);

        $('.course_price_beforeDiscount_content').html(data_detail_order.price_before_discount)
        $('.course_price_afterDiscount_content').html(data_detail_order.price_after_discount)
        $('.course_price_discount_content').html(data_detail_order.discount)
        $('.course_price_platformFee_content').html(data_detail_order.platform_fee)
        $('.course_price_total_content').html(data_detail_order.total)

        // implement kurikulum
        $('.course_curriculumList_content').html('');
        videoList.forEach((video, index) => {
            let isPreview = index == 0 ? '<a href="#" class="preview-link">Preview</a>' : '';
            let isDisabled = video.video ? `<button><img width="40px" src="/image/course-detail/play-light.png"></button>` : `<button disabled> <img class="lock-button" width="20px" src="/image/course-detail/video-locked.png"> </button>`;
            let videoCard = `
            <li class="d-flex justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    ${isDisabled}
                    <p>${video.title}</p>
                </div>
                <div class="d-flex">
                    ${isPreview}
                    <p>${video.duration}</p>
                </div>
            </li>`;

            $('.course_curriculumList_content').append(videoCard);
        })

        // implement projects
    })
})