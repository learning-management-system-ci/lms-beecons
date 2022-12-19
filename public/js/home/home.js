$(document).ready(() => {
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
        $('.nav-search-input form input').val('')
        $('#search-result').html('')
        $('#search-result-initial').show()
    })

    $('.nav-search-input form').on('submit', (e) => {
        e.preventDefault()
    })

    $('#nav-btn-search-x').on('click', (e) => {
        $('.nav-item-search .dropdown-menu.show').removeClass('show')
    })

    // close search when user clicks outside of search inpput
    $(document).on('click', (e) => {
        if (e.target !== $('.form-control')[0] && e.target !== $('#nav-btn-search')[0] && e.target !== $('#nav-btn-search-x')[0] && e.target !== $('#nav-btn-search')[0] && e.target !== $('#nav-btn-search img')[0]) {
            $('.nav-search-input').eq(0).hide()
            $('#nav-btn-search').show(200)
            $('.nav-search-input form input').val('')
            $('#search-result').html('')
            $('#search-result-initial').show()
            $('.nav-item-search .dropdown-menu.show').removeClass('show')
        }
    })

    // handle logout
    $('#btn-logout').on('click', function (e) {
        e.preventDefault()

        Cookies.remove('access_token')
        window.location = '/'
    })

    // handle contact us
    $('#form-contactus').on('submit', function (e) {
        e.preventDefault()
        $('#form-contactus button[type="submit"]').attr('disabled', true)

        let email = $('#form-contactus input[name="email"]').val()
        let question = $('#form-contactus textarea[name="question"]').val()
        let question_image = $('#form-contactus input[name="question_image"]')[0].files[0]

        let formData = new FormData()
        formData.append('email', email)
        formData.append('question', question)
        formData.append('question_image', question_image)

        $.ajax({
            url: '/api/contactus/question',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#form-contactus input[name="email"]').val('')
                $('#form-contactus textarea[name="question"]').val('')
                $('#form-contactus input[name="question_image"]').val('')
                new swal({
                    title: "Berhasil!",
                    text: "Pertanyaan anda telah terkirim",
                    icon: "success",
                    timer: 1200,
                    showConfirmButton: false
                })
            },
            error: function (error) {
                new swal({
                    title: "Gagal!",
                    text: "Pertanyaan anda gagal terkirim",
                    icon: "error",
                    timer: 1200,
                    showConfirmButton: false
                })
            },
            complete: function () {
                $('#form-contactus button[type="submit"]').attr('disabled', false)
            }
        })
    })

    getAllCourses()
})

async function getAllCourses() {
    try {
        const response = await $.ajax({
            url: '/api/course',
            method: 'GET',
            dataType: 'json'
        })

        $('.courses-loading').hide()

        let courses = response

        let coursesRekomendasi = courses.slice(0, 7)
        let courseRecent = JSON.parse(localStorage.getItem('search-recent'))
        let coursesResult = []

        $('.nav-search-input form input').on('keyup', () => {
            $('#search-result-initial').hide()
            let search = $('.nav-search-input form input').val()

            if (search.length > 0) {
                coursesResult = courses.filter(course => {
                    return course.title.toLowerCase().includes(search.toLowerCase())
                }).slice(0, 10)

                let htmlSearchResult = ''

                coursesResult.forEach(course => {
                    htmlSearchResult += `
                        <a href="/course/${course.course_id}" data-search-id="${course.course_id}">
                            <div class="search-item">
                                <div class="icon">
                                    <img src="${course.thumbnail}" alt="thumbnail">
                                </div>
                                <div class="desc">
                                    <h5>${course.title}</h5>
                                    <p>
                                        ${textTruncate(course.description, 80)}
                                    </p>
                                </div>
                            </div>
                        </a>
                    `
                })

                $('#search-result').removeClass('d-none')

                $('#search-result').html(htmlSearchResult)

                $('#search-result a').on('click', function (e) {
                    let searchId = $(this).data('search-id')
                    let course = courses.find(course => course.course_id == searchId)
                    localStorage.setItem('search-recent', JSON.stringify(course))
                })

            } else {
                $('#search-result').html('')
                $('#search-result-initial').show()
            }
        })

        if (courseRecent) {
            let htmlSearchRecent = `
                <a href="/course/${courseRecent.course_id}">
                    <div class="search-item">
                        <div class="icon">
                            <img src="${courseRecent.thumbnail}" alt="">
                        </div>
                        <div class="desc">
                            <h5>${courseRecent.title}</h5>
                            <p>
                                ${textTruncate(courseRecent.description, 80)}
                            </p>
                        </div>
                    </div>
                </a>
            `

            $('#search-recent').append(htmlSearchRecent)
        }

        let htmlSearchRekomendasi = ''

        coursesRekomendasi.forEach(course => {
            htmlSearchRekomendasi += `
                <a href="/course/${course.course_id}">
                    <div class="search-item">
                        <div class="icon">
                            <img src="${course.thumbnail}" alt="">
                        </div>
                        <div class="desc">
                            <h5>${course.title}</h5>
                            <p>
                                ${course.description.length > 80 ? course.description.slice(0, 80) + '...' : course.description}
                            </p>
                        </div>
                    </div>
                </a>
            `
        })

        $('#search-rekomendasi').append(htmlSearchRekomendasi)
    } catch (error) {
        // console.log(error);
    }
}