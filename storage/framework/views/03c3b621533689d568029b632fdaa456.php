<?php
$lang = request()->segment(2);
$url = 'admin/' . $lang . '/' . $module->link;
$url_store = url($url . '/store-record-day');
$url_update = url($url . '/update-record-day');
$url_delete = url($url . '/delete-record-day');
$url_fill_dropdown = url($url);
//$updatedby=app('request')->input('id_user')??Auth::id();
$insertedby=Auth::id();
?>


<div id="edit-record-day-container">
    <?php echo $__env->make('Records::records._records-day', [
    'url_update' => $url_update,
    'url_store' => $url_store,
    'url_fill_dropdown' => $url_fill_dropdown,
    'insertedby' => $insertedby,
    'id_country' => $id_country,
    'record' => $records,
    'date' => $date,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>



<!-- toastr CSS -->
<link rel="stylesheet" href="<?php echo e(url('LTE/plugins/toastr/toastr.min.css')); ?>">
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">

<!-- Select2 -->
<script src="<?php echo e(url('LTE/plugins/select2/js/select2.full.min.js')); ?>"></script>
<!-- toastr JS -->
<script src="<?php echo e(url('LTE/plugins/toastr/toastr.min.js')); ?>"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
<?php /**PATH /var/www/Modules/Records/resources/views/records/edit-records-day.blade.php ENDPATH**/ ?>