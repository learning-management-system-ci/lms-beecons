<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/webinar-training.css">
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div id="training">
    <div class="container">
        <div class="training-wrapper row"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
    <!-- <script src="js/home/faq.js"></script> -->
    <script src="/js/api/training/training.js"></script>
    <script src="/js/utils/getRupiah.js"></script>
<?= $this->endSection() ?>