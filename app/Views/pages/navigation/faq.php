<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="../../../style/faq.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="main-section px-5 mt-4 d-flex mb-4">
    <section class="faq mt-4">
        <div class="faq-title mb-5">
            <H3>Apa yang dapat kami bantu?</H3>
            <p>Jika kamu memiliki pertanyaan yang belum terjawab, silahkan kirimkan pesan ke kami melalui tombol
                "Hubungi Kami" di sudut kanan bawah layar.</p>
        </div>
        <div class="faq-list"></div>
    </section>
    <section class="right-side d-flex flex-column justify-content-between align-items-end">
        <img src="image/faq/figure1.png" class="mt-5" width="350px" alt="">
        <button id="contact-us"><i class="bi bi-envelope-fill me-2"></i>Hubungi Kami</button>
    </section>

</div>
<!-- <div class="contact-popup d-flex justify-content-center">
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
        <textarea class="p-2" name="pesan" id="" cols="43" rows="10" placeholder="Pesan"></textarea>
        <label for="image-upload" class="custom-file-upload">
            <i class="bi bi-paperclip"></i> UNGGAH GAMBAR
        </label>
        <input type="file" name="" id="image-upload" class="hide">

        <input type="submit">
    </form>
</div> -->
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../../js/faq/get_faqs.js"></script>
<script src="../../../js/faq/faq_contact.js"></script>
<?= $this->endSection() ?>