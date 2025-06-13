<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('app_admin/css/auth/bootstrap.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('app_admin/css/auth/style.css')); ?>">
    <script type="text/javascript" src="<?php echo e(url('app_admin/js/auth/jquery-3.4.1.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(url('app_admin/js/auth/bootstrap.min.js')); ?>"></script>
</head>

<body>
    <div>
        <p><?php echo e(__('auth.mail-forgotten.hi')); ?> <strong><?php echo e($name); ?> <?php echo e($surname); ?></strong>,<p>
        <p><?php echo e(__('auth.mail-forgotten.made')); ?><br>
        <p><?php echo e(__('auth.mail-forgotten.link')); ?> <br><a href="<?php echo e($url); ?>"><?php echo e($url); ?></a></p>
        <p><?php echo e(__('auth.mail-forgotten.note')); ?><br>
        <?php echo e(__('auth.mail-forgotten.expire')); ?></p>
        <p><?php echo e(__('auth.mail-forgotten.regards')); ?><br><strong><?php echo e(config('app.TITLE')); ?></strong></p>
        <p><a href="<?php echo e(config('app.URL')); ?>"><?php echo e(config('app.URL')); ?></a></p>
    </div>
</body>

</html>
<?php /**PATH /var/www/Modules/Auth/resources/views/auth/mail-forgotten.blade.php ENDPATH**/ ?>