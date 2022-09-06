<?= $this->extend('layouts/authentication_layout') ?>

<?= $this->section('authentication-component') ?>
<form method="post" action="<?= base_url(); ?>/login" class=" form d-flex flex-column" style="border: 2px solid rgba(236, 236, 236, 0);">
<?= csrf_field(); ?>    
    <p class="welcome-text">Welcome</p>
    <p class="sign-in-text"><?= $title; ?></p>
    <p class="info-text">Please input your email and password</p>

    <?php if (!empty(session()->getFlashdata('error'))) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php //echo $_SESSION['email'] ?>

    <?php if (!empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <label for="user_email" class="form-label">Email</label>
    <input type="email" name="email" id="user_email" placeholder="Email">

    <label for="user_pass" class="form-label mt-3">Password</label>
    <input type="password" name="password" id="user_pass" placeholder="Password">

    <div class="option d-flex justify-content-end align-items-center my-2">
        <a href="<?= base_url('forgot-password'); ?>">Forgot Password?</a>
    </div>

    <input class="btn btn-primary" type="submit" value="Sign In">
    <p class="sign-up" style="text-align: center;">Don't Have Account <a href="<?= base_url('register'); ?>">Sign up</a></p>
    <p class="horizontal">Or</p>
</form>
<?= $googleButton; ?>
<?= $this->endSection() ?>