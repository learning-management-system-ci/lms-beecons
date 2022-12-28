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



  const getData = async (url) => {
    let option = {
      type: "GET",
      url: document.location.origin + "/api/" + url,
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

  const CourseBundlingTag = (tag_data) => {
    let tag = ''
    for (let index = 0; index < tag_data.length; index++) {
      tag += `<p class="badge badge-sm bg-gradient-warning">${tag_data[index].name}</p>`
    }
    return tag
  }

  const CourseBundlingListDNDComponent = (course) => {
    $.each(course, function (index, value) {
      $('#course_panel').
        append(`
        <div data-course-id='${value.course_id}' class="dnd-course-list d-flex justify-content-between course-list-choice p-2 px-3 mb-2 text-white">
          <div class="d-flex flex-column course-container">
            <p class="course-name" style="margin-block-end: 0.75rem !important;">
              ${value.title}
            </p>
            <div class="d-flex gap-1">
              ${CourseBundlingTag(value.tag)}
            </div>
          </div>
          <div class="right-side-course">
            <b>
              ${value.category.name}
            </b>
          </div>
        </div>`)
    })
  }

  const populateCourseData = async () => {
    let userId = checkAuthor.uid
    let bundleData = await getData('bundling');
    let courseData = await getData('course');
    let cat_bundling = await getData('category-bundling');
    let course = courseData.filter((x) => x.service == "course")
    if (checkAuthor.role == 'author') {
      course = courseData.filter((x) => x.author_company == checkAuthor.company)
      bundleData = bundleData.bundling.filter((x) => x.author_company == checkAuthor.company)
    }
    $('#author-input').val(userId)
    CourseBundlingListDNDComponent(course)

    $.each(cat_bundling.reverse(), function (index, value) {
      $('#cat-bunding-wraper').append(`<option value='${value.category_bundling_id}'>${value.name}</option>`)
    })

    const course_table = $("#course-table")

    course_table.dataTable({
      data: bundleData,
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
            return `<p class="mb-0 text-sm px-3">${meta.row + 1}</p>`
          }
        },
        {
          data: "title",
          render: function (data, type, row, meta) {
            return `
              <div class="d-flex flex-column justify-content-center px-3">
                <h6 class="mb-0 text-sm font-weight-bold">${data}</h6>
                <p class="text-xs text-secondary mb-0"></p>
              </div>
            `
          }
        },
        {
          data: "category_name",
          render: function (data, type, row, meta) {
            return `<p class="text-xs font-weight-bold mb-0">${data}</p>`
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
          data: "bundling_id",
          render: function (data, type, row, meta) {
            return `
            <a href="/admin/bundling/${data}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="detail user">
              Detail
            </a>`
          }
        }
      ]
    })


  }

  const BundlingCourseOrderConstructor = (id) => {
    let list = []
    $('#bundling_panel').children().each((index, element) => {
      list.push({
        bundling_id: id,
        course_id: $(element).attr('data-course-id'),
        order: index + 1
      })
    })
    return list
  }

  const submitData = () => {
    $('#create-bundling-form').on('submit', async function (e) {
      e.preventDefault()
      let bundle_id
      let form_bundle = new FormData($('#create-bundling-form')[0])
      let course_order

      await $.ajax({
        type: "POST",
        data: form_bundle,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        url: document.location.origin + "/api/bundling/create",
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
          bundle_id = resp.data.bundling_id
        },
      })

      if (bundle_id) {
        course_order = BundlingCourseOrderConstructor(bundle_id)
        await $.ajax({
          type: "POST",
          data: JSON.stringify(course_order),
          contentType: 'application/json',
          processData: false,
          url: document.location.origin + "/api/course-bundling/create-order",
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

  submitData()

  populateCourseData();
})