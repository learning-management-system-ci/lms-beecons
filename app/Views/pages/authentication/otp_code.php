<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form method="post" action="<?= base_url('/send-otp'); ?>" id="otp-code" class=" form d-flex flex-column"
    style="border: 2px solid rgba(236, 236, 236, 0); width: 290px;">
    <p class="welcome-text">Check your email!</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input OTP code that sent to you</p>
    <?php if (!empty(session()->getFlashdata('error'))) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo session()->getFlashdata('error'); ?>
    </div>
    <?php endif; ?>
    <label for="otp" class="form-label">OTP</label>
    <input type="text" name="otp" id="otp" placeholder="Enter your OTP code">
    <button class="btn btn-primary mt-3" id="button" type="submit" disabled="disabled">Confirm</button>
    <p class="sign-up" style="text-align: center;">Remember Your Account? <a href="<?= base_url('login'); ?>"
            style="text-decoration: none;">Sign
            in</a></p>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#otp-code').validate({
            rules: {
                otp: {
                    required: true,
                    minlength: 6
                },
            }
        });

        if ($('button.btn').prop('disabled', 'disabled')) {
            $('button.btn').css({
                'background-color': '#B9B9B9'
            })
        }

        $('#otp-code input').on('keyup blur', function () {
            if ($('#otp-code').valid()) {
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