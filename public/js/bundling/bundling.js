$(document).ready(function() {
    handleBundlingApi()
})

async function handleBundlingApi() {
    let id = $('#bundling-id').val()

    try {
        let res = await $.ajax({
            url: `/api/course-bundling/detail/${id}`,
            method: "GET",
            dataType: "json"
        })

        let bundling = res[0].bundling[0]
        let courses = res[0].course
        let coursesPrice = courses.reduce((a, b) => a + parseInt(b.new_price), 0)

        $('.detail-bundling-title').text(bundling.title)
        $('.detail-bundling-description').text(bundling.description)
        $('.course-list').html(courses.map(function(course, i) {
            return `
                <li class="list-group-item py-3">
                    <div class="d-flex align-items-center gap-5">
                        <div class="item-number text-center">
                            <p class="m-0">Course</p>
                            <p class="m-0" style="font-size: 20px; font-weight: bold">${++i}</p>
                        </div>
                        <div class="flex-fill">
                            <a href="/course/${course.course_id}">
                                <h6>${course.title}</h6>
                            </a>
                            <p class="m-0">${getRupiah(course.new_price)}</p>
                        </div>
                    </div>
                </li>
            `
        }))
        $('.ringkasan-list').html(courses.map(function(course, i) {
            return `
                <li>
                    <div class="d-flex gap-2">
                        <div class="flex-fill text-truncate">${course.title}</div>
                        <div class="text-end text-nowrap">${getRupiah(course.new_price)}</div>
                    </div>
                </li>
            `
        }))
        $('.order-total').text(getRupiah(coursesPrice.toString()))

    } catch (error) {
        
    }
}