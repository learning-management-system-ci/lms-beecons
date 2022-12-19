<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/api/send-otp'); ?>" id="otp-code" class="form d-flex flex-column">
    <p class="welcome-text">Cek email kamu!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Silahkan masukkan kode OTP yang telah kami kirimkan</p>
    <label for="otp" class="form-label">OTP</label>
    <input type="text" name="otp" id="otp" placeholder="Masukkan kode OTP">
    <button class="app-btn btn mt-3" id="button" type="submit" disabled="disabled">Konfirmasi</button>
    <p class="sign-up">Ingat akun kamu? <a href="<?= base_url('login'); ?>">Masuk</a></p>
</form>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->include('components/authentication/loading') ?>
<?=$this->endSection()?>
<?=$this->section('authentication-js-logic')?>
<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<script src="js/authentication/api/otp_code.js"></script>
<?= $this->endSection() ?>
<?=$this->section('authentication-js')?>
<script src="js/authentication/otp_code.js"></script>
<?= $this->endSection() ?>