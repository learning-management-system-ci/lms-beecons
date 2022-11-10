$(document).ready(async function () {
    try {
        const categoryBundlingResponse = await $.ajax({
            url: '/api/category-bundling',
            method: 'GET',
            dataType: 'json'
        })

        const response = await $.ajax({
            url: '/api/course-bundling',
            method: 'GET',
            dataType: 'json'
        })

        $('.courses-bundling-loading').hide()

        let rekomendasi = response.slice(0, 3)

        $('#courses .courses-bundlings .courses-bundling-list').slick({
            dots: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            touchMove: true,
            centerMode: true,
        })

        $('.courses-bundlings .tags').html(
            `<a href="" class="item" data-category_bundling_id="0">All</a>` + 
            categoryBundlingResponse.map(tag => {
            return `<a href="" class="item" data-category_bundling_id="${tag.category_bundling_id}">${tag.name}</a>`
        }).reverse().join(''))

        $('#courses .courses-bundling .courses-bundling-rekomendasi').html(generateBundles(rekomendasi))

        setBundles(0)

        $('.courses-bundlings .tags .item').on('click', function(e) {
            e.preventDefault()
            const categoryBundlingId = $(this).data('category_bundling_id')
            
            setBundles(categoryBundlingId)
        })

        function generateBundles(bundles) {
            return bundles.map((item) => {
                return `
                    <div class="col-md-3 px-0">
                        <div class="my-card bundle">
                            <div class="content">
                                <div class="badges">
                                    <div class="item">Bundling</div>
                                </div>
                                <h2>${item.bundling[0].title}</h2>
                                <h3>What will you get?</h3>
                                <ul>
                                    ${item.course.map((course) => {
                                        return `<li>${course.title}</li>`
                                    })}
                                </ul>
    
                                Only
                                <div class="harga">
                                    ${getRupiah(item.bundling[0].new_price)}
                                    <del>${getRupiah(item.bundling[0].old_price)}</del>
                                </div>
                            </div>
                            <a href="${`courses/bundling/`}">
                                <button class="my-btn btn-full">Detail</button>
                            </a>
                            <div class="label">
                                HEMAT
                            </div>
                        </div>
                    </div>
                `
            })
        }

        function setBundles(tag = 0) {
            $('#courses .courses-bundlings .courses-bundling-list').slick('unslick')
            $(`.courses-bundlings .tags .item[data-category_bundling_id="${tag}"]`).addClass('active').siblings().removeClass('active')
            
            let result = []

            if (tag === 0) {
                result = response
            } else {
                result = response.filter(item => item.bundling[0].category_bundling_id === tag.toString())
            }

            $('#courses .courses-bundlings .courses-bundling-list').html(result.map((item) => {
                return `
                    <div class="pe-3 ps-0 py-4">
                        <div class="my-card bundle">
                            <div class="content">
                                <div class="badges">
                                    <div class="item">Bundling</div>
                                </div>
                                <h2>${item.bundling[0].title}</h2>
                                <h3>What will you get?</h3>
                                <ul>
                                    ${item.course.map((course) => {
                                        return `<li>${course.title}</li>`
                                    })}
                                </ul>

                                Only
                                <div class="harga">
                                    ${getRupiah(item.bundling[0].new_price)}
                                    <del>${getRupiah(item.bundling[0].old_price)}</del>
                                </div>
                            </div>
                            <a href="${`courses/bundling/`}">
                                <button class="my-btn btn-full">Detail</button>
                            </a>
                            <div class="label">
                                HEMAT
                            </div>
                        </div>
                    </div>
                `
            }))

            $('#courses .courses-bundlings .courses-bundling-list').slick({
                dots: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                touchMove: true,
                centerMode: true,
            })
        }
    } catch (error) {
        console.log(error)
    }
})