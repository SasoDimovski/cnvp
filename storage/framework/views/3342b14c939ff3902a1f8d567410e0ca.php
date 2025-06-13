<?php $__env->startSection('content'); ?>

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();
    $listing = app('request')->input('listing', config('activities.pagination'));

    $global_style = "cursor: pointer; color: #BD362F";
    $global_style_search = "background-color: #BD362F; color: #fff";

    $url = url('admin/' . $lang . '/' . $module->link);

    $url_base= 'admin/'.$lang.'/'.$id_module.'/activities/';

    $url_create= url($url_base.'create/');
    $url_edit = url($url_base.'edit/');
    $url_show = url($url_base.'show/');
    $url_delete = url($url_base.'delete/');

    $url_excel = url(request()->segment(3)."/excel/".$query);
    $url_pdf = url(request()->segment(3)."/pdf/".$query);

    ?>
    <?php echo $__env->make('activities::activities._include-functions.function-highlight-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa <?php echo e($module->design->icon); ?>"></i> <?php echo e($module->title); ?> <a class="btn btn-danger btn-sm" href="<?php echo e($url_create); ?>"><?php echo e(__('global.new_record')); ?></a></h1>
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
                    <input type="hidden" id="page" name="page" value="<?php echo e(app('request')->input('page')); ?>">
                    <!-- card card-red card-outline =============================================================================================== -->
                    <div class="card card-red card-outline">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                    <?php
                                    $name = 'id';
                                    $desc = __('activities.id');
                                    $maxlength = 10;

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?>

                                        <b onclick="deleteSearchInput('<?php echo e($name); ?>','<?php echo e($query); ?>')" style="<?php echo e($style); ?>"
                                           title="<?php echo e(__('global.delete_search_field_des')); ?>"><?php echo e($x); ?></b>
                                    </label>
                                    <input type="text" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                           class="form-control form-control-sm"
                                           value="<?php echo e($value); ?>"
                                           placeholder="<?php echo e($desc); ?>" maxlength="<?php echo e($maxlength); ?>">
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'name';
                                    $desc = __('activities.name');
                                    $maxlength = 100;

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?>

                                        <b onclick="deleteSearchInput('<?php echo e($name); ?>','<?php echo e($query); ?>')" style="<?php echo e($style); ?>"
                                           title="<?php echo e(__('global.delete_search_field')); ?>"><?php echo e($x); ?></b>
                                    </label>
                                    <input type="text" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                                           class="form-control form-control-sm"
                                           value="<?php echo e($value); ?>"
                                           placeholder="<?php echo e($desc); ?>" maxlength="<?php echo e($maxlength); ?>">
                                </div>


                            </div>

                            <div class="row" style="height: 7px"></div>

                            <div class="row">
                                <div class="col-sm-6 col-md-2 col-lg-1 col-xl-1">
                                    <?php
                                    $name = 'listing';
                                    $desc = __('global.listing');
                                    $options = [
                                        1 => '1',
                                        15 => '15',
                                        50 => '50',
                                        100 => '100',
                                        200 => '200',
                                        'a' => __('global.all'),
                                    ];
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?></label>
                                    <select id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>"
                                                <?php echo e($listing == $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php echo $__env->make('admin._flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- Table =============================================================================================== -->
                <div class="card card-gray card-outline">

                    <div class="card-body scrollmenu">
                        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php if(count($activities) > 0): ?>
                                <?php
                                $order = request()->query('order');
                                $sort = (request()->query('sort') == 'asc') ? 'desc' : 'asc';
                                ?>
                            <div class="dataTables_wrapper dt-bootstrap4">

                                <!-- Page =============================================================================================== -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <?php echo e(__('global.show_from')); ?>

                                        <strong> <span
                                                class="badge badge-warning"><?php echo e($activities->firstItem()); ?></span></strong>
                                        <?php echo e(__('global.to')); ?>

                                        <strong> <span
                                                class="badge badge-warning"><?php echo e($activities->lastItem()); ?></span></strong>
                                        (<?php echo e(__('global.sum')); ?>

                                        <strong> <span
                                                class="badge badge-danger"><?php echo e($activities->total()); ?></span></strong>
                                        <?php echo e(__('global.records')); ?>)
                                    </div>
                                </div>
                                <!-- Page end =============================================================================================== -->


                                <div class="row">
                                    <div class="col-sm-12">

                                        <table id="example2" class="table_grid">
                                            <thead>
                                            <tr>
                                                
                                                    <?php
                                                    $column_name = 'id';
                                                    $column_desc = __('activities.id');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        $query_sort == '' => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable <?php echo e($style_acs_desc); ?>"  style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('id','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                
                                                    <?php
                                                    $column_name = 'name';
                                                    $column_desc = __('activities.name');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                    onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                
                                                    <?php
                                                    $column_name = 'type';
                                                    $column_desc = __('activities.type');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable <?php echo e($style_acs_desc); ?>" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                
                                                    <?php
                                                    $column_name = 'projects';
                                                    $column_desc = __('activities.projects');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable <?php echo e($style_acs_desc); ?>" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                
                                                    <?php
                                                    $column_name = 'records';
                                                    $column_desc = __('activities.records');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable <?php echo e($style_acs_desc); ?>" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th style="white-space: nowrap; width: 1px;"></th>
                                                
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $isExpired = isset($activity->end_date) && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($activity->end_date));
                                                    ?>
                                                <tr>
                                                    <td><?php echo highlightSearch($activity->id, 'id', $global_style_search); ?></td>
                                                    <td><?php echo highlightSearch($activity->name, 'name', $global_style_search); ?></td>
                                                    <td class="text-center">
                                                        <?php if($activity->type== 1): ?>
                                                            <i class="fas fa-check text-gray"></i>
                                                        <?php endif; ?>

                                                    </td>
                                                    <td class="text-center"><?php echo e($activity->projects_count); ?></td>
                                                    <td class="text-center"><?php echo e($activity->records_count); ?></td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            
                                                            <button class="btn btn-info"
                                                                    onclick="getContentID('<?php echo e($url_show.'/'. $activity->id); ?>','ModalShow','<?php echo e($module->title); ?>')">
                                                                <i class="fas fa-eye"
                                                                   title="<?php echo e(__('global.show_hint')); ?>"></i></button>
                                                            

                                                                
                                                                <a href="<?php echo e($url_edit.'/'.$activity->id.'?'.$query); ?>"
                                                                   class="btn btn-success"><i
                                                                        class="fa fa-edit"
                                                                        title="<?php echo e(__('global.edit_hint')); ?>"></i></a>
                                                                
                                                                <a href="#" class="btn btn-danger modal_warning"
                                                                   data-toggle="modal"
                                                                   data-target="#ModalWarning"

                                                                   data-title="<?php echo e(__('global.delete_record')); ?>"
                                                                   data-url="<?php echo e($url_delete.'/'.$activity->id.'?'.$query); ?>"

                                                                   data-content_l="id: <?php echo e($activity->id); ?>, "
                                                                   data-content_b="<?php echo e($activity->name); ?>, "
                                                                   data-content_sub_l="<?php echo e($activity->code); ?>"
                                                                   data-content_sub_b=""

                                                                   data-query="<?php echo e($query); ?>"
                                                                   data-url_return="<?php echo e($url); ?>"
                                                                   data-success="<?php echo e(__('global.delete_success')); ?>"
                                                                   data-error="<?php echo e(__('global.delete_error')); ?>"

                                                                   data-method="DELETE"

                                                                   title="<?php echo e(__('global.delete_hint')); ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                


                                                        </div>

                                                    </td>
                                                </tr>


                                            </tbody>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </table>
                                    </div>
                                </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="pagination pagination-sm float-right">
                                            <?php echo e($activities->withQueryString()->links('pagination::bootstrap-4')); ?>

                                        </div>

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
                locale: {
                    format: "DD.MM.YYYY",
                    separator: " - ",
                    applyLabel: "Внеси",
                    cancelLabel: "Бриши",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    daysOfWeek: ["Не", "По", "Вт", "Ср", "Че", "Пе", "Са"],
                    monthNames: [
                        "Јануари", "Февруари", "Март", "Април", "Мај", "Јуни",
                        "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"
                    ],
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
            initializeDatePicker('input[name="start_date"]');
            initializeDatePicker('input[name="end_date"]');
        });


        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Activities/resources/views/activities/index.blade.php ENDPATH**/ ?>