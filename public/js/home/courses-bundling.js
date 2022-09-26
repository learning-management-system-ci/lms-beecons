$(document).ready(async function () {
    const response = await $.ajax({
        url: '/api/bundling',
        method: 'GET',
        dataType: 'json'
    })

    let rekomendasi = response.bundling.slice(0, 3)

    $('#courses .courses-bundling .courses-bundling-rekomendasi').html(rekomendasi.map((item) => {
        return `
            <div class="col-md-3 px-0">
                <div class="my-card bundle">
                    <div class="content">
                        <div class="badges">
                            <div class="item" style="background-color: #FFCB42;">Intermediate</div>
                            <div class="item" style="background-color: #002B5B; color: white;">Advanced</div>
                        </div>
                        <h2>${item.title}</h2>
                        <h3>What will you get?</h3>
                        <ul>
                            <li>Fundamental ReactJS</li>
                            <li>Intermediate ReactJs and NodeJS</li>
                            <li>Advanced Frontend Developer</li>
                        </ul>

                        Only
                        <div class="harga">
                            ${getRupiah(item.price)}
                            <del>Rp 4.999.000</del>
                        </div>
                    </div>
                    <a href="">
                        <button class="my-btn btn-full">Detail</button>
                    </a>
                    <div class="label">
                        HEMAT
                    </div>
                </div>
            </div>
        `
    }))

    setBundles()

    function setBundles(tag = 0) {
        $('#courses .courses-bundlings .courses-bundling-list').html(response.bundling.map((item) => {
            return `
                <div class="col-md-3 pe-4 pb-4 ps-0">
                    <div class="my-card bundle">
                        <div class="content">
                            <div class="badges">
                                <div class="item" style="background-color: #FFCB42;">Intermediate</div>
                                <div class="item" style="background-color: #002B5B; color: white;">Advanced</div>
                            </div>
                            <h2>${item.title}</h2>
                            <h3>What will you get?</h3>
                            <ul>
                                <li>Fundamental ReactJS</li>
                                <li>Intermediate ReactJs and NodeJS</li>
                                <li>Advanced Frontend Developer</li>
                            </ul>
    
                            Only
                            <div class="harga">
                                ${getRupiah(item.price)}
                                <del>Rp 4.999.000</del>
                            </div>
                        </div>
                        <a href="">
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
})