<div class="quiz-section text-center p-4 swiper myswiper mb-5">
    <div class="swiper-wrapper">
        <?= $this->renderSection('quiz-component') ?>
    </div>
    <div class="progress-box d-flex align-items-center justify-content-center p-1 mt-5">
        <button class="quiz-back"><img width="34px" src="image/course-detail/back.png" alt=""></button>
        <div id="loading"></div>
        <button class="quiz-next"><img width="110px" src="image/course-detail/next.png" alt=""></button>
    </div>
</div>