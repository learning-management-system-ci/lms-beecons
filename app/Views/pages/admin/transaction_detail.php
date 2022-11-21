<?= $this->extend('layouts/admin_layout') ?>

  <?= $this->section('css-component') ?>
  <?= $this->endSection() ?>

  <?= $this->section('app-component') ?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12 tab-content" >
          <div class="card tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0"><strong>Transaction Detail</strong></p>
                <!-- <button class="btn btn-primary btn-sm ms-auto" onclick="startSetting()">Edit</button> -->
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm font-weight-bolder">General Information</p>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <p class="mb-0 text-sm font-weight-bold ">Transaction ID</p>
                  <span class="text-sm transactionId-content">-</span>
                </div>
                <div class="col-md-6 mb-3">
                  <p class="mb-0 text-sm font-weight-bold ">Order Date</p>
                  <span class="text-sm orderDate-content">-</span>
                </div>
                <div class="col-md-6 mb-3">
                  <p class="mb-0 text-sm font-weight-bold ">Username</p>
                  <span class="text-sm username-content">-</span>
                </div>
                <div class="col-md-6 mb-3">
                  <p class="mb-0 text-sm font-weight-bold ">Status</p>
                  <span class="badge badge-sm status-content">-</span>
                  <!-- <span class="text-sm status-content">Software Engineer</span> -->
                </div>
                <div class="col-md-6 mb-3">
                  <p class="mb-0 text-sm font-weight-bold">Amount</p>
                  <span class="text-sm amount-content">-</span>
                </div>
              </div>
              <p class="text-uppercase text-sm font-weight-bolder">Items</p>
              <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-body px-0 pt-0 pb-2">
                      <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="table-user">
                          <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" onclick="sortTable(0)">Name</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" onclick="sortTable(1)">Type</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" onclick="sortTable(2)">Price</th>
                            </tr>
                          </thead>
                          <tbody id="item-list-content">
                            <!-- <tr>
                              <td>
                                <div class="d-flex px-2 py-1">
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">John Michael</h6>
                                  </div>
                                </div>
                              </td>
                              <td class="align-middle text-center">
                                <span class="text-secondary text-sm font-weight-bold">Rp. 270.000</span>
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
                            </tr>               -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="card fade d-none" id="setting">
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
                    <textarea  class="form-control address-content-setting" row="3" id="address-input"> </textarea>
                  </div>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                  <button class="btn btn-primary btn" onclick="postUserProfileData()">Save</button>
                </div>
              </div>
            </div>
          </div> -->
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
                              <td class="align-middle text-center">
                                <span class="text-secondary text-sm font-weight-bold">Rp. 270.000</span>
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
        </div>
      </div>
    </div>
  <?= $this->endSection() ?>

  <?= $this->section('js-component') ?>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
      integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <script src="/js/utils/getRupiah.js"></script>
    <script src="/js/api/admin/transactionDetail.js"></script>
  <?= $this->endSection() ?>
