<?php

$id = $project->id ?? '';
$name = $project->name ?? old('name');
$description = $project->description ?? old('description');
$code = $project->code  ?? old('code');

$start_date = (isset($project->start_date)) ? date("d.m.Y H:i:s", strtotime($project->start_date)) : old('start_date');
$end_date = (isset($project->end_date)) ? date("d.m.Y H:i:s", strtotime($project->end_date)) : old('end_date');

$dateinserted = (isset($project->dateinserted)) ? date("d.m.Y H:i:s", strtotime($project->dateinserted)) : '';
$dateupdated = (isset($project->dateupdated)) ? date("d.m.Y H:i:s", strtotime($project->dateupdated)) : '';

$isExpired = isset($project->end_date) && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($project->end_date));

$insertedby = $project->insertedby ?? old('insertedby');
$updatedby = $project->updatedby ?? old('updatedby');

$active = $project->active ?? '';
$type = $project->type ?? '';
?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    <?php if($active==0): ?>
                        <span class="bg-gradient-red"><?php echo e(__('global.deactivated')); ?></span>
                    <?php else: ?>
                        <span class="bg-gradient-success"><?php echo e(__('global.active')); ?></span>
                    <?php endif; ?>

                        <?php if($isExpired): ?>
                            <span class="bg-gradient-red"><?php echo e(__('global.expired')); ?></span>
                        <?php else: ?>
                            <span class="bg-gradient-success"><?php echo e(__('global.expired_no')); ?></span>
                        <?php endif; ?>

                        <?php if($type==1): ?>
                            <span class="bg-gradient-info"><?php echo e(__('projects.type')); ?></span>
                        <?php endif; ?>

                    <br>
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong><?php echo e(__('projects.id')); ?></strong>: <?php echo e($id); ?></span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong><?php echo e(__('projects.dateinserted')); ?></strong>: <?php echo e($dateinserted); ?></span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> <?php echo e(__('projects.dateupdated')); ?></strong>: <?php echo e($dateupdated); ?></span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-info bg-info"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong><?php echo e(__('projects.name')); ?></strong>: <?php echo e($name); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('projects.code')); ?></strong>: <?php echo e($code); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('projects.start_date')); ?></strong> <i class="fas fa-calendar text-info"></i> :
                
                       
                            <span><?php echo e($start_date); ?></span>
                            <div class="row" style="height: 7px"></div>
                           <strong><?php echo e(__('projects.end_date')); ?></strong> <i class="fas fa-calendar text-info"></i> :
                   
                          
                            <span><?php echo e($end_date); ?></span>
                            <div class="row" style="height: 7px"></div>
                              <strong><?php echo e(__('projects.description')); ?></strong> <i class="fas fa-comment text-info"></i> :
                            <div class="row" style="height: 7px"></div>
                            <?php echo e($description); ?>

                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-list bg-gradient-warning"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong><?php echo e(__('projects.activities')); ?></strong>:<br><br>
                            <?php if(count($activitiesAss) > 0): ?>
                                <ul>
                                    <?php $__currentLoopData = $activitiesAss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <span><?php echo e($activity->name); ?> </span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-list bg-gradient-warning"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong><?php echo e(__('projects.assignments')); ?></strong>:<br><br>
                            <?php if(count($assignments) > 0): ?>
                                <ul>
                                    <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <span><?php echo e($assignment->name); ?> </span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-info-circle bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <i class="fas fa-user text-success"></i> <strong><?php echo e(__('projects.insertedby')); ?></strong>: <?php echo e($insertedby_); ?> , id: <?php echo e($insertedby); ?><br>
                            <div class="row" style="height: 7px"></div>
                            <i class="fas fa-user text-success"></i> <strong><?php echo e(__('projects.updatedby')); ?></strong>: <?php echo e($updatedby_); ?> , id: <?php echo e($updatedby); ?>


                        </div>
                    </div>
                </div>

                <!--   ================================================================================-->
            </div>
        </div>
    </div>
</div>




<?php /**PATH /var/www/Modules/Projects/resources/views/projects/show.blade.php ENDPATH**/ ?>