$(document).ready(async function () {
    localStorage.setItem('current-tag-engineering', '0')
    localStorage.setItem('current-category-engineering', '0')
    localStorage.setItem('current-tag-it', '0')
    localStorage.setItem('current-category-it', '0')

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

        $('#courses-loading').hide()

        $('#courses #tab-courses-1 .tags').html(
            `<a href="" class="item" data-tag_id="0">All</a>` + 
            tagsResponse[0].tag.map(tag => {
            return `<a href="" class="item" data-tag_id="${tag.tag_id}">${tag.name}</a>`
        }).reverse().join(''))

        $('#courses #tab-courses-2 .tags').html(
            `<a href="" class="item" data-tag_id="0">All</a>` + 
            tagsResponse[1]?.tag.map(tag => {
            return `<a href="" class="item" data-tag_id="${tag.tag_id}">${tag.name}</a>`
        }).reverse().join(''))

        $('#courses .sub-tags').html(
            `<a href="" class="item" data-category_id="0">All</a>` + 
            categoryResponse.map(category => {
            return `<a href="" class="item" data-category_id="${category.category_id}">${category.name}</a>`
        }).reverse().join(''))

        generateListCourse(courseResponse, $('#courses-engineering'), '1', '0', '0')
        // generateListCourse(courseResponse, $('#courses-it'), '2', '0', '0')

        $('#courses  #tab-courses-1 .tags .item').on('click', function (e) {
            e.preventDefault()
            $(`#courses #tab-courses-1 .tags .item`).removeClass('active')
    
            let currentTag = $(this).data('tag_id').toString()
            localStorage.setItem('current-tag-engineering', currentTag)
            generateListCourse(courseResponse, $('#courses-engineering'), '1', localStorage.getItem('current-tag-engineering'), localStorage.getItem('current-category-engineering'))
        })

        $(`#courses #tab-courses-1 .sub-tags .item`).on('click', function(e) {
            e.preventDefault()
            $('#courses #tab-courses-1 .sub-tags .item').removeClass('active')

            let currentCategory = $(this).data('category_id').toString()
            
            localStorage.setItem('current-category-engineering', currentCategory)
            generateListCourse(courseResponse, $('#courses-engineering'), '1', localStorage.getItem('current-tag-engineering'), localStorage.getItem('current-category-engineering'))
        })

        $('#courses  #tab-courses-2 .tags .item').on('click', function (e) {
            e.preventDefault()
            $(`#courses #tab-courses-2 .tags .item`).removeClass('active')

            let currentTag = $(this).data('tag_id').toString()
            localStorage.setItem('current-tag-it', currentTag)
            generateListCourse(courseResponse, $('#courses-it'), '2', localStorage.getItem('current-tag-it'), localStorage.getItem('current-category-it'))
        })

        $(`#courses #tab-courses-2 .sub-tags .item`).on('click', function(e) {
            e.preventDefault()
            $('#courses #tab-courses-2 .sub-tags .item').removeClass('active')

            let currentCategory = $(this).data('category_id').toString()
            
            localStorage.setItem('current-category-it', currentCategory)
            generateListCourse(courseResponse, $('#courses-it'), '2', localStorage.getItem('current-tag-it'), localStorage.getItem('current-category-it'))
        })

        async function generateListCourse(courses, element, type, tag, category) {
            let currentTag = $(`#courses #tab-courses-${type} .tags .item[data-tag_id="${tag}"]`).html()
            $(`#courses #tab-courses-${type} .current-tag`).html(currentTag)
            $(`#courses #tab-courses-${type} .tags .item[data-tag_id="${tag}"]`).addClass('active')
            $(`#courses #tab-courses-${type} .sub-tags .item[data-category_id=${category}]`).addClass('active')
    
            let coursesByType = courses.filter(course => course.type[0].type_id === type)
            let coursesBytag = coursesByType.filter(course => course.tag.map(tag => tag.tag_id).includes(tag))
            let coursesByCategory = coursesBytag.filter(course => course.category[0].category_id === category)
            
            let result = []
            if (tag === '0' && category === '0') {
                result = coursesByType
            } else if (tag === '0' && category !== '0') {
                result = coursesByType.filter(course => course.category[0].category_id === category)
            } else if (tag !== '0' && category === '0') {
                result = coursesBytag
            } else {
                result = coursesByCategory
            }

            result = result.map((course) => {
                return {
                    ...course,
                    isBought: false
                }
            })

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
                    console.log(error)
                }

                result = result.map((course, i) => {
                    return {
                        ...course,
                        isBought: userCourses.map(userCourse => userCourse.course_id).includes(course.course_id)
                    }
                })
            }
    
            element.html(result.map(course => {
                return `
                    <div class="col-4 pb-4">
                        <div class="card-course">
                            <div class="image">
                                <a href="/course/${course.course_id}">
                                    <img src="image/home/img-course.jpg" alt="img">
                                </a>
    
                                <div class="card-course-tags">
                                    ${course.tag.map(tag => {
                                        return `<div class="item">${tag.name}</div>`
                                    }).join('')}
                                </div>
                            </div>
                            <div class="body">
                                <a href="/course/${course.course_id}">
                                    <h2 class="text-truncate">${course.title}</h2>
                                    <p>
                                        ${textTruncate(course.description, 120)}
                                    </p>
                                </a>
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
                                            <a href="${`/checkout/${course.course_id}`}">
                                                <button class="my-btn btn-full">Beli</button>
                                            </a>
                                            <button value=${course.course_id} class="button-secondary add-cart"><i class="fa-solid fa-cart-shopping"></i></button>
                                        `
                                    } else {
                                        return `
                                            <a href="${`/course/${course.course_id}`}">
                                                <button class="my-btn btn-full">Lihat Course</button>
                                            </a>
                                        `
                                    }
                                })()}
                            </div>
                        </div>
                    </div>
                `
            }))

            handleAddCart()
        }

        function handleAddCart() {
            return $('.add-cart').on('click', async function() {
                const course_id = $(this).val()

                if (!Cookies.get("access_token")) {
                    return new swal({
                        title: 'Gagal',
                        text: 'Anda belum login',
                        icon: 'error',
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
                } catch (error) {
                    console.log(error)
                }
            })
        }
    } catch (error) {
        console.log(error)
    }
})