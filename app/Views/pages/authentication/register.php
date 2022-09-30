<?=$this->extend('layouts/authentication_layout')?>

<script>
    window.onload = function () {
        google.accounts.id.initialize({
            client_id: "229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com", // Replace with your Google Client ID
            login_uri: "http://localhost:8080/login/loginWithGoogle" // We choose to handle the callback in server side, so we include a reference to a endpoint that will handle the response
        });
        // You can skip the next instruction if you don't want to show the "Sign-in" button
        google.accounts.id.renderButton(
            document.getElementById("buttonDiv"), // Ensure the element exist and it is a div to display correcctly
            { theme: "outline", size: "large" }  // Customization attributes
        );
        google.accounts.id.prompt(); // Display the One Tap dialog
    }
</script>
<?=$this->section('authentication-component')?>
<form action="<?= base_url('/api/register'); ?>" id="sign-up" class=" form d-flex flex-column"
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
            <label for="terms">By signing up you agree to our <a href="<?= base_url('/terms-and-conditions') ?>">Terms &
                    Condition and
                    Privacy
                    Policy.*</a></label>
        </div>
    </div>
    <button class="btn btn-primary mt-3" id="button" type="submit" disabled="disabled" style="border: 0;">Sign
        Up</button>
    <p class="sign-up" style="text-align: center;">Already Have Account? <a href="<?= base_url('login'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
    <p class="horizontal">Or</p>
</form>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<div id="g_id_onload"
    data-client_id="229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com"
    data-login_uri="http://localhost:8080/login/loginWithGoogle"
    data-auto_prompt="true"
    data-auto_select="true">
</div>
<?= $googleButton; ?>
<?= $this->include('components/authentication/error_modal') ?>
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