<?php helper("cookie"); ?>
<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="/style/loading.css">
<link rel="stylesheet" href="style/cart.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div id="cart" class="container">
    <?php if (!get_cookie("access_token")) : ?>
        <div class="section-no-login">
            <h1 class="mb-3">Kamu belum masuk</h1>
            <p class="mb-5">Silahkan login terlebih dahulu untuk melanjutkan transaksi pembelian course atau webinar</p>

            <a href="<?= base_url('/login') ?>" class="nav-link-btn">
                <button class="app-btn">Sign in</button>
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

            <div id="loading">
                <div class="stage">
                    <div class="dot-pulse">
                    </div>
                </div>
            </div>

            <hr>
        </section>
        <section class="voucher-order-total d-flex justify-content-between align-items-start">
            <div class="">

            </div>
            <div class="order-total">
                <div class="d-flex justify-content-between">
                    <h6>TOTAL</h6>
                    <h6 class="cart-total-final">Rp. 0</h6>
                </div>
                <a href="/checkout">
                    <button class="app-btn w-100 mt-3" id="checkout">Check Out</button>
                </a>
            </div>
        </section>
    <?php endif ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="../../../js/utils/getRupiah.js"></script>
<script src="js/cart/cart.js"></script>
<?= $this->endSection() ?>