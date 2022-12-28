

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
  Sortable.create(bundling_panel, {
    group: {
      name: 'shared',
      pull: 'clone',

    },
    onAdd: function (/**Event*/evt) {
      let el = evt.item
      $(el).find('.right-side-course').append(`
        <i id='del-course-bundling' class="bi bi-x-circle text-danger text-white" ></i>`
      )
    },
    animation: 150
  });

  Sortable.create(course_panel, {
    group: {
      put: false,
      name: 'shared',
      pull: 'clone'
    },
    animation: 150
  });

  $(".bundling-search-course").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".selection-course-list .course-list-choice").each(function () {
      $(this).text().toLowerCase().includes(value) ? $(this).removeClass('hide') : $(this).addClass('hide')
    });
  });

  var mutationObserver = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      $(mutation.target).find("#del-course-bundling").on('click', function () {
        console.log($(this).parent().parent().remove())
      })
    });
  });

  mutationObserver.observe($("#bundling_panel")[0], {
    attributes: true,
    characterData: true,
    childList: true,
    subtree: true,
    attributeOldValue: true,
    characterDataOldValue: true
  });



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

  const getData = async (url) => {
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

  const CourseBundlingTag = (tag_data) => {
    let tag = ''
    for (let index = 0; index < tag_data.length; index++) {
      tag += `<p class="badge badge-sm bg-gradient-warning">${tag_data[index].name}</p>`
    }
    return tag
  }

  const CourseBundlingListDNDComponent = (course, elementID) => {
    $.each(course, function (index, value) {
      $('#' + elementID).
        append(`
        <div data-course-id='${value.course_id}' class="${elementID == 'read-bundling-content' ? '' : 'dnd-course-list'} d-flex justify-content-between course-list-choice p-2 px-3 mb-2 text-white">
          <div class="d-flex flex-column course-container">
            <p class="course-name" style="margin-block-end: 0.75rem !important;">
              ${value.title}
            </p>
            <div class="d-flex gap-1">
              ${CourseBundlingTag(value.tag || value.course_tag)}
            </div>
          </div>
          <div class="right-side-course">
            <b>
              ${value?.category?.name ? value.category.name : value.category_name}
            </b>
            ${elementID == 'bundling_panel' ? "<i id='del-course-bundling' class='bi bi-x-circle text-white'></i>" : ""}
          </div>
        </div>`)
    })
  }

  const populateCourseDetailBundling = async (data) => {
    const content = {
      title: $('.title-content'),
      author: $('.author-content'),
      category: $('.category-content'),
      description: $('.description-content'),
      price: $('.price-content'),
      after_discount_price: $('.after-discount-price-content'),
      thumbnail: $('.thumbnail-content'),

      titleEdit: $('#title-input'),
      descriptionEdit: $('#description-input'),
      priceEdit: $('#price-edit'),
      after_priceEdit: $('#after-price-edit'),

    }

    let userId = checkAuthor.uid
    let category = await getData('category-bundling');
    let user_bundle_course = data.course
    let courseData = await getData('course');
    let course = courseData.filter((x) => x.service == "course")
    if (checkAuthor.role == 'author') {
      course = courseData.filter((x) => x.author_company == checkAuthor.company)
    }
    CourseBundlingListDNDComponent(course, 'course_panel')

    $('#author-input').val(userId)

    let userCatName = category.filter((x) => x.category_bundling_id == data.category_bundling_id)

    console.log(category)
    console.log(data)

    $.each(category.reverse(), function (index, value) {
      $('#cat-bunding-wraper').append(
        `<option ${userCatName[0].category_bundling_id == value.category_bundling_id ? 'selected' : ''} 
        value='${value.category_bundling_id}'>${value.name}</option>`
      )
    })

    user_bundle_course.sort((a, b) => {
      return a.order - b.order
    })

    CourseBundlingListDNDComponent(user_bundle_course, 'read-bundling-content')
    CourseBundlingListDNDComponent(user_bundle_course, 'bundling_panel')


    console.log(data.new_price)

    content.title.text(data.title)
    content.titleEdit.val(data.title)
    content.author.text(data.author_company)
    content.category.text(userCatName[0].name)
    content.description.text(data.description)
    content.descriptionEdit.text(data.description)
    content.price.text(getRupiah(data.old_price))
    content.priceEdit.attr('value', data.old_price)
    content.after_discount_price.text(getRupiah(data.new_price))
    content.after_priceEdit.attr('value', Math.abs(data.new_price))
    if (data.thumbnail) {
      content.thumbnail.attr('src', data.thumbnail)
    }



  }

  const populateCourseDetailReview = data => {

  }




  const populateCourseDetailPage = async () => {
    let url = window.location.href
    let course_id = url.substring(url.lastIndexOf('/') + 1)
    let bundling_data = await getBundlingDetailData(course_id);


    const BundlingCourseOrderConstructor = (id) => {
      let list = {
        bundling_id: id,
      }
      let orderArr = []
      $('#bundling_panel').children().each((index, element) => {
        orderArr.push({
          course_id: $(element).attr('data-course-id'),
          order: index + 1
        })
      })
      list.order = orderArr
      return list
    }

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

      $('#update-bundling-form').on('submit', async function (e) {
        e.preventDefault()

        let bundle_update
        let form_bundle = new FormData($('#update-bundling-form')[0])
        let course_order


        await $.ajax({
          type: "POST",
          data: form_bundle,
          dataType: 'json',
          contentType: false,
          cache: false,
          processData: false,
          url: document.location.origin + "/api/bundling/update/" + id,
          headers: {
            "Authorization": `Bearer ${Cookies.get("access_token")}`,
          },
          beforeSend: function () {
            Swal.fire({
              width: '300px',
              title: "<div class='status-loading'> " +
                '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
                '<p>Mengunggah...(<span id="add-video-uploading"></span>)</p> ' +
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
          success: function (resp) {
            bundle_update = true
          },
        })

        if (bundle_update) {
          course_order = BundlingCourseOrderConstructor(id)
          await $.ajax({
            type: "POST",
            data: JSON.stringify(course_order),
            contentType: 'application/json',
            processData: false,
            url: document.location.origin + "/api/course-bundling/update-order",
            dataType: "json",
            headers: {
              "Authorization": `Bearer ${Cookies.get("access_token")}`,
            },
            beforeSend: function () {
              Swal.fire({
                width: '300px',
                title: "<div> " +
                  '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
                  '<p>Sedang Mengirim...</p> ' +
                  "</div>",
                padding: '0px 0px 40px 6px',
                showConfirmButton: false,
                showClass: {
                  popup: 'animate__animated animate__fadeIn animate__fast'
                },
              })
            },
            success: function (resp) {
              Swal.fire({
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
        }


      })

    }


    populateCourseDetailBundling(bundling_data)
    // populateCourseDetailReview(reviews)
    // populateCourseDetailVideo(videos, course_id, title)
    // populateCourseDetailSetting(course)
    populateCourseEditDelete(course_id)
  }

  populateCourseDetailPage()
})