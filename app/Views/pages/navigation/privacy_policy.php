<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/faq.css">
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div class="container mt-4">
    <section class="navigation">
        <p class="mb-4">Home > <a href="#"> Frequently Asked Question</a></p>
        <hr>
    </section>
    <section class="faq mt-4">
        <div class="faq-title mb-5">
            <H3>FAQ's</H3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A nesciunt maxime laboriosam minus iste fuga
                odit repellat delectus iusto. Temporibus, praesentium dicta. Quae earum natus molestias ex neque
                eveniet dicta?</p>
        </div>
        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-title d-flex justify-content-between align-items-center">
                    <h4>01. Can i get a discount ?</h3>
                        <a class="expand d-flex justify-content-center align-items-center" data-bs-toggle="collapse"
                            href="#faq-1" role="button" aria-expanded="false" aria-controls="collapseExample"
                            id="button12">
                        </a>
                </div>
                <div class="faq-content collapse" id="faq-1">
                    <div class="card-body ml-5">
                        Some placeholder content for the collapse component. This panel is hidden by default but
                        revealed
                        when the user
                        activates the relevant trigger.
                    </div>
                </div>
                <hr>
            </div>
            <div class="faq-item">
                <div class="faq-title d-flex justify-content-between align-items-center">
                    <h4>02. Can i get a discount ?</h3>
                        <a class="expand" data-bs-toggle="collapse" href="#faq-2" role="button" aria-expanded="false"
                            aria-controls="collapseExample">
                        </a>
                </div>
                <div class="faq-content collapse" id="faq-2">
                    <div class="card-body ml-5">
                        Some placeholder content for the collapse component. This panel is hidden by default but
                        revealed
                        when the user
                        activates the relevant trigger.
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="js/home/faq.js"></script>
<?= $this->endSection() ?>