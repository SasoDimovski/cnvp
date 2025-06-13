<!-- Form-->

<?php
    //    echo '<pre>';
    //    print_r($record);
    //    echo '</pre>';
            $lang = request()->segment(2);
            $id_module= request()->segment(3);
            $query = request()->getQueryString();

?>
<form class="needs-validation" role="form" id="form_edit" name="form_edit" action="<?php echo e($url_store.'/'. Auth::id()); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>" method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_update" name="url_update" value="<?php echo e($url_update); ?>">
    <input type="hidden" id="url_store" name="url_store" value="<?php echo e($url_store); ?>">
    <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="<?php echo e($url_fill_dropdown); ?>">

    <input type="hidden" id="insertedby" name="insertedby" value="<?php echo e($insertedby); ?>">
    <input type="hidden" id="id_country" name="id_country" value="<?php echo e($id_country); ?>">
    <input type="hidden" id="date" name="date" value="<?php echo e($date); ?>">

    <input type="hidden" id="container" name="container" value="edit-record-day-container">
    <input type="hidden" id="refresh-container" name="refresh-container" value="index-container">
    <input type="hidden" id="refresh-route" name="refresh-route" value="<?php echo e(route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby])); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>">

    <input type="hidden" id="query" name="query" value="<?php echo e($query); ?>">


    <?php echo e(csrf_field()); ?>

    <?php echo method_field('POST'); ?>

    <div class="row">
        <div class="col-md-12  <?php echo e($isHoliday== 1 ? 'nonworking' : 'working'); ?>">





                    
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-10">
                            <?php
                            $name = 'id_project';
                            $desc = __('records.projects');
                            ?>
                            <label class="text-success" for="<?php echo e($name); ?>" ><?php echo e($desc); ?> *</label>
                            <select class="form-control"
                                    id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                    onchange="fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-activities/'+encodeURIComponent(this.value)+'/'+<?php echo e(Auth::id()); ?>, 'activities_dropdown');fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-assignments/'+encodeURIComponent(this.value)+'/<?php echo e(Auth::id()); ?><?php echo e(isset($date) ? '?type=day&date=' . urlencode($date) : ''); ?>', 'assignments_dropdown')"
                                    style="width: 100%" required>
                                <?php if(count($projects) > 0): ?>
                                    <option value="">&nbsp;</option>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($project->id); ?>"
                                            <?php if($project->active==0): ?> disabled <?php endif; ?>
                                            style="<?php if($project->active==0): ?> color: #a0a0a0; <?php endif; ?>"
                                        ><?php echo e($project->name); ?> (<?php echo e($project->id); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            $name = 'duration';
                            $desc = __('records.duration');
                            ?>
                            <div class="form-group">
                                <label for="<?php echo e($name); ?>" class="text-success"><?php echo e($desc); ?> *</label>
                                <select class="form-control" style="width:100%;" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" required>
                                    <option value="">&nbsp;</option>
                                    <?php for($i = 1; $i <= 16; $i++): ?>
                                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_assignment';
                            $desc = __('records.assignments');
                            ?>
                            <label class="text-success" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                            <div id="assignments_dropdown">
                                <select class="form-control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" style="width: 100%" required>
                                    <?php if(count($assignments) > 0): ?>
                                        <option value="">&nbsp;</option>
                                        <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($assignment->id); ?>"><?php echo e($assignment->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_activity';
                            $desc = __('records.activities');
                            ?>
                            <label class="text-success" for="<?php echo e($name); ?>" ><?php echo e($desc); ?> *</label>
                            <div id="activities_dropdown">
                                <select class="form-control"
                                        id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                        style="width: 100%" required>
                                    <?php if(count($activities) > 0): ?>
                                        <option value="">&nbsp;</option>
                                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($activity->id); ?>"><?php echo e($activity->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                    </div>


                    
                    <div class="row">
                        <div class="col-sm-10">
                            <?php
                            $name = 'note';
                            $desc = __('records.note');
                            ?>
                            <div class="form-group">
                                <label for="<?php echo e($name); ?>"><?php echo e($desc); ?></label>
                                <textarea class="form-control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" rows="2"
                                          placeholder=""></textarea>
                            </div>
                        </div>
                        <div class="col-sm-2 d-flex justify-content-end align-items-end">
                            <button type="submit"
                                    class="btn btn-submit ajax btn-success float-right mb-3"><?php echo e(__('records.add_new_record')); ?></button>
                        </div>
                    </div>
                    

   

        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row-->
</form>
<!-- /.form -->


<?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

 <span class="text-white"><?php echo e($record->id_group); ?></span>
    <?php if($record->lockrecord== 1): ?>
        <i class="fas fa-lock text-red"
           title="<?php echo e(__('records.locked')); ?>"></i>
    <?php endif; ?>
    <!-- Form-->
    <form class="needs-validation" role="form" id="form_edit" name="form_edit" action="<?php echo e($url_update.'/'. $record->id .'/'.Auth::id()); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>" method="POST" enctype="multipart/form-data">


        <input type="hidden" id="url_update" name="url_update" value="<?php echo e($url_update); ?>">
        <input type="hidden" id="url_store" name="url_store" value="<?php echo e($url_store); ?>">
        <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="<?php echo e($url_fill_dropdown); ?>">

        <input type="hidden" id="insertedby" name="insertedby" value="<?php echo e($insertedby); ?>">
        <input type="hidden" id="id_country" name="id_country" value="<?php echo e($id_country); ?>">
        <input type="hidden" id="date" name="date" value="<?php echo e($date); ?>">

        <input type="hidden" name="container" value="edit-record-day-container">
        <input type="hidden" id="refresh-container" value="index-container">
        <input type="hidden" id="refresh-route" value="<?php echo e(route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby])); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>">

        <?php echo e(csrf_field()); ?>

        <?php echo method_field('POST'); ?>

        <div class="row">
            <div class="col-md-12   <?php echo e($isHoliday== 1 ? 'nonworking' : 'working'); ?>">

                        
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-5 col-xl-10">
                                    <?php
                                    $name = 'id_project';
                                    $desc = __('records.projects');
                                    ?>
                                <label class="text-red" for="<?php echo e($name); ?>" ><?php echo e($desc); ?> *</label>
                                <select class="form-control"
                                        id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"   <?php if($record->lockrecord == 1): ?> disabled  <?php endif; ?>
                                        onchange="fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-activities/'+encodeURIComponent(this.value)+'/'+<?php echo e(Auth::id()); ?>, 'activities_dropdown_<?php echo e($record->id); ?>');
                                    fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-assignments/'+encodeURIComponent(this.value)+'/'+<?php echo e(Auth::id()); ?>, 'assignments_dropdown_<?php echo e($record->id); ?>')"
                                        style="width: 100%" required>
                                    <?php if(count($projects) > 0): ?>

                                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($project->id); ?>" <?php echo e(($project->id==$record->projects->id)? 'selected' : ''); ?>

                                            <?php if($project->active==0): ?> disabled <?php endif; ?>
                                                style="<?php if($project->active==0): ?> color: #a0a0a0; <?php endif; ?>">
                                            <?php echo e($project->name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                    <?php
                                    $name = 'duration';
                                    $desc = __('records.duration');
                                    ?>
                                <div class="form-group">
                                    <label for="<?php echo e($name); ?>" class="text-red"><?php echo e($desc); ?> *</label>
                                    <select class="form-control" style="width:100%;" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" <?php if($record->lockrecord == 1): ?> disabled  <?php endif; ?>>
                                        <option value=""></option>
                                        <option value="1" <?php echo e(($record->duration==1)? 'selected' : ''); ?>>1</option>
                                        <option value="2" <?php echo e(($record->duration==2)? 'selected' : ''); ?>>2</option>
                                        <option value="3" <?php echo e(($record->duration==3)? 'selected' : ''); ?>>3</option>
                                        <option value="4" <?php echo e(($record->duration==4)? 'selected' : ''); ?>>4</option>
                                        <option value="5" <?php echo e(($record->duration==5)? 'selected' : ''); ?>>5</option>
                                        <option value="6" <?php echo e(($record->duration==6)? 'selected' : ''); ?>>6</option>
                                        <option value="7" <?php echo e(($record->duration==7)? 'selected' : ''); ?>>7</option>
                                        <option value="8" <?php echo e(($record->duration==8)? 'selected' : ''); ?>>8</option>
                                        <option value="9" <?php echo e(($record->duration==9)? 'selected' : ''); ?>>9</option>
                                        <option value="10" <?php echo e(($record->duration==10)? 'selected' : ''); ?>>10</option>
                                        <option value="11" <?php echo e(($record->duration==11)? 'selected' : ''); ?>>11</option>
                                        <option value="12" <?php echo e(($record->duration==12)? 'selected' : ''); ?>>12</option>
                                        <option value="13" <?php echo e(($record->duration==13)? 'selected' : ''); ?>>13</option>
                                        <option value="14" <?php echo e(($record->duration==14)? 'selected' : ''); ?>>14</option>
                                        <option value="15" <?php echo e(($record->duration==15)? 'selected' : ''); ?>>15</option>
                                        <option value="16" <?php echo e(($record->duration==16)? 'selected' : ''); ?>>16</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                                    <?php
                                    $name = 'id_assignment';
                                    $desc = __('records.assignments');
                                    ?>
                                <label class="text-red" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                                <div id="assignments_dropdown_<?php echo e($record->id); ?>">

                                    <select class="form-control" style="width:100%;" id="id_assignment" name="id_assignment" required <?php if($record->lockrecord == 1): ?> disabled  <?php endif; ?>>

                                        <?php if(count($record->projects->assignments) > 0): ?>
                                            <option value="">&nbsp;</option>
                                            <?php $__currentLoopData = $record->projects->assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($assignment->id); ?>" <?php echo e(($assignment->id==$record->assignments->id)? 'selected' : ''); ?>>
                                                    <?php echo e($assignment->name); ?> (<?php echo e($assignment->id); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                                    <?php
                                    $name = 'id_activity';
                                    $desc = __('records.activities');
                                    ?>
                                <label class="text-red" for="<?php echo e($name); ?>" ><?php echo e($desc); ?> *</label>
                                <div id="activities_dropdown_<?php echo e($record->id); ?>">
                                    <select class="form-control" <?php if($record->lockrecord == 1): ?> disabled  <?php endif; ?>
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                            style="width: 100%" required>
                                        <?php if(count($record->projects->activities) > 0): ?>
                                            <option value="">&nbsp;</option>
                                            <?php $__currentLoopData = $record->projects->activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($activity->id); ?>" <?php echo e(($activity->id==$record->activities->id)? 'selected' : ''); ?>><?php echo e($activity->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                        </div>


                        
                        <div class="row">
                            <div class="col-sm-10">
                                    <?php
                                    $name = 'note';
                                    $desc = __('records.note');
                                    ?>
                                <div class="form-group">
                                    <label for="<?php echo e($name); ?>"><?php echo e($desc); ?></label>
                                    <textarea class="form-control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" rows="2" <?php if($record->lockrecord == 1): ?> readonly  <?php endif; ?>
                                              placeholder=""><?php echo e($record->note); ?></textarea>
                                    <?php if($record->lockrecord == 0): ?>
                                    <?php echo __('records.notice'); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-2 d-flex justify-content-end align-items-end">
                                <?php if($record->lockrecord == 0): ?>

                                    <button type="submit"
                                            class="btn btn-submit ajax btn-danger float-right  mb-3"><?php echo e(__('global.update')); ?></button>

                                <?php endif; ?>
                            </div>
                        </div>


                        


            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row-->
    </form>



<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<style>

    .nonworking {
        background-color: #fbfbd2;
    }

    .working {
        background-color: #f9f9f9;
    }

</style>
<?php /**PATH /var/www/Modules/Records/resources/views/records/_records-day.blade.php ENDPATH**/ ?>