<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form method="post" action="<?= base_url('/new-password'); ?>" class=" form d-flex flex-column" id="new-password"
    style="border: 2px solid rgba(236, 236, 236, 0); width: 290px;">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input your new passowrd</p>
    <?php if (!empty(session()->getFlashdata('error'))) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo session()->getFlashdata('error'); ?>
    </div>
    <?php endif; ?>

    <label for="user_pass" class="form-label mt-3">New Password</label>
    <input type="password" name="user_pass" id="user_pass" placeholder="Password">
    <label for="user_confirm_pass" class="form-label mt-3">Confirm New Password</label>
    <input type="password" name="user_confirm_pass" id="user_confirm_pass" placeholder="Confirm Password">
    <button class="btn btn-primary mt-3" id="button" type="submit" disabled="disabled">Reset</button>
    <p class="sign-up" style="text-align: center;">Remember Your Account? <a href="<?= base_url('login'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        console.log("mashoook");
        $('#new-password').validate({
            rules: {
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

        $('#new-password input').on('keyup blur', function () {
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
<?=$this->endSection()?>