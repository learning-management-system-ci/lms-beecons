<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="../../../image/logo.png" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarApp" aria-controls="navbarApp" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarApp">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item">
                    <a class="nav-link mx-2 active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 active" href="">Webinar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 active" href="<?= base_url('/courses') ?>">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 active" href="<?= base_url('/faq') ?>">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 active" href="<?= base_url('/about-us') ?>">About Us</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item me-3">
                    <div class="nav-item-search">
                        <div class="nav-search-input">
                            <form action="">
                                <input class="form-control border" placeholder="search">
                            </form>
                            <i class="fa-solid fa-xmark" id="nav-btn-search-x"></i>
                        </div>
                        <button class="nav-btn-icon my-1" id="nav-btn-search" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <div class="dropdown-menu my-2" aria-labelledby="nav-btn-search">
                            <div id="search-result-initial">
                                <div class="p-2 border-bottom">
                                    <h5 class="ctg">Recent</h5>
                                    <div id="search-recent"></div>
                                </div>
                                <div class="p-2">
                                    <h5 class="ctg">Rekomendasi</h5>
                                    <div id="search-rekomendasi"></div>
                                </div>
                            </div>
                            <div id="search-result" class="p-2"></div>
                        </div>
                    </div>
                </li>
                <li class="nav-item me-3">
                    <a href="/cart">
                        <button class="nav-btn-icon my-1">
                            <div class="nav-btn-icon-amount">5</div>
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                    </a>
                </li>
                <li class="nav-item me-3">
                    <div class="dropdown nav-item-icon">
                        <button class="nav-btn-icon my-1" id="dropdown-notification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <div class="nav-btn-icon-amount">2</div> -->
                            <i class="fa-solid fa-bell"></i>
                        </button>
                        <div class="dropdown-menu my-2 notifications" aria-labelledby="dropdown-notification">
                            <div class="header shadow-sm">
                                <h3 class="mb-0">Notifikasi</h3>
                                <a href="" class="notifications-baca">Sudah dibaca</a>
                            </div>
                            <?php if (!get_cookie("access_token")) : ?>
                                <div class="content">
                                    <h3>Kamu belum daftar</h3>
                                    <p>
                                        Silakan daftar terlebih dahulu untuk melihat detail keranjang belanja kamu dan
                                        melakukan transaksi pembelian
                                    </p>
                                    <a href="<?= base_url('/login') ?>" class="nav-link-btn">
                                        <button class="my-btn btn-sign-in">Sign in</button>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="notifications-list">
                                    <div class="notif unread">
                                        <a href="" class="">
                                            <div class="icon">
                                                <img src="/image/home/notif-icon.png" alt="icon">
                                            </div>
                                            <div class="item">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam,
                                                    quae.
                                                </p>
                                                <span>1 jam yang lalu</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="notif unread">
                                        <a href="" class="">
                                            <div class="icon">
                                                <img src="/image/home/notif-icon.png" alt="icon">
                                            </div>
                                            <div class="item">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam,
                                                    quae.
                                                </p>
                                                <span>1 jam yang lalu</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="notif">
                                        <a href="" class="">
                                            <div class="icon">
                                                <img src="/image/home/notif-icon.png" alt="icon">
                                            </div>
                                            <div class="item">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam,
                                                    quae.
                                                </p>
                                                <span>1 jam yang lalu</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="notif">
                                        <a href="" class="">
                                            <div class="icon">
                                                <img src="/image/home/notif-icon.png" alt="icon">
                                            </div>
                                            <div class="item">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam,
                                                    quae.
                                                </p>
                                                <span>1 jam yang lalu</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </li>
                <?php if (!get_cookie("access_token")) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/login') ?>" class="nav-link-btn">
                            <button class="my-btn btn-sign-in">Sign in</button>
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <div class="dropdown nav-item-profile">
                            <button class="nav-btn-profile" id="dropdown-profile" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="../../../image/home/people.jpg" class="nav-profile me-1" alt="">
                            </button>
                            <div class="dropdown-menu mt-2" aria-labelledby="dropdown-profile">
                                <a href="<?= base_url('/profile') ?>" class="dropdown-item">Profile</a>
                                <a href="<?= base_url('/') ?>" class="dropdown-item" id="btn-logout">Logout</a>
                            </div>
                        </div>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>