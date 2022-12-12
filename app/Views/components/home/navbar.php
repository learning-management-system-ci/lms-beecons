<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container container-fluid">
        <a class="navbar-brand" href="/">
            <img src="../../../image/logo.svg" alt="logo" height="60px" width="60px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarApp" aria-controls="navbarApp" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarApp">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item">
                    <a class="nav-link mx-2 <?php if (uri_string() == '/') : echo 'active';
                                            endif ?>" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 <?php if (uri_string() == 'courses' || str_contains(uri_string(), 'course')) : echo 'active';
                                            endif ?>" href="/courses">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 <?php if (uri_string() == 'training') : echo 'active';
                                            endif ?>" href="/training">Training</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 <?php if (uri_string() == 'webinar') : echo 'active';
                                            endif ?>" href="/webinar">Webinar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 <?php if (uri_string() == 'faq') : echo 'active';
                                            endif ?>" href="/faq">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 <?php if (uri_string() == 'about-us') : echo 'active';
                                            endif ?>" href="/about-us">About Us</a>
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
                        <button class="nav-btn-icon my-1" id="cart-count">
                            <!-- <div class="nav-btn-icon-amount">0</div> -->
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                    </a>
                </li>
                <li class="nav-item me-3">
                    <div class="dropdown nav-item-icon">
                        <button class="nav-btn-icon my-1" id="dropdown-notification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <div class="nav-btn-icon-amount">0</div> -->
                            <i class="fa-solid fa-bell"></i>
                        </button>
                        <div class="dropdown-menu notifications dropdown-menu-end" aria-labelledby="dropdown-notification">
                            <div class="header shadow-sm">
                                <h3 class="mb-0">Notifikasi</h3>
                                <?php if (get_cookie("access_token")) : ?>
                                    <a href="" class="notifications-baca">Sudah dibaca</a>
                                <?php endif ?>
                            </div>
                            <?php if (!get_cookie("access_token")) : ?>
                                <div class="content">
                                    <h3>Kamu belum daftar</h3>
                                    <p>
                                        Silakan daftar terlebih dahulu untuk melihat detail keranjang belanja kamu dan
                                        melakukan transaksi pembelian
                                    </p>
                                    <a href="/login" class="nav-link-btn">
                                        <button class="my-btn btn-sign-in">Sign in</button>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="notifications-list"></div>
                            <?php endif ?>
                        </div>
                    </div>
                </li>
                <?php if (!get_cookie("access_token")) : ?>
                    <li class="nav-item">
                        <a href="/login" class="nav-link-btn">
                            <button class="my-btn btn-sign-in">Sign in</button>
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <div class="dropdown nav-item-profile">
                            <button class="nav-btn-profile bg-transparent" id="dropdown-profile" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="dropdown-profile">
                                <a href="/profile" class="dropdown-item">Profile</a>
                                <a href="/" class="dropdown-item" id="btn-logout">Logout</a>
                            </div>
                        </div>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>