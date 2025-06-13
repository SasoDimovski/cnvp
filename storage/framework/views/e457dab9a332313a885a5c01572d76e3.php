<?php
    $date = request()->query('date');
    $type = request()->query('type');
    $year = request()->query('year');
?>

<select class="form-control" style="width:100%;" id="id_assignment" name="id_assignment" required>
    <option value="">&nbsp;</option>


    <?php if(count($assignments) > 0): ?>
        <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $endDate = \Carbon\Carbon::parse($assignment->end_date);
                $hide = false;

                if (($type === 'day' || $type === 'week') && $date) {
                    $compareDate = \Carbon\Carbon::parse($date);
                    if ($endDate->lt($compareDate)) {
                        $hide = true;
                    }
                }

                if ($type === 'day-table' && $year) {
                    $assignmentYear = $endDate->year;
                    if ($assignmentYear < intval($year)) {
                        $hide = true;
                    }
                }

                if ($hide) {
                    continue;
                }
            ?>
            <option value="<?php echo e($assignment->id); ?>">
                <?php echo e($assignment->name); ?>,
                <?php echo e($endDate->format('d.m.Y')); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>




































</select>
<?php /**PATH /var/www/Modules/Records/resources/views/records/_assignments.blade.php ENDPATH**/ ?>