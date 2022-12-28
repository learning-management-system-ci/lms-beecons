<?= $this->extend('layouts/admin_layout') ?>

  <?= $this->section('css-component') ?>
    <link rel="stylesheet" href="<?= base_url('style/datatable.css') ?>">
  <?= $this->endSection() ?>

  <?= $this->section('app-component') ?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Transaction table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="transaction-table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody id="transaction-list-content">
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
              <!-- <nav aria-label="Page navigation example" class="px-2">
                <ul class="pagination justify-content-center">
                  <li class="page-item">
                    <a class="page-link" href="javascript:;" aria-label="Previous">
                      <i class="fa fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item"><a class="page-link" href="javascript:;">1</a></li>
                  <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
                  <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:;" aria-label="Next">
                      <i class="fa fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav> -->
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.js"></script>
    <script src="/js/api/admin/transaction.js"></script>
  <?= $this->endSection() ?>
