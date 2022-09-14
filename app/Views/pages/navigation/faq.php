<?= $this->extend('layouts/app_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="style/faq.css">
<?= $this->endSection() ?>



<?= $this->section('app-component') ?>
<div class="container mt-4">
    <section class="faq mt-4">
        <div class="faq-title mb-5">
            <H3>FAQ's</H3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A nesciunt maxime laboriosam minus iste fuga
                odit repellat delectus iusto. Temporibus, praesentium dicta. Quae earum natus molestias ex neque
                eveniet dicta?</p>
        </div>
        <div class="faq-list"></div>
        <script>
            $.getJSON('<?= base_url('/api/faq/');?>', function (
                data) {
                var resources = data.faq
                    .sort((a, b) => a.faq_id - b.faq_id)
                    .map(({
                        faq_id,
                        question,
                        answer
                    }) => {
                        return (`<div class="faq-item">
                                <div class="faq-title d-flex justify-content-between align-items-center">
                                    <h4>0${faq_id}. ${question}</h3>
                                        <a class="expand d-flex justify-content-center align-items-center" data-bs-toggle="collapse"
                                            href="#faq${faq_id}" role="button" aria-expanded="false" aria-controls="collapseExample"
                                            id="button12">
                                        </a>
                                </div>
                                <div class="faq-content collapse" id="faq${faq_id}">
                                    <div class="card-body ml-5">
                                    ${answer}.
                                    </div>
                                </div>
                                <hr>
                            </div>`);
                    });

                $(".faq-list").html(resources);
            });
        </script>
    </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="js/home/faq.js"></script>
<?= $this->endSection() ?>