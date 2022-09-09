<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/forgot-password/submit'); ?>" id="forgot-password" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0); width: 290px;">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input your email account</p>
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" id="email" placeholder="Email">
    <button class="btn btn-primary mt-3" id="button" type="submit" disabled="disabled"
        style="border: 0;">Confirm</button>
    <p class="sign-up" style="text-align: center;">Remember Your Account? <a href="<?= base_url('sign-in'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
</form>
<?= $this->include('components/authentication/error_modal') ?>
<?=$this->endSection()?>
<?=$this->section('authentication-js')?>
<script src="js/authentication/forgot_password.js" />
<?=$this->endSection()?>