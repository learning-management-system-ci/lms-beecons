<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/api/register'); ?>" id="sign-up" class="form d-flex flex-column">
    <p class="welcome-text">Selamat datang!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Silahkan masukkan email dan password kamu</p>
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" id="email" placeholder="Email kamu">
    <label for="password" class="form-label mt-3">Password</label>
    <input type="password" name="password" id="password" placeholder="Password kamu">
    <label for="password_confirm" class="form-label mt-3">Confirm Password</label>
    <input type="password" name="password_confirm" id="password_confirm" placeholder="Tulis kembali password kamu">
    <div class="option d-flex my-2">
        <div class="checkbox d-flex align-items-start">
            <input class="me-2" type="checkbox" id="terms" name="terms">
            <label for="terms" class="priv-pol sign-up">Dengan mendaftar anda menyetujui <a
                    href="<?= base_url('/terms-and-conditions') ?>">Terms &
                    Condition*</a>
                    kami
            </label>
        </div>
    </div>
    <button class="btn mt-3" id="button" type="submit" disabled="disabled">Sign Up</button>
    <p class="sign-up">Sudah punya akun? <a href="<?= base_url('login'); ?>">Sign in</a></p>
    <p class="horizontal">Atau</p>
    <a href="<?= $googleButton; ?>" class="btn" id="googleButton">
        <img src="image/google-logo.svg" alt="">
        <p>Sign Up</p>
    </a>
</form>
<div id="g_id_onload" data-client_id="229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com"
    data-login_uri="<?=base_url("/login/loginOneTapGoogle")?>" data-auto_prompt="true" data-auto_select="false"
    data-context="signup">
</div>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<?= $this->endSection() ?>
<?=$this->section('authentication-js-logic')?>
<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<script src="js/authentication/api/register.js"></script>
<?= $this->endSection() ?>
<?=$this->section('authentication-js')?>
<script src="js/authentication/register.js"></script>
<?= $this->endSection() ?>