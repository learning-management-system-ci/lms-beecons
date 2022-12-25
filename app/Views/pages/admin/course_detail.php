<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('css-component') ?>
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="card shadow-lg mx-4 mt-4">
  <div class="card-body p-3">
    <div class="row gx-4">
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1 title-content placeholder-glow">
            <span class="placeholder col-4" style="display: inline !important;">--------------------------------</span>
          </h5>
          <p class="mb-0 font-weight-bold text-sm author-content placeholder-glow">
            <span class="placeholder col-8 ">--------------</span>
          </p>
        </div>
      </div>
      <div class="col-lg-5 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
        <div class="nav-wrapper position-relative end-0">
          <ul class="nav nav-pills nav-fill p-1" role="tablist">
            <li class="nav-item">
              <a class="nav-link mb-0 px-2 py-1 active d-flex align-items-center justify-content-center" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" href="javascript:;" role="tab" aria-controls="general" aria-selected="true">
                <i class="ni ni-hat-3"></i>
                <span class="ms-2">General</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-0 px-2 py-1 d-flex align-items-center justify-content-center" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" href="javascript:;" role="tab" aria-controls="video" aria-selected="false">
                <i class="ni ni-button-play"></i>
                <span class="ms-2">Chapter</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-0 px-2 py-1 d-flex align-items-center justify-content-center" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" href="javascript:;" role="tab" aria-controls="review" aria-selected="false">
                <i class="ni ni-chat-round"></i>
                <span class="ms-2">Review</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-md-12 tab-content">
      <div class="card tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center justify-content-between">
            <p class="mb-0"><strong>General Information</strong></p>
            <div>
              <button class="btn btn-primary btn-sm ms-auto" onclick="startSetting()">Edit</button>
              <button class="btn btn-danger btn-sm ms-auto" id='delete-course'>Hapus</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Title</p>
              <span class="text-sm title-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Author</p>
              <span class="text-sm author-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Type</p>
              <span class="text-sm type-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Category</p>
              <span class="text-sm category-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-12 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Tags</p>
              <span class="text-sm tags-content"><span class="placeholder col-4 "></span></span>
            </div>
            <div class="col-md-12 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Description</p>
              <span class="text-sm description-content"><span class="placeholder col-2 "></span><span class="placeholder col-2 "></span><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-12 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold ">Key Takeaways</p>
              <span class="text-sm key-takeaways-content"><span class="placeholder col-3 "></span><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-12 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold">Suitable For</p>
              <span class="text-sm suitable-for-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold">Price</p>
              <span class="text-sm price-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3 placeholder-glow">
              <p class="mb-0 text-sm font-weight-bold">After Discount Price</p>
              <span class="text-sm after-discount-price-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-12 mb-3">
              <p class="mb-0 text-sm font-weight-bold">Thumbnail</p>
              <div class="col-md-3">
                <img id="frame" src="" class="img-thumbnail thumbnail-content" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card fade d-none" id="setting">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Setting</strong></p>
            <button class="btn btn-danger btn-sm ms-auto" onclick="stopSetting()">Cancel</button>
          </div>
        </div>
        <form id="update-course-form" class="card-body pb-2" enctype="multipart/form-data">
          <div class="row ">
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Title</label>
                <input class="form-control title-content-setting" minlength="8" name="title" required type="text" id="title-input">
              </div>
              <small>Minimal 8 Karakter</small>
            </div>
            <div class="col-md-6">
              <input class="hide form-control author-content-create" name="author_id" type="text" id="author-input" disabled>
              <input class="hide form-control author-content-create" id="service" name="service" type="text" value="course">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Type</label>
                <select class="form-select type-content-setting" name="type_id" required id="type-input-wraper">
                  <option disabled>Select Course Type</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Tag</label>
                <select class="tag-picker" multiple id="type-tag-input" required>
                  <option disabled>Pilih Type Terlebih Dulu</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Category</label>
                <select name="category_id" required class="form-select category-content-setting" id="category-input-wraper">
                  <option disabled>Select Course Category</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Description</label>
                <textarea minlength="8" required name="description" class="form-control description-content-setting" rows="7" id="description-input"> </textarea>
                <small>Minimal 8 Karakter</small>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Key Takeways</label>
                <textarea name="key_takeaways" class="form-control key-takeaways-content-setting" rows="5" id="key-takeaways-input"> </textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Suitable For</label>
                <textarea class="form-control suitable-for-content-setting" rows="3" id="suitable-for-input"> </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Price</label>
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">Rp. </span>
                  <input required name="old_price" class="form-control price-content-setting" type="number" id="price-input">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">After Discount Price</label>
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">Rp. </span>
                  <input name="new_price" class="form-control after-discount-price-content-setting" type="number" id="after-discount-price-input">
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Thumbnail</label>
                <div class="mb-5">
                  <input accept=".jpg, .jpeg, .png" required name="thumbnail" class="form-control" type="file" id="thumbnail-input">
                </div>
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
              <button class="btn btn-primary btn" id="submit-btn-course-detail-setting">Save</button>
            </div>
          </div>
        </form>
      </div>
      <div class="card tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Chapter List</strong></p>
            <button class="btn btn-primary btn-sm ms-auto" onclick="startCreateVideo()">Add Chapter</button>
          </div>
        </div>
        <div class="card-body">
          <div class="list-group" id="course-video">

          </div>
          <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
              <button class="btn btn-primary btn-sm px-4 mt-4" id="submit-btn-course-list-video">Save</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card fade d-none" id="create-video">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Add Video</strong></p>
            <button class="btn btn-danger btn-sm ms-auto" onclick="stopCreateVideo()">Back</button>
          </div>
        </div>
        <form class="card-body" id="add-video" enctype="multipart/form-data">
          <div class="row ">
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Title</label>
                <input class="form-control title-content-setting" name="title" type="text" id="title-input-add">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Thumbnail</label>
                <div>
                  <input class="form-control" name="thumbnail" type="file" id="thumbnail-input">
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Video</label>
                <div class="mb-5">
                  <input class="form-control" name="video" type="file" id="video-input">
                </div>
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
              <button class="btn btn-primary btn" id="submit-btn-course-detail-setting">Save</button>
            </div>
          </div>
        </form>
      </div>
      <div class="card tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Review</strong></p>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="table-user">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" onclick="sortTable(0)">Username</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" onclick="sortTable(1)">Feedback</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" onclick="sortTable(2)">Score</th>
                        </tr>
                      </thead>
                      <tbody id="course-review-list-content">
                        <tr>
                          <td>
                            <h6 class="mb-0 text-sm px-2">John Michael</h6>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Numquam, ullam.</span>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">4.5</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">John Michael</h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class="badge bg-warning">Pending</span>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">Rp. 10.000</p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">John Michael</h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class="badge bg-danger">Failed</span>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">Rp. 10.000</p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer pt-3  ">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="copyright text-center text-sm text-muted text-lg-start">
            © <script>
              document.write(new Date().getFullYear())
            </script>,
            made with <i class="fa fa-heart"></i> by
            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
            for a better web.
          </div>
        </div>
        <div class="col-lg-6">
          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</div>
<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<script src="/js/utils/getRupiah.js"></script>
<script src="/js/utils/textTruncate.js"></script>
<script src="/js/api/admin/courseDetail.js"></script>
<?= $this->endSection() ?>