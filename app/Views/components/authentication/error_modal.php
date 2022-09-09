<div class="modal" tabindex="-1" id="message-modal">
    <div class="modal-dialog error">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">System Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?php echo session()->getFlashdata('error'); ?></p>
            </div>
        </div>
    </div>
</div>
<?php if (!empty(session()->getFlashdata('error'))) : ?>
<script>
    $('document').ready(function () {
        $('#message-modal').modal('toggle');
    })
</script>
<?php endif; ?>