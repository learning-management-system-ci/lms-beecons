<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('APP_NAME') ?? 'Learning Platform' ?></title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a35fe366cf.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

    <!-- MomentJs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../../../style/slick.css">
    <link rel="stylesheet" href="../../../style/slick-theme.css">

    <link rel="stylesheet" href="../../../style/fileinput.css">
    <link rel="stylesheet" href="../../../style/fileinput-rtl.css">

    <!-- mystyle -->
    <link rel="stylesheet" href="../../../style/app_layout.css">
    <?= $this->renderSection('css-component') ?>
</head>

<body>
    <?php helper("cookie"); ?>
    <?php echo $this->include('components/home/navbar.php') ?>

    <main>
        <?php if(uri_string() != '/' && uri_string() != 'profile' && uri_string() != 'referral-code'  && !str_contains(uri_string(), 'webinar')) : ?>
        <div class="main-container pt-4">
            <?php 
            switch(uri_string()) {
                case "faq":
            ?>
            <p class="navigation breadcrumb-anchor">Frequently Asked Question</p>
            <hr>
            <?php 
                    break;
                case "terms-and-conditions":
            ?>
            <p class="navigation breadcrumb-anchor">Terms and Condditions</p>
            <hr>
            <?php 
                    break;
                case "about-us":
            ?>
            <p class="navigation breadcrumb-anchor">About Us</p>
            <hr>
            <?php 
                    break;
                case "bundling":
            ?>
            <p class="navigation breadcrumb-anchor"><a href="<?= base_url('/') ?>" style="font-weight: 300;">Home</a> >
                <a> Bundling</a>
            </p>
            <hr>
            <?php 
                    break;
                case "courses":
            ?>
            <p class="navigation breadcrumb-anchor">Courses</p>
            <hr>
            <?php
                    break;
                default:
            } ?>
        </div>
        <?php endif; ?>
        <?= $this->renderSection('app-component') ?>
    </main>

    <?php echo $this->include('components/home/footer.php') ?>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>

    <!-- js cookie -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>

    <script src="../../../js/home/slick.js"></script>

    <!-- myscript -->
    <script src="../../../js/utils/textTruncate.js"></script>
    <script src="../../../js/home/home.js"></script>
    <script src="../../../js/home/notification.js"></script>
    <script src="../../../js/home/profile.js"></script>
    <script src="../../../js/library/fileinput.js"></script>
    <?= $this->renderSection('js-component') ?>
</body>

</html>