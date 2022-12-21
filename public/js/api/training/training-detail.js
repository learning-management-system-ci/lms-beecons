
$(document).ready(function () {
    let url = window.location.href
    let training_id = url.substring(url.lastIndexOf('/') + 1)
    sessionStorage.setItem('training_id', training_id)
    // handle training
    const trainingDetailData = getTrainingDetailData(training_id)
    trainingDetailData.then((training) => {
        training = training[0]
        $(".title").html(training.title)
        $(".banner").attr("src", training.thumbnail)
        $(".description").html(training.description)
        $(".price").html(getRupiah(training.new_price))
        $(".checkout").click(() => {
            window.location.href = `/checkout?type=training&id=${training_id}`
        })
    })
})

const getTrainingDetailData = async (id) => {
    const option = {
        type: "GET",
        url: document.location.origin + `/api/course/filter/training/detail/${id}`,
        dataType: "json",
    }
    let data
    await $.ajax(option).done((training) => {
        data = training
    })
    return data
}

