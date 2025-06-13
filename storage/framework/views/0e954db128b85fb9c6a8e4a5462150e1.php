<div class="modal fade" id="ModalRestriction">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-exclamation-triangle  text-danger" ></i> <strong><span id="title_res"></span></strong></h6>
                <button type="button" class="close" data-dismiss="modal" style="cursor: pointer">&times;</button>
            </div>

            <!-- Modal body -->

            <div class="modal-body">
                <div class="callout callout-danger">
                    <span id="content_res_l"></span><strong><span id="content_res_b"></span></strong>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" style="cursor: pointer"><?php echo e(__('global.close')); ?></button>
            </div>

        </div>
    </div>
</div>
<?php /**PATH /var/www/resources/views/admin/_include-modals/modal-restrictions.blade.php ENDPATH**/ ?>