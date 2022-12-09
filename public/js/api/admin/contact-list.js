console.log(Cookies.get('access_token'))
$.ajax({
    type: "GET",
    url: "/api/contactus",
    headers: {
        Authorization: 'Bearer ' + Cookies.get('access_token')
    },
    dataType: 'json',
    success: function (result, status, xhr) {
        $.each(result, function (key, value) {
            console.log(value.question_image)
            $("tbody").append(`
            <tr id='questionID_${value.contact_us_id}'>
                <td>
                    <h6 class="text-sm mb-0 ps-3">${value.email}</h6>
                </td>
                <td>
                    <p class="user-question-text text-xs font-weight-bold mb-0 text-wrap w-300">
                    ${value.question}
                    </p>
                    <input class="expand-btn" type="checkbox">
                </td>
                <td class="align-middle text-center text-sm">
                    <button class="btn-default" data-bs-target="#modal-image${value.contact_us_id}" data-bs-toggle="modal">
                        <img src="${value.question_image}" class="avatar avatar-sm me-3" alt="user1">
                    </button>
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">${value.created_at}</span>
                </td>
                
                <td class="align-middle">
                    <button data-bs-target="#reply-modal${value.contact_us_id}" data-bs-toggle="modal" class="btn-default text-secondary font-weight-bold text-xs">
                        <span class="badge badge-pill badge-md bg-gradient-warning">Kirim Jawaban</span>
                    </button>
                </td>
                <td class="align-middle">
                    <button data-bs-target="#delete-modal${value.contact_us_id}" data-bs-toggle="modal" class="btn-default text-secondary font-weight-bold text-xs">
                        <span class="badge badge-pill badge-md bg-danger">Hapus</span>
                    </button>
                </td>
            </tr>
        `);

            $('#image-modal').append(`
            <div class="modal fade" id="modal-image${value.contact_us_id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lampiran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="/upload/question/${value.question_image}" width="465" alt="user1">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `)

            $('#reply-modal').append(`
            <div class="modal fade" id="reply-modal${value.contact_us_id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kirim Jawaban</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="reply-form">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
                                <input type="text" name="email" class="form-control" value="${value.email}" id="user-email${value.contact_us_id}" disabled>
                            </div>
                            <input type="text" name="question" class="hide" value="${value.question}" id="user-question${value.contact_us_id}">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" name="answer" id="message-text${value.contact_us_id}"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button data-bs-dismiss="modal" id="send-reply${value.contact_us_id}" type="button" class="btn bg-gradient-primary">Send message</button>
                    </div>
                    </div>
                </div>
            </div>
        
        `)

            $('#delete-modal').append(`
            <div class="modal fade" id="delete-modal${value.contact_us_id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p>Apakah anda yakin mau menghapus pesan dari ${value.email}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button data-bs-dismiss="modal" id="send-delete${value.contact_us_id}" type="button" class="btn bg-gradient-danger">Hapus</button>
                    </div>
                    </div>
                </div>
            </div>
        
        `)

            $("#send-reply" + value.contact_us_id).on('click', function (e) {
                e.preventDefault()
                const form_data = {
                    email: $('#user-email' + value.contact_us_id).val(),
                    answer: $('#message-text' + value.contact_us_id).val(),
                    question: $('#user-question' + value.contact_us_id).val()
                }

                $.ajax({
                    type: 'POST',
                    url: '/api/contactus/answer',
                    data: form_data,
                    headers: {
                        Authorization: 'Bearer ' + Cookies.get('access_token')
                    },
                    cache: false,
                    processData: true,
                    beforeSend: function () {
                        Swal.fire({
                            width: '300px',
                            title: "<div class='status-loading'> " +
                                '<p>Sedang Mengirim...</p> ' +
                                "</div>",
                            showConfirmButton: false,
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__fast'
                            },
                        })
                    },
                    success: function (response) {
                        console.log(response)
                        $.ajax({
                            url: '/api/contactus/delete/' + value.contact_us_id,
                            type: 'delete',
                            headers: {
                                Authorization: 'Bearer ' + Cookies.get('access_token')
                            },
                            success: function (data) {
                                $('#questionID_' + value.contact_us_id).remove()
                                return Swal.fire({
                                    width: '300px',
                                    title: "<div class='status-loading'> " +
                                        '<h5>Jawaban Terkirim</h5> ' +
                                        "</div>",
                                    showConfirmButton: true,
                                    showClass: {
                                        popup: 'animate__animated animate__fadeIn animate__fast'
                                    },
                                })
                            },
                        });
                    }
                });


            })

            $('#send-delete' + value.contact_us_id).on('click', function (e) {
                $.ajax({
                    url: '/api/contactus/delete/' + value.contact_us_id,
                    type: 'delete',
                    headers: {
                        Authorization: 'Bearer ' + Cookies.get('access_token')
                    },
                    beforeSend: function () {
                        Swal.fire({
                            width: '300px',
                            title: "<div class='status-loading'> " +
                                '<p>Menghapus...</p> ' +
                                "</div>",
                            showConfirmButton: false,
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__fast'
                            },
                        })
                    },
                    success: function (data) {
                        $('#questionID_' + value.contact_us_id).remove()
                        return Swal.fire({
                            width: '300px',
                            title: "<div class='status-loading'> " +
                                '<h5>Berhasil Terhapus</h5> ' +
                                "</div>",
                            showConfirmButton: true,
                            showClass: {
                                popup: 'animate__animated animate__fadeIn animate__fast'
                            },
                        })
                    },
                });

            })

        })

    },


});


