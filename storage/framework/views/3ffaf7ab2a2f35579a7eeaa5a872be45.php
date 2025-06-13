<select class="form-control" style="width:100%;" id="id_activity" name="id_activity" required>
    <option value="">&nbsp;</option>
    <?php if(count($activities) > 0): ?>

        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <option value="<?php echo e($activity->id); ?>"><?php echo e($activity->name); ?> (<?php echo e($activity->id); ?>)</option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</select>
<?php /**PATH /var/www/Modules/Records/resources/views/records/_activities.blade.php ENDPATH**/ ?>