$(document).ready(async function () {
    try {
        const categoryResponse = await $.ajax({
            url: '/api/category',
            method: 'GET',
            dataType: 'json'
        })

        $('#courses .sub-tags').html(categoryResponse.map(category => {
            return `<a href="" class="item">${category.name}</a>`
        }).join(''))
    } catch (error) {
        console.log(error)
    }
})