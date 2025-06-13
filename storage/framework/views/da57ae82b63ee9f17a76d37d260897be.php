<?php $__env->startSection('content'); ?>

                <div class="hr-top" >
                    <div class="hr-top-label" ></div>
                </div>
                <label for="tab-1" class="tab"><?php echo e(config('app.TITLE')); ?></label>
                <form action="<?php echo e(url('/forgotten-email-post')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="group">
                        <label for="email" class="label"><?php echo e(__('auth.forgotten.email_label')); ?> </label>
                        <input type="text" class="input" id="email" name="email" placeholder="<?php echo e(__('auth.forgotten.email')); ?>"  maxlength="60" required>
                    </div>
                    <div class="line"></div>
                    <div class="group">
                        <input type="submit" class="button" value="<?php echo e(__('auth.forgotten.send')); ?>">
                    </div>

                    <div class="foot-lnk">
                        <a href="<?php echo e(url('admin')); ?>"><?php echo e(trans('auth.forgotten.back')); ?></a>
                    </div>

                    <div class="hr" style="height: 224px">
                        <?php echo $__env->make('auth::_flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php if(count($errors) > 0): ?>
                            <?php $__currentLoopData = $errors->get('email'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="alert alert-danger alert-dismissible show error_massage" role="alert" >
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $error; ?>

                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>

                    <div class="footer">
                        <?php echo e(__('global.developed_by')); ?>

                        <a href="<?php echo e(config('app.DEVELOPED_LINK')); ?>" target="_blank"
                           class="footer_link"><?php echo e(config('app.DEVELOPED')); ?></a>
                        <?php
                        echo " (v. " . phpversion().")" ; ?>
                    </div>

                </form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional_css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional_js'); ?>
<script>
    $(document).ready(function () {
        // show the alert
        setTimeout(function () {
            $(".alert").alert('close');
        }, 5000);
    });
    ////////////////////////////////////////////////////////////////////////
    window.setInterval('refresh()', 100000); 	// Call a function every 10000 milliseconds (OR 10 seconds).
    // Refresh or reload page.
    function refresh() {
        window .location.reload();
    }
    ////////////////////////////////////////////////////////////////////////
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Auth/resources/views/auth/forgotten-email.blade.php ENDPATH**/ ?>