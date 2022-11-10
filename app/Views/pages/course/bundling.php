<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="../../../style/bundling.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="px-5 mt-4">
    <!-- <section class="navigation">
        <p class="mb-4">Courses > <a href="#"> Mastering Frontend Developer</a></p>
        <hr>
    </section> -->
    <section class="bundle d-flex mt-4">
        <div class="left-section">
            <h3>Mastering Frontend Developer</h3>
            <div class="level">Fundamental</div>
            <p class="description mt-4">In this bundling, you will learn how to become a professional front-end
                developer. Two courses will
                be obtained, and
                several video materials and evaluations will be in each class.</p>
            <h5>There are 2 courses in this bundling</h5>
            <ul class="mt-4">
                <li>
                    <div class="list-course d-flex">
                        <div class="course-number">
                            Course <br>
                            1
                        </div>
                        <div class="course-name">
                            <h5>ReactJS</h5>
                            <p>8 Video</p>
                        </div>
                    </div>
                    <hr>
                </li>
                <li>
                    <div class="list-course d-flex">
                        <div class="course-number">
                            Course <br>
                            2
                        </div>
                        <div class="course-name">
                            <h5>NodeJS</h5>
                            <p>19 Video</p>
                        </div>
                    </div>
                    <hr>
                </li>
            </ul>
        </div>
        <div class="right-section">
            <div class="order-card">
                <h4>Order Summary</h4>
                <p class="mt-4 mb-1">Mastering Frontend Developer</p>
                <ul>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                ReactJS
                            </p>
                            <p class="order-price mb-2">
                                Rp.200.000
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                NodeJS
                            </p>
                            <p class="order-price mb-2">
                                Rp.400.000
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                Platform Fee
                            </p>
                            <p class="order-price mb-2">
                                Rp.10.000
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="order-list mb-2">
                                Flash Sale Discount
                            </p>
                            <p class="order-price mb-2 text-decoration-line-through">
                                Rp.200.000
                            </p>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="order-total d-flex justify-content-between">
                    <h5>Order Total</h5>
                    <h5>Rp.610.000</h5>
                </div>
                <div class="discount-info mt-2 text-center p-3">
                    Awesome! You saved a total of <b>Rp 200.000</b> on your order.
                </div>
                <button class="mt-2">Checkout</button>
            </div>
            <div class="cheap-info text-center mt-3">
                <img src="/image/bundling/Wallet.png" width="75px">
                <h5>Cheaper + Worthy</h5>
                <p>The most affordable price with many benefits you can get</p>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>