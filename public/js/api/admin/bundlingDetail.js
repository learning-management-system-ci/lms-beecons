

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

$(document).ready(() => {
  // check the cookies if the user is logged in
  if (!Cookies.get('access_token')) {
    // if not, redirect to login page
    window.location.href = '/login'
  }

  let checkAuthor = jwt_decode(Cookies.get('access_token'))

  const getBundlingDetailData = async (id) => {
    let option = {
      type: "GET",
      url: document.location.origin + `/api/bundling/detail/${id}`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (course) {
        data = course
      },
    }

    let data
    await $.ajax(option)
    return data
  }

  const getCourseData = async (url) => {
    let option = {
      type: "GET",
      url: document.location.origin + `/api/` + url,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (resp) {
        data = resp
      }
    }

    let data
    await $.ajax(option)
    return data
  }

  const populateCourseDetailGeneral = async (data) => {
    const content = {
      title: $('.title-content'),
      author: $('.author-content'),
      category: $('.category-content'),
      description: $('.description-content'),
      price: $('.price-content'),
      after_discount_price: $('.after-discount-price-content'),
      thumbnail: $('.thumbnail-content'),
    }

    let userId = checkAuthor.uid
    let category = await getCourseData('category-bundling');

    $('#author-input').val(userId)

    let userCatName = category.filter((x) => x.category_bundling_id == data.category_bundling_id)
    $.each(category.reverse(), function (index, value) {
      $('#category-input-wraper').append(`<option value='${value.category_id}'>${value.name}</option>`)
    })

    // $.each(courses, function())


    content.title.text(data.title)
    content.author.text(data.author_company)
    content.category.text(userCatName[0].name)
    content.description.text(data.description)
    content.price.text(getRupiah(data.old_price))
    content.after_discount_price.text(getRupiah(data.new_price))
    if (data.thumbnail) {
      content.thumbnail.attr('src', data.thumbnail)
    }
  }

  const populateCourseDetailReview = data => {

  }


  const populateCourseDetailSetting = (data, course) => {
    const url = window.location.href
    const course_id = url.substring(url.lastIndexOf('/') + 1)

    const wraper = {
      type: $('#type-input-wraper'),
      category: $('#category-input-wraper'),
    }
    const content = {
      title: $('.title-content-setting'),
      author: $('.author-content-setting'),
      description: $('.description-content-setting'),
      price: $('.price-content-setting'),
      after_discount_price: $('.after-discount-price-content-setting'),
      thumbnail: $('.thumbnail-content-setting'),
    }

    content.title.val(data.title)
    content.author.val(data.author)
    content.description.text(data.description)
    content.price.val(data.old_price)
    content.after_discount_price.val(data.new_price)
  }

  const populateCourseDetailPage = async () => {
    let url = window.location.href
    let course_id = url.substring(url.lastIndexOf('/') + 1)
    let bundling_data = await getBundlingDetailData(course_id);

    const populateCourseEditDelete = async (id) => {
      $('#delete-bundling').on('click', function () {
        Swal.fire({
          text: 'Yakin mau menghapus bundling ini ?!',
          showCancelButton: true,
        }).then(async function (res) {
          if (res.isConfirmed) {
            let success_delete_bundling
            await $.ajax({
              type: "DELETE",
              url: `/api/course-bundling/deletebybundling/${id}`,
              processData: false,
              headers: {
                "Authorization": `Bearer ${Cookies.get("access_token")}`,
              },
              beforeSend: function () {
                Swal.fire({
                  width: '300px',
                  title: "<div class='status-loading'> " +
                    '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
                    '<p>Mohon Tunggu</p> ' +
                    "</div>",
                  padding: '0px 0px 40px 6px',
                  showConfirmButton: false,
                  showClass: {
                    popup: 'animate__animated animate__fadeIn animate__fast'
                  },
                })
              },
              success: function () {
                success_delete_bundling = true
              },
            })
            if (success_delete_bundling) {
              await $.ajax({
                type: "DELETE",
                url: `/api/bundling/delete/${id}`,
                processData: false,
                headers: {
                  "Authorization": `Bearer ${Cookies.get("access_token")}`,
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
                    return window.location.href = '/admin/bundling'
                  });
                },
              })
            }
          }
        })
      })

      return 0

      $('#update-course-form').on('submit', function (e) {
        e.preventDefault()
        let form = new FormData($('#update-course-form')[0])
        form.append('tag', JSON.stringify(type_tag_choice.getSelected()))

        $.ajax({
          type: "POST",
          url: `/api/course/update/${id}`,
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


    populateCourseDetailGeneral(bundling_data)
    // populateCourseDetailReview(reviews)
    // populateCourseDetailVideo(videos, course_id, title)
    // populateCourseDetailSetting(course)
    populateCourseEditDelete(course_id)
  }

  populateCourseDetailPage()
})