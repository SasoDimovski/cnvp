<?php $__env->startSection('content'); ?>

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();
    $listing = app('request')->input('listing', config('users.pagination'));

    $global_style = "cursor: pointer; color: #BD362F";
    $global_style_search = "background-color: #BD362F; color: #fff";

    $url = url('admin/' . $lang . '/' . $module->link);

    $url_base= 'admin/'.$lang.'/'.$id_module.'/users/';

    $url_create= url($url_base.'create/');
    $url_edit = url($url_base.'edit/');
    $url_show = url($url_base.'show/');
    $url_delete = url($url_base.'delete/');


    $url_records = url($url_base.'index-records/');

    $url_excel = url(request()->segment(3)."/excel/".$query);
    $url_pdf = url(request()->segment(3)."/pdf/".$query);

    //echo $assignModules
    ?>
    <?php echo $__env->make('users::users._include-functions.function-highlight-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa <?php echo e($module->design->icon); ?>"></i> <?php echo e($module->title); ?>

                            <?php if(in_array(18, $assignModules)): ?>
                            <a class="btn btn-danger btn-sm" href="<?php echo e($url_create); ?>"><?php echo e(__('global.new_record')); ?></a>
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
                    <input type="hidden" id="page" name="page" value="<?php echo e(app('request')->input('page')); ?>">
                    <!-- card card-red card-outline =============================================================================================== -->
                    <div class="card card-red card-outline">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-12 col-md-1 col-lg-1 col-xl-1">
                                    <?php
                                    $name = 'id';
                                    $desc = __('users.id');
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
                                    $desc = __('users.name');
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
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'surname';
                                    $desc = __('users.surname');
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
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?php
                                    $name = 'email';
                                    $desc = __('users.email');
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
                                    <text-input :name="$username" :desc="__('users.username')" :maxlength="$maxlength" ></text-input>
                                    <?php
                                    $name = 'username';
                                    $desc = __('users.username');
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

                                <div class="col-sm-12 col-md-4 col-lg-5 col-xl-3">
                                    <?php
                                    $name = 'id_country';
                                    $desc = __('users.id_country');

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <label class="control-label"><?php echo e($desc); ?>

                                        <b onclick="deleteSearchInput('<?php echo e($name); ?>','<?php echo e($query); ?>')" style="<?php echo e($style); ?>"
                                           title="<?php echo e(__('global.delete_search_field')); ?>"><?php echo e($x); ?></b>
                                    </label>
                                    <select class="select2bs4"
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" onchange="this.form.submit()"
                                            style="width: 100%">
                                        <?php if(count($countries) > 0): ?>
                                            <option value="">&nbsp;</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($country->id); ?>" <?php echo e(((app('request')->input($name))==$country->id)? 'selected' : ''); ?>><?php echo e($country->name); ?> (<?php echo e($country->id); ?>)</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                    <?php
                                    $name = 'id_expiration_time';
                                    $desc = __('users.id_expiration_time');
                                    $desc_label = __('users.id_expiration_time_des');

                                    $value = app('request')->input($name) ? app('request')->input($name) : null;
                                    $style = app('request')->input($name) ? $global_style : null;
                                    $x = app('request')->input($name) ? ('    x') : null;
                                    ?>
                                    <label class="control-label" title="<?php echo e($desc_label); ?>"><?php echo e($desc); ?>

                                        <b onclick="deleteSearchInput('<?php echo e($name); ?>','<?php echo e($query); ?>')" style="<?php echo e($style); ?>"
                                           title="<?php echo e(__('global.delete_search_field')); ?>"><?php echo e($x); ?></b>
                                    </label>

                                    <select class="select2bs4" title="<?php echo e($desc_label); ?>"
                                            id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" onchange="this.form.submit()"
                                            style="width: 100%">
                                        <?php if(count($expiration_time) > 0): ?>
                                            <option value="" title="<?php echo e(__('users.id_expiration_time_des')); ?>">&nbsp;
                                            </option>
                                            <?php $__currentLoopData = $expiration_time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expiration_time_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($expiration_time_->id); ?>"
                                                        title="<?php echo e(__('users.id_expiration_time_des')); ?>" <?php echo e(((app('request')->input($name))==$expiration_time_->id)? 'selected' : ''); ?>><?php echo e($expiration_time_->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                            </div>

                            <div class="row" style="height: 7px"></div>

                            <div class="row">

                                <div class="col-sm-6 col-md-2 col-lg-3 col-xl-2">
                                    <div class="row" style="height: 17px"></div>
                                    <div class="custom-control custom-checkbox">
                                        <?php
                                        $name = 'active';
                                        $desc = __('global.active');
                                        ?>
                                        <input class="custom-control-input" type="checkbox" id="<?php echo e($name); ?>"
                                               name="<?php echo e($name); ?>" value="1"
                                               <?php echo e(((app('request')->input($name))!='')? 'checked' : ''); ?>  onchange="this.form.submit()">
                                        <label for="<?php echo e($name); ?>"
                                               class="custom-control-label"
                                               id="<?php echo e($name); ?>"><?php echo e($desc); ?></label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <?php
                                        $name = 'deactivated';
                                        $desc = __('global.deactivated');
                                        ?>
                                        <input class="custom-control-input" type="checkbox" id="<?php echo e($name); ?>"
                                               name="<?php echo e($name); ?>" value="1"
                                               <?php echo e(((app('request')->input($name))!='')? 'checked' : ''); ?>  onchange="this.form.submit()">
                                        <label for="<?php echo e($name); ?>"
                                               class="custom-control-label"
                                               id="<?php echo e($name); ?>"><?php echo e($desc); ?></label>
                                    </div>
                                </div>
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
                        <?php if(count($users) > 0): ?>
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
                                                class="badge badge-warning"><?php echo e($users->firstItem()); ?></span></strong>
                                        <?php echo e(__('global.to')); ?>

                                        <strong> <span
                                                class="badge badge-warning"><?php echo e($users->lastItem()); ?></span></strong>
                                        (<?php echo e(__('global.sum')); ?>

                                        <strong> <span
                                                class="badge badge-danger"><?php echo e($users->total()); ?></span></strong>
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
                                                    $column_desc = __('users.id');
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
                                                
                                                <th style="white-space: nowrap; width: 1px;" class="target-cell"></th>
                                                
                                                    <?php
                                                    $column_name = 'name';
                                                    $column_desc = __('users.name');
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
                                                    $column_name = 'surname';
                                                    $column_desc = __('users.surname');
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
                                                    $column_name = 'email';
                                                    $column_desc = __('users.email');
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
                                                    $column_name = 'username';
                                                    $column_desc = __('users.username');
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
                                                    $column_name = 'records';
                                                    $column_desc = __('projects.records');
                                                    $query_sort = request()->query('sort');
                                                    $style_acs_desc = match(true) {
                                                        $query_sort == 'asc' && $order == $column_name => 'asc',
                                                        $query_sort == 'desc' && $order == $column_name => 'desc',
                                                        default => $style_acs_desc='',
                                                    };
                                                    ?>
                                                <th class="sortable <?php echo e($style_acs_desc); ?>" style="white-space: nowrap; width: 1px;"
                                                    onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                

                                                <th style="white-space: nowrap; width: 1px;"><i class="fas fa-lock"  title="<?php echo e(__('global.active_status')); ?>"></i>
                                                </th>
                                                
                                                <th style="white-space: nowrap; width: 1px;"  class="source-cell"></th>
                                                
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <tr <?php if($user->active == 0): ?> style="color: #cccccc" <?php endif; ?>>
                                                    <td><?php echo highlightSearch($user->id, 'id', $global_style_search); ?></td>
                                                    <td  class="target-cell"> </td>
                                                    <td><?php echo highlightSearch($user->name, 'name', $global_style_search); ?></td>
                                                    <td><?php echo highlightSearch($user->surname, 'surname', $global_style_search); ?></td>
                                                    <td><?php echo highlightSearch($user->email, 'email', $global_style_search); ?></td>
                                                    <td><?php echo highlightSearch($user->username, 'username', $global_style_search); ?></td>
                                                    <td class="text-center"><?php echo e($user->records_count); ?></td>
                                                    <td>
                                                        <?php if($user->active == 0): ?>
                                                            <i class="fas fa-lock"
                                                               title="<?php echo e(__('global.deactivated')); ?>"></i>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="source-cell">
                                                        <div class="btn-group btn-group-sm">
                                                            
                                                            <a href="<?php echo e($url_records.'/'.$user->id); ?>"
                                                               class="btn btn-warning"><i
                                                                    class="fa fa-receipt"
                                                                    title="<?php echo e(__('users.records')); ?>"></i></a>
                                                            

                                                            <button class="btn btn-info"

                                                                    onclick="getContentID('<?php echo e($url_show.'/'. $user->id); ?>','ModalShow','<?php echo e($module->title); ?>')">
                                                                <i class="fas fa-eye"
                                                                   title="<?php echo e(__('global.show_hint')); ?>"></i></button>
                                                            <?php if(in_array(18, $assignModules)): ?>
                                                            
                                                            <?php if((Auth::id() != 1)&&($user->id !=1)||(Auth::id() == 1)): ?>
                                                                
                                                                <a href="<?php echo e($url_edit.'/'.$user->id.'?'.$query); ?>"
                                                                   class="btn btn-success"><i
                                                                        class="fa fa-edit"
                                                                        title="<?php echo e(__('global.edit_hint')); ?>"></i></a>
                                                                
                                                                <a href="#" class="btn btn-danger modal_warning"
                                                                   data-toggle="modal"
                                                                   data-target="#ModalWarning"

                                                                   data-title="<?php echo e(__('global.delete_record')); ?>"
                                                                   data-url="<?php echo e($url_delete.'/'.$user->id.'?'.$query); ?>"

                                                                   data-content_l="id: <?php echo e($user->id); ?>, "
                                                                   data-content_b="<?php echo e($user->surname); ?> <?php echo e($user->name); ?>, "
                                                                   data-content_sub_l="<?php echo e($user->username); ?>"
                                                                   data-content_sub_b=""

                                                                   data-query="<?php echo e($query); ?>"
                                                                   data-url_return="<?php echo e($url); ?>"
                                                                   data-success="<?php echo e(__('global.delete_success')); ?>"
                                                                   data-error="<?php echo e(__('global.delete_error')); ?>"

                                                                   data-method="DELETE"

                                                                   title="<?php echo e(__('global.delete_hint')); ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                
                                                            <?php endif; ?>

                                                            <?php endif; ?>

                                                        </div>

                                                    </td>
                                                </tr>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>


                                        </table>
                                    </div>
                                </div>

                                <!-- Page =============================================================================================== -->

                                <div class="row">
                                    <div class="col-sm-6 col-md-6">

                                            <?php
                                            $query = request()->getQueryString();
                                            if (empty($query)) {
                                                $query = 'r';
                                            }
                                            ?>

                                    </div>


                                    <div class="col-sm-6 col-md-6">
                                        <div class="pagination pagination-sm float-right">
                                            <?php echo e($users->withQueryString()->links('pagination::bootstrap-4')); ?>

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
<?php $__env->startSection('additional_css'); ?>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
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
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Users/resources/views/users/index.blade.php ENDPATH**/ ?>