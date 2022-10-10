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
        generateListCourse(courseResponse, $('#courses-it'), '2', '0', '0')

        $('#courses  #tab-courses-1 .tags .item').on('click', function (e) {
            e.preventDefault()
            $(`#courses #tab-courses-1 .tags .item`).removeClass('active')
    
            let currentTag = $(this).data('tag_id').toString()
            localStorage.setItem('current-tag-engineering', currentTag)
            generateListCourse(courseResponse, $('#courses-engineering'), '1', localStorage.getItem('current-tag-engineering'), localStorage.getItem('current-category-engineering'))
            handleAddCart()
        })

        $(`#courses #tab-courses-1 .sub-tags .item`).on('click', function(e) {
            e.preventDefault()
            $('#courses #tab-courses-1 .sub-tags .item').removeClass('active')

            let currentCategory = $(this).data('category_id').toString()
            
            localStorage.setItem('current-category-engineering', currentCategory)
            generateListCourse(courseResponse, $('#courses-engineering'), '1', localStorage.getItem('current-tag-engineering'), localStorage.getItem('current-category-engineering'))
            handleAddCart()
        })

        $('#courses  #tab-courses-2 .tags .item').on('click', function (e) {
            e.preventDefault()
            $(`#courses #tab-courses-2 .tags .item`).removeClass('active')

            let currentTag = $(this).data('tag_id').toString()
            localStorage.setItem('current-tag-it', currentTag)
            generateListCourse(courseResponse, $('#courses-it'), '2', localStorage.getItem('current-tag-it'), localStorage.getItem('current-category-it'))
            handleAddCart()
        })

        $(`#courses #tab-courses-2 .sub-tags .item`).on('click', function(e) {
            e.preventDefault()
            $('#courses #tab-courses-2 .sub-tags .item').removeClass('active')

            let currentCategory = $(this).data('category_id').toString()
            
            localStorage.setItem('current-category-it', currentCategory)
            generateListCourse(courseResponse, $('#courses-it'), '2', localStorage.getItem('current-tag-it'), localStorage.getItem('current-category-it'))
            handleAddCart()
        })

        function generateListCourse(courses, element, type, tag, category) {
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

            handleAddCart()
    
            element.html(result.map(course => {
                return `
                    <div class="col-4 pb-4">
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
                                <a href="/course-detail">
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
                            text: res.message,
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
                    });
                }).catch((err) => {
                    console.log(error)
                })
            })
        }
    } catch (error) {
        console.log(error)
    }
})