<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="style/cart.css">
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div class="container mt-4 mb-5">
    <section class="navigation">
        <p class="mb-4">Home > <a href="#"> Cart</a></p>
        <hr>
    </section>
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
                    <button id="remove">
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
                    <button id="remove">
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
                    <button id="remove">
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
        <form class="mb-3 voucher d-flex align-items-center">
            <input type="text" class="form-control" placeholder="Kode Voucher" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <span>
                <button id="redeem">Redeem</button>
            </span>
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
            <button class="mt-3" id="checkout">Check Out</button>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/home/cart.js"></script>
<?= $this->endSection() ?>