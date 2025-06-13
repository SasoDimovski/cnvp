<?php $__env->startSection('content'); ?>

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);

    $queryParams = [];
    if ($query = request()->getQueryString()) {
        parse_str($query, $queryParams);

        // Отстрануваме празни, null и "all" вредности
        $queryParams = array_filter($queryParams, fn($value) => !in_array($value, [null, ''], true));
    }
    $query = http_build_query($queryParams);

    $listing = app('request')->input('listing', config('reports.pagination'));

    $global_style = "cursor: pointer; color: #BD362F";
    $global_style_search = "background-color: #BD362F; color: #fff";

    $year_current = date('Y');
    $year_selected = app('request')->input('year') ? app('request')->input('year') : date('Y');

    $month_current = date('m');
    $month_selected = app('request')->input('month') ? app('request')->input('month') : date('m');

    $url = url('admin/' . $lang . '/' . $module->link); //admin/mk/14/records

    $total=0;
    $message_error = __('global.update_error');
    $message_success = __('global.update_success');

    $url_pdf='';
    $url_excel=$url.'/export-excel-group';
    $url_pdf=$url.'/export-pdf-group';
    ?>
    <?php echo $__env->make('users::users._include-functions.function-highlight-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <i class="fa <?php echo e($module->design->icon); ?>"></i> <?php echo e($module->title); ?> / <span class="text-success"><?php echo e(__('reports.type_group')); ?></span>
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
                <?php echo $__env->make('Reports::reports._search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- card card-red card-outline  END =============================================================================================== -->
                <!-- Search end=============================================================================================== -->
                <?php echo $__env->make('admin._flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- Table =============================================================================================== -->
                <div class="card card-warning card-outline">

                    <div class="card-body scrollmenu">

                        <?php if(count($records) > 0): ?>
                                <?php
                                $order = request()->query('order');
                                $sort = (request()->query('sort') == 'asc') ? 'desc' : 'asc';
                                ?>
                            <div class="dataTables_wrapper dt-bootstrap4">

                                <!-- Page =============================================================================================== -->
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <?php echo e(__('global.show_from')); ?>

                                                                        <strong> <span
                                                                                class="badge badge-warning"><?php echo e($records->firstItem()); ?></span></strong>
                                                                        <?php echo e(__('global.to')); ?>

                                                                        <strong> <span
                                                                                class="badge badge-warning"><?php echo e($records->lastItem()); ?></span></strong>
                                                                        (<?php echo e(__('global.sum')); ?>

                                                                        <strong> <span
                                                                                class="badge badge-danger"><?php echo e($records->total()); ?></span></strong>
                                                                        <?php echo e(__('global.records')); ?>)

                                                                            <?php
                                                                            $query = request()->getQueryString();
                                                                            $queryParams = [];
                                                                            if (!empty($query)) {
                                                                                parse_str($query, $queryParams);
                                                                            }
                                                                            $query_export = http_build_query(array_merge($queryParams, ['listing' => 'a']));
                                                                            parse_str($query_export, $queryParams);
                                                                            ?>
                                                                        <a class="btn btn-default btn-sm float-right"
                                                                           href="<?php echo e($url_excel.'?'.$query_export); ?>"
                                                                           title="<?php echo e(__('global.export_excel')); ?>"><i
                                                                                class="fa fa-print"></i> <?php echo e(__('global.export_excel')); ?>

                                                                        </a>







                                                                    </div>
                                                                </div>
                                <!-- Page end =============================================================================================== -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example2" class="table_grid">
                                                <thead>

                                                <tr>
                                                  















                                                    
                                                        <?php
                                                        $column_name = 'name';
                                                        $column_desc = __('reports.id_user');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                        <?php
                                                        $column_name = 'id_country';
                                                        $column_desc = __('reports.id_country');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>

                                                    

                                                        <?php
                                                        $column_name = 'year';
                                                        $column_desc = __('reports.year');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                        <?php
                                                        $column_name = 'date';
                                                        $column_desc = __('reports.date');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                        <?php
                                                        $column_name = 'project';
                                                        $column_desc = __('reports.project');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                        <?php
                                                        $column_name = 'assignment';
                                                        $column_desc = __('reports.assignment');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                        <?php
                                                        $column_name = 'activity';
                                                        $column_desc = __('reports.activity');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                        <?php
                                                        $column_name = 'duration';
                                                        $column_desc = __('reports.duration_s');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $total = $total+$record->duration;
                                                        $record_assignments_name=$record->assignments->name??'n/a';
                                                        $record_activities_name=$record->activities->name??'n/a';
                                                        ?>
                                                    <tr <?php if($record->activities->type==1): ?> style="color: #BD362F" <?php endif; ?> >

                                                        <td> <?php echo $record->insertedByUser->name; ?> <?php echo $record->insertedByUser->surname; ?></td>
                                                        <td><?php echo $record->countries->name; ?></td>
                                                        <td class="text-center"><?php echo $record->year; ?></td>
                                                        <td class="text-center"><?php echo $record->date; ?></td>
                                                        <td><?php echo highlightSearch( $record->projects->name, 'project', $global_style_search); ?></td>
                                                        <td><?php echo highlightSearch( $record_assignments_name, 'assignment', $global_style_search); ?></td>
                                                        <td><?php echo highlightSearch( $record_activities_name, 'activity', $global_style_search); ?>

                                                            </td>
                                                        <td class="text-center"><?php echo $record->duration; ?></td>




                                                    </tr>


                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <?php if($records->total()< $listing): ?>
                                                <tr>

                                                    <td colspan="7" class="text-right">
                                                        <strong><?php echo e(__('reports.total')); ?>:</strong></td>
                                                    <td class="text-center text-danger"><strong><?php echo e($total); ?></strong>
                                                    </td>

                                                </tr>
                                                <?php endif; ?>

                                                </tbody>


                                            </table>
                                        </div>
                                    </div>

                                <div class="col-sm-12 col-md-12">
                                    <div class="pagination pagination-sm float-right">
                                        <?php echo e($records->withQueryString()->links('pagination::bootstrap-4')); ?>

                                    </div>

                                </div>


                                <!-- Page end =============================================================================================== -->
                            </div>
                        <?php else: ?>
                            <?php echo e(__('global.no_records')); ?>

                        <?php endif; ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- Table end =============================================================================================== -->


            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('additional_css'); ?>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
    <!-- date-range-picker -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/daterangepicker/daterangepicker.css')); ?>">
    <style>
        .daterangepicker.single .drp-buttons {
            display: block !important;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('additional_js'); ?>
    <!-- Select2 -->
    <script src="<?php echo e(url('LTE/plugins/select2/js/select2.full.min.js')); ?>"></script>
    
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?php echo e(url('LTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')); ?>"></script>
    <!-- InputMask -->
    <script src="<?php echo e(url('LTE/plugins/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(url('LTE/plugins/inputmask/min/jquery.inputmask.bundle.min.js')); ?>"></script>
    <!-- date-range-picker -->
    <script src="<?php echo e(url('LTE/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
    <!-- bs-custom-file-input -->
    <script src="<?php echo e(url('LTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>"></script>
    
    <script>


        $(document).ready(function () {
            // Иницијализација на bsCustomFileInput
            bsCustomFileInput.init();

            // Конфигурација за Date Range Picker
            const datePickerConfig = {
                singleDatePicker: true,
                autoUpdateInput: false,
                showDropdowns: true,
                minYear: 2012,  // Минимална година
                maxYear: parseInt(moment().format('YYYY'), 10) + 1,  // Максимална година (тековна + 1)

                locale: {
                    format: "DD.MM.YYYY",
                    separator: " - ",
                    // applyLabel: "Внеси",
                    // cancelLabel: "Бриши",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    daysOfWeek: ["Не", "По", "Вт", "Ср", "Че", "Пе", "Са"],
                    // monthNames: [
                    //     "Јануари", "Февруари", "Март", "Април", "Мај", "Јуни",
                    //     "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"
                    // ],
                    firstDay: 1
                }
            };

            // Функција за иницијализација на Date Range Picker за дадено поле
            function initializeDatePicker(selector) {
                const inputField = $(selector);

                inputField.daterangepicker(datePickerConfig);

                inputField.on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD.MM.YYYY'));
                });

                inputField.on('cancel.daterangepicker', function () {
                    $(this).val('');
                });
            }

            // Иницијализација за `start_date` и `end_date`
            initializeDatePicker('input[name="date_from"]');
            initializeDatePicker('input[name="date_to"]');
        });

        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Reports/resources/views/reports/index-group.blade.php ENDPATH**/ ?>