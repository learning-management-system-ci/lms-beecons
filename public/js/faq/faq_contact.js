$("#contact-us").on("click", function (event) {
    event.preventDefault();
    Swal.fire({
        width: '1200px',
        html: `<div class="contact-popup d-flex justify-content-center">
    <div class="contact-info">
        <p>Terima kasih telah menggunakan <b>Stufast Learning Center</b>.</p>
        <p>Jika kamu memiliki pertanyaan atau komentar silahkan hubungi kami melalui formulir ini.</p>
        <p>Kami akan membalas pesan kamu melalui email secepat mungkin. Mohon diperhatikan bahwa pesan yang dikirim di luar jam kerja akan kami balas paling cepat di hari kerja berikutnya.</p>
        <div class="d-flex ">
            <img src="image/faq/figure1.png" width="250px" alt="">
            <p><b> Stufast Learning Center! </b></p>
        </div>
    </div>
    <form class="contact-form d-flex flex-column" enctype="multipart/form-data">
        <input class="px-2" type="email" placeholder="Email" name="email">
        <textarea class="p-2" name="question" id="" cols="50" rows="10" placeholder="Pesan" required></textarea>
        <div class="d-flex align-items-center file-group">
            <label for= "image-upload" class="custom-file-upload" >
                <i class="bi bi-paperclip"></i> UNGGAH GAMBAR
                <input type="file" name="question_image" class="hide" id="image-upload" accept=".jpg, .jpeg, .png" required>
            </label >
            <span class='filename'></span>
        </div>
        <input type="submit" class="swal2-confirm" value="Kirim">
    </form>
</div>`,
        padding: '0px 0px 40px 6px',
        showConfirmButton: false,
        showClass: {
            popup: 'animate__animated animate__fadeIn animate__fast'
        },
        showCloseButton: true,
        preConfirm: () => {


            let form = new FormData($('.contact-form')[0])
            return $.ajax({
                type: 'POST',
                url: 'http://localhost:8080/api/contactus/question',
                data: form,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    Swal.fire({
                        width: '300px',
                        title: "<div class='status-loading'> " +
                            '<img class="loading-icon" src="image/cart/redeem-loading.gif" alt=""> ' +
                            '<p>Sedang Mengirim</p> ' +
                            "</div>",
                        padding: '0px 0px 40px 6px',
                        showConfirmButton: false,
                        showClass: {
                            popup: 'animate__animated animate__fadeIn animate__fast'
                        },
                    })
                },
                success: function (response) {
                    console.log(response)
                    return response
                }
            });

        }
    }).then((result) => {
        console.log(result)


        if (!result.isConfirmed) return
        if (result.value.status == '201') {
            return Swal.fire({
                title: "<div class='status-success'> " +
                    '<img class="mb-4 success-icon" src="image/cart/success-popup.png" alt=""> ' +
                    '<h5 class="mt-4">Pesan Terkirim<h5> ' +
                    '<p>Mohon tunggu balasan dari tim kami</p> ' +
                    "</div>",
                focusConfirm: false,
                padding: '0px 0px 33px 40px',
                showConfirmButton: false,
                showCloseButton: true,
            })
        }
        else {
            return Swal.fire({
                title: "<div class='status-warning'> " +
                    '<img class="mb-4 success-icon" width="100px" src="image/cart/warning-popup.png" alt=""> ' +
                    '<h5 class="mt-4">Terjadi Masalah<h5> ' +
                    `<p>${result.value.messages.email}</p>` +
                    "</div>",
                focusConfirm: false,
                // padding: '0px 0px 42px 50px',
                showConfirmButton: false,
                showCloseButton: true,
            })
        }



    })

    $('#image-upload').on('change', function (e) {
        $('.filename').text(e.target.files[0].name)
    })


    $('.contact-form').on('submit', function (event) {
        event.preventDefault()
        Swal.clickConfirm()
    })
})
