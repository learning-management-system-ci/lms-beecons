<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a35fe366cf.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style/slick.css">
    <link rel="stylesheet" href="style/slick-theme.css">

    <!-- mystyle -->
    <link rel="stylesheet" href="style/home.css">
</head>

<body>
    <!-- <header>
        <div class="topnav">
            <div class="topnav-left">
                <a href="" class="nav-link logo">
                    <img src="image/logo.png" alt="logo">
                </a>
                <a href="" class="nav-link">Home</a>
                <a href="" class="nav-link">Webinar</a>
                <a href="" class="nav-link">Courses</a>
            </div>
            <div class="topnav-right">
                <a href="" class="nav-link">Home</a>
                <a href="" class="nav-link">Home</a>
                <?php if (session()->get('LoggedUserData')) : ?>
                    <a href="/login" class="nav-link-btn">
                        <button class="btn-my btn-sign-in">Sign in</button>
                    </a>
                <?php else : ?>
                    <div class="dropdown nav-link-btn">
                        <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </header> -->

    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="image/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Webinar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Courses</a>
                    </li>
                </ul>
                <a class="nav-link" href="#">Link</a>
                <?php if (session()->get('LoggedUserData')) : ?>
                    <a href="/login" class="nav-link-btn">
                        <button class="btn-my btn-sign-in">Sign in</button>
                    </a>
                <?php else : ?>
                    <div class="dropdown nav-link-btn">
                        <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </nav>

    <main>
        <?= $this->renderSection('app-component') ?>
    </main>

    <footer class="footer-container">
        <div class="item">
            <img src="image/logo.png" alt="logo">
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
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <script src="js/slick.js"></script>

    <!-- myscript -->
    <script src="js/home.js"></script>
</body>

</html>