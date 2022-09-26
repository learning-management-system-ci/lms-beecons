<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('app-component') ?>

<?= $this->include('components/home/hero') ?>
<?= $this->include('components/home/why_choose_us') ?>
<?= $this->include('components/home/choose_course') ?>
<?= $this->include('components/home/webinar') ?>
<?= $this->include('components/home/mentor') ?>
<?= $this->include('components/home/our_partner') ?>
<?= $this->include('components/home/testimoni') ?>

<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="../../../js/api/home/index.js"></script>
<?= $this->endSection() ?>