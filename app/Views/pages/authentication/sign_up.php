<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form method="post" action="<?= base_url(); ?>/register" id="sign-up" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0); max-width: 290px;">
    <p class="welcome-text">Welcome</p>
    <p class="sign-in-text">Sign Up</p>
    <p class="info-text">Please input your email and password</p>
    <label for="user_email" class="form-label">Email</label>
    <input type="text" name="user_email" id="user_email" placeholder="Email">
    <label for="user_pass" class="form-label mt-3">Password</label>
    <input type="password" name="user_pass" id="user_pass" placeholder="Password">
    <label for="user_confirm_pass" class="form-label mt-3">Confirm Password</label>
    <input type="password" name="user_confirm_pass" id="user_confirm_pass" placeholder="Confirm Password">
    <div class="option d-flex align-items-center" style="max-width: 290px;">
        <div class="checkbox d-flex justify-content-between align-items-center" style="align-self: stretch;">
            <input type="checkbox" id="terms" name="terms" style="align-self: stretch;">
            <label for="terms">By signing up you agree to our Terms & Condition and Privacy Policy.*</label>
        </div>
    </div>
    <button class="btn btn-primary" id="button" type="submit" disabled="disabled" style="border: 0;">Sign Up</button>
    <p class="sign-up" style="text-align: center;">Already Have Account? <a href="<?= base_url('login'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
    <p class="horizontal">Or</p>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#sign-up').validate({
            rules: {
                user_email: {
                    required: true,
                    email: true
                },
                user_pass: {
                    required: true,
                    minlength: 8
                },
                user_confirm_pass: {
                    required: true,
                    equalTo: '#user_pass'
                }
            }
        });

        if ($('button.btn').prop('disabled', 'disabled')) {
            $('button.btn').css({
                'background-color': '#B9B9B9'
            })
        }

        $('#sign-up input').on('keyup blur', function () {
            if ($('#sign-up').valid()) {
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
<?=$this->endSection()?>