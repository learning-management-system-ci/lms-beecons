$("#contact-us").on("click", function (event) {
    console.log('helllosfisfjdsjfgusdgfyuzfugdfjyg')
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
    <form class="contact-form d-flex flex-column">
        <input class="px-2" type="text" placeholder="Email" name="useremail">
        <textarea class="p-2" name="pesan" id="" cols="50" rows="10" placeholder="Pesan"></textarea>
        <label for="image-upload" class="custom-file-upload">
            <i class="bi bi-paperclip"></i> UNGGAH GAMBAR
        </label>
        <input type="file" name="" id="image-upload" class="hide">

        <input type="submit" value="Kirim">
    </form>
</div>`,
        padding: '0px 0px 40px 6px',
        showConfirmButton: false,
        showClass: {
            popup: 'animate__animated animate__fadeIn animate__fast'
        },
        showCloseButton: true,
    })
})