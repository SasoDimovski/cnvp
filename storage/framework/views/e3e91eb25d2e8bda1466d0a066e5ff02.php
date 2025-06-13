<?php
$lang = request()->segment(2);
$query = request()->getQueryString();
$year_selected = app('request')->input('year') ? app('request')->input('year') : date('Y');
$month_selected = app('request')->input('month') ? app('request')->input('month') : date('m');
$url = 'admin/' . $lang . '/' . $module->link;

$allLocked=isset($calendar->allLocked)?$calendar->allLocked:'';
$url_show_records_day = url($url . '/show-records-day');
$url_show_records_day_list = url($url . '/show-records-day-list');
$url_show_records_week = url($url . '/show-records-week');
$url_show_records_week_list = url($url . '/show-records-week-list');
$url_delete_records_day = url($url . '/delete-records-day');
$url_delete_records_week = url($url . '/delete-records-week');
$url_edit_record_week= url($url . '/edit-records-week');
$url_return= url($url . '/'.$user->id);
$url_edit_record_day = url($url . '/edit-record-day');

// Наоѓање на селектираната земја од request или првата земја од assignCountries
$id_country = app('request')->input('id_country') ?? optional($assignCountries->first())->id;

// Наоѓање на името на селектираната земја
$selectedCountry = $assignCountries->where('id', $id_country)->first();
$country_name = optional($selectedCountry)->name ?? optional($assignCountries->first())->name;
?>


<?php if(count($calendar) > 0): ?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3><strong><?php echo e($year_selected); ?></strong>, <?php echo $country_name; ?>

                <?php if($allLocked== 1): ?> <strong class="text-red"><?php echo e(__('records.locked_year')); ?></strong> <?php endif; ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <label class="text-red">
                <?php echo $user->name; ?> <?php echo $user->surname; ?>, <?php echo $user->username; ?>,  id: <?php echo $user->id; ?>, <?php echo $user->email; ?>

            </label>
        </div>
    </div>



    <div class="dataTables_wrapper dt-bootstrap4">
        <div class="row">
            <div class="col-sm-12">

                
                <div class="calendar-grid">
                    <?php
                        $dayOrder = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                        $weeklyTotal = 0;
                        $dayIndex = 0;
                        $openRow = false;
                        $calendarCount = count($calendar);
                        $currentMonth = '';
                        $showSingleMonth = isset($singleMonth) && $singleMonth;
                    ?>

                    <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $calendar_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $monthName = date('F', strtotime($calendar_->date));
                            $dayNumber = date('d', strtotime($calendar_->date));
                            $startDay = strtolower(date('D', strtotime($calendar_->date)));
                            $weeklyTotal += $calendar_->total_duration ?? 0;
                        ?>

                            <!-- Нов месец (ако има повеќе месеци) -->
                        <?php if(!$showSingleMonth && ($dayNumber == 1 || $currentMonth != $monthName)): ?>
                            <?php
                                // Затвори ја претходната картичка ако месецот се смени
                                if ($currentMonth != '') {
                                    echo '</div></div></div>';
                                }
                                $currentMonth = $monthName;
                                $dayIndex = array_search($startDay, $dayOrder);
                            ?>

                            <div class="card card-green card-outline mb-4">
                                <div class="card-header">
                                    <h4 class="m-0"><strong><?php echo e($monthName); ?></strong></h4>
                                </div>
                                <div class="card-body scrollmenu">
                                    <div class="grid-header">
                                        <div>Mon</div>
                                        <div>Tue</div>
                                        <div>Wed</div>
                                        <div>Thu</div>
                                        <div>Fri</div>
                                        <div class="gray-text">Sat</div>
                                        <div class="gray-text">Sun</div>
                                        <div class="week-summary-header text-success"><?php echo e(__('records.weekly_total')); ?></div>
                                    </div>

                                    <div class="grid-row">
                                        <?php for($i = 0; $i < $dayIndex; $i++): ?>
                                            <div class="grid-item empty"></div>
                                        <?php endfor; ?>
                                        <?php $openRow = true; ?>
                                        <?php endif; ?>

                                        <!-- Денови во календарот -->
                                        <div class="grid-item
                                        <?php if($calendar_->day == 'sat' || $calendar_->day == 'sun'): ?> weekend <?php endif; ?>
                                        <?php if($calendar_->is_holiday == 1): ?> selected <?php endif; ?>
                                         <?php if($calendar_->lock_ == 1  ): ?> gray-text  <?php endif; ?>">
                                            <div class="grid-content">


                                                <div class="row">
                                                    <div class="col-sm-6 text-left">
                                                    <span class="day-label"><?php echo e(date('d', strtotime($calendar_->date))); ?></span>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <?php if($calendar_->lock_ == 1): ?>
                                                            <i class="fa fa-lock text-gray"
                                                               title="<?php echo e(__('calendar.lock')); ?>"></i>&nbsp;&nbsp;



                                                        <?php endif; ?>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-12 ">
                                                        <?php if($calendar_->lock_ == 0): ?>
                                                            <?php  $style = $calendar_->total_duration ? 'butt_full_day' : 'butt_empty_day'; ?>
                                                            <?php  $style_non_working = $calendar_->is_holiday == 1 ? 'butt_non_working' : ''; ?>
                                                            <button class="btn  <?php echo e($style); ?> <?php echo e($style_non_working); ?>"
                                                                    onclick="getContentID('<?php echo e($url_edit_record_day.'/'.date("Y-m-d", strtotime($calendar_->date)).'/'.$id_country.'/'.Auth::id().'?'.$query); ?>', 'ModalShow', '<?php echo e(__('records.title_working_hours',['date'=>date("d.m.Y", strtotime($calendar_->date))])); ?>')">
                                                                <strong><?php echo e($calendar_->total_duration ?? __('records.enter_working_hours')); ?></strong>
                                                            </button>
                                                        <?php endif; ?>
                                                            <?php if($calendar_->lock_ == 1&&$calendar_->total_duration ): ?>
                                                            <?php  $style = $calendar_->total_duration ? 'butt_full_day_lock' : 'butt_empty_day_lock'; ?>
                                                            <?php  $style_non_working = $calendar_->is_holiday == 1 ? 'butt_non_working_lock' : ''; ?>
                                                            <button class="btn  <?php echo e($style); ?> <?php echo e($style_non_working); ?>">
                                                                <strong><?php echo e($calendar_->total_duration ?? __('records.enter_working_hours')); ?></strong>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="row buttons">

                                                    <div class="col-sm-6 text-left">
                                                        <div class="btn-group btn-group-sm mt-3">
                                                            <?php if($calendar_->total_duration > 0): ?>
                                                                <button class="btn btn-outline-success modal90"
                                                                        onclick="getContentID('<?php echo e($url_show_records_day_list.'/'.date("Y-m-d", strtotime($calendar_->date)).'/'.$id_country.'/'.Auth::id()); ?>', 'ModalShow', '<?php echo e(__('records.title_working_hours',['date'=>date("d.m.Y", strtotime($calendar_->date))])); ?>')">
                                                                    <i class="fas fa-list"
                                                                       title="<?php echo e(__('global.show_hint')); ?>"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 text-right">
                                                        <div class="btn-group btn-group-sm mt-3">
                                                            <?php if($calendar_->total_duration > 0 &&$calendar_->lock_ == 0): ?>
                                                                <a href="#"
                                                                   class="btn btn-outline-success modal_warning"
                                                                   data-toggle="modal"
                                                                   data-target="#ModalWarning"

                                                                   data-title="<?php echo e(__('records.delete_daily_records')); ?>"
                                                                   data-url="<?php echo e($url_delete_records_day.'/'.date("Y-m-d", strtotime($calendar_->date)).'/'.$id_country.'/'.Auth::id()); ?>"


                                                                   data-content_l="<?php echo e(__('records.date')); ?>: <strong><?php echo e(date("d.m.Y", strtotime($calendar_->date))); ?></strong> "
                                                                   data-content_b="<?php echo e(__('records.duration')); ?>: <strong><?php echo e($calendar_->total_duration); ?></strong> "
                                                                   data-content_sub_l=""
                                                                   data-content_sub_b=""

                                                                   data-query="<?php echo e($query); ?>"
                                                                   data-url_return="<?php echo e($url_return); ?>"
                                                                   data-success="<?php echo e(__('global.delete_success')); ?>"
                                                                   data-error="<?php echo e(__('global.delete_error')); ?>"



                                                                   data-method="DELETE"
                                                                   title="<?php echo e(__('global.delete_hint')); ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <?php
                                            $dayIndex++;

                                            // Прикажи збир веднаш по Sunday
                                            if ($calendar_->day == 'sun') {
                                        ?>

                                        <div class="grid-item week-summary text-success">
                                            <?php
                                                $dateFormatted = date("Y-m-d", strtotime($calendar_->date));
                                                $dateMinus7 = date("d.m", strtotime($calendar_->date . ' -6 days'));
                                                $dateOriginal = date("d.m", strtotime($calendar_->date));
                                            ?>

                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                   <span class="week-label"><?php echo e($dateMinus7); ?> - <?php echo e($dateOriginal); ?></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12 text-lg-center ">


                                                    <?php if($calendar_->lock_ == 0): ?>
                                                        <?php
                                                            $style = (isset($weeklyTotal) && $weeklyTotal > 0) ? 'butt_full_week' : 'butt_empty_week';
                                                        ?>
                                                        <button class="btn btn-success btn <?php echo e($style); ?>"
                                                                onclick="getContentID('<?php echo e($url_edit_record_week.'/'.date("Y-m-d", strtotime($calendar_->date)).'/'.$id_country.'/'.Auth::id().'?'.$query); ?>', 'ModalShow', '<?php echo e(__('records.title_working_hours_week', ['date'=>$dateMinus7, 'date1'=>$dateOriginal])); ?>')">
                                                            <strong class="text-white">
                                                                <?php if(isset($weeklyTotal) && $weeklyTotal > 0): ?>
                                                                 <?php echo e($weeklyTotal); ?>

                                                                <?php else: ?>
                                                                    <?php echo e(__('records.enter_working_hours')); ?>

                                                                 <?php endif; ?>

                                                            </strong>
                                                        </button>

                                                    <?php endif; ?>
                                                        <?php if($calendar_->lock_ == 1&&(isset($weeklyTotal) && $weeklyTotal > 0)): ?>
                                                        <?php
                                                            $style = (isset($weeklyTotal) && $weeklyTotal > 0) ? 'butt_full_week_lock' : 'butt_empty_week_lock';
                                                        ?>
                                                        <button class="btn btn-success btn <?php echo e($style); ?>">
                                                            <strong class="text-white">
                                                                <?php if(isset($weeklyTotal) && $weeklyTotal > 0): ?>
                                                                    <?php echo e($weeklyTotal); ?>

                                                                <?php else: ?>
                                                                    <?php echo e(__('records.enter_working_hours')); ?>

                                                                <?php endif; ?>

                                                            </strong>
                                                        </button>


                                                    <?php endif; ?>






                                                </div>
                                            </div>

                                            <div class="row buttons">
                                                <div class="col-sm-6 text-left">
                                                    <div class="btn-group btn-group-sm mt-2">
                                                        <?php if($weeklyTotal > 0): ?>
                                                            <button class="btn btn-outline-dark modal90"
                                                                    onclick="getContentID('<?php echo e($url_show_records_week_list.'/'.$dateFormatted.'/'.$id_country.'/'.Auth::id()); ?>', 'ModalShow', '<?php echo e(__('records.title_working_hours_week', ['date'=>$dateMinus7, 'date1'=>$dateOriginal])); ?>')">
                                                                <i class="fas fa-list"
                                                                   title="<?php echo e(__('global.show_hint')); ?>"></i>
                                                            </button>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                                <div class="col-sm-6  text-right">
                                                    <div class="btn-group btn-group-sm mt-2">

                                                        <?php if($weeklyTotal > 0&&$calendar_->lock_ == 0): ?>
                                                            <a href="#"
                                                               class="btn btn-outline-dark modal_warning"
                                                               data-toggle="modal"
                                                               data-target="#ModalWarning"

                                                               data-title="<?php echo e(__('records.delete_daily_records')); ?>"
                                                               data-url="<?php echo e($url_delete_records_week.'/'.date("Y-m-d", strtotime($calendar_->date)).'/'.$id_country.'/'.Auth::id()); ?>"

                                                               data-content_l="<?php echo e(__('records.period')); ?>: <strong><?php echo e($dateMinus7); ?> - <?php echo e($dateOriginal); ?> </strong> "
                                                               data-content_b="<?php echo e(__('records.duration')); ?>: <strong><?php echo e($weeklyTotal); ?></strong> "
                                                               data-content_sub_l=""
                                                               data-content_sub_b=""

                                                               data-query="<?php echo e($query); ?>"
                                                               data-url_return="<?php echo e($url_return); ?>"
                                                               data-success="<?php echo e(__('global.delete_success')); ?>"
                                                               data-error="<?php echo e(__('global.delete_error')); ?>"



                                                               data-method="DELETE"
                                                               title="<?php echo e(__('global.delete_hint')); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                            echo '</div><div class="grid-row">';

                                             $dayIndex = 0;
                                            $weeklyTotal = 0;
                                            $openRow = true;
                                        }
                                        ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <!-- Затвори ја последната недела ако не завршува со недела -->
                                        <?php if($openRow && $currentMonth == 'December'): ?>
                                            <?php for($i = $dayIndex; $i < 7; $i++): ?>
                                                <div class="grid-item empty"></div>
                                            <?php endfor; ?>
                                            <div class="grid-item week-summary text-success">
                                                <strong><?php echo e($weeklyTotal); ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div></div></div>
                </div>


                

            </div>
            <!-- /.container-fluid -->

<?php else: ?>
    <?php echo e(__('global.no_records')); ?>

<?php endif; ?>
            <style>

                .grid-header {
                    display: grid;
                    grid-template-columns: repeat(8, 1fr);
                    text-align: center;
                    font-weight: bold;
                    margin-bottom: 10px;
                    padding: 3px;
                }
                .grid-header div{
                    min-width: 80px;
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
                    grid-template-columns: repeat(8, 1fr);
                    text-align: center;
                    font-weight: bold;
                }

                .grid-item {

                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;  /* Распределување на содржина */
                    position: relative;
                    height: 120px;  /* Висина според дизајнот */
                    border: 1px solid #ddd;
                    padding: 7px;
                    background-color: #f9f9f9;
                    min-width: 80px;
                }

                .grid-item.empty {
                    background-color: transparent;
                    border: none;
                }
                .butt_empty_day_lock {
                    background-color: #dc3545;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_empty_day {
                    background-color: #dc3545;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_empty_day:hover {
                    background-color: #a71d2a; /* Потемна нијанса при hover */
                    cursor: pointer; /* Променува курсорот во рака */
                    color: #FFFFFF!important;;
                }
                .butt_full_day{
                    background-color: #28a745;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_full_day_lock{
                    background-color: #93a797;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_full_day:hover{
                    background-color: #218838;
                    color: #FFFFFF!important;;
                }
                .butt_empty_week {
                    background-color: #dc3545;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_full_week_lock{
                    background-color: #28a745;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_empty_week_lock {
                    background-color: #dc3545;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_full_week{
                    background-color: #28a745;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_non_working{
                    background-color: #d9d9d9!important;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_non_working_lock{
                    background-color: #d9d9d9!important;
                    width: 80px;
                    color: #FFFFFF!important;;
                }
                .butt_non_working:hover{
                    background-color: #bababa!important;
                }
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
                    font-size: 15px;
                    color: #bebebe;
                    padding-left: 3px;
                }
                .week-label {
                    font-size: 12px;
                    color: #555;
                    padding-left: 1px;
                }

                .total-label {
                    font-size: 17px;
                    color: #555;
                    padding-left: 3px;
                }
                .grid-content {
                    flex-grow: 1;
                }
                .lock-container {

                }
                .gray-text {
                    color: #a0a0a0;  /* Светло сива боја за текстот */
                }

                .gray-text input[type="checkbox"] {
                    accent-color: #a0a0a0;  /* Светло сива боја на чекбоксот */
                }

                @media only screen and (max-width: 768px) {
                  .butt_empty_day, .butt_full_day, .butt_empty_week, .butt_full_week, .butt_non_working, .butt_empty_day_lock, .butt_full_day_lock, .butt_empty_week_lock, .butt_full_week_lock, .butt_non_working_lock{
                        max-width:46px;
                        padding:5px;
                }
                .buttons {
                        display:none;
                }
                .grid-item {
                    height: unset;
                }
                }

            </style>
<?php /**PATH /var/www/Modules/Records/resources/views/records/_index.blade.php ENDPATH**/ ?>