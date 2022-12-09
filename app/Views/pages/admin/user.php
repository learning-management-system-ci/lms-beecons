<?= $this->extend('layouts/admin_layout') ?>

  <?= $this->section('css-component') ?>
    <link rel="stylesheet" href="<?= base_url('style/datatable.css') ?>">
  <?= $this->endSection() ?>

  <?= $this->section('app-component') ?>
  <div class="container-fluid py-4">
    <div class="row">
      <!-- <div class="col-12">
        <div class="card mb-4">
          <div class="card-body px-3 pt-3 pb-0">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Search" id="search-input" onkeyup="filterTable()">
            </div>
          </div>
        </div>
      </div> -->
      <div class="col-12">
        <div class="card mb-4">
          <!-- <div class="card-header pb-0">
            <h6>Authors table</h6>
          </div> -->
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <!-- <table id="table-user" class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th >Name</th>
                    <th >Email</th>
                    <th >Role</th>
                    <th ></th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table> -->
              <table class="table align-items-center mb-0" id="table-user">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody id="user-list-content">
                  <!-- <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">John Michael</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Manager</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-success">User</span>
                    </td>
                    <td class="align-middle">
                      <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
                      <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Delete user">
                        Delete
                      </a>
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
                      <p class="text-xs font-weight-bold mb-0">Manager</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-warning">Author</span>
                    </td>
                    <td class="align-middle">
                      <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
                      <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Delete user">
                        Delete
                      </a>
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
                      <p class="text-xs font-weight-bold mb-0">Manager</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-secondary">Admin</span>
                    </td>
                    <td class="align-middle">
                      <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a>
                      <a href="javascript:;" class="text-secondary font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Delete user">
                        Delete
                      </a>
                    </td>
                  </tr> -->
                </tbody>
              </table>
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
      
    <!-- Datatables Package -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.js"></script>

    <script src="/js/api/admin/user.js"></script>
  <?= $this->endSection() ?>