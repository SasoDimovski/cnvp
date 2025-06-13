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
        <p><?php echo __('users.mail-registration.hi'); ?> <strong><?php echo $name; ?> <?php echo $surname; ?></strong>,<p>
        <?php echo __('users.mail-registration.made'); ?> <strong><?php echo config('app.TITLE'); ?></strong><br>

         <?php echo __('users.mail-registration.link'); ?> <a href="<?php echo $url; ?>"><?php echo $url; ?></a><p>
        <p> <?php echo __('users.mail-registration.note'); ?><br>
        <?php echo __('users.mail-registration.expire',['name'=>config('auth.registration_link')]); ?><p>
         <p><?php echo __('users.mail-registration.link_app'); ?> <a href="<?php echo config('app.URL'); ?>"><?php echo config('app.URL'); ?></a></p>
        <p><?php echo __('users.mail-registration.regards'); ?><br><strong><?php echo config('app.TITLE'); ?></strong></p>

    </div>
</body>

</html>
<?php /**PATH /var/www/Modules/Users/resources/views/users/mail-registration.blade.php ENDPATH**/ ?>