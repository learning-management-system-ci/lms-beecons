<?= $this->extend('layouts/authentication_layout') ?>

<?= $this->section('authentication-component') ?>
<form method="post" action="<?= base_url(); ?>/login/submit" id="login" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0);">
    <?= csrf_field(); ?>
    <p class="welcome-text">Welcome</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input your email and password</p>

    <span
        style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("error")) echo session()->getFlashData("error"); ?></span>
    <span
        style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("success")) echo session()->getFlashData("success"); ?></span>
    <label for="user_email" class="form-label">Email</label>
    <input type="email" name="user_email" id="user_email" placeholder="Email">

    <label for="user_pass" class="form-label mt-3">Password</label>
    <input type="password" name="user_pass" id="user_pass" placeholder="Password">

    <div class="option d-flex justify-content-end align-items-center my-2">
        <a href="<?= base_url('forgot-password'); ?>">Forgot Password?</a>
    </div>
    <button class="btn btn-primary" id="button" type="submit" disabled="disabled">Sign In</button>
    <p class="sign-up" style="text-align: center;">Don't Have Account <a href="<?= base_url('sign-up'); ?>">Sign up</a>
    </p>
    <p class="horizontal">Or</p>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        console.log("mashoook");
        $('#login').validate({
            rules: {
                user_email: {
                    required: true,
                    email: true
                },
                user_pass: {
                    required: true,
                    minlength: 8
                }
            }
        });

        if ($('button.btn').prop('disabled', 'disabled')) {
            $('button.btn').css({
                'background-color': '#B9B9B9'
            })
        }

        $('#login input').on('keyup blur', function () {
            if ($('#login').valid()) {
                $('button.btn').prop('disabled', false).css({
                    'background-color': '#002B5B'
                });
            } else {
                $('button.btn').prop('disabled', 'disabled');
            }
        });

    });
</script>
<?= $googleButton; ?>
<?= $this->endSection() ?>