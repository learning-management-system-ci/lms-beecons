<?= $this->extend('layouts/authentication_layout') ?>

<?= $this->section('authentication-component') ?>
<form action="<?= base_url('/api/login'); ?>" id="login" class="form d-flex flex-column">
    <?= csrf_field(); ?>
    <p class="welcome-text">Selamat datang!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Silahkan masukkan email dan password kamu</p>

    <div>
        <label for="email" class="form-label">Email</label>
        <input class="btn-full" type="email" name="email" id="email" placeholder="Email kamu">
    </div>

    <label for="password" class="form-label mt-3">Sandi</label>
    <div class="input-group">
        <input type="password" name="password" id="password" placeholder="Password kamu">
        <button class="btn btn-outline-secondary" type="button" id="show-password"><i class="bi bi-eye"
                id="eye-icon"></i></button>
    </div>

    <div class="option d-flex justify-content-end align-items-center my-2 sign-up">
        <a href="<?= base_url('forgot-password'); ?>">Lupa password?</a>
    </div>

    <button class="app-btn btn" id="button" type="submit" disabled="disabled" style="border: 0;">Masuk</button>
    <p class="sign-up">Belum punya akun? <a href="<?= base_url('register'); ?>">Daftar</a>
    </p>
    <p class="horizontal">Atau</p>
    <a href="<?= $googleButton; ?>" class="app-btn btn" id="googleButton">
        <img src="image/google-logo.svg" alt="">
        <p>Masuk</p>
    </a>
</form>
<div id="g_id_onload" data-client_id="229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com"
    data-login_uri="<?= base_url("/login/loginOneTapGoogle") ?>" data-auto_prompt="true" data-auto_select="false"
    data-context="signin">
</div>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<?= $this->endSection() ?>
<script type="text/javascript">
    var base_url = '<?= base_url() ?>';
</script>
<?= $this->section('authentication-js-logic') ?>
<script src="js/authentication/api/login.js"></script>
<?= $this->endSection() ?>
<?= $this->section('authentication-js') ?>
<script src="js/authentication/login.js"></script>
<?= $this->endSection() ?>