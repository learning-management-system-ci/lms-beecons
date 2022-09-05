<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="" id="sign-up" class=" form d-flex flex-column" style="border: 2px solid rgba(236, 236, 236, 0);">
    <p class="welcome-text">Welcome</p>
    <p class="sign-in-text">Sign Up</p>
    <p class="info-text">Please input your email and password</p>
    <label for="user_email" class="form-label">Email</label>
    <input type="text" name="email" id="user_email" placeholder="Email" required onchange="email_validate()">
    <label for="user_pass" class="form-label mt-3">Password</label>
    <input type="password" name="pass" id="user_pass" placeholder="Password">
    <label for="user_confirm_pass" class="form-label mt-3">Confirm Password</label>
    <input type="password" name="pass" id="user_confirm_pass" placeholder="Confirm Password">
    <div class="option d-flex align-items-center" style="max-width: 290px;">
        <div class="checkbox d-flex justify-content-between align-items-center" style="align-self: stretch;">
            <input type="checkbox" id="terms" name="terms" style="align-self: stretch;" required
                onchange="terms_conditions()">
            <label for="terms">By signing up you agree to our Terms & Condition and Privacy Policy.*</label>
        </div>
    </div>
    <input class="btn btn-primary" type="submit" value="Sign Up">
    <p class="sign-up" style="text-align: center;">Already Have Account? <a href="<?= base_url('login'); ?>" style="text-decoration: none;">Sign
            in</a></p>
    <p class="horizontal">Or</p>
    <button class="google"><img src="image/google.png" alt=""></button>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script>
    function login() {

        isValid = false;

        if (email_validate() && terms_conditions()) {
            isValid = true;
        }

        return isValid;
    }

    // validate the email
    function email_validate() {
        let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let email = $('#user_email').val();
        if (!email.match(mailformat)) {
            $('#user_email').addClass('is-invalid');
            return false;
        } else {
            $('#user_email').removeClass('is-invalid');
            $('#user_email').addClass('is-valid');
            return true;
        }

        //     Uppercase (A-Z) and lowercase (a-z) English letters.
        // Digits (0-9).
        // Characters ! # $ % & ' * + - / = ? ^ _ ` { | } ~
        // Character . ( period, dot or fullstop) provided that it is not the first or last character and it will not come one after the other.
    }

    // validate terms & conditions agree or not
    function terms_conditions() {
        if ($("#terms").prop('checked') == true) {
            $('#terms').removeClass('is-invalid')
            $('#terms').addClass('is-valid')
            return true;
        } else {
            $('#terms').addClass('is-invalid')
            return false;
        }
    }
</script>
<?=$this->endSection()?>