<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="/style/loading.css">
<link rel="stylesheet" href="../../../style/courses.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>

<div id="courses">
    <div class="my-container courses-list">
        <div class="bg-white rounded courses-list border">
            <ul class="nav nav-tabs nav-fill mb-3 bg-gray" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-courses-engineering" role="tab" aria-controls="tab-courses-1" aria-selected="true">Engineering</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link disabled" id="ex2-tab-2" data-bs-toggle="tab" href="#tab-courses-it" role="tab" aria-controls="tab-courses-2" aria-selected="false">Information Technology</a>
                </li>
            </ul>

            <div class="tab-content mb-5 p-4 pb-5">
                <div class="tab-pane fade show active" id="tab-courses-engineering" role="tabpanel">
                    <div id="courses-loading">
                        <div class="stage">
                            <div class="dot-pulse">
                            </div>
                        </div>
                    </div>

                    <div class="tags pt-2 pb-4"></div>

                    <h2 class="text-center mb-4 current-tag"></h2>

                    <div class="sub-tags mb-5"></div>

                    <div id="courses-engineering" class="row px-5"></div>
                </div>
                <div class="tab-pane fade" id="tab-courses-it" role="tabpanel">
                    <div class="tags pt-2 pb-4"></div>

                    <h2 class="text-center mb-4 current-tag"></h2>

                    <div class="sub-tags mb-5"></div>

                    <div id="courses-it" class="row px-5"></div>
                </div>
            </div>
        </div>

        <div class="courses-bundling">
            <div class="my-container">
                <h1 class="">Ikuti beberapa kursus dengan pilihan paket bundling!</h1>

                <div class="courses-bundling-loading">
                    <div class="stage">
                        <div class="dot-pulse">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-md-center gap-4 py-3 courses-bundling-rekomendasi">
                    <!-- <div class="col-md-3 px-0">
                        <div class="my-card bundle">
                            <div class="content">
                                <div class="badges">
                                    <div class="item" style="background-color: #FFCB42;">Intermediate</div>
                                    <div class="item" style="background-color: #002B5B; color: white;">Advanced</div>
                                </div>
                                <h2>Mastering Frontend Developer</h2>
                                <h3>What will you get?</h3>
                                <ul>
                                    <li>Fundamental ReactJS</li>
                                    <li>Intermediate ReactJs and NodeJS</li>
                                    <li>Advanced Frontend Developer</li>
                                </ul>

                                Only
                                <div class="harga">
                                    Rp 3.499.000
                                    <del>Rp 4.999.000</del>
                                </div>
                            </div>
                            <a href="">
                                <button class="my-btn btn-full">Detail</button>
                            </a>
                            <div class="label">
                                HEMAT
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="my-container">
            <nav class="mt-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li> -->
                    <li class="breadcrumb-item active" aria-current="page">Bundling</li>
                </ol>
                <hr>
            </nav>
        </div>
        <div class="courses-bundlings">
            <h2>Paket yang tersedia</h2>

            <div class="courses-bundling-loading">
                <div class="stage">
                    <div class="dot-pulse">
                    </div>
                </div>
            </div>

            <div class="tags pt-2 pb-4"></div>

            <div class="courses-bundling-list py-2">
                <!-- <div class="col-md-3 pe-4 pb-4 ps-0">
                    <div class="my-card bundle">
                        <div class="content">
                            <div class="badges">
                                <div class="item" style="background-color: #FFCB42;">Intermediate</div>
                                <div class="item" style="background-color: #002B5B; color: white;">Advanced</div>
                            </div>
                            <h2>Mastering Frontend Developer</h2>
                            <h3>What will you get?</h3>
                            <ul>
                                <li>Fundamental ReactJS</li>
                                <li>Intermediate ReactJs and NodeJS</li>
                                <li>Advanced Frontend Developer</li>
                            </ul>

                            Only
                            <div class="harga">
                                Rp 3.499.000
                                <del>Rp 4.999.000</del>
                            </div>
                        </div>
                        <a href="">
                            <button class="my-btn btn-full">Detail</button>
                        </a>
                        <div class="label">
                            HEMAT
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../../js/utils/getRupiah.js"></script>
<script src="../../../js/utils/textTruncate.js"></script>
<script src="../../../js/home/courses.js"></script>
<script src="../../../js/home/courses-bundling.js"></script>
<?= $this->endSection() ?>