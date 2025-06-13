<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(config('app.TITLE_HEADER')); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/uploads/_images/favicon.png">
    <link rel="icon" type="image/png" href="/uploads/_images/favicon.png" />
    <?php echo $__env->make('admin._header_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('additional_css'); ?>
</head>



<body class="hold-transition sidebar-mini layout-fixed text-sm">

<!-- ModalWarning =============================================================================================================================== -->
<?php echo $__env->make('admin._include-modals.modal-warning', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- ModalRestrictions=============================================================================================================================== -->
<?php echo $__env->make('admin._include-modals.modal-restrictions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- ModalRestrictions=============================================================================================================================== -->
<?php echo $__env->make('admin._include-modals.modal-show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- ModalRestrictions=============================================================================================================================== -->
<?php echo $__env->make('admin._include-modals.modal-image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- ModalDocuments=============================================================================================================================== -->
<?php echo $__env->make('admin._include-modals.modal-document', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="wrapper">

<!-- =============================================== -->
<?php echo $__env->make('admin._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin._modules', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- =============================================== -->


<?php echo $__env->yieldContent('content'); ?>


<!-- =============================================== -->
<?php echo $__env->make('admin._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- =============================================== -->


</div>
<!-- ./wrapper -->

<?php echo $__env->make('admin._header_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('additional_js'); ?>

</body>
</html>
<?php /**PATH /var/www/resources/views/admin/master.blade.php ENDPATH**/ ?>