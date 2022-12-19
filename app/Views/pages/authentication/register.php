<?= $this->extend('layouts/authentication_layout') ?>

<?= $this->section('authentication-component') ?>
<form action="<?= base_url('/api/register'); ?>" id="sign-up" class="form d-flex flex-column">
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
        <button class="btn btn-outline-secondary" type="button" id="show-password"><i class="bi bi-eye" id="eye-icon-password"></i></button>
    </div>

    <label for="password_confirm" class="form-label mt-3">Konfirmasi Sandi</label>
    <div class="input-group">
        <input type="password" name="password_confirm" id="password_confirm" placeholder="Tulis kembali password kamu">
        <button class="btn btn-outline-secondary" type="button" id="show-confirm"><i class="bi bi-eye" id="eye-icon-password_confirm"></i></button>
    </div>
    <div class="option d-flex my-2">
        <div class="checkbox d-flex align-items-start">
            <input class="me-2" type="checkbox" id="terms" name="terms">
            <label for="terms" class="priv-pol sign-up">Dengan mendaftar anda menyetujui <a href="<?= base_url('/terms-and-conditions') ?>">kebijakan privasi*</a>
                kami
            </label>
        </div>
    </div>
    <button class="app-btn btn mt-3" id="button" type="submit" disabled="disabled">Daftar</button>
    <p class="sign-up">Sudah punya akun? <a href="<?= base_url('login'); ?>">Masuk</a></p>
    <p class="horizontal">Atau</p>
    <a href="<?= $googleButton; ?>" class="app-btn btn" id="googleButton">
        <img src="image/google-logo.svg" alt="">
        <p>Masuk</p>
    </a>
</form>
<div id="g_id_onload" data-client_id="229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com" data-login_uri="<?= base_url("/login/loginOneTapGoogle") ?>" data-auto_prompt="true" data-auto_select="false" data-context="signup">
</div>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<?= $this->endSection() ?>
<?= $this->section('authentication-js-logic') ?>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script>
<script src="js/authentication/api/register.js"></script>
<?= $this->endSection() ?>
<?= $this->section('authentication-js') ?>
<script src="js/authentication/register.js"></script>
<?= $this->endSection() ?>