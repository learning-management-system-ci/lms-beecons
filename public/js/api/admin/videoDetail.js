// check the cookies if the user is logged in
if(!Cookies.get('access_token')){
  // if not, redirect to login page
  window.location.href = '/login'
}

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
    return data
  }

  const populateEditVideoData = ( data ) => {
    const content = {
      id: $('#video-id-input'),
      title: $('#title-input'),
      thumbnail: $('#thumbnail-input'),
      video: $('#video-input'),
    };

    content.id.val(data.video_id)
    content.title.val(data.title)

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
    content.thumbnail.attr('src', video.thumbnail)
    console.log(video)
    content.video_wraper.empty()
    content.video_wraper.innerHTML = `
    <source class="video-content" src="${video.video}" type="video/mp4">
    Your browser does not support the video tag.
    `
  }



  populateVideoData()
})