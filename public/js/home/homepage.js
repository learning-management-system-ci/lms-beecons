$(document).ready(async function () {
    // handle courses
    try {
        const courseResponse = await $.ajax({
            url: '/api/course',
            method: 'GET',
            dataType: 'json'
        })
        
        setCourses('0')
        handleAddCart()

        $('#choose-course .tags .item').on('click', function (e) {
            e.preventDefault()
            let typeId = $(this).attr('data-type-id')
            
            setCourses(typeId)
            handleAddCart()
        })

        function setCourses(type) {
            let coursesAll = courseResponse.slice(0, 3)
            let coursesEngineering = courseResponse.filter(course => course.type[0].type_id === '1').slice(0, 3)
            let coursesIt = courseResponse.filter(course => course.type[0].type_id === '2').slice(0, 3)

            $(`#choose-course .tags .item[data-type-id="${type}"]`).addClass('active').siblings().removeClass('active')

            let courses = []
            if (type === '0') courses = coursesAll
            else if (type === '1') courses = coursesEngineering
            else if (type === '2') courses = coursesIt

            $('#choose-course .choose-course-list').html(courses.map(course => {
                return `
                    <div class="col col-md-4 px-4 pb-4">
                        <div class="card-course">
                            <div class="image">
                                <img src="image/home/img-course.jpg" alt="img">
    
                                <div class="card-course-tags">
                                    ${course.tag.map(tag => {
                                        return `<div class="item">${tag.name}</div>`
                                    }).join('')}
                                </div>
                            </div>
                            <div class="body">
                                <h2 class="text-truncate">${course.title}</h2>
                                <p>
                                    ${textTruncate(course.description, 120)}
                                </p>
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
                                <a href="">
                                    <button class="my-btn btn-full">Beli</button>
                                </a>
                                <button value=${course.course_id} class="button-secondary add-cart"><i class="fa-solid fa-cart-shopping"></i></button>
                            </div>
                        </div>
                    </div>
                `
            }))
        }

        function handleAddCart() {
            return $('.add-cart').on('click', function() {
                const course_id = $(this).val()
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
                    
                    return new swal({
                        title: "Berhasil!",
                        text: "Course berhasil ditambahkan ke keranjang",
                        icon: "success",
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => window.location = '/cart')
                }).catch((err) => {
                    console.log(error)
                })
            })
        }
    } catch (error) {
        console.log(error)
    }

    // handle mentor slider
    try {
        const mentorResponse = await $.ajax({
            url: '/api/mentor',
            method: 'GET',
            dataType: 'json'
        })
        
        let mentors = mentorResponse.map(mentor => {
            return {
                id: mentor.id,
                fullname: mentor.fullname,
                profile_picture: 'people.jpg',
                job: mentor.job_name,
                stars: 4.5,
                links: {
                    linkedin: '/',
                    ig: '/',
                    fb: '/'
                }
            }
        })

        $('#mentor-wrapper').html(mentors.map(mentor => {
            return `
                <div class="card-mentor">
                    <div class="profile">
                        <img src="image/home/${mentor.profile_picture}" alt="mentor">
                    </div>

                    <div class="info">
                        <h2>${mentor.fullname}</h2>
                        <p>${mentor.job}</p>
                    </div>

                    <div class="star-container">
                        <div class="stars" style="--rating: ${mentor.stars}"></div>
                        <h2>${mentor.stars}</h2>
                    </div>

                    <div class="sosmed">
                        <a href="${mentor.links.linkedin}">
                            <i class="fa-brands fa-linkedin"></i>
                        </a>
                        <a href="${mentor.links.ig}">
                            <i class="fa-brands fa-chrome"></i>
                        </a>
                        <a href="${mentor.links.fb}">
                            <i class="fa-brands fa-square-behance"></i>
                        </a>
                    </div>
                </div>
            `
        }))

        $('#mentor-wrapper').slick({
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            touchMove: true,
            autoplay: true,
            speed: 500,
            autoplaySpeed: 1200,
        })
    } catch (error) {
        console.log(error)
    }

    // handle articles
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
                <div class="col col-md-3">
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
        console.log(error)
    }

    // handle testimoni
    try {
        const testimoniResponse = await $.ajax({
            url: '/api/testimoni',
            method: 'GET',
            dataType: 'json'
        })

        let testimonials = testimoniResponse.map(testimoni => {
            return {
                testimoni_id: testimoni.testimoni_id,
                fullname: testimoni.user[0].fullname,
                job: 'Alumbi Fullstack Engineer',
                picture: 'people.jpg',
                testimoni: testimoni.testimoni
            }
        })
        
        $('#testimoni .testimoni-slick').html(testimonials.map((testimoni) => {
            return (
                `
                    <div class="testimoni-container">
                        <div class="image">
                            <img src="image/home/${testimoni.picture}" alt="">
                        </div>
                        <div class="content">
                            <div class="title">
                                ${testimoni.job}
                            </div>
                            <div class="name">
                                ${testimoni.fullname}
                            </div>
                            <div class="text">
                                ${testimoni.testimoni}
                            </div>
                        </div>
                    </div>
                `
            )
        }))

        // testimoni slider
        $('.testimoni-slick').slick({
            dots: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            touchMove: true,
            centerMode: true,
        })
    } catch (error) {
        console.log(error)
    }
})