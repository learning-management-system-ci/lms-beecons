<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/api/new-password'); ?>" class="form d-flex flex-column" id="new-password">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Silahkan masukkan pasword baru kamu</p>
    <div class="input-group">
        <label for="password" class="form-label mt-3">Sandi Terbaru</label>
        <input type="password" name="password" id="password" placeholder="Password baru">
        <button class="btn btn-outline-secondary" type="button" id="show-password"><i class="bi bi-eye-slash"
                id="eye-icon-password"></i></button>
    </div>
    <div class="input-group">
        <label for="password_confirm" class="form-label mt-3">Konfirmasi Sandi Terbaru</label>
        <input type="password" name="password_confirm" id="password_confirm" placeholder="Tulis kembali password baru">
        <button class="btn btn-outline-secondary" type="button" id="show-confirm"><i class="bi bi-eye-slash"
                id="eye-icon-password_confirm"></i></button>
    </div>
    <button class="app-btn btn mt-3" id="button" type="submit" disabled="disabled">Atur Ulang</button>
    <p class="sign-up">Ingat akun kamu? <a href="<?= base_url('login'); ?>">Masuk</a></p>
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