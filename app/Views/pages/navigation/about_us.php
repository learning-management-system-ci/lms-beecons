<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/about-us.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="container mt-4">
  <section class="navigation">
    <p class="mb-4">Home > <a href="#"> About Us</a></p>
    <hr>
  </section>
  <section class="about-us my-6">
    <h3 class="about-us-title my-4">Founder</h3>
    <div class="about-us-founder">
      <div class="d-flex align-items-center mt-4">
        <div class="flex-shrink-0 founder-photo">
          <img src="image/founder-photo.png" alt="Founder Photo" class="">
        </div>
        <div class="flex-grow-1 ms-3 ml-4">
          <h3>John Doe</h3>
          <p>CEO & Founder</p>
          <p class="description">Lahir di Sleman, Yogyakarta. Merupakan lulusan Universitas ABC, Fakultas Teknik (2010-2014). Tinggal di Yogyakarta selama sekolah dasar hinggal kuliah. Mendirikan Beecons di tahun 2018.</p>
        </div>
      </div>
    </div>
  </section> 
  <section class="about-us my-6">
    <h3 class="about-us-title my-4">Location</h3>
    <div class="about-us-content row row-cols-2 justify-content-between">
      <div class="col-6">
        <div class="about-us-card p-5">
          <h4>
            PT. Baracipta Esa Engineering (Studio)
          </h4>
          <p>
            Jl. Raya Cikarang Barat No. 1, Cikarang Barat, Bekasi, Jawa Barat 17530
          </p>
          <a>
            Google Maps
          </a>
        </div>
      </div>
      <div class="col-6">
        <div class="about-us-card p-5">
          <h4>
            PT. Baracipta Esa Engineering (Studio)
          </h4>
          <p>
            Jl. Raya Cikarang Barat No. 1, Cikarang Barat, Bekasi, Jawa Barat 17530
          </p>
          <a>
            Google Maps
          </a>
        </div>
      </div>
    </div>
  </section>  
</div>

<?= $this->endSection() ?>