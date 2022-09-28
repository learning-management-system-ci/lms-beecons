$(document).ready(async function () {
    try {
        localStorage.setItem('current-tag-engineering', '0')
        localStorage.setItem('current-category-engineering', '0')
        localStorage.setItem('current-tag-it', '0')
        localStorage.setItem('current-category-it', '0')

        const categoryResponse = await $.ajax({
            url: '/api/category',
            method: 'GET',
            dataType: 'json'
        })

        $('#courses .sub-tags').html(
            `<a href="" class="item" data-category_id="0">All</a>` + 
            categoryResponse.map(category => {
            return `<a href="" class="item" data-category_id="${category.category_id}">${category.name}</a>`
        }).reverse().join(''))

        const tagsResponse = await $.ajax({
            url: '/api/type_tag',
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
            tagsResponse[1].tag.map(tag => {
            return `<a href="" class="item" data-tag_id="${tag.tag_id}">${tag.name}</a>`
        }).reverse().join(''))

        const courseResponse = await $.ajax({
            url: '/api/course',
            method: 'GET',
            dataType: 'json'
        })

        setListCourse('1', '0', '0')
        setListCourse('2', '0', '0')
        
        $('#courses  #tab-courses-1 .tags .item').on('click', function (e) {
            e.preventDefault()
            $(`#courses #tab-courses-1 .tags .item`).removeClass('active')

            let currentTag = $(this).data('tag_id').toString()
            localStorage.setItem('current-tag-engineering', currentTag)
            setListCourse('1', localStorage.getItem('current-tag-engineering'), localStorage.getItem('current-category-engineering'))
        })

        $(`#courses #tab-courses-1 .sub-tags .item`).on('click', function(e) {
            e.preventDefault()
            $('#courses #tab-courses-1 .sub-tags .item').removeClass('active')

            let currentCategory = $(this).data('category_id').toString()
            
            localStorage.setItem('current-category-engineering', currentCategory)
            setListCourse('1', localStorage.getItem('current-tag-engineering'), localStorage.getItem('current-category-engineering'))
        })

        $('#courses  #tab-courses-2 .tags .item').on('click', function (e) {
            e.preventDefault()
            $(`#courses #tab-courses-2 .tags .item`).removeClass('active')

            let currentTag = $(this).data('tag_id').toString()
            localStorage.setItem('current-tag-it', currentTag)
            setListCourse('2', localStorage.getItem('current-tag-it'), localStorage.getItem('current-category-it'))
        })

        $(`#courses #tab-courses-2 .sub-tags .item`).on('click', function(e) {
            e.preventDefault()
            $('#courses #tab-courses-2 .sub-tags .item').removeClass('active')

            let currentCategory = $(this).data('category_id').toString()
            
            localStorage.setItem('current-category-it', currentCategory)
            setListCourse('2', localStorage.getItem('current-tag-it'), localStorage.getItem('current-category-it'))
        })

        function setListCourse(type, tag, category) {
            let selectedType = type
            let selectedTag = tag
            let selectedCategory = category

            $(`#courses #tab-courses-${type} .tags .item[data-tag_id="${selectedTag}"]`).addClass('active')
            $(`#courses #tab-courses-${type} .sub-tags .item[data-category_id=${selectedCategory}]`).addClass('active')

            let coursesByType = courseResponse.filter(course => course.type.type_id === selectedType)
            let coursesBytag = coursesByType.filter(course => course.tag.map(tag => tag.tag_id).includes(selectedTag))
            let coursesByCategory = coursesBytag.filter(course => course.category.category_id === selectedCategory)

            let courseDocument = selectedType === '1'? '#courses-engineering' : '#courses-it'
            let result
            if (tag === '0' && category === '0') {
                result = coursesByType
            } else if (tag === '0' && category !== '0') {
                result = coursesByType.filter(course => course.category.category_id === selectedCategory)
            } else if (tag !== '0' && category === '0') {
                result = coursesBytag
            } else {
                result = coursesByCategory
            }

            $(courseDocument).html(result.map(course => {
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
                                <h2>${course.title}</h2>
                                <p>
                                    ${course.description}
                                </p>
                                <p class="harga">
                                    <del>Rp 4.999.000</del>
                                    ${getRupiah(course.price)}
                                </p>
                            </div>
                            <div class="card-course-button">
                                <a href="">
                                    <button class="my-btn btn-full">Beli</button>
                                </a>
                                <a href="">
                                    <button class="button-secondary"><i class="fa-solid fa-cart-shopping"></i></button>
                                </a>
                            </div>
                        </div>
                    </div>
                `
            }))
        }
    } catch (error) {
        console.log(error)
    }
})