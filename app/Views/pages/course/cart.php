<?php helper("cookie"); ?>
<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="style/cart.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div id="cart" class="main-container mb-5">
    <section>
        <nav class="pt-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
            <hr>
        </nav>
    </section>
    <?php if (!get_cookie("access_token")) : ?>
        <div class="section-no-login">
            <h1 class="mb-3">Kamu belum masuk</h1>
            <p class="mb-5">Silahkan login terlebih dahulu untuk melanjutkan transaksi pembelian course atau webinar</p>

            <a href="<?= base_url('/login') ?>" class="nav-link-btn">
                <button class="my-btn">Sign in</button>
            </a>
        </div>
    <?php else : ?>
        <section class="cart-list mb-4">
            <table width="100%" cellpadding="5" cellspacing="5">
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

                <tr id="record-data">
                    <td class="d-flex align-items-center mb-4 mt-4">
                        <button id="remove" class="cart-btn-remove">
                            <img src="image/cart/xbutton.png" alt="">
                        </button>
                        <img src="image/cart/frontend-banner.png" alt="">
                        <h6>Frontend Development</h6>
                    </td>
                    <td>
                        <p>Rp. 200.000</p>
                    </td>
                    <td>
                        <p>Rp. 160.000</p>
                    </td>
                </tr>

                <tr id="record-data">
                    <td class="d-flex align-items-center mb-4 mt-4">
                        <button id="remove" class="cart-btn-remove">
                            <img src="image/cart/xbutton.png" alt="">
                        </button>
                        <img src="image/cart/ux-banner.png" alt="">
                        <h6>UI/UX Design (Advanced Class)</h6>
                    </td>
                    <td>
                        <div class="price">
                            <p class="strike">Rp. 200.000</p>
                            <p class="discount">20%</p>
                        </div>
                    </td>
                    <td>
                        <div class="price">
                            <p>Rp. 160.000</p>
                        </div>
                    </td>
                </tr>
                <tr id="record-data">
                    <td class="d-flex align-items-center mb-4 mt-4">
                        <button id="remove" class="cart-btn-remove">
                            <img src="image/cart/xbutton.png" alt="">
                        </button>
                        <img src="image/cart/ux-banner.png" alt="">
                        <h6>UI/UX Design (Advanced Class)</h6>
                    </td>
                    <td>
                        <div class="price">
                            <p class="strike">Rp. 200.000</p>
                            <p class="discount">20%</p>
                        </div>
                    </td>
                    <td>
                        <div class="price">
                            <p>Rp. 160.000</p>
                        </div>
                    </td>
                </tr>

            </table>

            <hr>
        </section>
        <section class="voucher-order-total d-flex justify-content-between align-items-start">
            <form id="cart-form-redeem">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Kode Voucher" required>
                    <button type="submit" id="redeem" class="my-btn">Redeem</button>
                </div>
            </form>
            <div class="order-total">
                <div class="d-flex justify-content-between mb-2">
                    <p>Subtotal</p>
                    <p>Rp. 219.000</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p>Coupon</p>
                    <p>20%</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h6>TOTAL</h6>
                    <h6>Rp. 219.000</h6>
                </div>
                <button class="my-btn w-100 mt-3" id="checkout">Check Out</button>
            </div>
        </section>
    <?php endif ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/home/cart.js"></script>
<?= $this->endSection() ?>