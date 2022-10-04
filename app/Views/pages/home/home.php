<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="../../../style/home.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>

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
<script src="../../../js/utils/getRupiah.js"></script>
<script src="../../../js/utils/textTruncate.js"></script>
<script src="../../../js/home/homepage.js"></script>
<?= $this->endSection() ?>