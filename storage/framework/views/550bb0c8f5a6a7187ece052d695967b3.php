<?php $__env->startSection('content'); ?>

                <div class="hr-top">
                    <div class="hr-top-label"><?php echo e(__('auth.registration.welcome')); ?></div>
                </div>
                <label for="tab-1" class="tab"><?php echo e(config('app.TITLE')); ?></label>
                <form action="<?php echo e(url('/registration-post')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="hash" name="hash" value="<?php echo e($hash); ?>">
                    <div class="group">
                        <label for="new-password" class="label"><?php echo e(__('auth.registration.password')); ?></label>
                        <input type="password" class="input" id="new-password" name="new-password" maxlength="30"
                               placeholder="" >
                    </div>
                    <div class="group">
                        <label for="confirm-password" class="label"><?php echo e(__('auth.registration.confirm_password')); ?></label>
                        <input type="password" class="input" id="confirm-password" name="confirm-password"
                               maxlength="30" >
                        <div class="label" style="width: 100%;text-align: right;" id="toggle_img"><img
                                src="/auth/images/eye-close.png" style="cursor: pointer;" id="toggle"
                                onclick="toggleSwap()"
                                title="<?php echo e(__('auth.registration.toggle')); ?>"
                            ></div>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="<?php echo e(__('auth.registration.enter')); ?>">
                    </div>
                    <div class="foot-lnk"></div>
                    <div class="hr">
                        <?php echo $__env->make('auth::_flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php if(count($errors) > 0): ?>
                            <?php $__currentLoopData = $errors->get('new-password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="alert alert-danger alert-dismissible show error_massage" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
                                    <?php echo $error; ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $errors->get('confirm-password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="alert alert-danger alert-dismissible show error_massage" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
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
                        echo " (v. " . phpversion() . ")"; ?>
                    </div>
                </form>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional_css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional_js'); ?>
<script>
    ////////////////////////////////////////////////////////////////////////
    $(document).ready(function () {
        // show the alert
        setTimeout(function () {
            $(".alert").alert('close');
        }, 5000);
    });
    ////////////////////////////////////////////////////////////////////////
    // Query the elements
    const passwordEle = document.getElementById('new-password');
    const passwordEle1 = document.getElementById('confirm-password');
    const toggleEle = document.getElementById('toggle');
    toggleEle.addEventListener('click', function () {
        const type = passwordEle.getAttribute('type');
        passwordEle.setAttribute(
            'type',
            type === 'password' ? 'text' : 'password'
        );
        const type1 = passwordEle1.getAttribute('type');
        passwordEle1.setAttribute(
            'type',
            type1 === 'password' ? 'text' : 'password'
        );
    });
    ////////////////////////////////////////////////////////////////////////
    window.setInterval('refresh()', 100000); 	// Call a function every 10000 milliseconds (OR 10 seconds).
    // Refresh or reload page.
    function refresh() {
        window.location.reload();
    }

    ////////////////////////////////////////////////////////////////////////
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Auth/resources/views/auth/registration.blade.php ENDPATH**/ ?>