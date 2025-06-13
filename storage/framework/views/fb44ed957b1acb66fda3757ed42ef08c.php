<?php if(!$records->isEmpty()): ?>

            <div class="row">
                <div class="col-sm-12  scrollmenu">

                    <table id="example2" class="table_grid">
                        <thead>
                        <tr>
                            <th class="text-center" style="white-space: nowrap; width: 1px;"><?php echo e(__('records.id')); ?></th>
                            <th class="text-center" style="white-space: nowrap; width: 1px;"><?php echo e(__('records.id_group')); ?></th>
                            <th class="text-center"><?php echo e(__('records.id_country')); ?></th>
                            <th class="text-center" style="white-space: nowrap; width: 1px;"><?php echo e(__('records.date')); ?></th>
                            <th class="text-center"><?php echo e(__('records.project')); ?></th>
                            <th class="text-center"><?php echo e(__('records.assignment')); ?></th>
                            <th class="text-center"><?php echo e(__('records.activity')); ?></th>
                            <th class="text-center" style="white-space: nowrap; width: 1px;"><?php echo e(__('records.duration_s')); ?></th>
                            
                            <th style="white-space: nowrap; width: 1px;" ><i class="fas fa-lock"></i> <?php echo e(__('records.projects')); ?></th>
                            
                            <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"></i> <?php echo e(__('records.year')); ?></th>
                            
                            <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"></i> <?php echo e(__('records.record')); ?></th>
                            
                            <th style="white-space: nowrap; width: 1px;"><?php echo e(__('records.approved')); ?></th>

                        </tr>
                        </thead>


                        <tbody>
                            <?php
                            $total = 0;
                            ?>
                        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php


                                $id = $record->id ?? '';
                                $id_group = $record->id_group ?? '';
                                $id_country = $record->countries->name ?? '';
                                $project = $record->projects->name ?? '';
                                $assignment = $record->assignments->name ?? '';
                                $activity = $record->activities->name ?? '';
                                $duration = $record->duration ?? '';
                                $year = $record->year ?? '';
                                $date = (isset($record->date)) ? date("d.m.Y", strtotime($record->date)) : '';
                                $note = $record->note ?? '';


                                $insertedby = $record->insertedby ?? '';
                                $updatedby = $record->updatedby ?? '';
                                $approvedby = $record->approvedby ?? '';

                                $dateinserted = (isset($record->dateinserted)) ? date("d.m.Y  H:i:s", strtotime($record->dateinserted)) : '';
                                $dateupdated = (isset($record->dateupdated)) ? date("d.m.Y  H:i:s", strtotime($record->dateupdated)) : '';


                                $dateofapproval = (isset($record->dateofapproval)) ? date("d.m.Y  H:i:s", strtotime($record->dateofapproval)) : '';

                                $lockrecord = $record->lockrecord ?? '';
                                $total = $total + $duration;
                                ?>

                            <tr>
                                <td class="text-center"><?php echo e($id); ?></td>
                                <td class="text-center"><?php echo e($id_group); ?></td>
                                <td><?php echo e($id_country); ?></td>
                                <td><?php echo e($date); ?></td>
                                <td><?php echo e($project); ?></td>
                                <td><?php echo e($assignment); ?></td>
                                <td><?php echo e($activity); ?>

                                <?php if($note): ?>
                                    &nbsp;<i class="fas fa-comment text-warning" title="<?php echo e($note); ?>"></i>

                                <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo e($duration); ?></td>
                                <td class="text-center">
                                    <?php if($record->projects->active== 0): ?>
                                        <i class="fas fa-lock"
                                           title="<?php echo e(__('records.locked_project')); ?>"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($record->lock_== 1): ?>
                                        <i class="fas fa-lock"
                                           title="<?php echo e(__('records.locked_year')); ?>"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($record->lockrecord== 1): ?>
                                        <i class="fas fa-lock"
                                           title="<?php echo e(__('records.locked_record')); ?>"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($record->approvedby): ?>
                                        <i class="fas fa-check"
                                           title="<?php echo e(__('records.approved')); ?>: <?php echo e($record->approvedByUser->name); ?> <?php echo e($record->approvedByUser->surname); ?>, id: <?php echo e($record->approvedByUser->id); ?>"></i>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td colspan="7" class="text-right">
                                <strong><?php echo e(__('records.weekly_total')); ?>:</strong></td>
                            <td class="text-center text-danger"><strong><?php echo e($total); ?></strong>
                            <td colspan="4">
                            </td>

                        </tr>

                        </tbody>


                    </table>
                </div>
            </div>


<?php else: ?>
    <?php echo e(__('global.no_records')); ?>

<?php endif; ?>




<?php /**PATH /var/www/Modules/Records/resources/views/records/show-records-list.blade.php ENDPATH**/ ?>