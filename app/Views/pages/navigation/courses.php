<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="/style/loading.css">
<link rel="stylesheet" href="../../../style/courses.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>

<div id="courses">
    <div class="courses-list pt-4">
        <div class="container">
            <div class="pb-5">
                <div class="text-end mb-4">
                    <span class="btn-filter-wrapper">
                        <button class="app-btn btn-filter">
                            <span>Filters</span>
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <div class="filter-container d-none">
                            <div class="filter-container__header">
                                <h3>Filters</h3>
                                <a href="" id="btn-clearall">Clear all</a>
                            </div>
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-bidang">
                                            Bidang
                                        </button>
                                    </h2>
                                    <div id="accordion-bidang" class="accordion-collapse p-2 collapse show">
                                        <div class="filter-item text-start">
                                            <div class="d-flex gap-2">
                                                <input type="checkbox" name="bidang" value="engineering">
                                                <label>Engineering</label>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <input type="checkbox" name="bidang" value="it">
                                                <label>IT</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-kelas">
                                            Kelas
                                        </button>
                                    </h2>
                                    <div id="accordion-kelas" class="accordion-collapse p-2 collapse">
                                        <div class="filter-item text-start"></div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-tingkat">
                                            Tingkat
                                        </button>
                                    </h2>
                                    <div id="accordion-tingkat" class="accordion-collapse p-2 collapse">
                                        <div class="filter-item text-start"></div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-apply app-btn btn-full mt-3">Apply</button>
                        </div>
                    </span>
                </div>

                <div id="courses-loading">
                    <div class="stage">
                        <div class="dot-pulse">
                        </div>
                    </div>
                </div>

                <div id="courses-list" class="row"></div>

                <!-- PAGINATION -->
                <div class="courses-pagination mt-5">
                    <div class="btn-pgn-prev-wrapper"></div>
                    <div class="btn-pgn-wrapper"></div>
                    <div class="btn-pgn-next-wrapper"></div>
                </div>
                <!-- END PAGINATION -->
            </div>



            <div class="bg-white rounded courses-list border d-none">
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

                        <!-- PAGINATION -->
                        <div class="courses-pagination mt-5">
                            <div class="btn-pgn-prev-wrapper"></div>
                            <div class="btn-pgn-wrapper"></div>
                            <div class="btn-pgn-next-wrapper"></div>
                        </div>
                        <!-- END PAGINATION -->
                    </div>
                    <div class="tab-pane fade" id="tab-courses-it" role="tabpanel">
                        <div class="tags pt-2 pb-4"></div>

                        <h2 class="text-center mb-4 current-tag"></h2>

                        <div class="sub-tags mb-5"></div>

                        <div id="courses-it" class="row px-5"></div>

                        <!-- PAGINATION -->
                        <div class="courses-pagination mt-5">
                            <div class="btn-pgn-prev-wrapper"></div>
                            <div class="btn-pgn-wrapper"></div>
                            <div class="btn-pgn-next-wrapper"></div>
                        </div>
                        <!-- END PAGINATION -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="container">
            <div class="courses-bundling">
                <div class="my-container">
                    <h1 class="">Ikuti beberapa kursus dengan pilihan paket bundling!</h1>

                    <div class="courses-bundling-loading">
                        <div class="stage">
                            <div class="dot-pulse">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-md-center gap-4 py-3 courses-bundling-rekomendasi"></div>
                </div>
            </div>
            <nav class="mt-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Bundling</li>
                </ol>
                <hr>
            </nav>

            <div class="courses-bundlings">
                <h2>Paket yang tersedia</h2>

                <div class="courses-bundling-loading">
                    <div class="stage">
                        <div class="dot-pulse">
                        </div>
                    </div>
                </div>

                <div class="tags pt-2 pb-4"></div>

                <div class="courses-bundling-list py-2"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="../../../js/utils/getRupiah.js"></script>
<script src="../../../js/utils/textTruncate.js"></script>
<script src="../../../js/home/courses2.js"></script>
<script src="../../../js/home/courses-bundling.js"></script>
<?= $this->endSection() ?>