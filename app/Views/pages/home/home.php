<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="/style/loading.css">
<link rel="stylesheet" href="../../../style/home.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<?php
helper("cookie");
if (get_cookie("access_token")) {
}
?>
<div id="g_id_onload" data-client_id="229684572752-p2d3d602o4jegkurrba5k2humu61k8cv.apps.googleusercontent.com" data-login_uri="<?= base_url("/login/loginOneTapGoogle") ?>" data-auto_prompt="true" data-auto_select="false" data-skip_prompt_cookie="access_token" data-context="signin">
</div>
<?= $this->include('components/home/hero') ?>
<?= $this->include('components/home/why_choose_us') ?>
<?= $this->include('components/home/choose_course') ?>
<?= $this->include('components/home/webinar') ?>
<?= $this->include('components/home/mentor') ?>
<?= $this->include('components/home/our_partner') ?>
<?= $this->include('components/home/artikel') ?>
<?= $this->include('components/home/testimoni') ?>

<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../../js/utils/getRupiah.js"></script>
<script src="../../../js/utils/textTruncate.js"></script>
<script src="../../../js/home/homepage.js"></script>
<?= $this->endSection() ?>