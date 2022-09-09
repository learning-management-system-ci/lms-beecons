<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form method="post" action="<?= base_url('/new-password'); ?>" class=" form d-flex flex-column" id="new-password"
    style="border: 2px solid rgba(236, 236, 236, 0); width: 290px;">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input your new passowrd</p>
    <label for="password" class="form-label mt-3">New Password</label>
    <input type="password" name="password" id="password" placeholder="Password">
    <label for="password_confirm" class="form-label mt-3">Confirm New Password</label>
    <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm Password">
    <button class="btn btn-primary mt-3" id="button" type="submit" disabled="disabled">Reset</button>
    <p class="sign-up" style="text-align: center;">Remember Your Account? <a href="<?= base_url('login'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
</form>
<?= $this->include('components/authentication/error_modal') ?>
<?= $this->endSection() ?>
<?=$this->section('authentication-js')?>
<script>
    $(document).ready(function () {
        $('#new-password').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirm: {
                    required: true,
                    equalTo: '#password'
                }
            }
        });

        if ($('button.btn').prop('disabled', 'disabled')) {
            $('button.btn').css({
                'background-color': '#B9B9B9'
            })
        }

        $('#new-password input').on('keyup blur', function () {
            if ($('#new-password').valid()) {
                $('button.btn').prop('disabled', false).css({
                    'background-color': '#002B5B'
                });
            } else {
                $('button.btn').prop('disabled', 'disabled').css({
                    'background-color': '#B9B9B9'
                });
            }
        });

    });
</script>
<?=$this->endSection()?>