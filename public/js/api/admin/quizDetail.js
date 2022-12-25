// check the cookies if the user is logged in
if (!Cookies.get('access_token')) {
  // if not, redirect to login page
  window.location.href = '/login'
}


const editAnswer = () => {
  return $('.answer-list').on('click', function (e) {
    let this_el = $(this)
    Swal.fire({
      text: 'Edit Jawaban',
      input: 'text',
      showCancelButton: true,
      inputValue: $(this).text()
    }).then(function (text) {
      this_el.html(text.value)
    })
    return e.stopImmediatePropagation();
  })
}

const deleteQuiz = () => {
  return $('.delete-btn').on('mousedown', function (e) {
    let parent_quiz = $(this).attr('data-target-quiz');
    Swal.fire({
      text: 'Yakin mau menghapus ?!',
      showCancelButton: true,
    }).then(function (text) {
      if (text.isConfirmed) {
        $(parent_quiz).remove();
        if ($('#accordionExample').children().length == 0) {
          $('#accordionExample').append('<p class="no-quiz text-center">Belum ada pertanyaan</p>')
        }
      }

    })
    return e.stopImmediatePropagation();
  })
}

const addQuiz = () => {
  return $('#add-quiz').on('click', function () {
    $('.no-quiz').remove()
    let quiz_total = $('#accordionExample').children().length + 1
    let answer_list = choiceComponent(quiz_total)
    $('#accordionExample').append(quizComponent(quiz_total, 'Masukkan Pertanyaan', answer_list));
    deleteQuiz()
    editAnswer()
  })
}

const quizComponent = (id, question, answer) => {
  return `<div class="accordion-item" id='quiz-items${id}'>
                <h2 class="accordion-header d-flex align-items-center" id="heading${id}">

                <button aria-expanded="false" style="box-shadow:none ;" class="collapsed accordion-button" 
                  type="button" data-bs-toggle="collapse" data-bs-target="#collapse${id}" aria-controls="collapse${id}">

                  <p class=" accordion-title">Soal ${id}</p>
                </button>

              </h2>
                <div id="collapse${id}" class="accordion-collapse collapse" aria-labelledby="heading${id}">
                    <div class="accordion-body ">
                        <div style="display: block;">
                            <div class="quiz-section text-center p-1 swiper myswiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <h5 class="quiz-title mb-3 text-start p-1" contentEditable>${question}</h4>
                                        <div
                                            class="quiz-option-list d-flex justify-content-center align-items-center flex-wrap">
                                            ${answer}
                                        </div>
                                    </div>
                                </div>
                                <button data-target-quiz="#quiz-items${id}" type="button" class="delete-btn text-white btn bg-danger bg-info mt-3">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
}

const choiceComponent = (questionID, arrayAnswer, checkedAnswer) => {
  let answer = ""
  for (let index = 0; index < 4; index++) {
    if (!arrayAnswer) {
      answer += `
      <div class="quiz-option px-3 d-flex align-items-center quiz-id-${questionID}">
          <input ${index == 0 ? 'checked' : ""} type="radio" data-input-order="${index + 1}" name='choice-${questionID}'>
          <p title="Click untuk edit jawaban" class="answer-list" id="${questionID}-${index + 1}">Masukkan Jawaban</p>
      </div>
      `
    } else {
      answer += `
      <div class="quiz-option px-3 d-flex align-items-center quiz-id-${questionID}">
          <input type="radio" ${checkedAnswer == index + 1 ? 'checked' : ""} name='choice-${questionID}' data-input-order="${index + 1}">
          <p title="Click untuk edit jawaban" class="answer-list" id="${questionID}-${index + 1}">${arrayAnswer[index]}</p>
      </div>
      `
    }

  }
  return answer
}

const appendingQuizData = (data) => {
  $.each(data, function (index, value) {
    let answer_list = choiceComponent(index + 1, value.answer, value.is_valid)
    $('#accordionExample').append(quizComponent(index + 1, value.question, answer_list));
  })
}

const dataConstructor = () => {

  let dataQuiz = []
  $('.accordion-item').each(function (i, el) {
    let choice = []
    $(`.quiz-id-${i + 1}`).each(function () {
      console.log(i + 1)
      choice.push($(this).find(`p`).text())
    })
    const jsonConstruct = {
      question: $(this).find('.quiz-title').text(),
      is_valid: $(this).find('input:checked').attr('data-input-order'),
      answer: choice
    }
    dataQuiz.push(jsonConstruct)
  })

  return dataQuiz
}


const sendingData = (reqType, url, formData) => {
  $.ajax({
    type: reqType,
    url: `/api/quiz/${url}`,
    contentType: 'application/x-www-form-urlencoded',
    data: formData,
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
    error: function (err) {
      return console.log(err)
    },
  })
}


$(document).ready(() => {

  // Sortable.create(accordionExample, {
  //   handle: '.dragNdrop',
  //   animation: 150,
  //   onEnd: function (evt) {
  //     $('.accordion-item').each(function (i, el) {
  //       $(this).find('.quiz-option').each(function () {
  //         $(this).attr('class', `quiz-option px-3 d-flex align-items-center quiz-id-${i + 1}`)
  //       })
  //     })
  //   }
  // })


  const getData = async (url) => {
    let option = {
      type: "GET",
      url: `/api/${url}`,
      dataType: "json",
      headers: {
        "Authorization": `Bearer ${Cookies.get("access_token")}`,
      },
      success: function (video) {
        data = video
      },
      error: function (err) {
        Promise.reject(new Error(err));
      }
    }
    let data
    await $.ajax(option)
    return data
  }

  const populateVideoData = async () => {
    const title = $('.title-content')
    let url = window.location.href
    let video_id = url.substring(url.lastIndexOf('/') + 1)
    let video
    let quiz
    let status

    try {
      video = await getData('course/video/' + video_id)
      quiz = await getData('quiz/' + video_id)
    } catch (e) {
      status = e.status
    }
    title.text(video.title)
    status == 400 ? $('#accordionExample').append('<p class="no-quiz text-center">Belum ada pertanyaan</p>')
      : appendingQuizData(quiz.question)
    addQuiz()
    editAnswer()
    deleteQuiz()

    $('#save-quiz').on('click', function () {
      let dataSerialize = `video_id=${video_id}&question=${JSON.stringify(dataConstructor())}`
      if (dataConstructor().length == 0) {
        return Swal.fire({
          icon: 'error',
          text: 'Tidak bisa mengirim pertanyaan kosong',
        })
      }
      if (status == 400) {
        console.log('hello')
        return sendingData('POST', `create`, dataSerialize)
      }
      return sendingData('PUT', `update/${video_id}`, dataSerialize)
    })
  }
  // addQuiz(quiz.question)
  populateVideoData()
})