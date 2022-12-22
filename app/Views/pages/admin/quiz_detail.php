<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('css-component') ?>
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-md-12 tab-content" id="detail-page">
      <div class="card tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center placeholder-glow">
            <h5 class="title-content"><span class="placeholder col-8" style=" display: inline !important;">--------------------------------</span></h5>
            <button id="add-quiz" class="btn btn-primary btn-sm ms-auto">Add Quiz</button>
          </div>
        </div>
        <div class="card-body text-center">

          <div class="accordion" id="accordionExample">
            <!--  -->
          </div>
          <button id="save-quiz" class="btn btn-primary btn-sm ms-auto mt-4">Save Quiz</button>
        </div>
      </div>

    </div>
  </div>
  <?= $this->endSection() ?>

  <?= $this->section('js-component') ?>
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://SortableJS.github.io/Sortable/Sortable.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
  <script src="/js/utils/getRupiah.js"></script>
  <script src="/js/api/admin/quizDetail.js"></script>
  <?= $this->endSection() ?>