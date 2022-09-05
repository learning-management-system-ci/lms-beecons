<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/forgot-password/submit'); ?>" id="sign-up" class=" form d-flex flex-column" style="border: 2px solid rgba(236, 236, 236, 0);">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text">Reset Password</p>
    <p class="info-text">Please input your email account</p>
    <?php if (!empty(session()->getFlashdata('error'))) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
    <label for="user_email" class="form-label">Email</label>
    <input type="text" name="email" id="user_email" placeholder="Email" required onchange="email_validate()">

    <input class="btn btn-primary mw-290" type="submit" value="Confirm" style="margin-top: 20px">
    <p class="sign-up" style="text-align: center;">Remember Your Account? <a href="<?= base_url('sign-in'); ?>" style="text-decoration: none;">Sign
            in</a></p>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script>
    function login() {

        isValid = false;

        if (email_validate()) {
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