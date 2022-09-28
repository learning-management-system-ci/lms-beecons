$(document).ready(async function () {
    try {
        const response = await $.ajax({
            url: '/api/course-bundling',
            method: 'GET',
            dataType: 'json'
        })

        let rekomendasi = response.slice(0, 3)

        $('#courses .courses-bundling .courses-bundling-rekomendasi').html(generateBundles(rekomendasi))

        setBundles()

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
                                    ${getRupiah(item.bundling[0].price)}
                                    <del>Rp 4.999.000</del>
                                </div>
                            </div>
                            <a href="${`courses/bundling/${item.course_bundling_id}`}">
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
            $('#courses .courses-bundlings .courses-bundling-list').html(response.map((item) => {
                return `
                    <div class="col-md-3 pe-4 pb-4 ps-0">
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
                                    ${getRupiah(item.bundling[0].price)}
                                    <del>Rp 4.999.000</del>
                                </div>
                            </div>
                            <a href="${`courses/bundling/${item.course_bundling_id}`}">
                                <button class="my-btn btn-full">Detail</button>
                            </a>
                            <div class="label">
                                HEMAT
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