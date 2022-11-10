<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/checkout.css">
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-qsGN92Rh94gid13G"></script>
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div class="px-5 mt-4 mb-5">
    <!-- <section class="navigation">
        <p class="mb-4"><b>Cart</b></p>
        <hr>
    </section> -->
    <section class="checkout-main d-flex justify-content-between align-items-start">
        <div class="order-list-section" id="checkout-items-content">
            <h4 class="mb-3">Pesanan</h4>
        </div>
        <div class="order-summary-card p-4">
            <h4 class="mb-4">
                Ringkasan Biaya
            </h4>
            <div class="total-count-prize d-flex justify-content-between">
                <h5 class="total" id="checkout-itemsCount-content">Total (0 item)</h5>
                <h5 class="prize" id="checkout-subtotal">Rp. 0</h5>
            </div>
            <div class="coupon-prize d-flex justify-content-between">
                <h5 class="coupon">Coupon</h5>
                <h5 class="prize" id="checkout-code-discount">-</h5>
            </div>
            <button type="button" class="btn-modal-referral border border-2" data-bs-toggle="modal" data-bs-target="#cart-referral-modal">
                <span>
                    <img src="/image/cart/referral-icon.png" alt="icon">
                </span>
                <span>
                    Pakai promo atau referral
                </span>
            </button>
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
                                        <input type="text" id="redeem-input" class="form-control" name="code" placeholder="Masukkan kode promo atau referral" required>
                                        <button type="submit" id="redeem-btn" class="my-btn">Redeem</button>
                                    </form>
                                </div>
                            </div>

                            <div class="cart-referral-modal-vouchers pt-3">
                                <h6 class="m-0">Voucher yang kamu punya</h6>
                                <small>Hanya bisa pilih 1 kupon</small>

                                <div id="cart-voucher-list" class="row m-0 pt-3">
                                    <!-- <div class="col-6 pb-3 pe-2 ps-0">
                                        <button class="cart-referral-modal-coucher-btn">
                                            <div class="referral-item">
                                                <div class="icon">
                                                    <img src="/image/cart/voucher-icon.png" alt="">
                                                </div>
                                                <div class="disc">
                                                    15%
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="col-6 pb-3 pe-2 ps-0">
                                        <button class="cart-referral-modal-coucher-btn">
                                            <div class="referral-item">
                                                <div class="icon">
                                                    <img src="/image/cart/voucher-icon.png" alt="">
                                                </div>
                                                <div class="disc">
                                                    15%
                                                </div>
                                            </div>
                                        </button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="final-prize d-flex justify-content-between align-items-center p-2 mt-2">
                <p>Pembayaran Penuh</p>
                <h5 id="checkout-total">Rp. 0</h5>
            </div>

            <hr>

            <p class="email">Email</p>
            <p class="user-email p-1 mt-1" id="checkout-email">example@gmail.com</p>
            
            <button class="mt-2 py-2"id="checkout-btn">Lanjutkan ke Pembayaran</button>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/home/cart.js"></script>
<script src="js/utils/getRupiah.js"></script>
<script src="js/api/checkout/checkout.js"></script>
<?= $this->endSection() ?>