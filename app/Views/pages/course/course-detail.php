<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="/style/course-detail.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<?= $this->endSection() ?>


<!-- note -->
<!-- kepada para pengintegrasi, fetch data quiz lakukan sebelum pemanggilan library swiper.js agar dapat dilakukan scroll soal -->

<?= $this->section('app-component') ?>

<!-- kalian bisa tambahkan class "hide" pada element untuk menyembunyikan element -->

<!-- <div id="loading-page">
</div> -->
<div class="px-5 mb-5 d-none" id="course-detail-page">
    <section style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb navigation">
            <a class="breadcrumb-item active" aria-current="page" href="/courses">Courses</a>
            <a class="breadcrumb-item course_type_content active" aria-current="page" href="#">Courses</a>
            <li class="breadcrumb-item course_title_content breadcrumb-anchor" aria-current="page" href="">Courses</li>
        </ol>
        <hr>
    </section>
    <section class="category mt-4 mb-4">
        <h3 class="course_title_content">Fundamentals</h3>
        <p class="course_type_content"> <img src="/image/course-detail/category-icon.png" alt=""> Information Tech (IT)
        </p>
    </section>
    <section class="course-content d-flex justify-content-stretch">
        <div class="left-side">
            <!-- VIDEO EMBED -->
            <!-- <iframe class="mb-5 course-video-content" width="727" height="400" src="https://www.youtube.com/embed/mRttyh1GQ5I"></iframe> -->
            <div class="video-panel">
                <video class="course-video-wraper mb-5" class="mb-5" controls>
                    <source class="course-video-content" src="/upload/course-video/1.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <!-- QUIZ PANEL -->
            <div class="quiz-panel">

            </div>
            <!-- <div class="quiz-section text-center p-4 swiper myswiper mb-5 ">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <h4 class="quiz-title">QUESTION</h4>
                        <p class="mb-3">PILIHAN GANDA</p>
                        <div class="quiz-option-list d-flex justify-content-center align-items-center p-1 flex-wrap">
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-1" id="A-1">
                                <label for="A-1">Hello</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-1" id="B-1">
                                <label for="B-1">Hello</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-1" id="C-1">
                                <label for="C-1">Hello</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-1" id="D-1">
                                <label for="D-1">Hello</label>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <h4 class="quiz-title">QUESTION</h4>
                        <p class="mb-3">PILIHAN GANDA</p>
                        <div class="quiz-option-list d-flex justify-content-center align-items-center p-1 flex-wrap">
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-2" id="A-2">
                                <label for="A-2">Hello</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-2" id="B-2">
                                <label for="B-2">Hello</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-2" id="C-2">
                                <label for="C-2">Hello</label>
                            </div>
                            <div class="quiz-option px-3 d-flex align-items-center">
                                <input type="radio" name="question-2" id="D-2">
                                <label for="D-2">Hello</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress-box d-flex align-items-center justify-content-center p-1 mt-5">
                    <button class="quiz-back"><img width="34px" src="/image/course-detail/back.png" alt=""></button>
                    <div id="loading"></div>
                    <button class="quiz-next"><img width="110px" src="/image/course-detail/next.png" alt=""></button>
                    <button class="quiz-finish hide"><img width="110px" src="/image/course-detail/finish.png" alt=""></button>
                </div>
            </div> -->


            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Tentang</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Kurikulum</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Projek</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-review" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Review</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-resume-tab" data-bs-toggle="pill" data-bs-target="#pills-resume" type="button" role="tab" aria-controls="pills-resume" aria-selected="false">Resume</button>
                </li>
            </ul>
            <div class="tab-content description" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <p class="course_description_content">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Tempora, esse. Inventore dicta
                        saepe minus consectetur accusantium deleniti consequatur reprehenderit. Nihil explicabo
                        autem voluptatum atque laudantium incidunt commodi eveniet aspernatur doloribus?</p>
                    <h4 class="mt-3">Key Takeway</h4>
                    <ul class="course_description-keyTakeaway_content">
                        <li>Proxima Centauri</li>
                        <li>Sagitarius-A</li>
                        <li>Ursa Major</li>
                    </ul>
                    <h4 class="mt-3">Kelas ini cocok untuk</h4>
                    <ul class="course_description-suitableFor_content">
                        <li>Proxima Centauri</li>
                        <li>Sagitarius-A</li>
                        <li>Ursa Major</li>
                    </ul>
                </div>
                <div class="tab-pane fade curiculum " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="list-box pb-1">
                        <p class="curiculum-title mb-3 course_title_content">Becoming Professional UI/UX Designer</p>
                        <ul class="curiculum-list course_curriculumList_content ps-2">
                            <li class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <button>
                                        <div class="play"></div>
                                    </button>
                                    <p>Course Introduction</p>
                                </div>
                                <div class="d-flex">
                                    <a href="#" class="preview-link">Preview</a>
                                    <p>09.10</p>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <button disabled>
                                        <div class="locked"></div>
                                    </button>
                                    <p>Course Introduction</p>
                                </div>
                                <div class="d-flex">
                                    <p>09.10</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade project" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <h4>Create Tokopedia Responsive Learning</h4>
                    <img class="project-banner mb-2" src="/image/course-detail/banner.png" alt="">
                    <p>Membuat desain antarmuka untuk website pembelajaran online yang dapat diakses menggunakan
                        berbagai perangkat yang
                        dimiliki oleh user. Mulailah dari tahap Research untuk memahami perasaan user (empati),
                        merancang hingga tahap pengujian
                        kepada user</p>
                    <div class="button-group d-flex justify-content-between mt-5">
                        <div class="d-flex align-items-center">
                            <!-- tambahkan class disable pada start-button untuk 
                            mematikan tombol secara visual. atribut disable befungsi
                            untuk mematikan fungsi element button -->
                            <button class="start-button" disabled>Start</button>
                            <button class="play-button-project">
                                <img src="/image/course-detail/play-project-disable.png">
                            </button>
                        </div>
                        <button class="download-button">
                            <img src="/image/course-detail/download-disable.png" alt="">
                        </button>
                    </div>
                </div>
                <div class="tab-pane fade user-review course-review-content" id="pills-review" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">
                    <div class="review-card d-flex align-items-center ps-3">
                        <img class="user-image" src="/image/course-detail/person.png" alt="">
                        <div class="review-data pe-4 d-flex flex-column">
                            <div class="top-section d-flex justify-content-between">
                                <div class="user-title d-flex">
                                    <h6>Loid Forger</h6>
                                    <p>General User</p>
                                </div>
                                <div class="user-score d-flex">
                                    <span class="stars-container">★★★★★</span>
                                    <img src="/image/course-detail/star.png" alt="">
                                    <h6>4.9</h6>
                                </div>
                            </div>
                            <p class="review-description">"Video materi sangat membantu, pokoknya mantul"</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade resume " id="pills-resume" role="tabpanel" aria-labelledby="pills-resume-tab" tabindex="0">
                    <div class="list-box pb-1">
                        <p class="resume-title mb-3 course_title_content">Becoming Professional UI/UX Designer</p>
                        <ul class="resume-list course_resumeList_content ps-2">
                            <li class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <p>Course Introduction</p>
                                </div>
                                <div class="d-flex">
                                    <a href="#" class="preview-link">Resume</a>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <p>Course Introduction</p>
                                </div>
                                <div class="d-flex">
                                    <a href="#" class="preview-link">Resume</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-side">

            <!-- KODE YANG DIKOMENTARI DI BAWAH ADALAH LIST VIDEO VERSI
            USER UNPAID (PENGGUNA BELUM BAYAR). JADI KODE DIBAWAH SAMA PENTINGNYA
            DENGAN KODE YANG LAIN. JANGAN DIHAPUS!! -->


            <!-- <div class="video-list mb-5 p-3 pt-4">
                <h5 class="mb-3 course_videoCount_content">8 Video</h5>
                <hr>
                <div class="scrollable-video-list pe-3 ">
                    <div class="sub-chapter mb-3 course_videoList_content">
                        <div class="list-card-button d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                            <p>7 mins</p>
                        </div>
                        <div class="list-card-button d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                            <p>7 mins</p>
                        </div>
                        <div class="list-card-button d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                            <p>7 mins</p>
                        </div>
                    </div>
                    <div class="buy-course d-flex align-items-center justify-content-between p-2 px-3">
                        <img width="20px" src="/image/course-detail/paid-lock.png" alt="">
                        <p>BUY COURSE</p>
                    </div>
                </div>
            </div> -->

            <div class="video-list mb-5 p-3 pt-4">
                <h5 class="mb-3 course_videoCount_content">8 Video</h5>
                <hr>
                <div class="scrollable-video-list pe-3 course_videoList_content" id="content-list">
                    <h6 class="title-chapter d-flex flex-row-reverse justify-content-between">BAB 1. Introduction
                    </h6>
                    <div class="sub-chapter mb-3 ps-3">
                        <div class="list-card-button complete d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction of ReactJS</p>
                            </div>
                            <p class="duration">7 mins</p>
                        </div>
                        <!-- class list-card-button untuk mengaktifkan card video -->
                        <div class="list-card-button d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                            <p class="duration">7 mins</p>
                        </div>
                        <!-- class complete untuk mengaktifkan card yang dicentang (user menyelesaikan video/quiz) -->
                        <div class="list-card-button complete d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction of ReactJS</p>
                            </div>
                            <p class="duration">7 mins</p>
                        </div>
                        <!-- class quiz untuk mengaktifkan quiz -->
                        <div class="list-card-button quiz-card d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                        </div>
                    </div>
                    <h6 class="title-chapter  d-flex flex-row-reverse justify-content-between">BAB 2. Perancangan
                        dan Desain dengan AutoCAD</h6>
                    <div class="sub-chapter mb-3 ps-3">
                        <div class="list-card-button complete d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                            <p class="duration">7 mins</p>
                        </div>
                        <div class="list-card-button d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                            <p class="duration">7 mins</p>
                        </div>
                        <div class="list-card-button quiz-card d-flex justify-content-between align-items-center p-3 mb-3">
                            <div class="list-title d-flex align-items-center">
                                <button></button>
                                <p>Introduction</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-card">
                <h4>Order Summary</h4>
                <p class="mt-4 mb-1 course_title_content">Mastering Frontend Developer</p>
                <ul class="detail_order_content">
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                Course Fee
                            </p>
                            <p class="order-price mb-2 course_price_beforeDiscount_content">
                                Rp.200.000
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                Platform Fee
                            </p>
                            <p class="order-price mb-2 course_price_platformFee_content">
                                Rp.10.000
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                Flash Sale Discount
                            </p>
                            <p class="order-price mb-2 text-decoration-line-through course_price_discount_content">
                                Rp.200.000
                            </p>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="order-total d-flex justify-content-between ">
                    <h5>Order Total</h5>
                    <h5 class="course_price_total_content">Rp.610.000</h5>
                </div>
                <div class="discount-info mt-2 text-center p-3">
                    Hebat! Kamu udah hemat <b class="course_price_discount_content">Rp 200.000</b> pada pemesananmu.
                </div>
                <button class="mt-2" id="btn-buy-course">Beli</button>
                <button class="mt-2 add-to-cart" id="btn-add-to-cart">Masukkan ke Keranjang</button>
            </div>
        </div>
    </section>

    <!-- image caching (agar gambar dari css maupun javascript bisa langsung dimuat ga pake delay) -->
    <div class="hide">
        <img src="/image/course-detail/button-quiz-light.png" alt="">
        <img src="/image/course-detail/button-quiz-dark.png" alt="">
        <img src="/image/course-detail/play-dark.png" alt="">
        <img src="/image/course-detail/check.svg" alt="">
        <img src="/image/course-detail/pause-button.png" alt="">
        <img src="/image/course-detail/loading-indicator.png" alt="">
        <img src="/image/course-detail/video-locked.png" alt="">
        <img src="/image/course-detail/play-project-enable.png" alt="">
    </div>


</div>

<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="/js/library/swiper-bundle.min.js"></script>
<script src="/js/library/progress-bar.js"></script>
<script src="/js/utils/getRupiah.js"></script>
<script src="/js/utils/textTruncate.js"></script>
<script src="/js/home/course-detail.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>