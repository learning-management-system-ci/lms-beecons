<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a35fe366cf.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../../style/slick.css">
    <link rel="stylesheet" href="../../../style/slick-theme.css">

    <!-- mystyle -->
    <link rel="stylesheet" href="../../../style/home.css">
    <?= $this->renderSection('css-component') ?>
</head>

<body>
    <?php helper("cookie");?>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="../../../image/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarApp"
                aria-controls="navbarApp" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarApp">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <div class="nav-item-search">
                            <div class="nav-search-input">
                                <form action="">
                                    <input class="form-control border" placeholder="search">
                                </form>
                                <i class="fa-solid fa-xmark" id="nav-btn-search-x"></i>
                            </div>
                            <button class="nav-btn-icon mt-1" id="nav-btn-search" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-auto-close="false">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <div class="dropdown-menu mt-2" aria-labelledby="nav-btn-search">
                                <div id="search-result-initial">
                                    <div class="p-2 border-bottom">
                                        <h5 class="ctg">Recent</h5>
                                        <div id="search-recent">
                                            <!-- <a href="">
                                            <div class="search-item">
                                                <div class="icon">
                                                    <img src="/image/home/img-course.jpg" alt="">
                                                </div>
                                                <div class="desc">
                                                    <h5>Frontend</h5>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, qui minim labore
                                                    </p>
                                                </div>
                                            </div>
                                        </a> -->
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <h5 class="ctg">Rekomendasi</h5>
                                        <div id="search-rekomendasi">
                                            <!-- <a href="">
                                            <div class="search-item">
                                                <div class="icon">
                                                    <img src="/image/home/img-course.jpg" alt="">
                                                </div>
                                                <div class="desc">
                                                    <h5>Frontend</h5>
                                                    <p>
                                                        Lorem ipsum dolor sit amet, qui minim labore
                                                    </p>
                                                </div>
                                            </div>
                                        </a> -->
                                        </div>
                                    </div>
                                </div>
                                <div id="search-result" class="p-2"></div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item me-4">
                        <div class="dropdown nav-item-icon">
                            <button class="nav-btn-icon mt-1" id="dropdown-cart" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="nav-btn-icon-amount">5</div>
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </div>
                    </li>
                    <li class="nav-item me-4">
                        <div class="dropdown nav-item-icon">
                            <button class="nav-btn-icon mt-1" id="dropdown-notification" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="nav-btn-icon-amount">2</div>
                                <i class="fa-solid fa-bell"></i>
                            </button>
                            <div class="dropdown-menu mt-2 notifications" aria-labelledby="dropdown-notification">
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
                            <button class="nav-btn-profile" id="dropdown-profile" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="../../../image/home/people.jpg" class="nav-profile me-1" alt="">
                            </button>
                            <div class="dropdown-menu mt-2" aria-labelledby="dropdown-profile">
                                <a href="<?= base_url('/profile') ?>" class="dropdown-item">Profile</a>
                            </div>
                        </div>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?php if(uri_string() != '/' && uri_string() != 'profile' && !str_contains(uri_string(), 'courses')) : ?>
        <div class="container mt-4">
            <section class="navigation">
                <p class="mb-4"><a href="<?= base_url('/') ?>" style="font-weight: 300;">Home</a> >
                    <?php if(uri_string() == 'faq') : ?>
                    <a> Frequently Asked Question</a>
                    <?php endif; ?>
                    <?php if(uri_string() == 'terms-and-conditions') : ?>
                    <a> Terms and Conditions</a>
                    <?php endif; ?>
                    <?php if(uri_string() == 'about-us') : ?>
                    <a> About-Us</a>
                    <?php endif; ?>
                    <?php if(uri_string() == 'bundling') : ?>
                    <a> Bundling</a>
                    <?php endif; ?>
                </p>
                <hr>
            </section>
        </div>
        <?php endif; ?>
        <?php if(str_contains(uri_string(), 'courses')) : ?>
        <div class="container mt-4">
            <section class="navigation">
                <p class="mb-4"><a href="<?= base_url('courses') ?>" style="font-weight: 300;">Courses</a>
                    <?php if(uri_string() != 'courses') : ?>
                    >
                    <?php endif; ?>
                    <?php if(uri_string() == 'courses/bundling') : ?>
                    <a> Bundling</a>
                    <?php endif; ?>
                </p>
                <hr>
            </section>
        </div>
        <?php endif; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
        <?= $this->renderSection('app-component') ?>
    </main>

    <footer class="footer-container">
        <div class="item">
            <img src="../../../image/logo.png" alt="logo">
        </div>
        <div class="item">
            <h2>Pages</h2>

            <a href="" class="footer-link">Home</a>
            <a href="" class="footer-link">Pricing</a>
            <a href="" class="footer-link">Blog</a>
            <a href="" class="footer-link">Demo</a>
        </div>
        <div class="item">
            <h2>Service</h2>

            <a href="" class="footer-link">Konstruksi</a>
            <a href="" class="footer-link">Coding</a>
            <a href="" class="footer-link">UI/UX Design</a>
        </div>
        <div class="item">
            <h2>Contact</h2>

            <div class="contact">
                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <p>(+62) 82322491613</p>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <p>asnandyx@gmail.com</p>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <p>
                        Jl. Mijil No.98, Karangjati, Sinduadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta
                        55284
                    </p>
                </div>
            </div>
        </div>
        <div class="item">
            <h2>Sosial media</h2>

            <div class="sosmed">
                <a href="">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>

    <script src="../../../js/home/slick.js"></script>

    <!-- myscript -->
    <script src="../../../js/home/home.js"></script>
    <?= $this->renderSection('js-component') ?>
</body>

</html>