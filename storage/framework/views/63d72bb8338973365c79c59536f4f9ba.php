<div class="modal fade" id="ModalWarning">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" style="text-align: center"><i class="fa fa-exclamation-triangle text-danger"></i> <strong><span id="title_war"></span></strong></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="callout callout-danger">
                    <span id="content_war_l"></span><br>
                    <strong><span id="content_war_b"></span></strong><br>
                    <span id="content_war_sub_l"></span><br>
                    <strong><span id="content_war_sub_b"></span></strong>
                </div>
            </div>

            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('global.no')); ?></button>
                <form action="" method="POST" id="url_war" name="url_war">
                    <input type="hidden" id="url_return_war" name="url_return_war" value="">
                    <input type="hidden" id="query_war" name="query_war" value="">
                    <input type="hidden" id="success_war" name="success_war" value="">
                    <input type="hidden" id="error_war" name="error_war" value="">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger"><?php echo e(__('global.yes')); ?></button>
                </form>
            </div>


        </div>
    </div>
</div>
<?php /**PATH /var/www/resources/views/admin/_include-modals/modal-warning.blade.php ENDPATH**/ ?>