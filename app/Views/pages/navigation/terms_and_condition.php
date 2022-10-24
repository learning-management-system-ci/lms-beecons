<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/faq.css">
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div class="px-5 mt-4">
    <section class="faq mt-4">
        <div class="faq-title mb-5">
            <H3>Terms and Conditions</H3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A nesciunt maxime laboriosam minus iste fuga
                odit repellat delectus iusto. Temporibus, praesentium dicta. Quae earum natus molestias ex neque
                eveniet dicta?</p>
            <section>
                <H3>1. Abc Lima Dasar</H3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A nesciunt maxime laboriosam minus iste fuga
                    odit repellat delectus iusto. Temporibus, praesentium dicta. Quae earum natus molestias ex neque
                    eveniet dicta?</p>
                <H3>2. Abc Lima Dasar</H3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A nesciunt maxime laboriosam minus iste fuga
                    odit repellat delectus iusto. Temporibus, praesentium dicta. Quae earum natus molestias ex neque
                    eveniet dicta?</p>
            </section>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="js/home/faq.js"></script>
<?= $this->endSection() ?>