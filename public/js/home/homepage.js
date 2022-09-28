$(document).ready(async function () {
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
            <div class="col col-md-4 pe-5 pb-5">
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

    try {
        const courseResponse = await $.ajax({
            url: '/api/course',
            method: 'GET',
            dataType: 'json'
        })
        
        setCourses('0')

        $('#choose-course .tags .item').on('click', function (e) {
            e.preventDefault()
            let typeId = $(this).attr('data-type-id')

            $('#choose-course .tags .item').removeClass('active')
            setCourses(typeId)
        })

        function setCourses(type) {
            let coursesAll = courseResponse.slice(0, 3)
            let coursesEngineering = courseResponse.filter(course => course.type.type_id === '1').slice(0, 3)
            let coursesIt = courseResponse.filter(course => course.type.type_id === '2').slice(0, 3)

            $(`#choose-course .tags .item[data-type-id="${type}"]`).addClass('active')

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