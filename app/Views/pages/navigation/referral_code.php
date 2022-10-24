<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="../../../style/profile.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<?= $this->include('components/profile/edit_modal') ?>
<div class="container">
    <div class="row">
        <div class="col-20">
            <?= $this->include('components/profile/sidebar') ?>
        </div>
        <div class="col mb-2">
            <h4 class="mb-4">Kamu akan mendapatkan diskon untuk pembelian kelas selanjutnya dengan membagikan kode
                referral-mu!</h4>
            <div class="row">
                <div class="col referral">
                    <div class="content d-flex align-items-start flex-column mb-2" style="height: 175px;">
                        <h5 class="text-uppercase font-weight-light mb-2">Referral Code</h5>
                        <div class="d-flex align-items-center flex-row mb-2">
                            <h4 class="m-0 me-2">ReferralCode</h4>
                            <button type="button" class="btn-grey-200" style="height: 30px; border-radius: 5px;">
                                Copy
                            </button>
                        </div>
                        <div class="card mb-auto">
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-12x">
                                    <img src="image/auth-image.png" class="course-image me-1" alt="">
                                </div>
                                <div class="col d-flex align-items-start flex-column" style="height: 35px;">
                                    <h5 class="mb-auto">10 Orang</h5>
                                    <p class="m-0">Menerima kode referral anda</p>
                                </div>
                            </div>
                        </div>
                        <div class="card hide expand" href="#voucher" role="button">
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-12x">
                                    <img src="image/auth-image.png" class="course-image me-1" alt="">
                                </div>
                                <div class="col d-flex align-items-start flex-column" style="height: 35px;">
                                    <h5 class="mb-auto">5 Voucher</h5>
                                    <p class="m-0">Lihat voucher kamu disini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card voucher-container collapse" id="voucher">
                        <h5>Voucher</h5>
                        <div class="row">
                            <div class="col mb-4 voucher">
                                <img style="height: inherit;" src="image/profile/voucher.png" alt="">
                            </div>
                            <div class="col mb-4 voucher">
                                <img style="height: inherit;" src="image/profile/voucher.png" alt="">
                            </div>
                            <div class="col mb-4 voucher">
                                <img style="height: inherit;" src="image/profile/voucher.png" alt="">
                            </div>
                            <div class="col mb-4 voucher">
                                <img style="height: inherit;" src="image/profile/voucher.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col referral">
                    <div class="card rule">
                        <div>
                            <h5>Cara memiliki Referral Code</h5>
                            <ol class="ps-3">
                                <li>
                                    Buat akun pada website
                                </li>
                                <li>
                                    Buat akun pada website
                                </li>
                            </ol>
                        </div>
                        <div>
                            <h5>Cara memiliki Referral Code</h5>
                            <ol class="ps-3">
                                <li>
                                    Buat akun pada website
                                </li>
                                <li>
                                    Buat akun pada website
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->section('js-component') ?>
<script src="../../../js/api/referral/index.js"></script>
<script src="../../../js/api/profile/index.js"></script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>