$(".list-card-button").on('mouseup', function () {
    var check_image = $(this).find("button");
    if (check_image.css("background-image").includes("play")) {

        $(this).removeClass("list-card-button").addClass("list-active")
        $(this).siblings().addClass('list-card-button').removeClass("list-active")
        $(this).siblings(".complete").removeClass("list-active-complete")
    }
    if (check_image.css("background-image").includes("pause")) {
        $(this).addClass("list-card-button").removeClass("list-active")
    }
    if (check_image.css("background-image").includes("complete")) {
        $(this).addClass("list-active-complete").removeClass("list-card-button")
        $(this).siblings().addClass('list-card-button')

    }
})