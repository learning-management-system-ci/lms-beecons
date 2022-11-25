<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/about-us.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="main-container" id="profile">
    <div class="row justify-content-between">
        <div class="col-6">
            <div class="images">
                <div>
                    <img src="/image/about-us/1.png" alt="">
                </div>
                <div>
                    <img src="/image/about-us/2.png" alt="">
                </div>
                <div>
                    <img src="/image/about-us/3.png" alt="">
                </div>
            </div>
        </div>
        <div class="col-5 mt-4">
            <h2 class="title">
                Stufast Learning Center
            </h2>
            <p class="description">
                Stufast merupakan tempat dimana kamu dapat mengasah kemampuan professional 
                melalui real time project dan akan didampingi oleh mentor yang sudah expert 
                dengan bidangnya. Stufast juga memberikan kamu sertifikat yang dapat membuat 
                skill kamu lebih menjanjikan di dunia kerja.
            </p>
        </div>
    </div>
</div>
<div class="main-container my-4" id="why">
    <div class="row py-4 justify-content-center">
        <div class="col-12 title">
            <h1>Mengapa belajar di Stufast Learning Center?</h1>
        </div>
        <!-- make 3 point  -->
        <div class="col-11 row">
            <div class="col-4 px-3">
                <div class="image p-2">
                    <img src="/image/about-us/bullet-1.png" alt="">
                </div>
                <h3 class="content-title">Relevansi Kurikulum</h3>
                <p class="content-description mx-4">
                    Kami merancang dan menyediakan kurikulum 
                    berstandar tinggi yang telah disesuaikan 
                    dengan kebutuhan industri teknologi saat ini.
                </p>
            </div>
            <div class="col-4 px-3">
                <div class="image p-2">
                    <img src="/image/about-us/bullet-2.png" alt="">
                </div>
                <h3 class="content-title">Bimbingan belajar</h3>
                <p class="content-description mx-4">
                    Kami menyediakan mentor profesional untuk 
                    mendukung pembelajaran kamu sesuai dengan 
                    bidang yang kamu pilih.
                </p>
            </div>
            <div class="col-4 px-3">
                <div class="image p-2">
                    <img src="/image/about-us/bullet-3.png" alt="">
                </div>
                <h3 class="content-title">Pilihan program</h3>
                <p class="content-description mx-4">
                    Kami menyediakan dua pilihan program 
                    (Engineering & IT) dengan level yang berbeda
                    untuk kamu pilih sesuai dengan kemampuan kamu.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="main-container my-4" id="location">
    <div class="row">
        <div class="col-6">
            <img src="/image/about-us/office.png" alt="">
        </div>
        <div class="col-6 align-self-center">
            <h3 class="title">Lokasi Kami</h3>
            <p class="description">PT. Baracipta Esa Engineering (Studio)</p>
            <span class="detail my-4">Jl. Mijil No.98, Karangjati, Sinduadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55284</span>
            <a class="btn" >Google Maps <i class="fa-solid fa-share-from-square"></i></a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>