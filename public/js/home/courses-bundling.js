$(document).ready(function () {
    handleBundling()
})

async function handleBundling () {
    try {
        const categoryBundlingResponse = await $.ajax({
            url: '/api/category-bundling',
            method: 'GET',
            dataType: 'json'
        })

        const response = await $.ajax({
            url: '/api/bundling',
            method: 'GET',
            dataType: 'json'
        })

        $('.courses-bundling-loading').hide()

        let rekomendasi = response.bundling.slice(0, 3)

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
                    <div class="col-md-4">
                        <div class="my-card bundle">
                            <div class="content">
                                <div class="badges">
                                    <div class="item">Bundling</div>
                                </div>
                                <h2>${item.title}</h2>
                                <h3>What will you get?</h3>
                                <ul>
                                    ${item.course.map((course) => {
                                        return `<li><div class='text-truncate'>${course.title}</div></li>`
                                    }).join('')}
                                </ul>
    
                                Only
                                <div class="harga">
                                    ${getRupiah(item.new_price)}
                                    <del>${getRupiah(item.old_price)}</del>
                                </div>
                            </div>
                            <a href="/courses/bundling/${item.bundling_id}">
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
                result = response.bundling
            } else {
                result = response.bundling.filter(item => item.category_bundling_id === tag.toString())
            }

            if (result.length === 0) {
                $('#courses .courses-bundlings .courses-bundling-list').html(`
                    <div class="col-md-12 text-center">Data bundling tidak ada</div>
                `)
                return
            }

            $('#courses .courses-bundlings .courses-bundling-list').html(result.map((item) => {
                return `
                    <div class="pe-3 ps-0 py-4">
                        <div class="my-card bundle">
                            <div class="content">
                                <div class="badges">
                                    <div class="item">Bundling</div>
                                </div>
                                <h2>${item.title}</h2>
                                <h3>What will you get?</h3>
                                <ul>
                                    ${item.course.map((course) => {
                                        return `<li><div class='text-truncate'>${course.title}</div></li>`
                                    }).join('')}
                                </ul>

                                Only
                                <div class="harga">
                                    ${getRupiah(item.new_price)}
                                    <del>${getRupiah(item.old_price)}</del>
                                </div>
                            </div>
                            <a href="/courses/bundling/${item.bundling_id}">
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
                adaptiveHeight: true
            })
        }
    } catch (error) {
        console.log(error)
    }
}