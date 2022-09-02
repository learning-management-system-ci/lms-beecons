<?= $this->extend('layouts/authentication_layout') ?>

<?= $this->section('authentication-component') ?>
<form method="post" action="<?= base_url(); ?>/login/submit" class=" form d-flex flex-column" style="border: 2px solid rgba(236, 236, 236, 0);">
<?= csrf_field(); ?>    
    <p class="welcome-text">Welcome</p>
    <p class="sign-in-text">Sign In</p>
    <p class="info-text">Please input your email and password</p>

    <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("error")) echo session()->getFlashData("error"); ?></span>
    <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("success")) echo session()->getFlashData("success"); ?></span>
    <label for="user_email" class="form-label">Email</label>
    <input type="email" name="email" id="user_email" placeholder="Email">

    <label for="user_pass" class="form-label mt-3">Password</label>
    <input type="password" name="password" id="user_pass" placeholder="Password">

    <div class="option d-flex justify-content-between align-items-center">
        <div class="checkbox d-flex align-items-center">
            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            <label for="vehicle1">Remember Me</label><br>
        </div>
        <a href="#">Forgot Password?</a>
    </div>

    <button type="submit" class="btn btn-primary">Sign in</button>
    <p class="sign-up" style="text-align: center;">Don't Have Account <a href="#">Sign up</a></p>
    <p class="horizontal">Or</p>
</form>
<?= $googleButton; ?>
<?= $this->endSection() ?>