<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="<?= base_url('style/datatable.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4" id="table-course-card">
        <div class="card-header pb-0 d-flex align-items-center justify-content-between">
          <h6>Bundling Table</h6>
          <div>
            <button class="btn btn-primary btn-sm ms-auto" onclick="createCourseShow()">Add Bundling</button>
            <a class="btn btn-warning btn-sm ms-auto" href="admin/course">Course List</a>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="course-table">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody id="course-list-content">
                <!-- <tr>
                      <td>
                        <p class="mb-0 text-sm font-weight-bold px-3 ">23/04/18</p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">Luthfi Anum Pratama</p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-sm font-weight-bold">Rp. 270.000</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Success</span>
                      </td>
                      <td class="align-middle">
                        <a href="/admin/transaction/1" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <p class="mb-0 text-sm font-weight-bold px-3 ">23/04/18</p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">Luthfi Anum Pratama</p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-sm font-weight-bold">Rp. 270.000</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                      </td>
                      <td class="align-middle">
                        <a href="/admin/transaction/1" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <p class="mb-0 text-sm font-weight-bold px-3 ">23/04/18</p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">Luthfi Anum Pratama</p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-sm font-weight-bold">Rp. 270.000</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-danger">Failed</span>
                      </td>
                      <td class="align-middle">
                        <a href="/admin/transaction/1" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr> -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card mb-4 d-none" id="create-course-card">
        <div class="card-header pb-0 d-flex align-items-center">
          <h6>Create New Bundling</h6>
          <button class="btn btn-danger btn-sm ms-auto" onclick="createCourseHide()">Back</button>
        </div>
        <div class="card-body pb-2">
          <form class="row" enctype="multipart/form-data" id="create-bundling-form">
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Title</label>
                <input class="form-control title-content-create" name="title" type="text" id="title-input">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Category Bundling</label>
                <select class="form-select type-content-create" id="cat-bunding-wraper" name="category_bundling_id" required>
                  <option value="" disabled selected hidden>-- Select Course Category --</option>
                </select>
              </div>
            </div>
            <input class="form-control author-content-create hide" name="author_id" type="text" id="author-input" disabled>
            <!-- <div class="col-md-6">
             
              <div class="form-group">

              </div>
            </div> -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Description</label>
                <textarea name="description" class="form-control description-content-create" rows="7" id="description-input"> </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Price</label>
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">Rp. </span>
                  <input required name="old_price" class="form-control price-content-create" type="number" id="price-input">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">After Discount Price</label>
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">Rp. </span>
                  <input name="new_price" class="form-control after-discount-price-content-create" type="number" id="after-discount-price-input">
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Thumbnail</label>
                <div class="mb-5">
                  <input name="thumbnail" accept=".jpg, .jpeg, .png" class="form-control" type="file" id="thumbnail-input">
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between bundling-dragndrop-panel align-items-stretch">

              <div class="col-md-6 p-2 selection-course-bundling">
                <label for="example-text-input" class="form-control-label">Course untuk Bundling</label>
                <div class="selection-bundling-list p-2 border-secondary border" id="bundling_panel">

                </div>
              </div>
              <div class="col-md-6 p-2 selection-course-bundling">
                <label for="example-text-input" class="form-control-label">Course Anda</label>
                <div>
                  <input type="text" class="bundling-search-course mb-3 ps-3" placeholder="Cari Course Anda">
                  <div class="selection-course-list border-secondary border p-2" id="course_panel">
                  </div>
                </div>
              </div>

            </div>
            <div class="col-md-12 mt-3 d-flex justify-content-center">
              <button class="btn btn-primary btn" id="submit-btn-course-detail-create">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
<script src="/js/utils/textTruncate.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.js"></script>
<script src="/js/api/admin/bundling.js"></script>
<?= $this->endSection() ?>