<?php helper("cookie"); ?>
<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="style/cart.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div id="cart" class="main-container mb-5">
    <!-- <section>
        <nav class="pt-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
            <hr>
        </nav>
    </section> -->
    <?php if (!get_cookie("access_token")) : ?>
        <div class="section-no-login">
            <h1 class="mb-3">Kamu belum masuk</h1>
            <p class="mb-5">Silahkan login terlebih dahulu untuk melanjutkan transaksi pembelian course atau webinar</p>

            <a href="<?= base_url('/login') ?>" class="nav-link-btn">
                <button class="my-btn">Sign in</button>
            </a>
        </div>
    <?php else : ?>
        <section class="cart-list mb-4" id="cart-list">
            <table width="100%" cellpadding="5" cellspacing="5">
                <thead>
                    <tr id="field-name">
                        <th>
                            <h6>PESANAN</h6>
                        </th>
                        <th>
                            <h6>UNIT PRICE</h6>
                        </th>
                        <th>
                            <h6>PRICE</h6>
                        </th>
                    </tr>
                </thead>

                <tbody></tbody>
            </table>

            <hr>
        </section>
        <section class="voucher-order-total d-flex justify-content-between align-items-start">
            <!-- <form id="cart-form-redeem">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Kode Voucher" required>
                    <button type="submit" id="redeem" class="my-btn">Redeem</button>
                </div>
            </form> -->
            <div class="">
                <button type="button" class="btn-modal-referral border border-2" data-bs-toggle="modal" data-bs-target="#cart-referral-modal">
                    <span>
                        <img src="/image/cart/referral-icon.png" alt="icon">
                    </span>
                    <span>
                        Pakai promo atau referral
                    </span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="cart-referral-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog my-0">
                        <div class="modal-content">
                            <div class="cart-referral-modal-container">
                                <div class="cart-referral-modal-header">
                                    <h5 class="m-0">Promo</h5>
                                    <div class="cart-referral-modal-header-btn">
                                        <a href="/cart">Reset Diskon</a>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                </div>

                                <div class="cart-referral-modal-form py-3">
                                    <h6 class="m-0">Kode voucher</h6>
                                    <small>Hanya bisa pilih 1 kupon</small>
                                    <div>
                                        <form id="cart-referral-modal-form">
                                            <input type="text" class="form-control" name="code" placeholder="Masukkan kode promo atau referral" required>
                                            <button type="submit" id="redeem" class="my-btn">Redeem</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="cart-referral-modal-vouchers pt-3">
                                    <h6 class="m-0">Voucher yang kamu punya</h6>
                                    <small>Hanya bisa pilih 1 kupon</small>

                                    <div class="row py-2">
                                        <div class="col-6 pb-3 pe-2">
                                            <div class="referral-item">
                                                <div class="icon">
                                                    <img src="/image/cart/voucher-icon.png" alt="">
                                                </div>
                                                <div class="disc">
                                                    15%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 pb-3 pe-2">
                                            <div class="referral-item">
                                                <div class="icon">
                                                    <img src="/image/cart/voucher-icon.png" alt="">
                                                </div>
                                                <div class="disc">
                                                    15%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 pb-3 pe-2">
                                            <div class="referral-item">
                                                <div class="icon">
                                                    <img src="/image/cart/voucher-icon.png" alt="">
                                                </div>
                                                <div class="disc">
                                                    15%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-total">
                <div class="d-none">
                    <div class="d-flex justify-content-between mb-2">
                        <p>Total</p>
                        <p class="cart-total"></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Coupon</p>
                        <p>20%</p>
                    </div>
                    <hr>
                </div>
                <div class="d-flex justify-content-between">
                    <h6>TOTAL</h6>
                    <h6 class="cart-total">Rp. 0</h6>
                </div>
                <a href="/checkout">
                    <button class="my-btn w-100 mt-3" id="checkout">Check Out</button>
                </a>
            </div>
        </section>
    <?php endif ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../../js/utils/getRupiah.js"></script>
<script src="js/cart/cart.js"></script>
<?= $this->endSection() ?>