$(document).ready(function () {
    // handle training
    handleTraining()
})

async function handleTraining() {
    try {
        const trainingResponse = await $.ajax({
            url: '/api/course/filter/training',
            method: 'GET',
            dataType: 'json'
        })

        $('#training .training-wrapper').html(
            trainingResponse.map(training => {
            return `
                <div class="col-md-4">
                    <div class="card-training">
                        <div class="thumbnail">
                            <img src="${training.thumbnail}" alt="thumbnail">
                        </div>
                        <div class="title">
                            <h2 class="text-truncate">${training.title}</h2>
                        </div>
                        <div class="body">
                            <p class="mb-2">
                                ${textTruncate(training.description, 130)}
                            </p>
                            <div class="info d-flex align-items-center gap-2">
                                <i class="fa-solid fa-house"></i>   
                                <p class="m-0">In House Traning</p>
                            </div>
                        </div>
                        <div class="price my-1 mb-2">
                            <p class="m-0">${getRupiah(training.new_price)}</p>
                        </div>
                        <div class="btn-wrapper">
                            <a href="${`/training/${training.course_id}`}">
                                <button class="app-btn btn-full">Lihat Detail</button>
                            </a>
                        </div>
                    </div>
                </div>
            `})
        )
    } catch (error) {
        // console.log(error)
    }
}