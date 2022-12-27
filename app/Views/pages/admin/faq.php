<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('css-component') ?>
<link rel="stylesheet" href="/style/admin.css">
<?= $this->endSection() ?>

<?= $this->section('app-component') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>List FAQ</h6>
                    <button data-bs-target="#add-faq-dialog" data-bs-toggle="modal" id="add-faq-btn" class="btn btn-primary btn-sm ms-auto">Add FAQ</button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pertanyaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jawaban</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-faq-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-faq-form">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Pertanyaan</label>
                        <input type="text" name="add-title" class="form-control" id="add-faq-title">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Jawaban</label>
                        <textarea class="form-control" name="add-content" id="add-faq-content"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button data-bs-dismiss="modal" id="send-add-faq" type="button" class="btn bg-gradient-primary">Send message</button>
            </div>
        </div>
    </div>
</div>

<div id="update-modal"></div>
<div id="delete-modal"></div>

<?= $this->endSection() ?>

<?= $this->section('js-component') ?>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Datatables Package -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/date-1.2.0/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.js"></script>
<script src="/js/api/admin/faq.js"></script>
<?= $this->endSection() ?>