if (!Cookies.get('access_token')) {
    // if not, redirect to login page
    window.location.href = '/login'
}
let checkAuthor = jwt_decode(Cookies.get('access_token'))


const ajaxSend = (type, url, data, id) => {
    const dialogPopup = (msg, showOK) => {
        return Swal.fire({
            width: '300px',
            title: "<div class='status-loading'> " +
                `${msg}` +
                "</div>",
            showConfirmButton: showOK,
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__fast'
            },
        })
    }

    $.ajax({
        type: type,
        url: `/api/faq/${url}`,
        headers: {
            Authorization: 'Bearer ' + Cookies.get('access_token')
        },
        dataType: 'json',
        data: data,
        beforeSend: function () {
            dialogPopup('<p>Mohon Tunggu...</p>', false)
        },
        success: function () {
            if (type == 'DELETE') {
                $('#faqID_' + id).remove()
            }
            dialogPopup('<h5>Success</h5>', true).then((result) => {
                if (type == 'PUT' || type == 'POST') {
                    return window.location.reload()
                }
                return
            }).catch((err) => {

            });
        }
    })
}




$(document).ready(() => {
    if (checkAuthor.role == 'author') {
        $('#add-faq-btn').remove()
        return $("table").html(`<p class='text-center'>Anda tidak memiliki access</p>`)
    }
    $.ajax({
        type: "GET",
        url: "/api/faq",
        headers: {
            Authorization: 'Bearer ' + Cookies.get('access_token')
        },
        dataType: 'json',
        success: function (result) {
            $.each(result, function (key, value) {
                $("tbody").append(`
            <tr id='faqID_${value.faq_id}'>
                <td>
                    <h6 class="email-user text-sm mb-0 ps-3">${value.question}</h6>
                </td>
                <td>
                    <p id='tets'class="user-question-text text-xs font-weight-bold mb-0 text-wrap w-500">
                    ${value.answer}
                    </p>
                    <input class="mt-3 expand-btn" type="checkbox">
                </td>
                <td class="align-middle">
                    <button data-bs-target="#update-modal${value.faq_id}" data-bs-toggle="modal" class="btn-default text-secondary font-weight-bold text-xs">
                        <span class="badge badge-pill badge-md bg-gradient-warning">Perbaruhi</span>
                    </button>
                    <button data-bs-target="#delete-modal${value.faq_id}" data-bs-toggle="modal" class="btn-default text-secondary font-weight-bold text-xs">
                        <span class="badge badge-pill badge-md bg-danger">Hapus</span>
                    </button>
                </td>
            </tr>
        `);

                $('#update-modal').append(`
            <div class="modal fade" id="update-modal${value.faq_id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Perbaruhi FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="update-form">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Pertanyaan</label>
                                <input type="text" name="text" class="form-control" value="${value.question}" id="question-${value.faq_id}">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Jawaban</label>
                                <textarea class="form-control" style="resize: none;" name="answer" rows="7" id="answer-${value.faq_id}"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button data-bs-dismiss="modal" id="send-update${value.faq_id}" type="button" class="btn bg-gradient-primary">Perbaruhi</button>
                    </div>
                    </div>
                </div>
            </div>
        
        `)

                $('#delete-modal').append(`
            <div class="modal fade" id="delete-modal${value.faq_id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p>Apakah anda yakin mau menghapus FAQ </p>
                            <b>${value.question}</b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button data-bs-dismiss="modal" id="send-delete${value.faq_id}" type="button" class="btn bg-gradient-danger">Hapus</button>
                    </div>
                    </div>
                </div>
            </div>
        
        `)


                $('#answer-' + value.faq_id).val(value.answer)
                $("#send-update" + value.faq_id).on('click', function (e) {
                    e.preventDefault()
                    const form_data = {
                        answer: $('#answer-' + value.faq_id).val(),
                        question: $('#question-' + value.faq_id).val()
                    }
                    return ajaxSend('PUT', 'update/' + value.faq_id, form_data)
                })

                $('#send-delete' + value.faq_id).on('click', function (e) {
                    return ajaxSend('DELETE', 'delete/' + value.faq_id, '', value.faq_id)
                })
            })
        },

    });

    $("#send-add-faq").on('click', function (e) {
        e.preventDefault()
        const form_data = {
            answer: $('#add-faq-content').val(),
            question: $('#add-faq-title').val()
        }
        return ajaxSend('POST', 'create/', form_data)
    })
})







