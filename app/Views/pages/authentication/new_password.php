<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/api/new-password'); ?>" class="form d-flex flex-column" id="new-password">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Silahkan masukkan pasword baru kamu</p>
    <label for="password" class="form-label mt-3">New Password</label>
    <input type="password" name="password" id="password" placeholder="Password baru">
    <label for="password_confirm" class="form-label mt-3">Confirm New Password</label>
    <input type="password" name="password_confirm" id="password_confirm" placeholder="Tulis kembali password baru">
    <button class="btn mt-3" id="button" type="submit" disabled="disabled">Reset</button>
    <p class="sign-up">Ingat akun kamu? <a href="<?= base_url('login'); ?>">Sign in</a></p>
</form>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<?= $this->endSection() ?>
<?=$this->section('authentication-js-logic')?>
<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<script src="js/authentication/api/new_password.js"></script>
<?= $this->endSection() ?>
<?=$this->section('authentication-js')?>
<script src="js/authentication/new_password.js"></script>
<?= $this->endSection() ?>