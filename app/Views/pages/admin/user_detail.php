<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('css-component') ?>
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="card shadow-lg mx-4 mt-4">
  <div class="card-body p-3">
    <div class="row gx-4">
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img alt="profile_image" class="w-100 border-radius-lg shadow-sm profile-picture-content">
        </div>
      </div>
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="placeholder-glow mb-1 fullname-content">
            <span class="placeholder col-4" style="display: inline !important;">--------------------------------</span>
          </h5>
          <p class="mb-0 font-weight-bold text-sm job-name-content placeholder-glow">
            <span class="placeholder col-8 ">--------------</span>
          </p>
        </div>
      </div>
      <div class="col-lg-5 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
        <div class="nav-wrapper position-relative end-0">
          <ul class="nav nav-pills nav-fill p-1" role="tablist">
            <li class="nav-item">
              <a class="nav-link mb-0 px-2 py-1 active d-flex align-items-center justify-content-center" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" href="javascript:;" role="tab" aria-controls="profile" aria-selected="true">
                <i class="ni ni-single-02"></i>
                <span class="ms-2">Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-0 px-2 py-1 d-flex align-items-center justify-content-center" id="learning-tab" data-bs-toggle="tab" data-bs-target="#learning" href="javascript:;" role="tab" aria-controls="learning" aria-selected="false">
                <i class="ni ni-hat-3"></i>
                <span class="ms-2">Learning</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-0 px-2 py-1 d-flex align-items-center justify-content-center" id="transaction-tab" data-bs-toggle="tab" data-bs-target="#transaction" href="javascript:;" role="tab" aria-controls="transaction" aria-selected="false">
                <i class="ni ni-cart"></i>
                <span class="ms-2">Transaction</span>
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
      <div class="card tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Profile</strong></p>
            <button class="btn btn-primary btn-sm ms-auto" onclick="startSetting()">Settings</button>
          </div>
        </div>
        <div class="card-body">
          <div class="row placeholder-glow">
            <div class="col-md-6 mb-3">
              <p class="mb-0 text-sm font-weight-bold ">Full Name</p>
              <span class="text-sm fullname-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3">
              <p class="mb-0 text-sm font-weight-bold ">Email</p>
              <span class="text-sm email-content"><span class="placeholder col-2 "></span></span><span class="text-success"><i class="ni ni-check-bold"></i></span>
            </div>
            <div class="col-md-6 mb-3">
              <p class="mb-0 text-sm font-weight-bold ">Job</p>
              <span class="text-sm job-name-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3">
              <p class="mb-0 text-sm font-weight-bold">Role</p>
              <span class="text-sm"><span class="placeholder col-1 "></span></span>
            </div>
            <div class="col-md-6 mb-3">
              <p class="mb-0 text-sm font-weight-bold">Date Birth</p>
              <span class="text-sm date-birth-content"><span class="placeholder col-2 "></span></span>
            </div>
            <div class="col-md-6 mb-3">
              <p class="mb-0 text-sm font-weight-bold">Phone</p>
              <span class="text-sm phone-number-content"><span class="placeholder col-3 "></span></span>
            </div>
            <div class="col-md-12 mb-3">
              <p class="mb-0 text-sm font-weight-bold">Address</p>
              <span class="text-sm address-content"><span class="placeholder col-5 "></span></span>
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
        <div class="card-body">
          <div class="row ">
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Full Name</label>
                <input class="form-control fullname-content-setting" type="text" id="fullname-input">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-success">
                <label for="example-text-input" class="form-control-label">Email</label>
                <input class="form-control is-valid email-content-setting" type="text" id="email-input">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Job</label>
                <select class="form-control job-name-content-setting" id="job-input">
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Role</label>
                <select class="form-control role-content-setting" id="role-input">
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Date Birth</label>
                <input class="form-control date-birth-content-setting" type="date" id="date-birth-input">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Phone</label>
                <input class="form-control phone-number-content-setting" type="text" id="phone-input">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Address</label>
                <textarea class="form-control address-content-setting" row="3" id="address-input"> </textarea>
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
              <button class="btn btn-primary btn" onclick="postUserProfileData()">Save</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card tab-pane fade" id="learning" role="tabpanel" aria-labelledby="learning-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Learning</strong></p>
          </div>
        </div>
        <div class="card-body">
          <p class="text-uppercase text-sm">Course</p>
          <div class="row">
            <div class="col-12">
              <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="table-user">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" onclick="sortTable(0)">Course Name</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" onclick="sortTable(1)">Completion Percentage</th>
                        </tr>
                      </thead>
                      <tbody id="user-course-list-content">
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">John Michael</h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class="badge badge-sm bg-success">100%</span>
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
                            <span class="badge badge-sm bg-warning">80%</span>
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
                            <span class="badge badge-sm bg-danger">30%</span>
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
      <div class="card tab-pane fade" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0"><strong>Transaction</strong></p>
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
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" onclick="sortTable(0)">Date</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" onclick="sortTable(1)">Status</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" onclick="sortTable(2)">Amount</th>
                        </tr>
                      </thead>
                      <tbody id="user-transaction-list-content">
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">John Michael</h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class="badge bg-success">Success</span>
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
<script src="/js/utils/getRupiah.js"></script>
<script src="/js/api/admin/user.js"></script>
<script src="/js/api/admin/userDetail.js"></script>

<?= $this->endSection() ?>