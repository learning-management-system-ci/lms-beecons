$(document).ready(function () {
    handleCourses()

    $('#courses .btn-filter').on('click', function (e) {
        e.preventDefault()
        $('#courses .filter-container').toggleClass('d-none')
    })
})

function closeFilter() {
    $('#courses .filter-container').addClass('d-none')
}

async function handleCourses() {
    try {
        const tagsResponse = await $.ajax({
            url: '/api/type_tag',
            method: 'GET',
            dataType: 'json'
        })

        const categoryResponse = await $.ajax({
            url: '/api/category',
            method: 'GET',
            dataType: 'json'
        })

        const courseResponse = await $.ajax({
            url: '/api/course',
            method: 'GET',
            dataType: 'json'
        })

        let bidangs = [
            'Engineering',
            'IT'
        ]

        $('#accordion-bidang .filter-item').html(bidangs.map(function (bidang) {
            return `
                <div class="d-flex gap-2">
                    <input type="checkbox" name="bidang" value="${bidang}">
                    <label>${bidang}</label>
                </div>
            `
        }))

        $('#accordion-kelas .filter-item').html(tagsResponse[0].tag.map(function (tag) {
            return `
                <div class="d-flex gap-2">
                    <input type="checkbox" name="kelas" value="${tag.tag_id}">
                    <label>${tag.name}</label>
                </div>
            `
        }))

        $('#accordion-tingkat .filter-item').html(categoryResponse.map(function (category) {
            return `
                <div class="d-flex gap-2">
                    <input type="checkbox" name="tingkat" value="${category.category_id}">
                    <label>${category.name}</label>
                </div>
            `
        }))

        $('#courses-loading').hide()

        let courses = courseResponse

        let filter = {
            bidang: [],
            kelas: [],
            tingkat: []
        }

        generateListCourse(filter)

        $('#courses #btn-clearall').on('click', function (e) {
            e.preventDefault()
            $('#accordion-bidang input').prop('checked', false)
            $('#accordion-kelas input').prop('checked', false)
            $('#accordion-tingkat input').prop('checked', false)
            filter.bidang = []
            filter.kelas = []
            filter.tingkat = []
            generateListCourse(filter)
        })

        $('#courses .btn-apply').on('click', function (e) {
            e.preventDefault()
            filter.bidang = []
            filter.kelas = []
            filter.tingkat = []
            $('#accordion-bidang input').each(function () {
                if ($(this).is(':checked')) {
                    filter.bidang.push($(this).val())
                }
            })
            $('#accordion-kelas input').each(function () {
                if ($(this).is(':checked')) {
                    filter.kelas.push($(this).val())
                }
            })
            $('#accordion-tingkat input').each(function () {
                if ($(this).is(':checked')) {
                    filter.tingkat.push($(this).val())
                }
            })
            generateListCourse(filter)
            closeFilter()
        })

        function generateListCourse(filter, cpage = 1) {
            courses = courseResponse

            // handle filter
            if (filter.bidang.length > 0) {
                courses = courses.filter(function (course) {
                    return filter.bidang.includes(course.type)
                })
            }

            if (filter.kelas.length > 0) {
                courses = courses.filter(function (course) {
                    let tag = course.tag.map(function (tag) {
                        return tag.tag_id
                    })
                    return filter.kelas.some(function (item) {
                        return tag.includes(item)
                    })
                })
            }

            if (filter.tingkat.length > 0) {
                courses = courses.filter(function (course) {
                    return filter.tingkat.includes(course.category.category_id)
                })
            }
            // end handle filter

            let total = courses.length
            let perPage = 12
            let totalPage = Math.ceil(total / perPage)
            let start = (cpage - 1) * perPage
            let end = cpage * perPage
            courses = courses.slice(start, end)

            $(`#courses .btn-pgn-wrapper`).html('')
            for (let i = 1; i <= totalPage; i++) {
                $(`#courses .btn-pgn-wrapper`).append(`
                    <button class="btn-pgn" data-page='${i}'>${i}</button>
                `)
            }

            $(`#courses .btn-pgn-wrapper .btn-pgn[data-page=${cpage}]`).addClass('active')

            $(`#courses .btn-pgn-wrapper .btn-pgn`).on('click', function (e) {
                e.preventDefault()
                $('html, body').animate({
                    scrollTop: $(`#courses`).offset().top
                }, 0)
                let cpage = $(this).data('page')
                generateListCourse(filter, cpage)
            })

            if (cpage > 1) {
                $(`#courses .btn-pgn-prev-wrapper`).html(`
                    <button class="btn-pgn-prev"><i class="fa-solid fa-chevron-left"></i></button>
                `)
            } else {
                $(`#courses .btn-pgn-prev-wrapper`).html('')
            }

            if (cpage < totalPage) {
                $(`#courses .btn-pgn-next-wrapper`).html(`
                    <button class="btn-pgn-next"><i class="fa-solid fa-chevron-right"></i></button>
                `)
            } else {
                $(`#courses .btn-pgn-next-wrapper`).html('')
            }

            $(`#courses .btn-pgn-prev`).on('click', function (e) {
                e.preventDefault()
                $('html, body').animate({
                    scrollTop: $(`#courses`).offset().top
                }, 0)
                generateListCourse(filter, cpage - 1)
            })

            $(`#courses .btn-pgn-next`).on('click', function (e) {
                e.preventDefault()
                $('html, body').animate({
                    scrollTop: $(`#courses`).offset().top
                }, 0)
                generateListCourse(filter, cpage + 1)
            })

            $('#courses-list').html(courses.map(function (course) {
                return `
                    <div class="col-md-4 pb-4">
                        <div class="card-course">
                            <div class="image">
                                <a href="/course/${course.course_id}">
                                    <img src="${course.thumbnail}" alt="img">
                                </a>
    
                                <div class="card-course-tags">
                                    ${course.tag.map(tag => {
                                        return `<div class="item">${tag.name}</div>`
                                    }).join('')}
                                </div>
                                <div class='card-course-duration'>
                                    ${course.total_video_duration.total}
                                </div>
                            </div>
                            <div class="body">
                                <a href="/course/${course.course_id}">
                                    <h2 class="text-truncate mb-2">${course.title}</h2>
                                </a>
                                <p class='mb-2'>${course.author}</p>
                                <p class='mb-2'>
                                    ${textTruncate(course.description, 130)}
                                </p>
                                <div class="star-container">
                                    <div class="stars" style="--rating: ${course.rating_course}"></div>
                                </div>
                                <p class="harga">
                                    ${(() => {
                                        if (course.old_price !== '0') {
                                            return `<del>${getRupiah(course.old_price)}</del>`
                                        } else {
                                            return ''
                                        }
                                    })()}
                                    ${getRupiah(course.new_price)}
                                </p>
                            </div>
                            <div class="card-course-button">
                                ${(() => {
                                    if (!course.isBought) {
                                        return `
                                            <a href="${`/checkout?type=course&id=${course.course_id}`}" class='btn-checkout'>
                                                <button class="app-btn btn-full">Beli</button>
                                            </a>
                                            <button value=${course.course_id} class="button-secondary add-cart"><i class="fa-solid fa-cart-shopping"></i></button>
                                        `
                                    } else {
                                        return `
                                            <a href="${`/course/${course.course_id}`}">
                                                <button class="app-btn btn-full">Lihat Course</button>
                                            </a>
                                        `
                                    }
                                })()}
                            </div>
                        </div>
                    </div>
                `
            }))

            handleCheckout()

            handleAddCart()
        }

        function handleCheckout() {
            return $('.btn-checkout').on('click', function (e) {
                e.preventDefault()
                let href = $(this).attr('href')
                if (!Cookies.get('access_token')) {
                    return new swal({
                        title: 'Login',
                        text: 'Silahkan login terlebih dahulu',
                        icon: 'warning',
                        showConfirmButton: true
                    })
                } else {
                    window.location.href = href
                }
            })
        }

        function handleAddCart() {
            return $('.add-cart').on('click', async function () {
                const course_id = $(this).val()

                if (!Cookies.get("access_token")) {
                    return new swal({
                        title: 'Login',
                        text: 'Silahkan login terlebih dahulu',
                        icon: 'warning',
                        showConfirmButton: true
                    })
                }

                try {
                    const res = await $.ajax({
                        url: `/api/cart/create/course/${course_id}`,
                        method: 'POST',
                        dataType: 'json',
                        headers: {
                            Authorization: 'Bearer ' + Cookies.get("access_token")
                        }
                    })

                    if (res.status !== 200) {
                        return new swal({
                            title: 'Gagal',
                            text: 'Course sudah ada di keranjang',
                            icon: 'error',
                            showConfirmButton: true
                        })
                    }

                    new swal({
                        title: "Berhasil!",
                        text: "Course berhasil ditambahkan ke keranjang",
                        icon: "success",
                        timer: 1200,
                        showConfirmButton: false
                    })

                    const { item } = await $.ajax({
                        url: '/api/cart',
                        method: 'GET',
                        dataType: 'json',
                        headers: {
                            Authorization: 'Bearer ' + Cookies.get("access_token")
                        }
                    })

                    if (item.length > 0) {
                        $('#cart-count').append(
                            `<div class="nav-btn-icon-amount">${item.length}</div>`
                        );
                    }
                } catch (err) {
                    let error = err.responseJSON
                    return new swal({
                        title: 'Gagal',
                        text: error.messages.error,
                        icon: 'error',
                        showConfirmButton: true
                    })
                }
            })
        }
    } catch (error) {
        console.log(error)
    }
}