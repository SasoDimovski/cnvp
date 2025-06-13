<?php if(Session::has('success')): ?>
<div class="alert alert-success alert-dismissible show error_massage" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
 <?php echo Session::get('success'); ?>

</div>
<?php endif; ?>








<?php if(Session::has('error')): ?>
    <div class="alert alert-danger alert-dismissible show error_massage" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php if(is_array(Session::get('error'))): ?>
                <?php $__currentLoopData = Session::get('error'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $message; ?><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <?php echo Session::get('error'); ?>

        <?php endif; ?>
    </div>
<?php endif; ?>


<?php if(Session::has('warning')): ?>
<div class="alert alert-warning alert-dismissible show error_massage" role="alert" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
 <?php echo Session::get('warning'); ?>

</div>
<?php endif; ?>

<?php if(Session::has('info')): ?>
    <div class="alert alert-info alert-dismissible show error_massage" role="alert" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     <?php echo Session::get('info'); ?>

    </div>
<?php endif; ?>

<?php /**PATH /var/www/resources/views/admin/_flash-message.blade.php ENDPATH**/ ?>