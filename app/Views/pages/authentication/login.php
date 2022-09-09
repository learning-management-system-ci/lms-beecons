<?= $this->extend('layouts/authentication_layout') ?>

<?= $this->section('authentication-component') ?>
<form method="post" action="<?= base_url(); ?>/login" id="login" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0);">
    <?= csrf_field(); ?>
    <p class="welcome-text">Welcome</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input your email and password</p>
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" placeholder="Email">

    <label for="password" class="form-label mt-3">Password</label>
    <input type="password" name="password" id="password" placeholder="Password">

    <div class="option d-flex justify-content-end align-items-center my-2">
        <a href="<?= base_url('forgot-password'); ?>">Forgot Password?</a>
    </div>
    <button class="btn btn-primary" id="button" type="submit" disabled="disabled">Sign In</button>
    <p class="sign-up" style="text-align: center;">Don't Have Account <a href="<?= base_url('register'); ?>">Sign up</a>
    </p>
    <p class="horizontal">Or</p>
</form>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->endSection() ?>
<?=$this->section('authentication-js')?>
<script>
    $(document).ready(function () {
        console.log("mashoook");
        $('#login').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
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