<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="../../../style/profile.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="container text-center">
    <div class="row">
        <div class="col-2">
            <?= $this->include('components/profile/sidebar') ?>
        </div>
        <div class="col profile">
            <h4 class="text-start">My Profile</h4>
            <div class="row">
                <div class="col" style="padding: 0 10px 0 0;">
                    <div class="card">
                        <div class="row py-2 px-1">
                            <div class="col-12x">
                                <img src="image/auth-image.png" class="image-circle me-1" alt="">
                            </div>
                            <div class="col">
                                <div class="row px-5">
                                    <div class="col-12 text-start">
                                        <h4>Bella Fitria</h4>
                                    </div>
                                    <div class="col-12 text-start">
                                        <p class="font-weight-bold">Software Engineer</p>
                                    </div>
                                    <div class="col-12 text-start">
                                        <p>Alamat</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <i class="fa-solid fa-pencil"></i>
                            </div>
                        </div>
                        <hr class="my-1 mb-2">
                        <div class="row ">
                            <div class="col-6">
                                <div class="row">
                                    <div class="text-start">Tanggal Lahir</div>
                                    <div class="text-start">No HP</div>
                                    <div class="text-start">Email</div>
                                    <div class="text-start">LinkedIn</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="text-end">aijdbash</div>
                                    <div class="text-end">aijdbash</div>
                                    <div class="text-end">aijdbash</div>
                                    <div class="text-end">aijdbash</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" style="padding: 0 0 0 10px;">
                    <div class="card">
                        <h4 class="text-start">Upcoming webinar</h4>
                        <?= $this->include('components/card_component') ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row d-flex justify-content-between align-items-center text-start">
                    <div class="col-20">
                        <h5 class="font-weight-bold">
                            Learning Progress
                        </h5>
                        <p class="font-weight-light">For 3 months</p>
                    </div>
                    <div class="col">
                        <div class="progress" style="height: 15px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 50%;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-1">
                        <h4 class="font-weight-bold">
                            59%
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card">
                <h4 class="text-start">Ongoing courses</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12x">
                                <img src="image/auth-image.png" class="course-image me-1" alt="">
                            </div>
                            <div class="col text-start">
                                Something beside
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<?= $this->section('js-component') ?>
<script src="../../../js/api/profile/index.js"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="js/home/faq.js"></script>
<?= $this->endSection() ?>