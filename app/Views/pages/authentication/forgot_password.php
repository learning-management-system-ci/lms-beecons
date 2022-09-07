<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form action="<?= base_url('/forgot-password/submit'); ?>" id="forgot-password" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0); width: 290px;">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input your email account</p>
    <?php if (!empty(session()->getFlashdata('error'))) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
    <label for="email" class="form-label">Email</label>
    <input type="text" name="email" id="email" placeholder="Email">
    <button class="btn btn-primary mt-3" id="button" type="submit" disabled="disabled" style="border: 0;">Confirm</button>
    <p class="sign-up" style="text-align: center;">Remember Your Account? <a href="<?= base_url('sign-in'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#forgot-password').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            }
        });

        if ($('button.btn').prop('disabled', 'disabled')) {
            $('button.btn').css({
                'background-color': '#B9B9B9'
            })
        }

        $('#forgot-password input').on('keyup blur', function () {
            if ($('#forgot-password').valid()) {
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