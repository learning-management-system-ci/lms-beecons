// check the cookies if the user is logged in
if (!Cookies.get('access_token')) {
  // if not, redirect to login page
  window.location.href = '/login'
}

const content_edit = {
  id: $('#video-id-input'),
  cat_id: $('#video-id-category'),
  title: $('#title-input'),
  thumbnail: $('#thumbnail-input'),
  video: $('#video-input'),
  order: $('#video-order'),
};

const startEdit = () => {
  const editPage = $('#edit-page')
  const detailPage = $('#detail-page')

  editPage.removeClass('d-none')
  detailPage.addClass('d-none')
}

const stopEdit = () => {
  const editPage = $('#edit-page')
  const detailPage = $('#detail-page')

  editPage.addClass('d-none')
  detailPage.removeClass('d-none')
}

$(document).ready(() => {
  const getVideoDetailData = async (id) => {
    let option = {
      type: "GET",
      url: `/api/course/video/${id}`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (video) {
        data = video
      },
    }
    let data
    await $.ajax(option)
    console.log(data)
    return data
  }

  const populateEditVideoData = (data) => {

    content_edit.id.val(data.video_id)
    content_edit.title.val(data.title)
    content_edit.cat_id.val(data.video_category_id)
    content_edit.order.val(data.order)

  }

  const populateVideoData = async () => {
    let url = window.location.href
    let video_id = url.substring(url.lastIndexOf('/') + 1)
    const video = await getVideoDetailData(video_id)
    populateEditVideoData(video)
    const content = {
      id: $('.videoId-content'),
      title: $('.title-content'),
      thumbnail: $('.thumbnail-content'),
      video_wraper: $('.video-content-wraper'),
      video: $('.video-content'),
    }

    content.id.text(video.video_id)
    content.title.text(video.title)
    content.thumbnail.replaceWith(`<img class="img-thumbnail" width="400px" alt="thumbanail" src='${video.thumbnail}'>`)
    // content.video_wraper.empty()
    // content.video_wraper.innerHTML = `
    // <source class="video-content" src="${video.video}" type="video/mp4">
    // Your browser does not support the video tag.
    // `
    content.video_wraper.attr('src', video.video)



    $('#video-edit-form').on('submit', function (e) {
      e.preventDefault()
      let form = new FormData($('#video-edit-form')[0])

      $.ajax({
        type: "POST",
        url: `/api/course/video/update/${content_edit.id.val()}`,
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
              '<p>Sedang Mengirim...(<span id="upload-loading"></span>)</p> ' +
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
              console.log(percentComplete);
              $('#upload-loading').html((Math.round(percentComplete * 100)) + '%');
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



  populateVideoData()
})