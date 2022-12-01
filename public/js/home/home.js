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
        if (e.target !== $('.form-control')[0] && e.target !== $('#nav-btn-search')[0] && e.target !== $('#nav-btn-search-x')[0] && e.target !== $('#nav-btn-search')[0] && e.target !== $('#nav-btn-search i')[0]) {
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

    const getAllCourses = async () => {
        try {
            const response = await $.ajax({
                url: '/api/course',
                method: 'GET',
                dataType: 'json'
            })

            let courses = response

            let coursesRekomendasi = courses.slice(0, 5)
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
            console.log(error);
        }
    }

    getAllCourses()
})