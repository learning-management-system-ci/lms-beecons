<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/profile.css">
<link rel="stylesheet" href="style/loading.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<?= $this->include('components/profile/edit_modal') ?>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<div class="container text-center">
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
                    <div class="col-12" id="user-courses">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->section('js-component') ?>
<script src="../../../js/api/profile/index.js"></script>
<script src="../../../js/api/profile/edit_profile.js"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>