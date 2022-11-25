// check the cookies if the user is logged in
if(!Cookies.get('access_token')){
  // if not, redirect to login page
  window.location.href = '/login'
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
    const course_list_content = $("#course-list-content")
    course_list_content.empty()

    course.forEach((course) => {
      let arr_tags = []
      let {
        course_id:id,
        title,
        author,
        category,
        type,
        tag:tags
      } = course

      tags.forEach((tag) => {
        let name = tag.name
        if(!list_tag[name]){
          list_tag[name] = list_badge_color[Math.floor(Math.random() * list_badge_color.length)]
        }
        arr_tags.push(`<span class="badge badge-sm ${list_tag[name]}">${name}</span>`)
      })

      let html = `
      <tr>
        <td>
          <div class="d-flex flex-column justify-content-center px-3">
            <h6 class="mb-0 text-sm font-weight-bold">${textTruncate(title, 30)}</h6>
            <p class="text-xs text-secondary mb-0">${type.name}</p>
          </div>
        </td>
        <td class="text-xs">
          ${arr_tags.join(" ")}
        </td>
        <td>
          <p class="text-xs font-weight-bold mb-0">${category.name}</p>
        </td>
        <td class="text-xs">
          <p class="text-xs font-weight-bold mb-0">${author}</p>
        </td>
        <td class="align-middle">
          <a href="/admin/course/${id}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
            Detail
          </a>
        </td>
      </tr>
      `
      course_list_content.append(html)
    })
  }

  populateCourseData();
})