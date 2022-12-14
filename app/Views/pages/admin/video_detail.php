<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('css-component') ?>
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-md-12 tab-content" id="detail-page">
      <div class="card tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Video Detail</strong></p>
            <button class="btn btn-primary btn-sm ms-auto" onclick="startEdit()">Edit</button>
          </div>
        </div>
        <div class="card-body">
          <p class="text-uppercase text-sm font-weight-bolder">General Information</p>
          <div class="row">
            <div class="col-md-12 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Video ID</p>
              <span class="text-sm videoId-content"><span class="placeholder-wave"><span class="placeholder col-1 "></span></span></span>
            </div>
            <div class="col-md-12 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Title</p>
              <span class="text-sm title-content"><span class="placeholder-wave"><span class="placeholder col-2 "></span></span></span>
            </div>
            <div class="col-md-12 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Thumbnail</p>
              <div class="thumbnail-content"><span class="placeholder-wave"><span class="placeholder col-3 "></span></span></div>
            </div>
            <div class="col-md-6 mb-3">
              <p class="mb-0 text-sm font-weight-bold ">Video</p>
              <video class="mb-5 video-content-wraper" width="727" height="400" class="mb-5" controls>
                <!-- <source class="video-content" src="" type="video/mp4">
                Your browser does not support the video tag. -->
              </video>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 tab-content d-none" id="edit-page">
      <div class="card tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Video Detail</strong></p>
            <button class="btn btn-danger btn-sm ms-auto" onclick="stopEdit()">Back</button>
          </div>
        </div>
        <form class="card-body" enctype="multipart/form-data" id="video-edit-form">
          <p class="text-uppercase text-sm font-weight-bolder">General Information</p>
          <div class="row">
            <div class="col-md-12 mb-3">
              <!-- <p class="mb-0 text-sm font-weight-bold ">Video ID</p> -->
              <input style="display: none;" class="form-control video-id-content-setting" type="text" id="video-id-input" disabled>
              <input style="display: none;" name="video_category_id" class="form-control title-content-setting" type="text" id="video-id-category" required>
              <input style="display: none;" name="order" class="form-control title-content-setting" type="text" id="video-order" required>
            </div>
            <div class="col-md-12 mb-3">
              <p class="mb-0 text-sm font-weight-bold ">Title</p>
              <input class="form-control title-content-setting" name="title" type="text" id="title-input" required>
            </div>
            <div class="col-md-12 mb-3">
              <p class="mb-0 text-sm font-weight-bold ">Thumbnail</p>
              <div>
                <input class="form-control" name="thumbnail" type="file" id="thumbnail-input" required>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <p class="mb-0 text-sm font-weight-bold ">Video</p>
              <div>
                <input class="form-control" name="video" type="file" id="video-input" required>
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
              <button class="btn btn-primary btn" id="submit-btn-course-detail-setting">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script src="/js/utils/getRupiah.js"></script>
<script src="/js/api/admin/videoDetail.js"></script>
<?= $this->endSection() ?>