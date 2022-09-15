<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form method="post" action="<?= base_url(); ?>/register" id="sign-up" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0); width: 290px;">
    <p class="welcome-text">Welcome</p>
    <p class="sign-in-text">Sign Up</p>
    <p class="info-text">Please input your email and password</p>
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" id="email" placeholder="Email">
    <label for="password" class="form-label mt-3">Password</label>
    <input type="password" name="password" id="password" placeholder="Password">
    <label for="password_confirm" class="form-label mt-3">Confirm Password</label>
    <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm Password">
    <div class="option d-flex my-2">
        <div class="checkbox d-flex align-items-start">
            <input class="me-2" type="checkbox" id="terms" name="terms" style="height: 15px;">
            <label for="terms">By signing up you agree to our Terms & Condition and Privacy Policy.*</label>
        </div>
    </div>
    <button class="btn btn-primary mt-3" id="button" type="submit" disabled="disabled" style="border: 0;">Sign
        Up</button>
    <p class="sign-up" style="text-align: center;">Already Have Account? <a href="<?= base_url('login'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
    <p class="horizontal">Or</p>
</form>
<?= $googleButton; ?>
<?= $this->include('components/authentication/error_modal') ?>
<?=$this->endSection()?>
<?=$this->section('authentication-js')?>
<script src="js/authentication/register.js" />
<?=$this->endSection()?>