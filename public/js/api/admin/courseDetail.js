

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

  let checkAuthor = jwt_decode(Cookies.get('access_token'))
  let type_tag_choice = new SlimSelect({
    select: '#type-tag-input',
    settings: {
      allowDeselect: true
    }
  })


  $("#course-video").sortable({
    handle: '.bi-grip-horizontal',
    animation: 2000,
    ghostClass: '.bg-ghost-sortable '
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
        console.log(data)
        data.tags = data.tag
        delete data.tag
        data.reviews = data.review
        delete data.review

        if (data.video) {
          data.videos = data.video
          delete data.video
        }
        else {

          data.videos = data.video_category[0].video
        }




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

  const getCourseMemberData = async (id) => {
    let option = {
      type: "GET",
      url: document.location.origin + `/api/course/${id}/member`,
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

  const createVideoCategory = async (title, id) => {
    console.log(id)
    let getVideoCatID
    let formVidCat = `course_id=${id}&title=`
    try {
      await $.ajax({
        type: "POST",
        url: `/api/video-category/create`,
        data: formVidCat,
        headers: {
          "Authorization": `Bearer ${Cookies.get("access_token")}`,
        },
        beforeSend: function () {
          Swal.fire({
            width: '300px',
            title: "<div class='status-loading'> " +
              '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
              '<p>Inisialisasi Chapter Group</p> ' +
              "</div>",
            padding: '0px 0px 40px 6px',
            showConfirmButton: false,
            showClass: {
              popup: 'animate__animated animate__fadeIn animate__fast'
            },
          })
        },
        success: function (e) {
          console.log(e)
        },
      })

      await $.ajax({
        type: "GET",
        url: `/api/video-category/`,
        success: function (resp) {
          getVideoCatID = resp[0].video_category_id
        },
      })

    } catch (error) {

    }




    return getVideoCatID;
  }

  const populateCourseDetailGeneral = async data => {
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
      type_tag: $('#type-tag-input'),
    }

    const list_badge_color = [
      'bg-primary',
      'bg-secondary',
      'bg-success',
      'bg-danger',
      'bg-warning',
      'bg-info',
    ]

    let userId = checkAuthor.uid
    let category = await getCourseData('category');
    let type = await getCourseData('type')
    let type_tag = await getCourseData('type_tag')

    $('#author-input').val(userId)

    $.each(category.reverse(), function (index, value) {
      $('#category-input-wraper').append(`<option value='${value.category_id}'>${value.name}</option>`)
    })
    $.each(type.reverse(), function (index, value) {
      $('#type-input-wraper').append(`<option value='${value.type_id}'>${value.name}</option>`)
    })


    content.title.text(data.title)
    content.author.text(data.author_fullname)
    content.type.text(data.type)
    content.category.text(data.category)
    content.description.text(data.description)
    content.key_takeaways.text(data.key_takeaways)
    content.suitable_for.text(data.suitable_for)
    content.price.text(getRupiah(data.old_price))
    content.after_discount_price.text(getRupiah(data.new_price))

    let type_tag_filtered = type_tag.filter((x) => x.name == data.type)
    let addDataTypeTag = []
    $.each(type_tag_filtered[0].tag, function (index, val) {
      const container = {
        text: val.name,
        value: val.tag_id
      }
      addDataTypeTag.push(container)

    })
    if (addDataTypeTag.length > 0) {
      type_tag_choice.setData(addDataTypeTag)
    }


    if (data.tags) {
      content.tags.empty()
      let arrData = []
      data.tags.forEach(tag => {
        // get random data from bg color
        let bg = list_badge_color[Math.floor(Math.random() * list_badge_color.length)]
        content.tags.append(`<span class="badge ${bg} mx-1 ">${tag.name}</span>`)
        arrData.push(tag.tag_id)
      })

      if (arrData.length > 0) {
        type_tag_choice.setSelected(arrData)
      }

    }

    if (data.thumbnail) {
      content.thumbnail.attr('src', data.thumbnail)
    }
  }

  const populateCourseDetailMember = data => {
    console.log(data)
    const content = {
      member: $('#course-member-list-content'),
    }

    content.member.empty()
    if (data.length > 0) {
      data.forEach(member => {
        let {
          username,
          progress,
          transaction_at
        } = member
        let bg_progress

        if (progress == 0) {
          bg_progress = 'bg-danger'
        } else if (progress == 100) {
          bg_progress = 'bg-success'
        } else {
          bg_progress = 'bg-warning'
        }

        let template = `
          <tr>
            <td>
              <h6 class="mb-0 text-sm px-2">${username}</h6>
            </td>
            <td>
              <span class="text-xs font-weight-bold mb-0 wrap w-20">${transaction_at}</span>
            </td>
            <td>
              <span class="badge ${bg_progress} mx-1 ">${progress} %</span>
            </td>
          </tr>
        `
        content.member.append(template)
      })
    }
  }

  const populateCourseDetailVideo = (data, courseID, title) => {
    const content = {
      video: $('#course-video'),
      list_order_submit: $('#submit-btn-course-list-video'),
      submit_new_video: $('#add-video')
    }

    content.video.empty()

    content.video.append('<p class="no-quiz text-center">Belum ada chapter</p>')

    if (data) {
      content.video.text('')
      data.sort((a, b) => a.order - b.order)

      data.forEach(video => {
        let {
          video_id: id,
          title,
          duration
        } = video

        let template = `
      <li class="list-group-item d-flex justify-content-between align-items-start list-video" id="video-${id}" data-id-video="${id}">
        <div class="d-flex me-auto" style='gap: 12px;'>
          <div>
            <i class="bi bi-grip-horizontal dragNdrop"></i>
          </div>
          <div class="fw-bold">
              <div class="fw-bold">${title}
                <div>${duration}</div>
            </div>
          </div>
        </div>
        <div class="d-flex align-self-center" style="gap: 5px">
          <a class="text-underline text-sm d-flex align-items-center" href="/admin/video/${id}" >Details</a>
          <a class="text-underline text-sm text-info d-flex align-items-center" href="/admin/quiz/${id}" >Quiz List</a>
          <div class='ms-3'>
            <i class="bi bi-x-circle text-danger delete-video pointer" style="font-size: 1.5em" data-delete="${id}"></i>
          </div>
        </div>
      </li>`
        content.video.append(template)
      })
    }
    else {

    }



    const deleteVideo = () => {
      return $('.delete-video').on('mousedown', function (e) {
        let parent_quiz = $(this).attr('data-delete');

        Swal.fire({
          text: 'Yakin mau menghapus ?!',
          showCancelButton: true,
        }).then(function (text) {

          if (text.isConfirmed) {
            $.ajax({
              type: "DELETE",
              url: `/api/course/video/delete/${parent_quiz}`,
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
                  $(`#${parent_quiz}`).remove();
                  if ($('.parent').children().length == 0) {
                    content.video.text('<p class="no-quiz text-center">Belum ada chapter</p>')
                  }
                });
              },
            })
          }
        })
      })
    }

    deleteVideo()


    // on click list order submit 
    content.list_order_submit.on('click', () => {
      let list = []
      $('.list-video').each((index, element) => {
        // append to list
        list.push({
          video_id: $(element).data('id-video'),
          order: index + 1
        })
      })

      if (list.length == 0) {
        return Swal.fire({
          icon: 'error',
          text: 'Tidak bisa mengirim data kosong',
        })
      }

      $.ajax({
        type: "POST",
        url: `/api/course/video/order`,
        data: JSON.stringify(list),
        contentType: 'application/json',
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




    content.submit_new_video.on('submit', async (e) => {
      e.preventDefault()
      let form = new FormData($('#add-video')[0])
      let videoCat
      if (data) {
        form.append('order', data.length + 1)
        form.append('video_category_id', data[0].video_category_id)
      }
      else {
        form.append('order', 1)
        try {
          videoCat = await createVideoCategory(title, courseID)
          form.append('video_category_id', videoCat)
        } catch (error) {
          //console.log(error)
          return Swal.fire({
            icon: 'error',
            text: 'Terjadi error',
          })
        }
      }

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

    content.title.val(data.title)
    content.author.val(data.author)
    content.description.text(data.description)
    content.key_takeaways.text(data.key_takeaways)
    content.suitable_for.text(data.suitable_for)
    content.price.val(data.old_price)
    content.after_discount_price.val(data.new_price)
  }

  const populateCourseDetailPage = async () => {
    let url = window.location.href
    let course_id = url.substring(url.lastIndexOf('/') + 1)

    let course = await getCourseDetailData(course_id);
    let members = await getCourseMemberData(course_id);

    let {
      videos,
      title
    } = course

    const populateCourseEditDelete = async (id) => {
      $('#delete-course').on('click', function (e) {
        Swal.fire({
          text: 'Yakin Mau Menghapus Course Ini ?!',
          showCancelButton: true,
        }).then(function (resp) {
          if (resp.isConfirmed) {
            $.ajax({
              type: "DELETE",
              url: `/api/course/delete/${id}`,
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
                  return window.location.href = '/admin/course'
                });
              },
            })
          }
        })


      })

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


    populateCourseDetailGeneral(course)
    populateCourseDetailMember(members)
    populateCourseDetailVideo(videos, course_id, title)
    populateCourseDetailSetting(course)
    populateCourseEditDelete(course_id)
  }

  populateCourseDetailPage()
})