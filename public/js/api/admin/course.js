// check the cookies if the user is logged in
if (!Cookies.get('access_token')) {
  // if not, redirect to login page
  window.location.href = '/login'
}

const createCourseShow = () => {
  $("#create-course-card").removeClass("d-none")
  $("#table-course-card").addClass("d-none")
}

const createCourseHide = () => {
  $("#create-course-card").addClass("d-none")
  $("#table-course-card").removeClass("d-none")
}

$(document).ready(() => {
  const getCourseData = async () => {
    let option = {
      type: "GET",
      url: document.location.origin + "/api/course",
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (courses) {
        data = courses.filter((x) => x.service == "course")
      },
    }
    let data
    await $.ajax(option)
    return data
  }

  const populateCourseData = async () => {
    let course = await getCourseData();
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

    console.log(course)

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
            console.log(data)
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
          data: "author",
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
})