

<?php
$id_module = $module->id ?? '';
$lang = request()->segment(2);
$query = request()->getQueryString();

$year_current= request()->segment(6);

$id = $record->id ?? '';
$id_user = !empty($id) ? request()->segment(8) : request()->segment(7);
$id_project	 = $record->project ?? '';
$id_country	 = $record->id_country ?? '';
$id_assignment = $record->assignment ?? '';
$id_activity = $record->activity ?? '';
$duration = $record->duration ?? '';
$note = $record->note ?? '';
$date = (isset($record->date)) ? date("d.m.Y", strtotime($record->date)) : '';
$year = $record->year  ?? '';
$lockrecord = $record->lockrecord ?? '';
$approvedby =  $record->approvedby ?? '';


$url = url('admin/' . $lang . '/' . $module->link);


$url_store = $url . '/store-record-table/'. $id_user;
$url_update = $url . '/update-record-table/'.$id.'/'.$id_user;
$url_action = !empty($id) ? $url_update : $url_store;

$url_return = $url. '/index-records-table/'. $id_user;

$url_fill_dropdown = url($url);

$message_error = (!empty($id) ) ? __('global.update_error') : __('global.save_error');
$message_success = (!empty($id) ) ? __('global.update_success') : __('global.save_success');
?>






    <!-- Form-->
<form class="needs-validation" role="form" id="form_edit_record" name="form_edit_record" action="<?php echo e($url_action); ?>" method="POST" enctype="multipart/form-data">

    <input type="hidden" id="url_return" name="url_return" value="<?php echo e($url_return); ?>">
    <input type="hidden" id="query" name="query" value="<?php echo e($query); ?>">
    <input type="hidden" id="message_error" name="message_error" value="<?php echo e($message_error); ?>">
    <input type="hidden" id="message_success" name="message_success" value="<?php echo e($message_success); ?>">

    <input type="hidden" id="id" name="id" value="<?php echo e($id); ?>">
    <input type="hidden" id="id_user" name="id_user" value="<?php echo e($id_user); ?>">
    <input type="hidden" id="year_temp" name="year_temp" value="<?php echo e($year_current); ?>">



    <?php echo e(csrf_field()); ?>

    <?php echo method_field('POST'); ?>

    <div class="row">
        <div class="col-md-12">


            <div class="card card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><?php if(!empty($id)): ?> id: <?php echo e($id); ?><?php else: ?> <?php echo e(__('global.new_record')); ?> <?php endif; ?></h3>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-sm-12">
                        <?php
                        $name = 'id_country';
                        $desc = __('records.id_country');
                        $input_required= 'required';
                        ?>
                        <label class="control-label"><?php echo e($desc); ?></label>
                        <select class="form-control"
                                id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                style="width: 100%"  <?php echo e($input_required); ?>>
                            <?php if(count($assignCountries) > 0): ?>
                                <?php $__currentLoopData = $assignCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($country->id); ?>" <?php echo e(($id_country == $country->id) ? 'selected' : ''); ?>>
                                        <?php echo e($country->name); ?> 
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-sm-12">
                        <?php
                        $input_value = $date;
                        $input_name = 'date_';
                        $input_desc = __('records.date').' *';
                        $input_maxlength = 100;
                        $input_required= 'required';
                        $input_readonly= 'readonly';
                        $input_css= 'text-red';
                        ?>
                        <div class="form-group">
                            <label for="<?php echo e($input_name); ?>" class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?></label>
                            <input type="text" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>" class="form-control" value="<?php echo e($input_value); ?>"
                                   maxlength="<?php echo e($input_maxlength); ?>" <?php echo e($input_readonly); ?>  <?php echo e($input_required); ?>>
                            <!-- Сокриено поле што ќе ја испрати вредноста -->
                            <input type="hidden" name="<?php echo e($input_name); ?>" id="<?php echo e($input_name); ?>_hidden" value="<?php echo e($input_value); ?>">
                        </div>
                    </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-12">
                            <?php
                            $name = 'id_project';
                            $desc = __('records.project');
                            ?>
                            <label class="text-red" for="<?php echo e($name); ?>" ><?php echo e($desc); ?> *</label>
                            <select class="form-control"
                                    id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"

                                    onchange="fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-activities/'+encodeURIComponent(this.value)+'/'+<?php echo e(Auth::id()); ?>, 'activities_dropdown');
                                    fillDropdown('<?php echo e($url_fill_dropdown); ?>/get-assignments/'+encodeURIComponent(this.value)+'/<?php echo e(Auth::id()); ?><?php echo e(isset($year_current) ? '?type=day-table&year=' . urlencode($year_current) : ''); ?>', 'assignments_dropdown')"

                                    style="width: 100%" required>
                                <?php if(count($projects) > 0): ?>
                                    <option value="0" <?php if(!empty($id)  > 0): ?> disabled <?php endif; ?>  >&nbsp;</option>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($project->id); ?>" <?php echo e(($project->id==$id_project)? 'selected' : ''); ?>


                                        <?php if($project->active==0): ?> disabled <?php endif; ?>
                                            style="<?php if($project->active==0): ?> color: #a0a0a0; <?php endif; ?>">
                                        <?php echo e($project->name); ?><?php if($project->active==0): ?>
                                                / <?php echo e(__('records.inactive')); ?>

                                            <?php endif; ?>, <?php echo e(date("d.m.Y", strtotime($project->end_date))); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_assignment';
                            $desc = __('records.assignment');
                            ?>
                            <label class="text-red" for="<?php echo e($name); ?>"><?php echo e($desc); ?> *</label>
                            <div id="assignments_dropdown">
                                <select class="form-control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" style="width: 100%" required>
                                    <?php if(count($assignments) > 0): ?>
                                        <option value="">&nbsp;</option>
                                        <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($assignment->id); ?>" <?php echo e(($assignment->id==$id_assignment)? 'selected' : ''); ?>><?php echo e($assignment->name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-5 col-xl-5">
                            <?php
                            $name = 'id_activity';
                            $desc = __('records.activity');
                            ?>
                            <label class="text-red" for="<?php echo e($name); ?>" ><?php echo e($desc); ?> *</label>
                            <div id="activities_dropdown">
                                <select class="form-control"
                                        id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                        style="width: 100%" required>
                                    <?php if(count($activities) > 0): ?>
                                        <option value="">&nbsp;</option>
                                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($activity->id); ?>" <?php echo e(($activity->id==$id_activity)? 'selected' : ''); ?>><?php echo e($activity->name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            $name = 'duration';
                            $desc = __('records.duration');
                            ?>
                            <div class="form-group">
                                <label for="<?php echo e($name); ?>" class="text-red"><?php echo e($desc); ?> *</label>
                                <select class="form-control" style="width:100%;" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" required>
                                    <option value="">&nbsp;</option>
                                    <option value="1" <?php echo e(($duration==1)? 'selected' : ''); ?>>1</option>
                                    <option value="2" <?php echo e(($duration==2)? 'selected' : ''); ?>>2</option>
                                    <option value="3" <?php echo e(($duration==3)? 'selected' : ''); ?>>3</option>
                                    <option value="4" <?php echo e(($duration==4)? 'selected' : ''); ?>>4</option>
                                    <option value="5" <?php echo e(($duration==5)? 'selected' : ''); ?>>5</option>
                                    <option value="6" <?php echo e(($duration==6)? 'selected' : ''); ?>>6</option>
                                    <option value="7" <?php echo e(($duration==7)? 'selected' : ''); ?>>7</option>
                                    <option value="8" <?php echo e(($duration==8)? 'selected' : ''); ?>>8</option>
                                    <option value="9" <?php echo e(($duration==9)? 'selected' : ''); ?>>9</option>
                                    <option value="10" <?php echo e(($duration==10)? 'selected' : ''); ?>>10</option>
                                    <option value="11" <?php echo e(($duration==11)? 'selected' : ''); ?>>11</option>
                                    <option value="12" <?php echo e(($duration==12)? 'selected' : ''); ?>>12</option>
                                    <option value="13" <?php echo e(($duration==13)? 'selected' : ''); ?>>13</option>
                                    <option value="14" <?php echo e(($duration==14)? 'selected' : ''); ?>>14</option>
                                    <option value="15" <?php echo e(($duration==15)? 'selected' : ''); ?>>15</option>
                                    <option value="16" <?php echo e(($duration==16)? 'selected' : ''); ?>>16</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            $name = 'note';
                            $desc = __('records.note');
                            ?>
                            <div class="form-group">
                                <label for="<?php echo e($name); ?>"><?php echo e($desc); ?></label>
                                <textarea class="form-control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" rows="2"
                                          placeholder=""><?php echo e($note); ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-submit btn-success float-right"><?php echo e(__('global.save')); ?></button>
                </div>
                <!-- /.card-body -->


            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row-->
</form>
<!-- /.form -->



<!-- toastr CSS -->
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/toastr/toastr.min.css')); ?>">


<!-- Select2 -->
<link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<!-- date-range-picker -->
<link rel="stylesheet" href="<?php echo e(url('LTE/plugins/daterangepicker/daterangepicker.css')); ?>">



<!-- Select2 -->
<script src="<?php echo e(url('LTE/plugins/select2/js/select2.full.min.js')); ?>"></script>
    <!-- toastr JS -->
<script src="<?php echo e(url('LTE/plugins/toastr/toastr.min.js')); ?>"></script>



<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo e(url('LTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')); ?>"></script>
<!-- InputMask -->
<script src="<?php echo e(url('LTE/plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(url('LTE/plugins/inputmask/min/jquery.inputmask.bundle.min.js')); ?>"></script>
<!-- date-range-picker -->
<script src="<?php echo e(url('LTE/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo e(url('LTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>

<style>
    .daterangepicker.single .drp-buttons {
        display: block !important;
    }
    .daterangepicker {
        z-index: 1055 !important;
    }

    .daterangepicker {
        z-index: 1050 !important;  /* Осигурува дека datepicker-от е над сите елементи */
    }
    .bootstrap-datetimepicker-widget {
        z-index: 1050 !important; /* За datetimepicker */
    }
</style>


<script>
    // Пренеси ја PHP низата како JSON до JavaScript и претвори ја во правилен формат
    if (typeof lockedDays === 'undefined') {
        var lockedDays = <?php echo json_encode($locketDays, 15, 512) ?>; // Првична декларација
    } else {
        lockedDays = <?php echo json_encode($locketDays, 15, 512) ?>; // Ажурирај ја вредноста
    }

    // Претвори ги сите датуми во формат 'YYYY-MM-DD'
    lockedDays = Array.isArray(lockedDays) ? lockedDays.map(date => date.split(' ')[0]) : [];

    $(document).ready(function () {
        // Прочитај ја годината од hidden полето
        const selectedYear = $('#year_temp').val();

        // Постави го почетокот и крајот на годината
        const startDate = moment(`${selectedYear}-01-01`);
        const endDate = moment(`${selectedYear}-12-31`);

        // Иницијализација на bsCustomFileInput
        bsCustomFileInput.init();

        // Конфигурација за Date Picker со заклучени денови
        const dateTimePickerConfig = {
            singleDatePicker: true,
            autoUpdateInput: false,
            timePicker: false,
            timePicker24Hour: true,
            showDropdowns: false,
            minDate: startDate,
            maxDate: endDate,
            locale: {
                format: "DD.MM.YYYY",  // Формат за датум
                firstDay: 1
            },
            // Оневозможи заклучени денови
            isInvalidDate: function (date) {
                const formattedDate = date.format('YYYY-MM-DD');  // Претвори го моменталниот датум во формат YYYY-MM-DD
                return lockedDays.includes(formattedDate);  // Оневозможи ако датумот е во lockedDays
            }
        };

        // Иницијализирај DatePicker за одредено поле
        initializeDateTimePicker('#form_edit_record input[name="date_"]');

        function initializeDateTimePicker(selector) {
            const inputField = $(selector);
            inputField.daterangepicker(dateTimePickerConfig);

            inputField.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD.MM.YYYY'));
                $('#date__hidden').val(picker.startDate.format('DD.MM.YYYY'));
            });

            inputField.on('cancel.daterangepicker', function () {
                $(this).val('');
                $('#date__hidden').val('');
            });
        }
    });

    $(function () {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
<?php /**PATH /var/www/Modules/Records/resources/views/records/edit-record-table.blade.php ENDPATH**/ ?>