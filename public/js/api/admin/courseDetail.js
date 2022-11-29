

const startSetting = () => {
  const setting_page = $("#setting")
  const general_page = $("#general")

  general_page.removeClass("show active")
  setting_page.removeClass('d-none').addClass("show")
}

const stopSetting = () => {
  const setting_page = $("#setting")
  const general_page = $("#general")

  setting_page.removeClass("show").addClass('d-none')
  general_page.removeClass('d-none').addClass("show active")
}

$(document).ready(() => {
  // check the cookies if the user is logged in
  if(!Cookies.get('access_token')){
    // if not, redirect to login page
    window.location.href = '/login'
  }

  $("#course-video").sortable({
    direction: 'vertical'
  })

  const getCourseDetailData = async (id) => {
    let option = {
      type: "GET",
      url: document.location.origin + `/api/course/detail/${id}`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (course) {
        data = course
        data.tags = data.tag
        delete data.tag
        data.reviews = data.review
        delete data.review
        data.videos = data.video
        delete data.video
      },
    }

    let data
    await $.ajax(option)
    return data
  }

  const populateCourseDetailGeneral = data => {
    const content = {
      title: $('.title-content'),
      author: $('.author-content'),
      type: $('.type-content'),
      category: $('.category-content'),
      tags: $('.tags-content'),
      description: $('.description-content'),
      key_takeaways: $('.key-takeaways-content'),
      suitable_for: $('.suitable-for-content'),
      price: $('.price-content'),
      after_discount_price: $('.after-discount-price-content'),
      thumbnail: $('.thumbnail-content'),
    }

    const list_badge_color = [
      'bg-primary',
      'bg-secondary',
      'bg-success',
      'bg-danger',
      'bg-warning',
      'bg-info',
    ]

    content.title.text(data.title)
    content.author.text(data.author)
    content.type.text(data.type)
    content.category.text(data.category)
    content.description.text(data.description)
    content.key_takeaways.text(data.key_takeaways)
    content.suitable_for.text(data.suitable_for)
    content.price.text(getRupiah(data.old_price))
    content.after_discount_price.text(getRupiah(data.new_price))

    if (data.tags.length > 0) {
      content.tags.empty()
      data.tags.forEach(tag => {
        // get random data from bg color
        let bg = list_badge_color[Math.floor(Math.random() * list_badge_color.length)]
        content.tags.append(`<span class="badge ${bg} mx-1 ">${tag.name}</span>`)
      })
    }

    if (data.thumbnail) {
      content.thumbnail.attr('src', data.thumbnail)
    }
  }

  const populateCourseDetailReview = data => {
    const content = {
      review: $('#course-review-list-content'),
    }

    if (data.length > 0) {
      content.review.empty()
      data.forEach(review => {
        let {
          fullname: username,
          score,
          feedback
        } = review

        let template = `
          <tr>
            <td>
              <h6 class="mb-0 text-sm px-2">${username}</h6>
            </td>
            <td>
              <span class="text-xs font-weight-bold mb-0 wrap w-20">${textTruncate(feedback,110)}</span>
            </td>
            <td>
              <p class="text-xs font-weight-bold mb-0">${score}</p>
            </td>
          </tr>
        `
        content.review.append(template)
      })
    }
  }

  const populateCourseDetailVideo = data => {
    const content = {
      video: $('#course-video'),
    }

    content.video.empty()
    data.sort((a, b) => a.order - b.order)

    data.forEach(video => {
      let {
        video_id: id,
        title,
        duration
      } = video
      
      let template = `
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <div class="fw-bold">${title}</div>
          ${duration}
        </div>
        <div class="d-flex align-self-center">
          <a class="text-sm" href="/admin/video/${id}" >Details</a>
        </div>
      </li>`

      content.video.append(template)
    })
  }

  const populateCourseDetailData = async () => {
    let url = window.location.href
    let course_id = url.substring(url.lastIndexOf('/') + 1)

    let course = await getCourseDetailData(course_id);

    let {
      reviews,
      videos,
    } = course

    console.log(videos)

    populateCourseDetailGeneral(course)
    populateCourseDetailReview(reviews)
    populateCourseDetailVideo(videos)

  }

  populateCourseDetailData()
})