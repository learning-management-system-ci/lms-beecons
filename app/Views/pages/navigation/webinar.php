<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/webinar-training.css">
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div class="container">
    <section style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb navigation">
            <a class="breadcrumb-item active" aria-current="page" href="/">Home</a>
            <li class="breadcrumb-item course_title_content breadcrumb-anchor" aria-current="page" href="">Peluang Karir
                Seorang UI/UX Designer</li>
        </ol>
        <hr>
    </section>
    <section class="main-content d-flex">
        <section class="left-side">
            <h3>Peluang Karir Seorang UI/UX Designer</h3>
            <p class="category mb-5">UI/UX</p>
            <img class="banner mb-3" src="image/webinar-training/webinar-banner.png" alt="webinar-banner">

            <!-- ICON GROUP WEBINAR -->
            <div class="icon-group d-flex">
                <div class="icon-description d-flex align-items-center">
                    <img src="image/webinar-training/icon-video.png" alt="">
                    <p>Online Webinar</p>
                </div>
                <div class="icon-description d-flex align-items-center">
                    <img src="image/webinar-training/icon-document.png" alt="">
                    <p>Soft file rekaman webinar</p>
                </div>
            </div>

            <!-- ICON GROUP TRAINING -->
            <!-- <div class="icon-group d-flex">
                <div class="icon-description d-flex align-items-center">
                    <img src="image/webinar-training/icon-home.png" alt="">
                    <p>In-House Training</p>
                </div>
            </div> -->

            <hr>
            <p class="description">
                UI/UX Design memiliki dua komponen yang berbeda namun saling berkaitan tampilan (User Interface) dan
                tata letak atau
                pengalaman (User Experience) <br><br>

                Desain UX yaitu mendesain produk sesuai dengan kebutuhan pengguna. Untuk mencapainya,
                seorang UX Design harus mengeksplorasi kinerja pengguna dan melakukan penelitian terkait dengan
                implementasi penggunaan
                aplikasi. <br><br>

                Kemudian, UI Design merupakan visualisasi hasil dari penelitian UX Design yang akan berbentuk
                mockup/prototype
                aplikasi. UI Design berfokus pada bagaimana membuat tampilan (interface) yang menarik bagi pengguna.
                Proses desain yang
                akan dilakukan oleh UI/UX Designer diantaranya: <br>
                <ul>
                    <li>
                        <p>
                            UX Research Membuat konsep produk
                        </p>
                    </li>
                    <li>
                        <p>
                            Membuat rangka gambar (wireframes)
                        </p>
                    </li>
                    <li>
                        <p>
                            Melakukan pengujian Membuat visual desain
                        </p>
                    </li>
                    <li>
                        <p>
                            Implementasi hasil desain oleh programmer
                        </p>
                    </li>
                </ul>
            </p>
        </section>
        <section class="right-side">

            <!-- ORDER CARD WEBINAR -->
            <div class="order-card">
                <h4>Ringkasan Pesanan</h4>
                <p class="mt-4 mb-1">Webinar UI/UX Designer</p>
                <ul>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                Online Webinar
                            </p>
                            <p class="order-price mb-2">
                                Rp.200.000
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                Soft File Recording
                            </p>
                            <p class="order-price mb-2 free-text">
                                FREE
                            </p>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="order-total d-flex justify-content-between">
                    <h5>Total Pesanan</h5>
                    <h5>Rp.150.000</h5>
                </div>
                <div class="discount-info mt-2 text-center p-3">
                    Hebat! Kamu mendapatkan <b>gratis</b> rekaman video pada pesananmu.
                </div>
                <button class="mt-2">Beli</button>
                <button class="mt-2 add-to-cart">Masukkan ke Keranjang</button>
            </div>

            <!-- ORDER CARD TRAINING -->
            <!-- <div class="order-card">
                <h4 class="mb-3">Ringkasan Pesanan</h4>
                <div class="d-flex justify-content-between">
                    <p class="order-list mb-2">
                        Training Intro to Coding
                    </p>
                    <p class="order-price mb-2">
                        Rp.200.000
                    </p>
                </div>
                <hr>
                <div class="order-total d-flex justify-content-between">
                    <h5>Total Pesanan</h5>
                    <h5>Rp.200.000</h5>
                </div>
                <div class="discount-info mt-2 text-center p-3 hide">
                    Hebat! Kamu mendapatkan <b>gratis</b> rekaman video pada pesananmu.
                </div>
                <button class="mt-2">Beli</button>
                <button class="mt-2 add-to-cart hide">Masukkan ke Keranjang</button>
            </div> -->


        </section>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="js/home/faq.js"></script>
<?= $this->endSection() ?>