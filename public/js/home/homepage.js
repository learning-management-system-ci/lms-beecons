$(document).ready(async function () {
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
                            <a href="">
                                <button class="my-btn btn-full">Detail</button>
                            </a>
                        </div>
                    </div>
                `
            }))
        }
    } catch (error) {
        console.log(error)
    }
})