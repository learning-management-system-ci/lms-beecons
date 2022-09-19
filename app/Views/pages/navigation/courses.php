<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/courses.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>

<div id="courses">
    <div class="my-container">
        <nav class="mt-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li> -->
                <li class="breadcrumb-item active" aria-current="page">Courses</li>
            </ol>
            <hr>
        </nav>

        <div class="courses-category">
            <h1 class="">Choose Your Course</h1>
            <p class="text-center mb-5">
                Choose a specialization according to your passion. We provide two categories which are divided into Information Technology and construction engineering, in which there is a choice of courses that you can take
            </p>

            <div class="row justify-content-md-center gap-3">
                <div class="col-4">
                    <div class="my-card course">
                        <div class="image">
                            <img src="image/home/choose_course2.png" alt="img">
                        </div>
                        <div class="body">
                            <h2>Information Tech (IT)</h2>
                            <p>
                                Intensive program to learn to be a digital talent in Information Tech (IT)
                            </p>
                        </div>
                        <a href="">
                            <button class="my-btn btn-full">See Course</button>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="my-card course">
                        <div class="image">
                            <img src="image/home/choose_course.png" alt="img">
                        </div>

                        <div class="body">
                            <h2>Constructions</h2>
                            <p>
                                Intensive program to learn to be a digital talent in Construction Engineering
                            </p>
                        </div>

                        <a href="">
                            <button class="my-btn btn-full">See Course</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="courses-bundling">
        <div class="my-container">
            <h1 class="">Take several courses with a choice of bundling packages!</h1>

            <div class="row justify-content-md-center gap-4 py-3">
                <div class="col-md-3 px-0">
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
                </div>
                <div class="col-md-3 px-0">
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
                </div>
                <div class="col-md-3 px-0">
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
                </div>
            </div>
        </div>
    </div>

    <div class="my-container">
        <nav class="mt-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li> -->
                <li class="breadcrumb-item active" aria-current="page">Bundling</li>
            </ol>
            <hr>
        </nav>

        <div class="courses-bundlings">
            <h2>Paket yang tersedia</h2>

            <div class="tags pt-2 pb-4">
                <div class="item active">Semua Paket</div>
                <div class="item">Frontend</div>
                <div class="item">Backend</div>
                <div class="item">Mobile</div>
                <div class="item">UI/UX</div>
                <div class="item">Data Science</div>
                <div class="item">IT</div>
                <div class="item">Construction</div>
            </div>

            <div class="row gap-0 py-3">
                <div class="col-md-3 pe-4 pb-4 ps-0">
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
                </div>
                <div class="col-md-3 pe-4 pb-4 ps-0">
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
                </div>
                <div class="col-md-3 pe-4 pb-4 ps-0">
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
                </div>
                <div class="col-md-3 pe-4 pb-4 ps-0">
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
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="js/home/courses.js"></script>
<?= $this->endSection() ?>