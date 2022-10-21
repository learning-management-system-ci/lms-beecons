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
            <form id="cart-form-redeem">
                <div class="input-group mb-3 d-none">
                    <input type="text" class="form-control" placeholder="Kode Voucher" required>
                    <button type="submit" id="redeem" class="my-btn">Redeem</button>
                </div>
            </form>
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
                <button class="my-btn w-100 mt-3" id="checkout">Check Out</button>
            </div>
        </section>
    <?php endif ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../../js/utils/getRupiah.js"></script>
<script src="js/home/cart.js"></script>
<?= $this->endSection() ?>