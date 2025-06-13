<?php
$id_module = $module->id ?? '';

$id =   $record->id ?? '';
$id_country = $record->countries->name?? '';
$project	 = $record->projects->name ?? '';
$assignment = $record->assignments->name ?? '';
$activity = $record->activities->name ?? '';
$duration = $record->duration ?? '';
$year = $record->year ?? '';
$date = (isset($record->date)) ? date("d.m.Y", strtotime($record->date)) : '';
$note = $record->note ?? '';


$insertedby = $record->insertedby  ?? '';
$updatedby = $record->updatedby ?? '';
$approvedby =  $record->approvedby ?? '';

$dateinserted = (isset($record->dateinserted)) ? date("d.m.Y  H:i:s", strtotime($record->dateinserted)) : '';
$dateupdated = (isset($record->dateupdated)) ? date("d.m.Y  H:i:s", strtotime($record->dateupdated)) : '';


$dateofapproval = (isset($record->dateofapproval)) ? date("d.m.Y  H:i:s", strtotime($record->dateofapproval)) : '';

$lockrecord = $record->lockrecord ?? '';
?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    <?php if($lockrecord==1): ?>
                        <span class="bg-gradient-red"><?php echo e(__('users.records.locked')); ?></span>
                    <?php else: ?>
                        <span class="bg-gradient-success"><?php echo e(__('users.records.unlocked')); ?></span>
                    <?php endif; ?>
                    <?php if($approvedby): ?>
                        <span class="bg-gradient-success"><?php echo e(__('users.records.approved')); ?></span>
                    <?php else: ?>
                        <span class="bg-gradient-warning"><?php echo e(__('users.records.unapproved')); ?></span>
                    <?php endif; ?>

                    <br>
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong><?php echo e(__('users.id')); ?></strong>: <?php echo e($id); ?></span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong><?php echo e(__('users.created_at')); ?></strong>: <?php echo e($dateinserted); ?></span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> <?php echo e(__('users.updated_at')); ?></strong>: <?php echo e($dateupdated); ?></span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-list bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong><?php echo e(__('users.records.duration')); ?></strong>:<strong class="text-red"> <?php echo e($duration); ?></strong>
                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.id_country')); ?></strong>: <?php echo e($id_country); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.records.year')); ?></strong>: <?php echo e($year); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.records.date')); ?></strong> <i class="fas fa-calendar text-info"></i> : <?php echo e($date); ?>

                            <div class="row" style="height: 7px"></div>

                            <strong><?php echo e(__('users.records.project')); ?></strong>: <?php echo e($project); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.records.assignment')); ?></strong>: <?php echo e($assignment); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.records.activity')); ?></strong>: <?php echo e($activity); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.records.note')); ?></strong>:<br> <?php echo e($note); ?>

                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong><?php echo e(__('users.records.approvedby')); ?></strong>:
                            <?php if($approvedby): ?>
                               <?php echo e($record->approvedByUser->name); ?> <?php echo e($record->approvedByUser->surname); ?> id: <?php echo e($record->approvedByUser->id); ?>

                            <?php endif; ?>
                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.records.dateofapproval')); ?></strong> <i class="fas fa-calendar text-info"></i> : <?php echo e($dateofapproval); ?>

                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong><?php echo e(__('users.records.insertedby')); ?></strong>:
                            <?php if($insertedby): ?>
                                 <?php echo e($record->insertedByUser->name); ?> <?php echo e($record->insertedByUser->surname); ?>, id: <?php echo e($record->insertedByUser->id); ?>

                            <?php endif; ?>
                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong><?php echo e(__('users.records.updatedby')); ?></strong>:
                            <?php if($updatedby): ?>
                                <?php echo e($record->updatedByUser->name); ?> <?php echo e($record->updatedByUser->surname); ?> , id: <?php echo e($record->updatedByUser->id); ?>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <!--   ================================================================================-->


                <!--   ================================================================================-->


            </div>
        </div>
    </div>
</div>




<?php /**PATH /var/www/Modules/Users/resources/views/users/show-record.blade.php ENDPATH**/ ?>