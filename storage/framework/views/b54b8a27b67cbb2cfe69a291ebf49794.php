<!-- ModalDoc =============================================================================================================================== -->
<div class="modal fade" id="ModalDocument">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" style="text-align: center"><i class="fa fa-copy text-info"></i>  <b id="title_doc"></b>
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="needs-validation" role="form" id="url_doc" name="url_doc"  action="" method="POST" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" id="url_return_doc" name="url_return_doc"  value="">
                    <input type="hidden" id="query_doc" name="query_doc" value="">
                    <input type="hidden" id="success_doc" name="success_doc" value="">
                    <input type="hidden" id="error_doc" name="error_doc" value="">

                    <input type="hidden" id="id_doc" name="id_doc" value="">
                    <input type="hidden" id="id_record_doc" name="id_record_doc" value="">
                    <input type="hidden" id="id_user_doc" name="id_user_doc" value="">
                    <input type="hidden" id="id_module_doc" name="id_module_doc" value="">

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">

                            <input class="custom-control-input" type="checkbox" id="active_doc" name="active_doc">
                            <label for="active_doc" class="custom-control-label"><?php echo e(__('global.active')); ?></label>
                        </div>
                    </div>
                    <div class="form-group"><i class="fas fa-archive text-warning"></i>
                        <label for="name_doc" id="name_des_doc"></label>
                        <input type="text" id="name_doc" name="name_doc" class="form-control" value="" maxlength="100">
                    </div>

                    <div class="form-group"><i class="fas fa fa-book text-danger"></i>
                        <label id="file_name_desc_doc"></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <label class="custom-file-label" for="file_doc" id="file_name_doc"></label>
                                <input type="file" class="custom-file-input" id="file_doc" name="file_doc" onchange="checkDocuments(this,'<?php echo e(__('record.edit.document.restriction')); ?>','<?php echo e(__('record.edit.document.to_large')); ?>','<?php echo e(__('record.edit.document.ext_check_doc')); ?>')">

                            </div>
                        </div>
                    </div>
                    <div class="form-group"><i class="fas fa-comment text-info"></i>
                        <label for="comment_doc"><?php echo e(__('record.edit.document.comment')); ?></label>
                        <textarea type="text" id="comment_doc" name="comment_doc" class="form-control" rows="3" maxlength="400"></textarea>
                    </div>


                </form>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('global.close')); ?></button>
                <button type="button" class="btn btn-success" onclick="saveDocument()"><?php echo e(__('global.save')); ?></button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- end ModalDoc =============================================================================================================================== -->
<?php /**PATH /var/www/resources/views/admin/_include-modals/modal-document.blade.php ENDPATH**/ ?>