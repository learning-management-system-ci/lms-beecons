// check the cookies if the user is logged in
if (!Cookies.get('access_token')) {
  // if not, redirect to login page
  window.location.href = '/login'
}

let checkAuthor = jwt_decode(Cookies.get('access_token'))

const createCourseShow = () => {
  $("#create-course-card").removeClass("d-none")
  $("#table-course-card").addClass("d-none")
}

const createCourseHide = () => {
  $("#create-course-card").addClass("d-none")
  $("#table-course-card").removeClass("d-none")
}


$(document).ready(() => {

  let type_tag_choice = new SlimSelect({
    select: '#type-tag-input-wraper',
    settings: {
      allowDeselect: true
    }
  })


  const getCourseData = async (url) => {
    let option = {
      type: "GET",
      url: document.location.origin + `/api/${url}`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (courses) {
        data = courses
      },
    }
    let data
    await $.ajax(option)
    return data
  }

  const populateAdditionalData = async () => {
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

    $('#type-input-wraper').on('change', function () {
      let type_tag_filtered = type_tag.filter((x) => x.type_id == $(this).val())
      let addData = []

      $.each(type_tag_filtered[0].tag, function (index, val) {
        const container = {
          text: val.name,
          value: val.tag_id
        }
        addData.push(container)
      })

      type_tag_choice.setData(addData)

    })


  }

  const addCourse = async () => {
    $('#add-course-form').on('submit', function (e) {
      e.preventDefault()
      let form = new FormData($('#add-course-form')[0])
      form.append('tag', JSON.stringify(type_tag_choice.getSelected()))

      $.ajax({
        type: "POST",
        url: `/api/course/create`,
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

  const populateCourseData = async () => {
    let courseData = await getCourseData('course');
    let course = courseData.filter((x) => x.service == "course")
    if (checkAuthor.role == 'author') {
      course = courseData.filter((x) => x.author_company == checkAuthor.company)
    }

    const list_badge_color = [
      "bg-gradient-primary",
      "bg-gradient-info",
      "bg-gradient-success",
      "bg-gradient-warning",
      "bg-gradient-danger",
    ];
    let list_tag = {}
    const course_table = $("#course-table")
    // course_list_content.empty()

    //console.log(course)

    course_table.dataTable({
      data: course,
      language: {
        paginate: {
          next: `<i class="ni ni-bold-right" aria-hidden="true"></i>`,
          previous: `<i class="ni ni-bold-left" aria-hidden="true"></i>`
        }
      },
      dom: "<'row mx-4 mt-4'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row mx-4 mb-2'<'col-sm-12 col-md-6 text-sm'i><'col-sm-12 col-md-6'p>>",
      columns: [
        {
          data: "course_id",
          render: function (data, type, row, meta) {
            return `<a href="/admin/course/${data}" class="mb-0 text-sm px-3">${meta.row + 1}</a>`
          }
        },
        {
          data: "title",
          render: function (data, type, row, meta) {
            return `
              <div class="d-flex flex-column justify-content-center px-3">
                <h6 class="mb-0 text-sm font-weight-bold">${textTruncate(data, 30)}</h6>
                <p class="text-xs text-secondary mb-0">${row.type}</p>
              </div>
            `
          }
        },
        {
          data: "tag",
          render: function (data, type, row, meta) {
            let arr_tags = []
            if (!data) return
            data.forEach((tag) => {
              let name = tag.name
              if (!list_tag[name]) {
                list_tag[name] = list_badge_color[Math.floor(Math.random() * list_badge_color.length)]
              }
              arr_tags.push(`<span class="badge badge-sm ${list_tag[name]}">${name}</span>`)
            })
            return arr_tags.join('')
          },
          className: "text-xs tag-wrapper",
        },
        {
          data: "category",
          render: function (data, type, row, meta) {
            return `<p class="text-xs font-weight-bold mb-0">${data.name}</p>`
          }
        },
        {
          data: "author_company",
          render: function (data, type, row, meta) {
            return `<p class="text-xs font-weight-bold mb-0">${data}</p>`
          },
          className: "text-xs",
        },
        {
          data: "course_id",
          render: function (data, type, row, meta) {
            return `
            <a href="/admin/course/${data}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="detail user">
              Detail
            </a>`
          }
        }
      ]
    })


  }

  populateCourseData();
  populateAdditionalData()
  addCourse();
})