<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/api/forgot-password'); ?>" id="forgot-password" class="form d-flex flex-column">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Masukkan alamat email kamu</p>
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" id="email" placeholder="Email kamu">
    <button class="app-btn btn mt-3" id="button" type="submit" disabled="disabled">Confirm</button>
    <p class="sign-up">Ingat akun kamu? <a href="<?= base_url('sign-in'); ?>">Sign
            in</a></p>
</form>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<?= $this->endSection() ?>
<?=$this->section('authentication-js-logic')?>
<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<script src="js/authentication/api/forgot_password.js"></script>
<?= $this->endSection() ?>
<?=$this->section('authentication-js')?>
<script src="js/authentication/forgot_password.js"></script>
<?= $this->endSection() ?>