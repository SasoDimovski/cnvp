<!-- Form-->

<?php

            $lang = request()->segment(2);
            $id_module= request()->segment(3);
            $query = request()->getQueryString();

                // Внесената дата (на пример: 29.3.2025)
                $inputDate = $date;

                // Конвертирај ја датата во timestamp
                $timestamp = strtotime($inputDate);

                // Пресметај го почетокот на неделата (понеделник)
                $startOfWeek = strtotime('last monday', $timestamp);
                if (date('N', $timestamp) == 1) { // Ако е понеделник, нема потреба од "last monday"
                    $startOfWeek = $timestamp;
                }

                // Креирај низи за деновите од неделата
                $daysOfWeek = [];
                $datesOfDaysOfWeek = [];
                $dayMonthOfDaysOfWeek = [];
                for ($i = 0; $i < 7; $i++) {
                    $currentTimestamp = strtotime("+$i day", $startOfWeek);
                    $daysOfWeek[date('D', $currentTimestamp)] = strtolower(date('D', $currentTimestamp). ' ' . date('d.m.Y', $currentTimestamp) );
                    $datesOfDaysOfWeek[date('D', $currentTimestamp)] = date('Y-m-d', $currentTimestamp) ;
                    $dayMonthOfDaysOfWeek[date('D', $currentTimestamp)] = date('d.m', $currentTimestamp) ;
                }

                // Извлечи ги променливите
                $mon = $daysOfWeek['Mon'];
                $tue = $daysOfWeek['Tue'];
                $wed = $daysOfWeek['Wed'];
                $thu = $daysOfWeek['Thu'];
                $fri = $daysOfWeek['Fri'];
                $sat = $daysOfWeek['Sat'];
                $sun = $daysOfWeek['Sun'];

                $monDate = $datesOfDaysOfWeek['Mon'];
                $tueDate  = $datesOfDaysOfWeek['Tue'];
                $wedDate  = $datesOfDaysOfWeek['Wed'];
                $thuDate  = $datesOfDaysOfWeek['Thu'];
                $friDate  = $datesOfDaysOfWeek['Fri'];
                $satDate  = $datesOfDaysOfWeek['Sat'];
                $sunDate = $datesOfDaysOfWeek['Sun'];

                $monDayMonth = $dayMonthOfDaysOfWeek['Mon'];
                $tueDayMonth  = $dayMonthOfDaysOfWeek['Tue'];
                $wedDayMonth   = $dayMonthOfDaysOfWeek['Wed'];
                $thuDayMonth  = $dayMonthOfDaysOfWeek['Thu'];
                $friDayMonth   = $dayMonthOfDaysOfWeek['Fri'];
                $satDayMonth   = $dayMonthOfDaysOfWeek['Sat'];
                $sunDayMonth  = $dayMonthOfDaysOfWeek['Sun'];

//                     echo '<pre>';
//        print_r($nonWorkingDays);
//        echo '</pre>';

?>
<form class="needs-validation" role="form" id="form_edit" name="form_edit" action="<?php echo e($url_store.'/'. Auth::id()); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>"
      method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_update" name="url_update" value="<?php echo e($url_update); ?>">
    <input type="hidden" id="url_store" name="url_store" value="<?php echo e($url_store); ?>">
    <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="<?php echo e($url_fill_dropdown); ?>">

    <input type="hidden" id="insertedby" name="insertedby" value="<?php echo e($insertedby); ?>">
    <input type="hidden" id="id_country" name="id_country" value="<?php echo e($id_country); ?>">
    <input type="hidden" id="date" name="date" value="<?php echo e($date); ?>">

    <input type="hidden" name="container" value="edit-record-week-container">
    <input type="hidden" id="refresh-container" value="index-container">
    <input type="hidden" id="refresh-route"
           value="<?php echo e(route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby])); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>">

    <?php echo e(csrf_field()); ?>

    <?php echo method_field('POST'); ?>

    <div class="row">
        <div class="col-md-12">

            <div class="row">

                <div class="col-md-4">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <?php
                        $name = 'id_project';
                        $desc = __('records.projects');
                        ?>

                        <label class="text-success" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                        <select class="form-control"
                                id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                onchange="fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-activities/'+encodeURIComponent(this.value)+'/'+<?php echo e(Auth::id()); ?>, 'activities_dropdown');
                                    fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-assignments/'+encodeURIComponent(this.value)+'/<?php echo e(Auth::id()); ?><?php echo e(isset($date) ? '?type=week&date=' . urlencode($date) : ''); ?>', 'assignments_dropdown')"
                                style="width: 100%" required placeholder="<?php echo e($desc); ?>">
                            <?php if(count($projects) > 0): ?>
                                <option value="0">&nbsp;</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($project->id); ?>"
                                        <?php if($project->active==0): ?> disabled <?php endif; ?>
                                        style="<?php if($project->active==0): ?> color: #a0a0a0; <?php endif; ?>">

                                        <?php echo e($project->name); ?>  <?php if($project->active==0): ?>
                                            / <?php echo e(__('records.inactive')); ?>

                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <?php
                        $name = 'id_assignment';
                        $desc = __('records.assignments');
                        ?>
                        <label class="text-success" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                        <div id="assignments_dropdown">
                            <select class="form-control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" style="width: 100%"
                                    required>
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
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <?php
                        $name = 'id_activity';
                        $desc = __('records.activities');
                        ?>
                        <label class="text-success" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
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

                <div class="col-md-8">
                    <div class="row text-center">
                        <?php $__currentLoopData = [$monDayMonth => $monDate, $tueDayMonth => $tueDate, $wedDayMonth => $wedDate, $thuDayMonth => $thuDate, $friDayMonth => $friDate, $satDayMonth => $satDate, $sunDayMonth  => $sunDate]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $style = ( in_array($date, $nonWorkingDays)) ? 'nonworking' : '';
                            ?>
                            <div class="col-lg col-1-of-7 <?php echo e($style); ?>">
                                <div class="form-group">
                                    <label for="<?php echo e($date); ?>" class="text-success"><small><?php echo e($day); ?></small></label>
                                    <input type="text" id="<?php echo e($date); ?>" name="duration[<?php echo e($date); ?>]"
                                           class="form-control duration-input"
                                           value=""
                                           maxlength="2"
                                           data-day="<?php echo e($day); ?>">
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                            <button type="submit" class="btn btn-submit ajax btn-success check-duration float-right"><?php echo e(__('records.add_new_record')); ?></button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</form>



<div class="row" style="height: 10px"></div>

<?php if(count($records)>0): ?>
<form class="needs-validation" role="form" id="form_edit" name="form_edit"
      action="<?php echo e($url_update.'/'.Auth::id()); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>" method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_update" name="url_update" value="<?php echo e($url_update); ?>">
    <input type="hidden" id="url_store" name="url_store" value="<?php echo e($url_store); ?>">
    <input type="hidden" id="url_fill_dropdown" name="url_fill_dropdown" value="<?php echo e($url_fill_dropdown); ?>">

    <input type="hidden" id="insertedby" name="insertedby" value="<?php echo e($insertedby); ?>">
    <input type="hidden" id="id_country" name="id_country" value="<?php echo e($id_country); ?>">
    <input type="hidden" id="date" name="date" value="<?php echo e($date); ?>">

    <input type="hidden" name="container" value="edit-record-week-container">
    <input type="hidden" id="refresh-container" value="index-container">
    <input type="hidden" id="refresh-route"
           value="<?php echo e(route('refresh-index', ['lang' => $lang,'id_module' => $id_module,'id' => $insertedby])); ?><?php echo e(!empty($query) ? '?' . $query : ''); ?>">

    <?php echo e(csrf_field()); ?>

    <?php echo method_field('POST'); ?>


    <?php
        $idGroupArray =[];
    ?>

<?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $idGroupArray[] = $record['id_group'];
        ?>



        <div class="row">
            <div class="col-md-12">
                <div class="row">



                    <div class="col-md-4">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <?php
                                $name = 'id_project';
                                $desc = __('records.projects');
                                ?>


                            <label class="text-red" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                            <select class="form-control"
                                    id="<?php echo e($name); ?><?php echo e($record['id_group']); ?>" name="<?php echo e($name); ?><?php echo e($record['id_group']); ?>"
                                    onchange="fillDropdownActivity('<?php echo e($url_fill_dropdown); ?>/get-activities/'+encodeURIComponent(this.value)+'/'+<?php echo e(Auth::id()); ?>, 'activities_dropdown_<?php echo e($record['id_group']); ?>', '<?php echo e($record['id_group']); ?>');
                               fillDropdownAssignment('<?php echo e($url_fill_dropdown); ?>/get-assignments/'+encodeURIComponent(this.value)+'/'+<?php echo e(Auth::id()); ?>, 'assignments_dropdown_<?php echo e($record['id_group']); ?>', '<?php echo e($record['id_group']); ?>')
                                    "
                                    style="width: 100%" required>
                                <?php if(count($projects) > 0): ?>
                                    <option value="0">&nbsp;</option>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($project->id); ?>" <?php echo e(($project->id==$record['id_project'])? 'selected' : ''); ?>><?php echo e($project->name); ?>

                                            
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <?php
                                $name = 'id_assignment';
                                $desc = __('records.assignments');
                                ?>
                            <label class="text-red" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                            <div id="assignments_dropdown_<?php echo e($record['id_group']); ?>">
                                <select class="form-control" id="<?php echo e($name); ?><?php echo e($record['id_group']); ?>" name="<?php echo e($name); ?><?php echo e($record['id_group']); ?>" style="width: 100%"
                                        required>

                                    <option value="">&nbsp;</option>
                                    <?php $__currentLoopData = $record['project_assignments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($assignment['id']); ?>" <?php echo e(( $record['id_assignment']==$assignment['id'] )? 'selected' : ''); ?>><?php echo e($assignment['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <?php
                                $name = 'id_activity';
                                $desc = __('records.activities');
                                ?>
                            <label class="text-red" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                            <div id="activities_dropdown_<?php echo e($record['id_group']); ?>">
                                <select class="form-control"
                                        id="<?php echo e($name); ?><?php echo e($record['id_group']); ?>" name="<?php echo e($name); ?><?php echo e($record['id_group']); ?>"
                                        style="width: 100%" required>

                                    <option value="">&nbsp;</option>
                                    <?php $__currentLoopData = $record['project_activities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($activity['id']); ?>" <?php echo e(( $record['id_activity']==$activity['id'] )? 'selected' : ''); ?>><?php echo e($activity['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row text-center">
                            <?php $__currentLoopData = $datesOfDaysOfWeek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $dateA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $duration='';
                                     $note = '';
                                    $dayLabel = $day. ' ' . date('d.m.Y', strtotime($dateA));
                                    $dateLocal = date('Y-m-d', strtotime($dateA));
                                ?>
                                <?php $__currentLoopData = $record['date_durations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date_durations): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $dateDB = date('Y-m-d', strtotime($date_durations['date']));
                                         if($dateLocal===$dateDB) {
                                             $duration=$date_durations['duration'];
                                              $note = $date_durations['note'];
                                         }
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php
                                    $style = ( in_array($dateLocal, $nonWorkingDays)) ? 'nonworking' : '';
                                ?>
                                <div class="col-lg col-1-of-7 <?php echo e($style); ?>">
                                    <div class="form-group">
                                        <label for="<?php echo e($dateLocal); ?>" class="text-red"><small><?php echo e($day); ?>


                                                <?php if($note): ?>
                                                    &nbsp;<i class="fas fa-comment text-warning" title="<?php echo e($note); ?>"></i>
                                                <?php endif; ?>


                                            </small></label>
                                        <input type="text" id="<?php echo e($dateLocal); ?><?php echo e($record['id_group']); ?>" name="duration<?php echo e($record['id_group']); ?>[<?php echo e($dateLocal); ?>]"
                                               class="form-control duration-input"
                                               value="<?php echo e($duration); ?>"
                                               maxlength="2"
                                               data-day="<?php echo e($dayLabel); ?>">
                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                                <span class="text-white"><?php echo e($record['id_group']); ?></span>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>



                            






<div class="row" style="height: 10px"></div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <input type="hidden" id="id_group" name="id_group" value="<?php echo e(implode(',', $idGroupArray)); ?>">

            <button type="submit"
                    class="btn btn-submit ajax btn-danger float-right"><?php echo e(__('global.update')); ?> </button>
        </div>
    </div>
</form>
<?php endif; ?>

<hr>

<div class="row">
    <div class="col-md-4">

    </div>

    <div class="col-md-8">
        <div class="row text-center">
            <?php $__currentLoopData = [$monDayMonth => $monDate, $tueDayMonth => $tueDate, $wedDayMonth => $wedDate, $thuDayMonth => $thuDate, $friDayMonth => $friDate, $satDayMonth => $satDate, $sunDayMonth  => $sunDate]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $style = ( in_array($date, $nonWorkingDays)) ? 'nonworking' : '';
                ?>
                <div class="col-lg col-1-of-7 <?php echo e($style); ?>">
                    <label class="text-red"
                    ><small><?php echo e($day); ?></small></label>
                    <div class="form-group">
                        <input type="text" id="sum_<?php echo e($date); ?>" name="sum_<?php echo e($date); ?>"
                               class="form-control duration-input"
                               value=""
                               maxlength="2" readonly>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>


</div>
<div class="row">
    <div class="col-md-12  text-right">
         <span style="font-size: 1.5em; font-weight: bold;">
        <strong id="total" class="text-red"> </strong>
         </span>
    </div>
</div>




<style>
    .col-1-of-7 {
        flex: 0 0 14.28%;
        max-width: 14.28%;
        /*padding: 0.5rem;*/
    }

    @media (max-width: 992px) {
        .col-lg {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    .nonworking {
       background-color: #fbfbd2;
    }

</style>
<script>
    $(document).ready(function () {
        // Ограничи го внесот само на бројки од 1 до 16
        $('.duration-input').on('input', function () {
            let value = $(this).val();

            // Ако вредноста не е бројка или не е помеѓу 1 и 16, врати ја претходната вредност
            if (value && (!/^\d+$/.test(value) || value < 1 || value > 16)) {
                $(this).val($(this).data('previousValue')); // Врати ја претходната валидна вредност
            } else {
                $(this).data('previousValue', value); // Сочувај ја тековната валидна вредност
            }
        });

    });
    $(document).ready(function () {
        // Функција за ажурирање на сумите
        function updateSums() {
            let total_total = 0; // Вкупна сума

            // Низ сите датуми (sum_*)
            $('[id^="sum_"]').each(function () {
                const date = $(this).attr('id').replace('sum_', ''); // Земете го датумот од ID
                let total = 0;

                // Пребарај ги сите соодветни duration полиња и пресметај ја сумата
                $(`input[id^="${date}"]`).each(function () {
                    const value = parseInt($(this).val());
                    if (!isNaN(value)) {
                        total += value;
                        total_total += value; // Додај ја вредноста на вкупната сума
                    }
                });

                // Ажурирај го соодветното поле за сума
                $(this).val(total > 0 ? total : ''); // Постави ја сумата или остави празно поле
            });

            // Ажурирај ја вкупната сума во елементот #total
            $('#total').text(total_total > 0 ? total_total : '0');
        }

        // Ограничи го внесот само на бројки од 1 до 16
        $('.duration-input').on('input', function () {
            let value = $(this).val();

            // Ако вредноста не е бројка или не е помеѓу 1 и 16, врати ја претходната вредност
            if (value && (!/^\d+$/.test(value) || value < 1 || value > 16)) {
                $(this).val($(this).data('previousValue')); // Врати ја претходната валидна вредност
            } else {
                $(this).data('previousValue', value); // Сочувај ја тековната валидна вредност
            }

            // Ажурирај ги сумите
            updateSums();
        });

        // Ажурирај ги сумите при вчитување на страницата
        updateSums();
    });


    // $(document).ready(function () {
    //     // Функција за пресметка на почетните суми
    //     function calculateInitialSums() {
    //         let total_total = 0;
    //
    //         // За секое поле со ID кое почнува со "sum_"
    //         $('[id^="sum_"]').each(function () {
    //             const date = $(this).attr('id').replace('sum_', ''); // Земете го датумот од ID
    //             let total = 0;
    //
    //             // Пребарај ги сите duration полиња со истиот датум
    //             $(`input[name^="duration[${date}]"]`).each(function () {
    //                 const value = parseInt($(this).val());
    //                 if (!isNaN(value)) {
    //                     total += value;
    //                     total_total += value;
    //                 }
    //             });
    //
    //             // Постави ја почетната сума во полето
    //             $(this).val(total > 0 ? total : ''); // Ако нема вредност, остави празно поле
    //         });
    //
    //         // Постави ја вкупната сума во текстуалната содржина на #total
    //         $('#total').text(total_total > 0 ? total_total : '0');
    //     }
    //
    //     // Пресметај суми само при вчитување на страницата
    //     calculateInitialSums();
    // });



</script>
<?php /**PATH /var/www/Modules/Records/resources/views/records/_records-week.blade.php ENDPATH**/ ?>