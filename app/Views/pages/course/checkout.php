<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/checkout.css">
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div class="px-5 mt-4 mb-5">
    <!-- <section class="navigation">
        <p class="mb-4"><b>Cart</b></p>
        <hr>
    </section> -->
    <section class="checkout-main d-flex justify-content-between align-items-start">
        <div class="order-list-section">
            <h4 class="mb-3">Pesanan</h4>
            <div class="order-item mb-4">
                <div class="order-list-detail d-flex">
                    <img src="image/cart/ux-banner.png" alt="">
                    <div class="order-desc">
                        <p class="mb-3 course-badge">
                            Course
                        </p>
                        <h5 class="title">Frontend:</h5>
                        <h5 class="desc">Pelajaran dasar yang dipelajari untuk menjadi frontend engineer</h5>
                    </div>
                </div>
                <div class="order-list-subtotal mt-3">
                    <hr>
                    <div class="d-flex justify-content-between my-1">
                        <h5>Subtotal</h5>
                        <h5>Rp. 100.000</h5>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="order-item mb-4">
                <div class="order-list-detail d-flex">
                    <img src="image/cart/frontend-banner.png" alt="">
                    <div class="order-desc">
                        <p class="mb-3 bundling-badge">
                            Bundling
                        </p>
                        <h5 class="title">Frontend:</h5>
                        <h5 class="desc">Pelajaran dasar yang dipelajari untuk menjadi frontend engineer</h5>
                    </div>
                </div>
                <div class="order-list-subtotal mt-3">
                    <hr>
                    <div class="d-flex justify-content-between my-1">
                        <h5>Subtotal</h5>
                        <h5>Rp. 100.000</h5>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="order-item mb-4">
                <div class="order-list-detail d-flex">
                    <img src="image/cart/frontend-banner.png" alt="">
                    <div class="order-desc">
                        <p class="mb-3 webinar-badge">
                            Bundling
                        </p>
                        <h5 class="title">Frontend:</h5>
                        <h5 class="desc">Pelajaran dasar yang dipelajari untuk menjadi frontend engineer</h5>
                    </div>
                </div>
                <div class="order-list-subtotal mt-3">
                    <hr>
                    <div class="d-flex justify-content-between my-1">
                        <h5>Subtotal</h5>
                        <h5>Rp. 100.000</h5>
                    </div>
                    <hr>
                </div>
            </div>

        </div>
        <div class="order-summary-card p-4">
            <h4 class="mb-4">
                Ringkasan Biaya
            </h4>
            <div class="total-count-prize d-flex justify-content-between">
                <h5 class="total">Total (3 item)</h5>
                <h5 class="prize">Rp. 1.300.000</h5>
            </div>
            <div class="coupon-prize d-flex justify-content-between">
                <h5 class="coupon">Coupon</h5>
                <h5 class="prize">20%</h5>
            </div>
            <div class="final-prize d-flex justify-content-between align-items-center p-2 mt-2">
                <p>Pembayaran Penuh</p>
                <h5>Rp. 1.040.000</h5>
            </div>
            <hr>
            <p class="email">Email</p>
            <p class="user-email p-1 mt-1">bellafitria@gmail.com</p>
            <button class="mt-2 py-2">Lanjutkan ke Pembayaran</button>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/home/cart.js"></script>
<?= $this->endSection() ?>