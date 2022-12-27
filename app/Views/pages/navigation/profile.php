<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/profile.css">
<link rel="stylesheet" href="style/loading.css">
<link rel="stylesheet" href="style/fileinput.css">
<link rel="stylesheet" href="style/fileinput-rtl.css">
<link rel="stylesheet" href="/style/course-detail.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<?= $this->include('components/profile/edit_modal') ?>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<div class="container mt-4 text-center">
    <div class="row">
        <div class="col-20">
            <?= $this->include('components/profile/sidebar') ?>
        </div>
        <div class="col profile">
            <h4 class="text-start">My Profile</h4>
            <div class="row">
                <div class="col" style="padding: 0 10px 0 0;">
                    <div class="profile-data"></div>
                </div>
                <div class="col-3" style="padding: 0 0 0 10px;">
                    <div class="card">
                        <h5 class="text-start pb-2">Upcoming webinar</h5>
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
                        <p class="font-weight-light" id="created_at">For 3 months</p>
                    </div>
                    <div class="col">
                        <div class="progress" style="height: 15px; background-color: #FFE5A1;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h4 class="font-weight-bold progress-percent">
                            0%
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card">
                <h4 class="text-start">Ongoing courses</h4>
                <div class="row">
                    <div class="col-12" id="user-courses">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-review-group">
                        <label for="rating">Bagaimana Pengalaman Belajar Kamu?</label>
                        <div class="rating-input">
                            <label>
                                <input type="radio" name="rating" value="1" />
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="2" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="3" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="4" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="5" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                        </div>
                    </div>
                    <div class="input-review-group">
                        <label for="reviewText">Berikan ulasan dari kelas yang kamu ikuti</label>
                        <textarea class="form-control" id="reviewText" placeholder="Silahkan tulis ulasan disini..."
                            rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <button type="button" class="app-btn" id="reviewSubmit" disabled>Kirim</button>
            </div>
        </div>
    </div>
</div>
<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../../js/api/profile/index.js"></script>
<script src="../../../js/api/profile/edit_profile.js"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>