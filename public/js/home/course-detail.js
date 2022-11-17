//dropdown accordion untuk video category
$('#content-list').accordion({
    heightStyle: "content",
    collapsible: true,
    icons: {
        header: "bi-caret-right-fill",
        activeHeader: "bi-caret-down-fill"
    }
});

const add_to_cart = async (id, type) => {
    if(Cookies.get('token') == undefined){
        Swal.fire({
            title: 'Anda Belum Login!',
            text: 'Silahkan untuk login dahulu untuk membeli course ini',
            icon: 'error',
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result)=> {
            if ((result.dismiss === Swal.DismissReason.timer)) {
                window.location.href = "/login"
            }
        })
    } else {
        let option = {
            url: `http://localhost:8080/api/cart/create/${type}/${id}`,
            type: 'POST',
            dataType: 'json',
            headers: {
                authorization: `Bearer ${Cookies.get('access_token')}`
            },
            success: function (result) {
                console.log(result)
                window.location.href = "http://localhost:8080/cart";
            }
        }
    
        $.ajax(option)
    }

}



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

    const getQuizData = async (video_id) => {
        try {
            let option = {
                url: `http://localhost:8080/api/course/video/${video_id}`,
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    data = result
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
        $('#course-detail-page').removeClass('d-none')
        let {
            title, 
            type, 
            description, 
            key_takeaways, 
            suitable_for, 
            old_price, 
            new_price = old_price, 
            owned = 0, 
            review: reviews,
            tag: tags,
            thumbnail,
            video: videos,
        } = data

        // implement course title
        $('.course_title_content').html(title)

        // implement course type
        $('.course_type_content').html(type.name)

        // implement href course type
        $('a.course_type_content').attr('href', `http://localhost:8080/course/type/detail/${type.type_id}`)

        // implement course description
        $('.course_description_content').html(description)
        $('.course_description-keyTakeaway_content').html(key_takeaways)
        $('.course_description-suitableFor_content').html(suitable_for)

        // implement last video play

        // implement course video list
        let countVideo = videos.length
        $('.course_videoCount_content').html(countVideo + ' video')

        // sort video list by order
        videos.sort((a, b) => {
            return a.order - b.order
        })

        $('.course_videoList_content').html('')
        videos.forEach((video, index) => {
            let {
                title: video_title,
                score,
                isComplete = score > 50 ? 'complete' : '',
                duration,
                video: url,
                video_id : id,
            } = video

            let isDisabled = ((score > 50)) ? '' : 'disabled'
            let videoCard = `
            <div class="list-card-button ${isComplete} ${isDisabled} d-flex justify-content-between align-items-center p-3 mb-3" data-url="${url}" data-videoid=${id}>
                <div class="list-title d-flex align-items-center">
                    <button></button>
                    <p>${video_title}</p>
                </div>
                <p class="duration">${duration}</p>
            </div>`
            
            $('.course_videoList_content').append(videoCard)
        })
        $('.list-card-button.disabled').first().removeClass('disabled')

        function start_video (video_id, url, status = true) {
            console.log(video_id, url)
            const card_button = $(`.list-card-button[data-videoid=${video_id}]`);
            var check_image = card_button.find("button");
            $('.quiz-panel').hide()
            $('.video-panel').show()
            console.log(card_button)


            if (status) {
                if (check_image.css("background-image").includes("play")) {
                    card_button.removeClass("list-card-button").addClass("list-active")
                    card_button.siblings().addClass('list-card-button').removeClass("list-active list-active-complete list-active-quiz")
                    card_button.parent().siblings('.sub-chapter').children().addClass('list-card-button')
                        .removeClass("list-active-complete list-active-quiz list-active")
                }

                if (check_image.css("background-image").includes("complete")) {
                    card_button.addClass("list-active-complete").removeClass("list-card-button")
                    card_button.siblings().addClass('list-card-button').removeClass("list-active list-active-complete list-active-quiz")
                    card_button.parent().siblings('.sub-chapter').children().addClass('list-card-button')
                        .removeClass("list-active-complete list-active-quiz list-active")
                }

                if (check_image.css("background-image").includes("button-quiz")) {
                    card_button.addClass("list-active-quiz").removeClass("list-card-button")
                    card_button.siblings().addClass('list-card-button').removeClass("list-active list-active-complete list-active-quiz")
                    card_button.parent().siblings('.sub-chapter').children().addClass('list-card-button')
                        .removeClass("list-active-complete list-active-quiz list-active")
                }
            }

            $('.video-panel').html(`
            <video class="course-video-wraper mb-5" width="727" height="400" class="mb-5" controls>
                <source class="course-video-content" src="${url}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            `)

            $(".list-card-button").on('click', function () {
                if(!$(this).hasClass('disabled')) {
                    let url = $(this).data('url');
                    let video_id = $(this).data('videoid');

                    start_video(video_id, url)
                }
            })

            $('.course-video-wraper').on('ended', async function  () {
                if(!owned){
                    if(!Cookies.get("access_token")){
                        let feedback = confirm("You need to login and buy course to continue")
                        if(feedback){
                            window.location.href = "http://localhost:8080/login"
                        }
                        return 
                    }else{
                        let feedback = confirm("You need to buy course to continue")
                        if(feedback){
                            window.location.href = "http://localhost:8080/checkout"
                        }
                        return 
                    }
                }

                // hide element
                $(this).hide()
                let questions_template = '';
                let quizData = await getQuizData(video_id);
                const questions = quizData.quiz.soal
                questions.forEach(({question, answer}, index) => {
                    let question_template = `<div class="swiper-slide">
                        <h4 class="quiz-title">${question}</h4>
                        <p class="mb-3">PILIHAN GANDA</p>
                        <div class="quiz-option-list d-flex justify-content-center align-items-center p-1 flex-wrap">
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-${index}" id="A-${index}">
                                <label for="A-${index}">${answer[0]}</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-${index}" id="B-${index}">
                                <label for="B-${index}">${answer[1]}</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-${index}" id="C-${index}">
                                <label for="C-${index}">${answer[2]}</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-${index}" id="D-${index}">
                                <label for="D-${index}">${answer[3]}</label>
                            </div>
                        </div>
                    </div>`
                    questions_template += question_template
                })

                let template = `
                <div class="quiz-section text-center p-4 swiper myswiper mb-5 ">
                    <div class="swiper-wrapper">
                        ${questions_template}
                    </div>
                    <div class="progress-box d-flex align-items-center justify-content-center p-1 mt-5">
                        <button class="quiz-back"><img width="34px" src="/image/course-detail/back.png" alt=""></button>
                        <div id="loading"></div>
                        <button class="quiz-next"><img width="110px" src="/image/course-detail/next.png" alt=""></button>
                        <button class="quiz-finish hide"><img width="110px" src="/image/course-detail/finish.png" alt=""></button>
                    </div>
                </div>`
                $('.quiz-panel').html(template).show()

                
                let swiper = new Swiper(".myswiper", {
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

                //parameter menerima value 0 sampai 100
                //0 berarti belum mengerjakan sama sekali
                //100 berarti selesai mengerjakan
                loadingProgress(0)
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
                    let barInit = 100 / $('.swiper-slide').length
                    let checkedCount = $('input:checked').length
                    loadingProgress(Math.round(barInit * checkedCount))
                    showFinishButton(true, barInit, checkedCount)
                })
                
                
                $('.quiz-finish').on('click', function () {
                    // get video id
                    let videoId = $('.list-active').data('videoid')
                    let answerArrElement = $('input:checked')
                    let answerArr = []
                    let dict = {
                        'A': 1,
                        'B': 2,
                        'C': 3,
                        'D': 4
                    }
                    answerArrElement.each(function (index, element) {
                        let answerId = $(element).attr('id')
                        let answer = dict[answerId.split('-')[0]]
                        answerArr.push({'answer' : answer})
                        console.log(answerArr)
                    })
                    
                    // send post request to localhost:8080/api/course/video/:id
                    // with answerArr as body as raw json
                    // and get response as json
                    $.ajax({
                        url: `http://localhost:8080/api/course/video/${videoId}`,
                        type: 'POST',
                        data: JSON.stringify(
                            {
                                'answer': answerArr
                            }
                        ),
                        headers: {
                            'Authorization': `Bearer ${Cookies.get("access_token")}`
                        },
                        contentType: 'application/json',
                        success: function (response) {
                            // if success, go to next video
                            // if fail, show error message
                            if (response.success) {
                                //alert anda dapat melanjutkan ke video selanjutnya
                                //redirect ke video selanjutnya
                                if(response.pass){
                                    let timerInterval
                                    Swal.fire({
                                        title: 'Selamat!',
                                        text: 'Anda berhasil menyelesaikan video ini, silahkan lanjutkan ke video selanjutnya',
                                        icon: 'success',
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading()
                                            const b = Swal.getHtmlContainer().querySelector('b')
                                            timerInterval = setInterval(() => {
                                            b.textContent = Swal.getTimerLeft()
                                            }, 100)
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval)
                                        }
                                    }).then((result)=> {
                                        if ((result.dismiss === Swal.DismissReason.timer)) {
                                            $('.list-active').next().removeClass('disabled')
                                            $('.list-active').addClass('complete')
                                            $('.list-active').next().click()
                                        }
                                    })
                                    // alert('Selamat anda berhasil menyelesaikan video ini')
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Anda belum berhasil lolos kuis, silahkan coba lagi',
                                    }).then((result)=> {
                                        if (result.isConfirmed) {
                                            let video_id = $('.list-active').data('videoid')
                                            let url = $('.list-active').data('url');
                                            start_video(video_id, url, false)
                                        }
                                    })
                                }

                                // go to next video
                            } else {
                                // show error message
                                alert(response.message)
                            }
                        }
                    })
                })
                
                $('.quiz-section').removeClass('hide')
            })
        }

        // starter video
        let started_video = videos.some((video) => {
            if (video.score < 50) {
                let {video_id, video:url} = video;
                start_video(video_id, url)
            }
            return video.score < 50
        })

        if (!started_video) {
            start_video(videos[0].video_id, videos[0].video)
        }

        $(".list-card-button").on('click', function () {
            if(!$(this).hasClass('disabled')) {
                let url = $(this).data('url');
                let video_id = $(this).data('videoid');

                start_video(video_id, url)
            }
        })

        // implement course quiz list

        // implement course Review
        $('.course-review-content').html('')
        reviews.forEach((review) => {
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
        if(owned) {
            $('.order-card').hide();
        } else {
            let data_detail_order = {
                price_before_discount: getRupiah(old_price),
                price_after_discount: getRupiah(new_price),
                discount: getRupiah(`${old_price - new_price}`),
                platform_fee: getRupiah('10000'),
                total: getRupiah(`${10000 + parseInt(new_price)}`)
            }
    
            $('.course_price_beforeDiscount_content').html(data_detail_order.price_before_discount)
            $('.course_price_afterDiscount_content').html(data_detail_order.price_after_discount)
            $('.course_price_discount_content').html(data_detail_order.discount)
            $('.course_price_platformFee_content').html(data_detail_order.platform_fee)
            $('.course_price_total_content').html(data_detail_order.total)
            $('#btn-buy-course').on('click', function () {
                window.location.href = `/checkout?id=${course_id}&type=course`
            })
            $('#btn-add-to-cart').on('click', function () {
                add_to_cart(course_id, 'course')
            })
            $('.scrollable-video-list').append(`
            <div class="buy-course d-flex align-items-center justify-content-between p-2 px-3">
                        <img width="20px" src="/image/course-detail/paid-lock.png" alt="">
                        <p>BUY COURSE</p>
                    </div>`)
        }

        // implement kurikulum
        $('.course_curriculumList_content').html('');
        videos.forEach((video, index) => {
            let { video: url, title, duration } = video
            let isPreview = index == 0 ? '<a href="#" class="preview-link">Preview</a>' : '';
            let isDisabled = url ? `<button><img width="30px" src="/image/course-detail/play-light.png"></button>` : `<button disabled> <img class="lock-button" width="30px" src="/image/course-detail/video-locked.png"> </button>`;
            let videoCard = `
            <li class="d-flex justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    ${isDisabled}
                    <p>${title}</p>
                </div>
                <div class="d-flex">
                    ${isPreview}
                    <p>${duration}</p>
                </div>
            </li>`;

            $('.course_curriculumList_content').append(videoCard);
        })

        // implement projects
    })
})



