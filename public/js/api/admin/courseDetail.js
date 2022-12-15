

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

const startCreateVideo = () => {
  const create_video_page = $("#create-video")
  const video_page = $("#video")

  video_page.removeClass("show active").addClass('d-none')
  create_video_page.removeClass('d-none').addClass("show")
}

const stopCreateVideo = () => {
  const create_video_page = $("#create-video")
  const video_page = $("#video")

  create_video_page.removeClass("show").addClass('d-none')
  video_page.removeClass('d-none').addClass("show active")
}

const previewImage = () => {
  frame.src = URL.createObjectURL(event.target.files[0]);
}

$(document).ready(() => {
  // check the cookies if the user is logged in
  if (!Cookies.get('access_token')) {
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

  const getCourseCategoryListData = async () => {
    let option = {
      type: "GET",
      url: document.location.origin + `/api/category`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (categories) {
        data = categories
      }
    }

    let data
    await $.ajax(option)
    return data
  }

  const getCourseTypeListData = async () => {
    const option = {
      type: "GET",
      url: document.location.origin + `/api/type`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (types) {
        data = types
      }
    }
    let data
    await $.ajax(option)
    return data
  }

  const submitCourseDetailSetting = async (course_id) => {
    const data = {
      title: $("#title-input").val(),
      description: $("#description-input").val(),
      category_id: parseInt($("#category-input-wraper").val()),
      type_id: parseInt($("#type-input-wraper").val()),
      tags: $("#tags-input").val(),
      key_takeaways: $("#key-takeaways-input").val(),
      suitable_for: $("#suitable-for-input").val(),
      old_price: parseInt($("#price-input").val()),
      new_price: parseInt($("#after-discount-price-input").val()),
      thumbnail: $("#thumbnail-input")[0].files[0]
    }
    const formData = new FormData()
    Object.keys(data).forEach((key) => {
      formData.append(key, data[key])
    })
    console.log(data)

    let option = {
      type: "POST",
      url: document.location.origin + `/api/course/update/${course_id}`,
      processData: false,
      contentType: false,
      data: formData,
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: async function (course) {
        alert("upload success")
        console.log(course)
        let course_data = await getCourseDetailData(course_id)
        populateCourseDetailGeneral(course_data)
        stopSetting()

      },
    }

    await $.ajax(option)
    // console.log(data)
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
              <span class="text-xs font-weight-bold mb-0 wrap w-20">${textTruncate(feedback, 110)}</span>
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

  const populateCourseDetailVideo = (data, courseID) => {
    const content = {
      video: $('#course-video'),
      list_order_submit: $('#submit-btn-course-list-video'),
      submit_new_video: $('#add-video')
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
      <li class="list-group-item d-flex justify-content-between align-items-start list-video" data-id-video="${id}">
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

    // on click list order submit 
    content.list_order_submit.on('click', () => {
      console.log("clicked")
      let list = []
      $('.list-video').each((index, element) => {
        // append to list
        list.push({
          video_id: $(element).data('id-video'),
          order: index
        })
      })
      console.log(list)
    })

    content.submit_new_video.on('submit', (e) => {
      e.preventDefault()
      let form = new FormData($('#add-video')[0])
      form.append('video_category_id', courseID)
      form.append('order', data.length + 1)

      $.ajax({
        type: "POST",
        url: `/api/course/video/create`,
        data: form,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        beforeSend: function () {
          Swal.fire({
            width: '300px',
            title: "<div class='status-loading'> " +
              '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
              '<p>Sedang Mengirim...(<span id="add-video-uploading"></span>)</p> ' +
              "</div>",
            padding: '0px 0px 40px 6px',
            showConfirmButton: false,
            showClass: {
              popup: 'animate__animated animate__fadeIn animate__fast'
            },
          })
        },
        xhr: function () {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              $('#add-video-uploading').html((Math.round(percentComplete * 100)) + '%');
            }
          }, false);
          return xhr;
        },
        success: function () {
          return Swal.fire({
            width: '300px',
            title: "<div class='status-loading'> " +
              '<h5>Success</h5> ' +
              "</div>",
            showConfirmButton: true,
            showClass: {
              popup: 'animate__animated animate__fadeIn animate__fast'
            },
          }).then(function () {
            window.location.reload()
          });
        },
      })
    })


  }

  const populateCourseDetailSetting = data => {
    const url = window.location.href
    const course_id = url.substring(url.lastIndexOf('/') + 1)

    const wraper = {
      type: $('#type-input-wraper'),
      category: $('#category-input-wraper'),
    }
    const content = {
      title: $('.title-content-setting'),
      author: $('.author-content-setting'),
      tags: $('.tags-content-setting'),
      description: $('.description-content-setting'),
      key_takeaways: $('.key-takeaways-content-setting'),
      suitable_for: $('.suitable-for-content-setting'),
      price: $('.price-content-setting'),
      after_discount_price: $('.after-discount-price-content-setting'),
      thumbnail: $('.thumbnail-content-setting'),
      submit_btn: $('#submit-btn-course-detail-setting')
    }

    // paralel request promise all
    Promise.all([
      getCourseCategoryListData(),
      getCourseTypeListData()
    ]).then(values => {
      const [categories, types] = values
      categories.forEach(category => {
        isSelected = category.name == data.category ? 'selected' : ''
        wraper.category.append(`<option value="${category.category_id}" ${isSelected}>${category.name}</option>`)
      })

      types.forEach(type => {
        isSelected = type.name == data.type ? 'selected' : ''
        wraper.type.append(`<option value="${type.type_id}" ${isSelected}>${type.name}</option>`)
      })
    })

    content.title.val(data.title)
    content.author.val(data.author)
    content.description.text(data.description)
    content.key_takeaways.text(data.key_takeaways)
    content.suitable_for.text(data.suitable_for)
    content.price.val(data.old_price)
    content.after_discount_price.val(data.new_price)

    content.submit_btn.click(() => {
      submitCourseDetailSetting(course_id)
    })
  }

  const populateCourseDetailPage = async () => {
    let url = window.location.href
    let course_id = url.substring(url.lastIndexOf('/') + 1)

    let course = await getCourseDetailData(course_id);

    let {
      reviews,
      videos,
    } = course

    populateCourseDetailGeneral(course)
    populateCourseDetailReview(reviews)
    populateCourseDetailVideo(videos, course_id)
    populateCourseDetailSetting(course)
  }

  populateCourseDetailPage()
})