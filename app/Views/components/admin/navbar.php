<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <?php if (str_contains(uri_string(), 'admin')) : ?>
                    <?php
                    switch (uri_string()) {
                        case "admin":
                    ?>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
                        <?php
                            break;
                        case "admin/user":
                        ?>
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/admin">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">User</li>
                        <?php
                            break;
                        case "admin/course":
                        ?>
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/admin">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Course</li>
                        <?php
                            break;
                        case "admin/transaction":
                        ?>
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/admin">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Transaction</li>
                        <?php
                            break;
                        case "admin/contact":
                        ?>
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="/admin">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Contact Us Message</li>
                    <?php
                            break;
                        default:
                            echo "somerthing wrong";
                    } ?>
                <?php endif; ?>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0"><?= $title ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
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
                    <div class="dropdown nav-item-icon">
                        <button class="nav-btn-icon my-1" id="dropdown-notification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <div class="nav-btn-icon-amount">0</div> -->
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
                                    <a href="/login" class="nav-link-btn">
                                        <button class="my-btn btn-sign-in">Sign in</button>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="notifications-list">
                                    <!-- unread notification -->
                                    <!-- <div class="notif unread">
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
                                    </div> -->
                                    <!-- readed notification -->
                                    <!-- <div class="notif">
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
                                    </div> -->
                                </div>
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