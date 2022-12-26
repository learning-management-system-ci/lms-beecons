$(document).ready(function () {
    // handle courses
    handleCourses()

    // handle training
    handleTraining()

    // handle webinar
    // handleWebinar()

    // handle mentor slider
    handleAuthor()

    // handle articles
    handleArtikel()

    // handle testimoni
    handleTestimoni()
})

async function handleCourses() {
    try {
        const courseResponse = await $.ajax({
            url: '/api/course/latest',
            method: 'GET',
            dataType: 'json'
        })

        let courses = courseResponse.slice(0, 3)

        if (Cookies.get('access_token')) {
            let userCourses = []
            try {
                const res = await $.ajax({
                    url: `/api/user-course`,
                    method: 'GET',
                    dataType: 'json',
                    headers: {
                        Authorization: 'Bearer ' + Cookies.get("access_token")
                    }
                })

                userCourses = res
            } catch (error) {
                // console.log(error)
            }

            courses = courses.map((course, i) => {
                return {
                    ...course,
                    isBought: userCourses.map(userCourse => userCourse.course_id).includes(course.course_id)
                }
            })
        }
        
        $('#choose-course .choose-course-list').html(courses.map(course => {
            return `
                <div class="col col-md-4">
                    <div class="card-course">
                        <div class="image">
                            <a href="/course/${course.course_id}">
                                <img src="${course.thumbnail}" alt="img">
                            </a>

                            <div class="card-course-tags">
                                ${course.tag?.map(tag => {
                                    return `<div class="item">${tag.name}</div>`
                                }).join('')}
                            </div>
                            <div class='card-course-duration'>
                                ${course.total_video_duration.total}
                            </div>
                        </div>
                        <div class="body">
                            <a href="/course/${course.course_id}">
                                <h2 class="mb-2">${course.title}</h2>
                            </a>
                            <p class='mb-2'>${course.author}</p>
                            <p class='mb-2 d-none'>
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
            return $('.add-cart').on('click', function () {
                const course_id = $(this).val()

                if (!Cookies.get("access_token")) {
                    return new swal({
                        title: 'Login',
                        text: 'Silahkan login terlebih dahulu',
                        icon: 'warning',
                        showConfirmButton: true
                    })
                }

                $.ajax({
                    url: `/api/cart/create/course/${course_id}`,
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        Authorization: 'Bearer ' + Cookies.get("access_token")
                    }
                }).then((res) => {
                    if (res.status !== 200) {
                        return new swal({
                            title: 'Gagal',
                            text: 'Course sudah ada di keranjang',
                            icon: 'error',
                            showConfirmButton: true
                        })
                    }

                    $.ajax({
                        url: '/api/cart',
                        method: 'GET',
                        dataType: 'json',
                        headers: {
                            Authorization: 'Bearer ' + Cookies.get("access_token")
                        }
                    }).then((res) => {
                        if (res.item.length > 0) {
                            $('#cart-count').append(
                                `<div class="nav-btn-icon-amount">${res.item.length}</div>`
                            );
                        }
                    }).then(() => {
                        return new swal({
                            title: "Berhasil!",
                            text: "Course berhasil ditambahkan ke keranjang",
                            icon: "success",
                            timer: 1200,
                            showConfirmButton: false
                        })
                    })
                }).catch((err) => {
                    let error = err.responseJSON
                    return new swal({
                        title: 'Gagal',
                        text: error.messages.error,
                        icon: 'error',
                        showConfirmButton: true
                    })
                })
            })
        }
    } catch (error) {
        // console.log(error)
    }
}

async function handleTraining() {
    try {
        const trainingResponse = await $.ajax({
            url: '/api/course/filter/training/3',
            method: 'GET',
            dataType: 'json'
        })

        $('#training .training-wrapper').html(trainingResponse.map(training => {
            return `
                <div class="col-md-4">
                    <div class="card-training">
                        <div class="thumbnail">
                            <img src="${training.thumbnail}" alt="thumbnail">
                        </div>
                        <div class="title">
                            <h2 class="">${training.title}</h2>
                        </div>
                        <div class="body">
                            <p class="mb-2 d-none">
                                ${textTruncate(training.description, 130)}
                            </p>
                            <div class="info d-flex align-items-center gap-2">
                                <i class="fa-solid fa-house"></i>   
                                <p class="m-0">In House Traning</p>
                            </div>
                        </div>
                        <div class="price my-1 mb-2">
                            <p class="m-0">${getRupiah(training.new_price)}</p>
                        </div>
                        <div class="btn-wrapper">
                            <a href="${`/training/${training.course_id}`}">
                                <button class="app-btn btn-full">Lihat Detail</button>
                            </a>
                        </div>
                    </div>
                </div>
            `
        }))
    } catch (error) {
        // console.log(error)
    }
}

async function handleWebinar() {
    try {
        const webinarResponse = await $.ajax({
            url: '/api/webinar',
            method: 'GET',
            dataType: 'json'
        })

        $('#webinar .webinar-wrapper').html(webinarResponse.map(webinar => {
            return `
                <div class="col col-md-4">
                    <div class="card-webinar">
                        <div class="image">
                            <img src="${webinar.thumbnail}" alt="img">
                        </div>

                        <h2>${webinar.title}</h2>
                        <div class="item-info">
                            <i class="fa-solid fa-video"></i>
                            <p>${webinar.webinar_type}</p>
                        </div>
                        <div class="item-info">
                            <i class="fa-solid fa-file-video"></i>
                            <p>Soft file Rekaman Webinar</p>
                        </div>
                        <div class="price">
                            <del class="harga-diskon">${getRupiah(webinar.old_price)}</del>
                            <h2 class="harga m-0">${getRupiah(webinar.new_price)}</h2>
                        </div>

                        <a href="">
                            <button class="my-btn btn-full">Ikut Webinar</button>
                        </a>
                    </div>
                </div>
            `
        }))
    } catch (error) {
        // console.log(error)
    }
}

async function handleAuthor() {
    try {
        const authorResponse = await $.ajax({
            url: '/api/users/author',
            method: 'GET',
            dataType: 'json'
        })

        $('#author-wrapper').html(authorResponse.author.map(author => {
            return `
                <div class="card-author">
                    <div class="profile">
                        <img src="${author.profile_picture}" alt="profile">
                    </div>

                    <div class="info">
                        <h2 class='mb-3'>${author.fullname}</h2>
                        <p>${author.company}</p>
                    </div>

                    <div class="star-container">
                        <div class="stars" style="--rating: ${author.author_final_rating}"></div>
                        <h2 class="d-none">${author.author_final_rating}</h2>
                    </div>
                </div>
            `
        }))

        $('#author-wrapper').slick({
            dots: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            touchMove: true,
            autoplay: true,
            speed: 500,
            autoplaySpeed: 1200,
        })
    } catch (error) {
        // console.log(error)
    }
}

async function handleArtikel() {
    try {
        let artikels = [
            {
                id: 1,
                title: 'Artikel 1',
                content: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.',
            },
            {
                id: 2,
                title: 'Artikel 2',
                content: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.',
            },
            {
                id: 3,
                title: 'Artikel 3',
                content: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.',
            }
        ]

        $('#artikel .artikel-wrapper').html(artikels.map(artikel => {
            return `
                <div class="col col-md-4">
                    <a href="/" class="artikel-item" data-atikel-id=${artikel.id}>
                        <div class="image">
                            <img src="/image/home/people.jpg" alt="">
                            <div class="gradient"></div>
                            <div class="content">
                                <h2>${artikel.title}</h2>
                                <p>
                                    ${artikel.content.slice(0, 100)}...
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            `
        }))

        $('#artikel .artikel-item').on('mouseover', artikelMouseOver)
        $('#artikel .artikel-item').on('mouseout', artikelMouseOut)

        function artikelMouseOver() {
            $(this).find('.gradient').addClass('active')

            let artikelId = $(this).data('atikel-id')
            let artikel = artikels.find(artikel => artikel.id == artikelId)

            $(this).find('.content').html(
                `
                    <h2>${artikel.title}</h2>
                    <p>${artikel.content.slice(0, 150)}...</p>
                    <span>Baca selengkapnya <i class="fa-solid fa-arrow-right ms-2"></i></span>
                `
            )
        }

        function artikelMouseOut() {
            $(this).find('.gradient').removeClass('active')

            let artikelId = $(this).data('atikel-id')
            let artikel = artikels.find(artikel => artikel.id == artikelId)

            $(this).find('.content').html(
                `
                    <h2>${artikel.title}</h2>
                    <p>${artikel.content.slice(0, 100)}...</p>
                `
            )
        }
    } catch (error) {
        // console.log(error)
    }
}

async function handleTestimoni() {
    try {
        const testimoniResponse = await $.ajax({
            url: '/api/testimoni',
            method: 'GET',
            dataType: 'json'
        })

        $('#testimoni .testimoni-slick').html(testimoniResponse.testimoni.map((testimoni) => {
            return (`
                <div class="testimoni-container">
                    <div class="image">
                        <img src="${testimoni.users[0].profile_picture}" alt="profile">
                    </div>
                    <div class="content">
                        <div class="title">
                            
                        </div>
                        <div class="name">
                            ${testimoni.users[0].fullname}
                        </div>
                        <div class="text">
                            ${testimoni.testimoni}
                        </div>
                    </div>
                </div>
            `)
        }))

        // testimoni slider
        $('.testimoni-slick').slick({
            dots: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            touchMove: true,
            centerMode: false,
        })
    } catch (error) {
        console.log(error)
    }
}