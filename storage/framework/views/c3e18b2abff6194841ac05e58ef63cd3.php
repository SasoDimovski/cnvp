<?php $__env->startSection('content'); ?>

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();
    $listing = app('request')->input('listing', config('users.pagination'));

    $global_style = "cursor: pointer; color: #BD362F";
    $global_style_search = "background-color: #BD362F; color: #fff";

    $year_current = date('Y');
    $year_selected = app('request')->input('year') ? app('request')->input('year') : date('Y');

    $month_current = date('m');
    $month_selected = app('request')->input('month') ? app('request')->input('month') : date('m');



    $url = url('admin/' . $lang . '/' . $module->link); //admin/mk/14/records

    $url_table = $url.'/index-records-table/'.$user->id;
    $url_box = $url.'/'.$user->id;

    $url_create = $url .'/create-record-table/'.$year_selected.'/'.$user->id.'?'.$query;

    $url_edit = $url.'/edit-record-table';
    $url_show = $url.'/show-record-table';
    $url_delete = $url.'/delete-record-table';

    $url_return =$url_table;


    $total = 0;
    $message_error = __('global.update_error');
    $message_success = __('global.update_success');
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
                            <i class="fa <?php echo e($module->design->icon); ?>"></i> <?php echo e($module->title); ?>

                            <a class="btn btn-success btn-sm" href="<?php echo e($url_box); ?>"><?php echo e(__('records.box')); ?></a>
                            <a class="btn btn-warning btn-sm" href="<?php echo e($url_table); ?>"><?php echo e(__('records.table')); ?></a>
                           <?php if($isYearLocked == 0): ?>
                            <a class="btn btn-danger btn-sm" href="#" onclick="getContentID('<?php echo e($url_create); ?>','ModalShow','<?php echo e(__('records.title_working_hours',['date'=>$year_selected])); ?>')"><?php echo e(__('global.new_record')); ?></a></h1>
                           <?php endif; ?>
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
                    <div class="card card-warning card-outline">
                        <div class="card-body">


                            <div class="row">

                                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                                    <?php
                                    $name = 'id_country';
                                    $desc = __('records.id_country');

                                    // Наоѓање на селектираната земја од request или првата земја од assignCountries
                                    $id_country = app('request')->input($name) ?? 'all';

                                    // Наоѓање на името на селектираната земја
                                    $selectedCountry = $assignCountries->where('id', $id_country)->first();
                                    $country_name = optional($selectedCountry)->name ?? optional($assignCountries->first())->name;
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?></label>
                                    <select class="select2bs4"
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" onchange="this.form.submit()"
                                            style="width: 100%">
                                        <?php if(count($assignCountries) > 0): ?>
                                            <?php $__currentLoopData = $assignCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($country->id); ?>" <?php echo e(($id_country == $country->id) ? 'selected' : ''); ?>>
                                                    <?php echo e($country->name); ?> (<?php echo e($country->id); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <option value="all" <?php echo e($id_country=='all'? 'selected' : ''); ?>>All</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <?php
                                    $name = 'year';
                                    $desc = __('records.year');
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?>

                                    </label>

                                    <select class="select2bs4"
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" onchange="this.form.submit()"
                                            style="width: 100%">
                                        <?php if(count($years) > 0): ?>

                                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($year); ?>"
                                                    <?php echo e(($year_selected==$year)? 'selected' : ''); ?>><?php echo e($year); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <?php
                                    $name = 'month';
                                    $desc = __('records.month');
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?>

                                    </label>

                                    <select class="select2bs4"
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" onchange="this.form.submit()"
                                            style="width: 100%">
                                        <option value="1" <?php echo e($month_selected==1 ? 'selected' : ''); ?>>January</option>
                                        <option value="2" <?php echo e($month_selected==2 ? 'selected' : ''); ?>>February</option>
                                        <option value="3" <?php echo e($month_selected==3 ? 'selected' : ''); ?>>March</option>
                                        <option value="4" <?php echo e($month_selected==4 ? 'selected' : ''); ?>>April</option>
                                        <option value="5" <?php echo e($month_selected==5 ? 'selected' : ''); ?>>May</option>
                                        <option value="6" <?php echo e($month_selected==6 ? 'selected' : ''); ?>>June</option>
                                        <option value="7" <?php echo e($month_selected==7 ? 'selected' : ''); ?>>July</option>
                                        <option value="8" <?php echo e($month_selected==8 ? 'selected' : ''); ?>>August</option>
                                        <option value="9" <?php echo e($month_selected==9 ? 'selected' : ''); ?>>September</option>
                                        <option value="10" <?php echo e($month_selected==10 ? 'selected' : ''); ?>>October</option>
                                        <option value="11" <?php echo e($month_selected==11 ? 'selected' : ''); ?>>November</option>
                                        <option value="12" <?php echo e($month_selected==12 ? 'selected' : ''); ?>>December</option>
                                        <option value="all" <?php echo e($month_selected=='all'? 'selected' : ''); ?>>All</option>

                                    </select>
                                </div>
                            </div>
                            <div class="row" style="height: 7px"></div>
                            <div class="row">

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'date_from';
                                    $desc = __('records.date_from');
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

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">

                                    <?php
                                    $name = 'date_to';
                                    $desc = __('records.date_to');
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

                                <div class="col-sm-6 col-md-2  col-lg-2 col-xl-2">
                                    <label class="control-label"> &nbsp;</label>
                                    <button type="button"
                                            class="form-control form-control-sm btn btn-outline-secondary btn-sm"
                                            title="<?php echo e(__('global.reset_button_des')); ?>"
                                            onClick="window.open('<?php echo e($user->id); ?>','_self');"> <?php echo e(__('global.reset_button')); ?>

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
                <?php if(count($errors) > 0): ?>
                    <div id="toast-container" class="toast-top-full-width" onclick="closeErrorWindow(this)"
                         style="width:100%" ;>

                        <div class="toast toast-error" aria-live="assertive" style="width:100%" ;>
                            <div class="toast-progress" style="width:100%;"></div>
                            <button type="button" class="close" data-dismiss="toast-top-full-width"
                                    role="button" onclick="closeErrorWindow(this)">×
                            </button>
                            <p><strong><?php echo e(__('global.error_not')); ?></strong></p>
                            <div class="toast-message">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="callout callout-danger"
                                         style="color: #0a0a0a!important;padding: 5px!important;">
                                        <?php echo $error; ?>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
                                                                    <div class="col-sm-12 col-md-5">
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
                                                        $column_desc = __('records.id');
                                                        $query_sort = request()->query('sort');
                                                        $style_acs_desc = match (true) {
                                                            $query_sort == 'asc' && $order == $column_name => 'asc',
                                                            $query_sort == 'desc' && $order == $column_name => 'desc',
                                                            $query_sort == '' => 'desc',
                                                            default => $style_acs_desc = '',
                                                        };
                                                        ?>
                                                    <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                        style="white-space: nowrap; width: 1px;"
                                                        onclick="orderBy('id','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    
                                                    <th style="white-space: nowrap; width: 1px;" class="target-cell"></th>
                                                    


                                                        <?php
                                                        $column_name = 'id_country';
                                                        $column_desc = __('records.id_country');
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
                                                        $column_desc = __('records.year');
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
                                                        $column_desc = __('records.date');
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
                                                        $column_desc = __('records.project');
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
                                                        $column_desc = __('records.assignment');
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
                                                        $column_desc = __('records.activity');
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
                                                        $column_desc = __('records.duration_s');
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
                                                    
                                                    <th style="white-space: nowrap; width: 1px;" ><i class="fas fa-lock"></i> <?php echo e(__('records.projects')); ?></th>
                                                    
                                                    <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"></i> <?php echo e(__('records.year')); ?></th>
                                                    
                                                    <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"></i> <?php echo e(__('records.record')); ?></th>
                                                    
                                                    <th style="white-space: nowrap; width: 1px;"><?php echo e(__('records.approved')); ?></th>
                                                    
                                                    <th style="white-space: nowrap; width: 1px;" class="source-cell"></th>
                                                    
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $total = $total+$record->duration; ?>
                                                    <tr  <?php if($record->lockrecord== 1||$record->locket_year== 1||$record->projects->active== 0): ?> style="color: #cccccc" <?php endif; ?>>
                                                        <td><?php echo $record->id; ?></td>
                                                        <td  class="target-cell"> </td>
                                                        <td><?php echo $record->countries->name; ?></td>
                                                        <td class="text-center"><?php echo $record->year; ?></td>
                                                        <td class="text-center"><?php echo date("d.m.Y", strtotime($record->date)); ?></td>
                                                        <td><?php echo highlightSearch( $record->projects->name, 'project', $global_style_search); ?></td>
                                                        <td><?php echo highlightSearch( $record->assignments->name, 'assignment', $global_style_search); ?></td>
                                                        <td><?php echo highlightSearch( $record->activities->name, 'activity', $global_style_search); ?>

                                                            <?php if($record->note ): ?>
                                                                &nbsp;<i class="fas fa-comment text-warning" title="<?php echo e($record->note); ?>"></i>

                                                            <?php endif; ?>
                                                            </td>
                                                        <td class="text-center"><?php echo $record->duration; ?></td>

                                                        <td class="text-center">
                                                            <?php if($record->projects->active== 0): ?>
                                                                <i class="fas fa-lock"
                                                                   title="<?php echo e(__('records.locked_project')); ?>"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if($record->locket_year== 1): ?>
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
                                                        <td  class="source-cell">
                                                            <div class="btn-group btn-group-sm">

                                                                
                                                                <button class="btn btn-info"
                                                                        type="button"
                                                                        onclick="getContentID('<?php echo e($url_show.'/'. $record->id.'/'.$user->id); ?>','ModalShow','<?php echo e(__('records.records')); ?>')">
                                                                    <i class="fas fa-eye"
                                                                       title="<?php echo e(__('global.show_hint')); ?>"></i></button>
                                                                
                                                                <?php if($record->lockrecord== 0&&$record->locket_year== 0&&$record->projects->active==1): ?>
                                                                
                                                                <a href="#"
                                                                   class="btn btn-success"
                                                                   onclick="getContentID('<?php echo e($url_edit.'/'.date("Y", strtotime($record->date)).'/'.$record->id.'/'.$user->id.'?'.$query); ?>','ModalShow','<?php echo e(__('records.records')); ?>')"
                                                                ><i
                                                                        class="fa fa-edit"
                                                                        title="<?php echo e(__('global.edit_hint')); ?>"></i></a>
                                                                

                                                                
                                                                <a href="#" class="btn btn-danger modal_warning"
                                                                   data-toggle="modal"
                                                                   data-target="#ModalWarning"

                                                                   data-title="<?php echo e(__('global.delete_record')); ?>"
                                                                   data-url="<?php echo e($url_delete.'/'.$record->id.'/'.$user->id.'?'.$query); ?>"

                                                                   data-content_l="id: <strong class='text-red'><?php echo e($record->id); ?></strong>, "
                                                                   data-content_b="<?php echo e($record->projects->name); ?>, "
                                                                   data-content_sub_l="<?php echo e($record->assignments->name); ?>,"
                                                                   data-content_sub_b="<?php echo e($record->activities->name); ?>"

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

                                                        </td>

                                                    </tr>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>

                                                    <td colspan="7" class="text-right">
                                                        <strong><?php echo e(__('records.total')); ?>:</strong></td>
                                                    <td class="text-center text-danger"><strong><?php echo e($total); ?></strong>
                                                    </td>
                                                    <td colspan="5"></td>
                                                </tr>
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
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/toastr/toastr.min.css')); ?>">
    <style>
        .daterangepicker.single .drp-buttons {
            display: block !important;
        }
        .target-cell {
            display: none;
        }

        @media (max-width: 1400px) {
            .source-cell {
                display: none;
            }

            .target-cell {
                display: table-cell;
            }
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

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Records/resources/views/records/index-records-table.blade.php ENDPATH**/ ?>