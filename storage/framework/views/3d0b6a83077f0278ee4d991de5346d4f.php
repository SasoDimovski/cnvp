<?php $__env->startSection('content'); ?>

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();

    $nextEnteredYears = $lastEnteredYears + 1;
    $allLocked=isset($calendar->allLocked)?$calendar->allLocked:'';

    $url = url('admin/' . $lang . '/' . $module->link);

    $url_base = 'admin/' . $lang . '/' . $id_module . '/calendar/';
    $url_new_year = url($url_base . 'new-year/');
    $url_insert_holiday = url($url_base . 'insert-holiday/');
    $url_delete_year = url($url_base . 'delete/');


    ?>
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa <?php echo e($module->design->icon); ?>"></i> <?php echo e($module->title); ?>


                            <?php if(date('Y')>=$lastEnteredYears): ?>

                                <a href="#" class="btn btn-danger modal_warning"
                                   data-toggle="modal"
                                   data-target="#ModalWarning"

                                   data-title="<?php echo e(__('calendar.enter_year')); ?>"
                                   data-url="<?php echo e($url_new_year.'/'.$nextEnteredYears.'?'.$query); ?>"

                                   data-content_l="<?php echo e(__('calendar.last_year')); ?> <?php echo e($lastEnteredYears); ?>"
                                   data-content_b="<?php echo e(__('calendar.next_year')); ?> <?php echo e($nextEnteredYears); ?>"
                                   data-content_sub_l="<?php echo e(__('calendar.year_warning')); ?>"
                                   data-content_sub_b=""

                                   data-query="<?php echo e($query); ?>"
                                   data-url_return="<?php echo e($url); ?>"
                                   data-success="<?php echo e(__('global.delete_success')); ?>"
                                   data-error="<?php echo e(__('global.delete_error')); ?>"

                                   title="<?php echo e(__('calendar.enter_year')); ?>">

                                    <?php echo e(__('calendar.enter_year_short')); ?></a>
                            <?php endif; ?>

                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="<?php echo e($url); ?>"><?php echo e($module->title); ?></a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Search =============================================================================================== -->
                <form class="form-horizontal" name="form_search" id="form_search" method="get" action=""
                      accept-charset="UTF-8">
                    <!-- card card-red card-outline =============================================================================================== -->
                    <div class="card card-red card-outline">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                                    <?php
                                    $name = 'id_country';
                                    $desc = __('calendar.id_country');
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?></label>
                                    <select class="select2bs4"
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" required
                                            style="width: 100%">
                                        <?php if(count($countries) > 0): ?>
                                            <option value="">&nbsp;</option>
                                            <?php
                                                $id_country = '';
                                                $country_name = '';
                                            ?>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    if (app('request')->input('id_country') == $country->id) {
                                                        $id_country = $country->id;
                                                        $country_name = $country->name;
                                                    }
                                                ?>

                                                <option
                                                    value="<?php echo e($country->id); ?>" <?php echo e(((app('request')->input($name))==$country->id)? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <?php
                                    $name = 'year';
                                    $desc = __('calendar.year');
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?>

                                    </label>

                                    <select class="select2bs4"
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" required
                                            style="width: 100%">
                                        <?php if(count($years) > 0): ?>
                                            <option value="">&nbsp;
                                            </option>
                                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($year); ?>"
                                                    <?php echo e(((app('request')->input($name))==$year)? 'selected' : ''); ?>><?php echo e($year); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                                    <label class="control-label"> &nbsp;</label>
                                    <button type="button"
                                            class="form-control form-control-sm btn btn-outline-secondary btn-sm"
                                            title="<?php echo e(__('global.reset_button_des')); ?>"
                                            onClick="window.open('<?php echo e($url); ?>','_self');"> <?php echo e(__('global.reset_button')); ?>

                                    </button>
                                </div>

                                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                                    <label class="control-label"> &nbsp;</label>
                                    <button type="submit"
                                            class="form-control form-control-sm btn btn-outline-danger btn-sm"
                                            title="<?php echo e(__('global.search_button')); ?> "><?php echo e(__('global.search_button')); ?>

                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
                <!-- card card-red card-outline  END =============================================================================================== -->
                <!-- Search end=============================================================================================== -->

                <!-- Table =============================================================================================== -->
                
                
                <?php echo $__env->make('admin._flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                <?php if(count($calendar) > 0): ?>

                    <form class="form-horizontal" name="form_insert" id="form_insert" method="post"
                          action="<?php echo e($url_insert_holiday); ?>" accept-charset="UTF-8">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="year" name="year" value="<?php echo e(app('request')->input('year')); ?>">
                        <input type="hidden" id="id_country" name="id_country"
                               value="<?php echo e($id_country); ?>">
                        <input type="hidden" id="query" name="query" value="<?php echo e($query); ?>">
                        <input type="hidden" id="url_return" name="url_return" value="<?php echo e($url); ?>">

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h3><strong><?php echo e(app('request')->input('year')); ?></strong>, <?php echo $country_name; ?>

                                <?php if($allLocked== 1): ?> <strong class="text-red"><?php echo e(__('calendar.locked_year')); ?></strong> <?php endif; ?></h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="custom-control custom-checkbox">

                                <input class="custom-control-input" type="checkbox"
                                       id="lock_calendar"
                                       name="lock_calendar"
                                       value="1"
                                       onclick="selectAllLock('lock', 'lock_calendar')"
                                       <?php if($allLocked== 1): ?> checked <?php endif; ?>
                                >
                                <label for="lock_calendar"
                                       class="custom-control-label <?php if($allLocked== 1): ?> text-red <?php else: ?> text-success <?php endif; ?>">
                                    <i class="fas fa-lock text-gray" title="<?php echo e(__('calendar.lock')); ?>"></i>&nbsp;&nbsp;
                                    <?php if($allLocked== 1): ?>
                                        <?php echo __('calendar.unselect_all',['year'=>app('request')->input('year')]); ?>

                                    <?php else: ?>
                                        <?php echo __('calendar.select_all',['year'=>app('request')->input('year')]); ?>

                                    <?php endif; ?>
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <?php echo __('calendar.select_all_warning',['year'=>app('request')->input('year')]); ?>

                        </div>
                        <div class="col-sm-12 col-md-6">
                            <button type="button" onclick="form_insert.submit();"
                                    class="btn btn-success float-right"><?php echo e(__('global.save')); ?></button>
                        </div>
                    </div>


                    <div class="row" style="height: 7px"></div>



                        <div class="dataTables_wrapper dt-bootstrap4">

                            <div class="row">
                                <div class="col-sm-12">
                                    
                                    <div class="calendar-grid">

                                        <?php
                                            $week = [];
                                            $currentMonth = '';
                                            $dayOrder = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                                        ?>

                                        <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $monthName = date('F', strtotime($calendar_->date));
                                                $dayNumber = date('d', strtotime($calendar_->date));
                                                $startDay = strtolower(date('D', strtotime($calendar_->date)));
                                            ?>

                                                <!-- Додавање на месецот ако е нов -->
                                            <?php if($dayNumber == 1 || $currentMonth != $monthName): ?>
                                                <?php
                                                    $currentMonth = $monthName;
                                                    $dayIndex = array_search($startDay, $dayOrder);
                                                ?>

                                                    <!-- Додавање на месечно заглавие -->
                                                <div class="card card-green card-outline">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <h4><strong><?php echo e($monthName); ?></strong></h4>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">

                                                        <div class="grid-header">
                                                            <div>Mon</div>
                                                            <div>Tue</div>
                                                            <div>Wed</div>
                                                            <div>Thu</div>
                                                            <div>Fri</div>
                                                            <div class="gray-text">Sat</div>
                                                            <div class="gray-text">Sun</div>
                                                        </div>

                                                        <!-- Почеток на нов ред -->
                                                        <div class="grid-row">
                                                            <!-- Додавање празни места за денови од претходниот месец -->
                                                            <?php for($i = 0; $i < $dayIndex; $i++): ?>
                                                                <div class="grid-item empty"></div>
                                                            <?php endfor; ?>
                                                            <?php endif; ?>

                                                            <!-- Ден во календарот -->
                                                            <div class="grid-item
                                                                <?php if($calendar_->day == 'sat' || $calendar_->day == 'sun'): ?> weekend <?php endif; ?>
                                                                <?php if($calendar_->is_holiday == 1): ?> selected <?php endif; ?>
                                                                 <?php if($calendar_->lock_ == 1  ): ?> gray-text  <?php endif; ?>"
                                                            >

                                                                <div class="grid-content">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 text-left">
                                                                            <span class="day-label"><?php echo e(date('d', strtotime($calendar_->date))); ?></span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <span><?php echo __('calendar.holiday'); ?></span>
                                                                            <input type="checkbox"
                                                                                   id="checkbox_<?php echo e($calendar_->id); ?>"
                                                                                   name="holidays[<?php echo e($calendar_->id); ?>]"
                                                                                   value="1"
                                                                                <?php echo e($calendar_->is_holiday == 1 ? 'checked' : ''); ?>>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="lock-container">

                                                                    <?php if($calendar_->lock_ == 1): ?>
                                                                        <i class="fas fa-lock text-gray"
                                                                           title="<?php echo e(__('calendar.lock')); ?>"></i>&nbsp;&nbsp;
                                                                    <?php else: ?>
                                                                        <i class="fas fa-unlock text-success"
                                                                           title="<?php echo e(__('calendar.lock')); ?>"></i>&nbsp;&nbsp;
                                                                    <?php endif; ?>
                                                                    <input type="checkbox"
                                                                           data-master="lock_calendar"
                                                                           class="lock"
                                                                           id="lock_<?php echo e($calendar_->id); ?>"
                                                                           name="lock[<?php echo e($calendar_->id); ?>]"
                                                                           value="1"
                                                                        <?php echo e($calendar_->lock_ == 1 ? 'checked' : ''); ?>>
                                                                </div>
                                                            </div>

                                                            <?php
                                                                $dayIndex++;
                                                                if ($dayIndex == 7) {
                                                                    $dayIndex = 0;
                                                                    echo '</div><div class="grid-row">';
                                                                }
                                                            ?>

                                                            <?php if($dayNumber == date('t', strtotime($calendar_->date))): ?>
                                                                <!-- Пополнување на крајот на месецот со празни квадрати -->
                                                                <?php for($i = $dayIndex; $i < 7; $i++): ?>
                                                                    <div class="grid-item empty"></div>
                                                                <?php endfor; ?>
                                                        </div> <!-- Завршува редот -->
                                                    </div>
                                                </div>

                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </form>

                <?php else: ?>
                    <?php echo e(__('global.no_records')); ?>

                <?php endif; ?>



                <!-- /.card-body -->

                <?php if(count($calendar) > 0): ?>
                    <div class="row">
                        <div class="col-sm-12">
                        <a href="#" class="btn btn-danger modal_warning"
                           data-toggle="modal"
                           data-target="#ModalWarning"

                           data-title="<?php echo __('calendar.delete_year_warning',['year'=>app('request')->input('year')]); ?>"
                           data-url="<?php echo e($url_delete_year.'/'.app('request')->input('year')); ?>"

                           data-content_l="<?php echo __('calendar.delete_year_warning_des',['year'=>app('request')->input('year')]); ?>"
                           data-content_b=""
                           data-content_sub_l=""
                           data-content_sub_b=""

                           data-query="<?php echo e($query); ?>"
                           data-url_return="<?php echo e($url); ?>"
                           data-success="<?php echo e(__('calendar.delete_success',['year'=>app('request')->input('year')])); ?>"
                           data-error="<?php echo e(__('calendar.delete_error',['year'=>app('request')->input('year')])); ?>"

                           data-method="DELETE"
                           title="<?php echo __('calendar.delete_year_hint',['year'=>app('request')->input('year')]); ?>">
                            <i class="fa fa-trash"></i>
                        </a>
                        <button type="button" onclick="form_insert.submit();"
                                class="btn btn-success float-right"><?php echo e(__('global.save')); ?></button>
                        </div>
                    </div>
                    <div class="row" style="height: 17px"></div>
                    <!-- /.card-footer -->
                <?php endif; ?>

            </div>
            <!-- /.card -->
            <!-- Table end =============================================================================================== -->


            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('additional_css'); ?>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
    <style>

        .grid-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 3px;
        }
        .grid-header-item {
            border:1px solid #cccccc;
        }
        .calendar-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 100%;
            margin: auto;
        }

       .grid-row {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
        }

        .grid-item {

            display: flex;
            flex-direction: column;
            justify-content: space-between;  /* Распределување на содржина */
            position: relative;
            height: 110px;  /* Висина според дизајнот */
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .grid-item.empty {
            background-color: transparent;
            border: none;
        }

        /*.grid-item input[type="checkbox"] {*/
        /*    margin-top: 5px;*/
        /*}*/

        .weekend {
            background-color: #fbfbd2;
        }
        .non-weekend {
            background-color: #f9f9f9;
        }

        .selected {
            background-color: #fbfbd2;
        }

        .day-label {
            font-size: 12px;
            color: #555;
            padding-left: 3px;
        }
        .grid-content {
            flex-grow: 1;
        }
        .lock-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: absolute;
            bottom: 5px;
            right: 5px;
        }
        .gray-text {
            color: #a0a0a0;  /* Светло сива боја за текстот */
        }

        .gray-text input[type="checkbox"] {
            accent-color: #a0a0a0;  /* Светло сива боја на чекбоксот */
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('additional_js'); ?>
    <!-- Select2 -->
    <script src="<?php echo e(url('LTE/plugins/select2/js/select2.full.min.js')); ?>"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            //Initialize Select2 Elements
            //$('.select2').select2()
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Calendar/resources/views/calendar/index.blade.php ENDPATH**/ ?>