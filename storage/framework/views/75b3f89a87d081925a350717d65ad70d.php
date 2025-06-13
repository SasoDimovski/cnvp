<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>

    <title><?php echo e(config('app.TITLE_HEADER')); ?></title>
    <link rel="shortcut icon" type="image/png" href="/uploads/_images/favicon.png">
    <link rel="icon" type="image/png" href="/uploads/_images/favicon.png" />
    <?php echo $__env->make('auth::_header_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('additional_css'); ?>
</head>

<body>

<div class="login-wrap">
    <div class="login-html">
        <div class="login-form">
            <div class="sign-in-htm">




<?php echo $__env->yieldContent('content'); ?>




            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('auth::_header_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('additional_js'); ?>

</body>
</html>
<?php /**PATH /var/www/Modules/Auth/resources/views/master.blade.php ENDPATH**/ ?>