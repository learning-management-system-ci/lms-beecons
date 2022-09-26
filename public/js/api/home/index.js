let courses = []
const getAllCourses = async () => {
    try {
        const response = await $.ajax({
            url: '/api/course',
            method: 'GET',
            dataType: 'json'
        })

        courses = response

        let coursesRekomendasi = courses.slice(0, 3)
        let courseRecent = courses[0]
        let coursesResult = []

        $('.nav-search-input form input').on('keyup', () => {
            $('#search-result-initial').hide()
            let search = $('.nav-search-input form input').val()

            if (search.length > 0) {
                coursesResult = courses.filter(course => {
                    return course.title.toLowerCase().includes(search.toLowerCase())
                }).slice(0, 5)

                let htmlSearchResult = ''

                coursesResult.forEach(course => {
                    htmlSearchResult += `
                            <a href="">
                                <div class="search-item">
                                    <div class="icon">
                                        <img src="/image/home/${course.thumbnail}" alt="">
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

                $('#search-result').html(htmlSearchResult)
            } else {
                $('#search-result').html('')
                $('#search-result-initial').show()
            }
        })


        let htmlSearchRekomendasi = ''
        let htmlSearchRecent = `
                <a href="">
                    <div class="search-item">
                        <div class="icon">
                            <img src="/image/home/${courseRecent.thumbnail}" alt="">
                        </div>
                        <div class="desc">
                            <h5>${courseRecent.title}</h5>
                            <p>
                                ${courseRecent.description}
                            </p>
                        </div>
                    </div>
                </a>
            `

        coursesRekomendasi.forEach(course => {
            htmlSearchRekomendasi += `
                    <a href="">
                        <div class="search-item">
                            <div class="icon">
                                <img src="/image/home/${course.thumbnail}" alt="">
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
        $('#search-recent').append(htmlSearchRecent)
    } catch (error) {
        console.log(error);
    }
}

getAllCourses()