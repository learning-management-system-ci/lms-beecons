<?= $this->extend('layouts/authentication_layout') ?>

<script>
    window.onload = function () {
        google.accounts.id.initialize({
            client_id: "229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com", // Replace with your Google Client ID
            login_uri: "http://localhost:8080/login/loginWithGoogle" // We choose to handle the callback in server side, so we include a reference to a endpoint that will handle the response
        });
        // You can skip the next instruction if you don't want to show the "Sign-in" button
        google.accounts.id.renderButton(
            document.getElementById(
            "buttonDiv"), // Ensure the element exist and it is a div to display correcctly
            {
                theme: "outline",
                size: "large"
            } // Customization attributes
        );
        google.accounts.id.prompt(); // Display the One Tap dialog
    }
</script>
<?= $this->section('authentication-component') ?>
<form action="<?= base_url('/api/login'); ?>" id="login" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0); width: 290px;">
    <?= csrf_field(); ?>
    <p class="welcome-text">Selamat datang!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Silahkan masukkan email dan password kamu</p>
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" placeholder="Email kamu">

    <label for="password" class="form-label mt-3">Password</label>
    <input type="password" name="password" id="password" placeholder="Password kamu">

    <div class="option d-flex justify-content-end align-items-center my-2">
        <a href="<?= base_url('forgot-password'); ?>">Lupa password?</a>
    </div>

    <button class="btn" id="button" type="submit" disabled="disabled" style="border: 0;">Sign
        In</button>
    <p class="sign-up" style="text-align: center;">Don't Have Account <a href="<?= base_url('register'); ?>">Sign up</a>
    </p>
    <p class="horizontal">Or</p>
    <?= $googleButton; ?>
</form>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<div id="g_id_onload" data-client_id="229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com"
    data-login_uri="http://localhost:8080/login/loginWithGoogle" data-auto_prompt="true" data-auto_select="true">
</div>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->endSection() ?>
<?=$this->section('authentication-js-logic')?>
<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<script src="js/authentication/api/login.js"></script>
<?= $this->endSection() ?>
<?=$this->section('authentication-js')?>
<script src="js/authentication/login.js"></script>
<?= $this->endSection() ?>