<?=$this->extend('layouts/authentication_layout')?>

<?=$this->section('authentication-component')?>
<form method="post" action="<?= base_url('/new-password'); ?>" class=" form d-flex flex-column" style="border: 2px solid rgba(236, 236, 236, 0);">
    <p class="welcome-text">Oops!</p>
    <p class="sign-in-text">Reset Password</p>
    <p class="info-text">Please input your new passowrd</p>
    <?php if (!empty(session()->getFlashdata('error'))) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <label for="user_pass" class="form-label mt-3">New Password</label>
    <input type="password" name="password" id="user_pass" placeholder="Password">

    <label for="user_confirm_pass" class="form-label mt-3">Confirm New Password</label>
    <input type="password" name="password_confirm" id="user_confirm_pass" placeholder="Confirm Password">

    <input class="btn btn-primary mw-290" type="submit" value="Reset" style="margin-top: 20px">
    <p class="sign-up" style="text-align: center;">Remember Your Account? <a href="<?= base_url('login'); ?>" style="text-decoration: none;">Sign
            in</a></p>
</form>
<?=$this->endSection()?>