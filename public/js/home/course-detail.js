const add_to_cart = async (id, type) => {
    if (Cookies.get('token') == undefined) {
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
        }).then((result) => {
            if ((result.dismiss === Swal.DismissReason.timer)) {
                window.location.href = "/login"
            }
        })
    } else {
        let option = {
            url: `/api/cart/create/${type}/${id}`,
            type: 'POST',
            dataType: 'json',
            headers: {
                authorization: `Bearer ${Cookies.get('access_token')}`
            },
            success: function (result) {
                console.log(result)
                window.location.href = "/cart";
            }
        }

        $.ajax(option)
    }

}

const getCourseData = async (course_id) => {
    try {
        let option = {
            url: `/api/course/detail/${course_id}`,
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

const getVideoDetailData = async (video_id) => {
    try {
        let option = {
            url: `/api/course/video/${video_id}`,
            type: 'GET',
            dataType: 'json',
            headers: {
                authorization: `Bearer ${Cookies.get('access_token')}`
            },
            success: function (result) {
                data = result
            },
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
            url: `/api/course/video/${video_id}`,
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

const getResumeDetailData = async (resume_id) => {
    try {
        let option = {
            url: `/api/resume/detail/${resume_id}`,
            type: 'GET',
            dataType: 'json',
            headers: {
                authorization: `Bearer ${Cookies.get('access_token')}`
            },
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

const createResumeData = async (video_id, resume) => {
    try {
        let option = {
            url: `/api/resume/create`,
            type: 'POST',
            dataType: 'json',
            headers: {
                authorization: `Bearer ${Cookies.get('access_token')}`
            },
            data: {
                video_id: video_id,
                resume: resume
            },
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

const putResumeData = async (resume_id, video_id, resume) => {
    try {
        let option = {
            url: `/api/resume/update/${resume_id}`,
            type: 'PUT',
            dataType: 'json',
            headers: {
                "Authorization": `Bearer ${Cookies.get("access_token")}`,
            },
            data: {
                resume: resume,
                video_id: video_id
            },
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

const postReviewData = async (course_id, feedbackData) => {
    const { review, rating } = feedbackData
    try {
        let option = {
            url: `/api/review/create`,
            type: 'POST',
            dataType: 'json',
            headers: {
                "Authorization": `Bearer ${Cookies.get("access_token")}`,
            },
            data: {
                course_id: course_id,
                feedback: review,
                score: rating
            },
            success: function (result) {
                data = {result, err: null}
            },
            // add error condition
            error: function (err) {
                data = {result: null, err: err}
            }
            
        }
        let data
        await $.ajax(option)
        return data
    } catch (error) {
        console.log(error)
    }
}

// Populate Function
const populateGeneral = async (course) => {
    let {
        course_id,
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
        video: videos,
        countVideo = videos.length,
    } = course;
    console.log(course)
    sessionStorage.setItem('owned', owned)
    sessionStorage.setItem('is_reviewed', course.is_review)

    videos.sort((a, b) => {
        return a.order - b.order
    })

    $('.course_title_content').html(title)
    $('.course_type_content').html(type.name)
    $('a.course_type_content').attr('href', `/course/type/detail/${type.type_id}`)
    $('.course_description_content').html(description)
    $('.course_description-keyTakeaway_content').html(key_takeaways)
    $('.course_description-suitableFor_content').html(suitable_for)
    $('.course_videoCount_content').html(countVideo + ' video')

    populateVideo(videos, owned)
    populateResume(videos)
    populateReview(reviews)
    populatePricing({ old_price, new_price, course_id })
    populateCurriculum(videos)

    let started_video = videos.some((video) => {
        if (video.score < 50) {
            let { video_id, video: url, thumbnail, owned } = video;
            start_video(video_id, url, thumbnail, owned)
        }
        return video.score < 50
    })

    if (!started_video) {
        start_video(videos[0].video_id, videos[0].video, videos[0].thumbnail, owned)
    }

    $(".list-card-button-new").on('click', function () {
        if (!$(this).hasClass('disabled')) {
            let url = $(this).data('url');
            let video_id = $(this).data('videoid');
            let thumbnail = $(this).data('thumbnail');
            let owned = $(this).data('owned');

            start_video(video_id, url, thumbnail, owned)
        }
    })

    $('#reviewModal').modal({
        backdrop: 'static',
        keyboard: false
    })
}

const populateVideo = async (videos, owned) => {
    // empty video list
    $('.course_videoList_content').html('')

    // populate video list
    sessionStorage.setItem('videos', JSON.stringify(videos))
    videos.forEach((video, index) => {
        let {
            title: video_title,
            score,
            // isComplete = score > 50 ? 'complete-new' : '',
            duration,
            video: url,
            video_id: id,
            thumbnail,
            resumeContent = video.resume || null,
        } = video

        let isComplete;
        if (score > 50 && resumeContent) {
            isComplete = 'complete-new'
        } else {
            isComplete = ''
        }
        let isDisabled = ((score > 50)) ? '' : 'disabled'
        let videoCard = `
        <div class="list-card-button-new ${isComplete} ${isDisabled} d-flex justify-content-between align-items-center p-3 mb-3" data-url="${url}" data-videoid=${id} data-thumbnail=${thumbnail} data-owned=${owned}>
            <div class="list-title d-flex align-items-center">
                <button></button>
                <p>${video_title}</p>
            </div>
            <p class="duration">${duration}</p>
        </div>
        
        `

        $('.course_videoList_content').append(videoCard)
    })

    // enable first video
    $('.list-card-button-new.disabled').first().removeClass('disabled')
}

const populateResume = async (videos) => {
    if (Cookies.get("access_token")) {
        $('.course_resumeList_content').html('');
        videos.forEach((video, index) => {
            const { title, resume } = video
            let btn;
            if (resume == null)
                btn = `<button class="resume-list-btn" disabled>resume</button>`
            else
                btn = `<button class="resume-list-btn" onclick="displayViewResumeModal(${resume.resume_id})">resume</button>`

            let resumeList = `
            <li class="d-flex justify-content-between mb-3 ms-2">
                <div class="d-flex align-items-center">
                    <p class="fw-bold">${title}</p>
                </div>
                <div class="d-flex">
                    ${btn}
                </div>
            </li>
            `
            $('.course_resumeList_content').append(resumeList)
        })
    } else {
        $('.course_resumeList_content').html(`
            <li class="d-flex justify-content-between mb-3 ms-2">
                <div class="d-flex align-items-center">
                    <p class="fw-bold">Login to see your resume</p>
                </div>
            </li>
        `)
        $('.course_resumeList_content').addClass('d-flex justify-content-center')
    }
}

const populateReview = async (reviews) => {
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
            </div>
            `
        $('.course-review-content').append(reviewCard)
    })
}

const populatePricing = async (course) => {
    console.log(course.owned)
    if (!course.owned) {
        const { old_price, new_price, course_id } = course
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
            </div>
        `)
    } else {
        $('.order-card').hide()
    }
}

const populateCurriculum = async (videos) => {
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
}

function start_video(video_id, url, thumbnail, status = true) {
    const card_button = $(`.list-card-button-new[data-videoid=${video_id}]`);
    var check_image = card_button.find("button");
    sessionStorage.setItem("video_id", video_id)
    $('.quiz-panel').hide()
    $('.video-panel').show()

    if (status) {
        if (check_image.css("background-image").includes("play")) {
            // ubah list card button dia menjadi aktif
            card_button.addClass("active-new").removeClass("disabled")
            // ubah list card button lainnya menjadi list card button
            card_button.siblings().removeClass("active-new list-active-complete")
        }

        if (check_image.css("background-image").includes("complete")) {
            card_button.addClass("list-active-complete active-new")
            card_button.siblings().removeClass("active-new list-active-complete")
        }
    }

    $('.video-panel').html(`
    <video class="course-video-wraper mb-5" class="mb-5" controls poster="${thumbnail}">
        <source class="course-video-content" src="${url}" type="video/mp4">
        Your browser does not support the video tag.
    </video>`)

    // console.log(card_button)
    $('.course-video-wraper').on('ended', async function () {
        const owned = sessionStorage.getItem('owned') == 'true' ? true : false
        const video_id = sessionStorage.getItem('video_id')
        const course_id = sessionStorage.getItem('course_id')
        const is_reviewed = sessionStorage.getItem('is_reviewed') == 'true' ? true : false
        const videosData = JSON.parse(sessionStorage.getItem('videos'))
        const data = videosData.find(video => video.video_id == video_id)
        // const data = await getVideoDetailData(video_id)
        console.log(data)
        if (!owned) {
            if (!Cookies.get("access_token")) {
                let feedback = confirm("You need to login and buy course to continue")
                if (feedback) {
                    window.location.href = "/login"
                }
                return
            } else {
                let feedback = confirm("You need to buy course to continue")
                if (feedback) {
                    window.location.href = "/checkout"
                }
                return
            }
        }
        if (data.score < 50){
            // hide element
            console.log("belum lulus")
            $(this).hide()
            let questions_template = '';
            let quizData = await getQuizData(video_id);
            const questions = quizData.quiz.soal
            questions.forEach(({ question, answer }, index) => {
                let question_template = `<div class="swiper-slide">
                    <h4 class="quiz-title">${question}</h4>
                    <p class="mb-5">PILIHAN GANDA</p>
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
                let videoId = $('.active-new').data('videoid')
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
                    answerArr.push({ 'answer': answer })
                    console.log(answerArr)
                })

                // send post request to localhost:8080/api/course/video/:id
                // with answerArr as body as raw json
                // and get response as json
                $.ajax({
                    url: `/api/course/video/${videoId}`,
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
                        console.log(response)
                        if (response.success) {
                            //alert anda dapat melanjutkan ke video selanjutnya
                            //redirect ke video selanjutnya
                            if (response.pass) {
                                displayCreateResumeModal(response)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Anda belum berhasil lolos kuis, silahkan coba lagi',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let video_id = $('.active-new').data('videoid')
                                        let url = $('.active-new').data('url');
                                        let thumbnail = $('.active-new').data('thumbnail');
                                        // nnti benerin ya, seharusnya lebih aman lgi
                                        let owned = $('.active-new').data('owned');
                                        start_video(video_id, url, thumbnail, owned, false)
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
        } else if (!data.resume){
            displayCreateResumeModal(data)
        } else if (($('.list-card-button-new').length == $('.list-card-button-new.complete-new').length) && !is_reviewed ){
            displayCreateReviewModal()
        } else if($('.active-new').next()[0] == null){
            console.log(data)
            $('.active-new').next().click()
        } else {
            window.location.href = '/profile'
        }
    })
}

// const viewResumeModal = async (resume_id) => {
//     const resume_data = await getResumeDetailData(resume_id)
//     const { resume, video_id } = resume_data

//     const { value: resume_new } = await Swal.fire(
//         {
//             title: 'Resume',
//             input: "textarea",
//             inputAttributes: {
//                 'aria-label': 'Resume'
//             },
//             inputValue: resume,
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Save',
//             width: '50%',
//             height: '50%',
//             preConfirm: (resume) => {
//                 if (resume == '') {
//                     Swal.showValidationMessage(
//                         `Resume tidak boleh kosong`
//                     )
//                 }
//             },
//         }
//     )

//     if (resume !== resume_new) {
//         putResumeData(resume_id, video_id, resume_new)
//     }
// }

// const addViewResume = async (video_id) => {
//     const { value: resume } = await Swal.fire({
//         title: 'Resume',
//         input: "textarea",
//         inputAttributes: {
//             'aria-label': 'Resume'
//         },
//         allowOutsideClick: false,
//         allowEscapeKey: false,
//         showConfirmButton: true,
//         showCancelButton: false,
//         inputValidator: (resume) => {
//             if (resume == '') {
//                 return 'Resume tidak boleh kosong'
//             }
//         }

//     })

//     if (resume) {
//         createResumeData(video_id, resume)
//     }
// }

const displayViewResumeModal = async (resume_id) => {
    const resume_data = await getResumeDetailData(resume_id)
    const { resume, video_id } = resume_data

    $('#resumeViewModal').modal('show')
    $('#resumeViewModal #resumeViewText').val(resume)

    $('#resumeViewModal #resumeViewText').on('input', () => {
        console.log($('#resumeViewText').val())
        if ($('#resumeViewText').val() != '') {
            console.log('masuk')
            $('#resumeViewEdit').prop('disabled', false)
        } else {
            console.log('masuk2')
            $('#resumeViewEdit').prop('disabled', true)
        }
    })

    $('#resumeViewModal #resumeViewEdit').on('click', async() => {
        if($('#resumeViewText').val() != ''){
            await displayViewResumeModal(resume_id)
            $('#resumeViewModal').modal('hide')
        }
    })

    $('#resumeViewModal #resumeViewBack').on('click', () => {
        $('#resumeViewModal').modal('hide')
    })
}

const displayCreateResumeModal = async (data) => {
    // show resume modal
    $('#resumeAddModal').modal('show');
    $('#resumeAddText').val('')
    $('#score').text(data.score || '80')

    // check if resume input is not empty. if not empty, enable submit button
    $('#resumeAddText').on('input', () => {
        if ($('#resumeAddText').val() != '') {
            $('#resumeAddSubmit').prop('disabled', false)
        } else {
            $('#resumeAddSubmit').prop('disabled', true)
        }
    })

    // submit resume
    $('#resumeAddSubmit').on('click', async () => {
        const video_id = $('.active-new').data('videoid')

        // get resume text
        let resumeAddText = $('#resumeAddText').val()

        // post resume
        if(resumeAddText != ''){
            await createResumeData(video_id, resumeAddText)
            $('#resumeAddModal').modal('hide')

            $('.active-new').addClass('complete-new')
            if($('.list-card-button-new').length == $('.list-card-button-new.complete-new').length){
                displayCreateReviewModal()
            } else {
                $('.active-new').next().removeClass('disabled')
                $('.active-new').next().click()
            }
        }
    })
}

const displayCreateReviewModal = async () => {
    // show review modal
    $('#reviewModal').modal('show');
    
    // check if rating input and review text are not empty. if not empty, enable submit button
    $('.rating-input input').on('change', () => {
        if (($('#reviewText').val() != '') && ($('.rating-input input:checked').val() != undefined)) {
            $('#reviewSubmit').prop('disabled', false)
        } else {
            $('#reviewSubmit').prop('disabled', true)
        }
    })
    $('#reviewText').on('input', () => {
        if (($('#reviewText').val() != '') && ($('.rating-input input:checked').val() != undefined)) {
            $('#reviewSubmit').prop('disabled', false)
        } else {
            $('#reviewSubmit').prop('disabled', true)
        }
    })

    // onclick submit button
    $('#reviewModal').on('click', '#reviewSubmit', async (e) => {
        e.preventDefault();
        // get form values
        let formValues = {
            'rating': $('.rating-input input:checked').val(),
            'review': $('#reviewText').val()
        }

        // if all attribute form values is not empty, post data to backend
        if (formValues.rating && formValues.review) {
            const course_id = sessionStorage.getItem('course_id')
            let response = await postReviewData(course_id, formValues)

            // if success, close modal
            if (!response.err) {
                $('#reviewModal').modal('hide')
                // redirect to profile page
                window.location.href = '/profile'
            } else {
                alert(response.err)
            }
        }
        
    })
}

$(document).ready(() => {
    // get id from url last segment
    let url = window.location.href
    let course_id = url.substring(url.lastIndexOf('/') + 1)
    sessionStorage.setItem('course_id', course_id)

    courseData = getCourseData(course_id);

    // implement data
    courseData.then((data) => {
        $('#course-detail-page').removeClass('d-none')
        populateGeneral(data)
    })
})
