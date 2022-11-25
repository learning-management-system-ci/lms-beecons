// check the cookies if the user is logged in
if(!Cookies.get('access_token')){
  // if not, redirect to login page
  window.location.href = '/login'
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

  const populateVideoData = async () => {
    let url = window.location.href
    let video_id = url.substring(url.lastIndexOf('/') + 1)
    const video = await getVideoDetailData(video_id)
    const content = {
      id: $('.videoId-content'),
      title: $('.title-content'),
      video: $('.video-content'),
    }

    content.id.text(video.video_id)
    content.title.text(video.title)
    content.video.attr('src', video.video)
  }

  populateVideoData()
})