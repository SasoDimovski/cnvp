<?php $__env->startSection('content'); ?>

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();


    $id = $project->id ?? '';
    $name = $project->name ?? old('name');
    $description = $project->description ?? old('description');
    $code = $project->code  ?? old('code');

    $start_date = (isset($project->start_date)) ? date("d.m.Y H:i:s", strtotime($project->start_date)) : old('start_date');
    $end_date = (isset($project->end_date)) ? date("d.m.Y H:i:s", strtotime($project->end_date)) : old('end_date');

    $dateinserted = (isset($project->dateinserted)) ? date("d.m.Y H:i:s", strtotime($project->dateinserted)) : '';
    $dateupdated = (isset($project->dateupdated)) ? date("d.m.Y H:i:s", strtotime($project->dateupdated)) : '';


    $insertedby = $project->insertedby ?? old('insertedby');
    $updatedby = $project->updatedby ?? old('updatedby');

    $active = $project->active ?? '';
    $type= $project->type ?? '';


    $url = url('admin/' . $lang . '/' . $module->link);
    $url_store = url('admin/' . $lang . '/' . $id_module . '/projects/store/');
    $url_update = url('admin/' . $lang . '/' . $id_module . '/projects/update/' . $id);
    $url_action = !empty($id) ? $url_update : $url_store;
    $url_return = url('admin/' . $lang . '/' . $id_module . '/projects/edit/' . $id);
    $path_upload = 'uploads/projects/';

    $message_error = (isset($id)) ? __('global.update_error') : __('global.save_error');
    $message_success = (isset($id)) ? __('global.update_success') : __('global.save_success');

    $url_base= 'admin/'.$lang.'/'.$id_module.'/projects/';
    $url_create= url($url_base.'create_assign/');
    $url_edit = url($url_base.'edit_assign/');
    $url_show = url($url_base.'show_assign/');
    $url_delete = url($url_base.'delete_assign/');

    ?>


        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa <?php echo e($module->design->icon); ?>"></i> <?php echo e($module->title); ?> </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="<?php echo e($url); ?>"><?php echo e($module->title); ?></a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- / Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
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

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xll-6">
                        <!-- Form-->
                        <form class="needs-validation" role="form" id="form_edit" name="form_edit"
                              action="<?php echo e("{$url_action}"); ?>" method="POST" enctype="multipart/form-data">

                            <input type="hidden" id="url_return" name="url_return" value="<?php echo e($url_return); ?>">
                            <input type="hidden" id="query" name="query" value="<?php echo e($query); ?>">
                            <input type="hidden" id="message_error" name="message_error" value="<?php echo e($message_error); ?>">
                            <input type="hidden" id="message_success" name="message_success"
                                   value="<?php echo e($message_success); ?>">

                            <input type="hidden" id="id" name="id" value="<?php echo e($id); ?>">
                            <input type="hidden" id="id_module" name="id_module" value="<?php echo e($id_module); ?>">
                            <?php echo e(csrf_field()); ?>

                            <?php echo method_field('PUT'); ?>


                            <div class="card card">

                                <div class="card-header">
                                    <?php if($active==0): ?>
                                        &nbsp;<i class="fas fa-lock text-danger"
                                                 title="<?php echo e(__('global.deactivated')); ?>"></i>
                                    <?php endif; ?>
                                    <h3 class="card-title">  <?php if(isset($id)&&!empty($id)): ?>
                                            id: <?php echo e($id); ?>

                                        <?php else: ?>
                                            <?php echo e(__('global.new_record')); ?>

                                        <?php endif; ?></h3>&nbsp;&nbsp;


                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php
                                            $input_value = $active;
                                            $input_name = 'active';
                                            $input_desc = __('projects.active');
                                            $input_readonly = '';
                                            $input_css = 'text';
                                            ?>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="<?php echo e($input_name); ?>"
                                                           name="<?php echo e($input_name); ?>"
                                                           value="1" <?php if($input_value==1||$input_value==''): ?> <?php echo e('checked'); ?> <?php endif; ?> <?php echo e($input_readonly); ?>>
                                                    <label class="custom-control-label" for="<?php echo e($input_name); ?>"
                                                    <?php echo e($input_css); ?> id="<?php echo e($input_name); ?>"><?php echo e($input_desc); ?></label>
                                                </div>
                                            </div>


                                        </div>






















                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php
                                            $input_value = $name;
                                            $input_name = 'name';
                                            $input_desc = __('projects.name');
                                            $input_maxlength = 100;
                                            $input_readonly = '';
                                            $input_css = 'text-red';
                                            ?>
                                            <div class="form-group">
                                                <label for="<?php echo e($input_name); ?>" class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?>

                                                    *</label>
                                                <input type="text" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                       class="form-control" value="<?php echo e($input_value); ?>"
                                                       maxlength="<?php echo e($input_maxlength); ?>" <?php echo e($input_readonly); ?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            $input_value = $code;
                                            $input_name = 'code';
                                            $input_desc = __('projects.code');
                                            $input_maxlength = 100;
                                            $input_readonly = '';
                                            $input_css = 'text-red';
                                            ?>
                                            <div class="form-group">
                                                <label for="<?php echo e($input_name); ?>" class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?>

                                                    *</label>
                                                <input type="text" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                       class="form-control" value="<?php echo e($input_value); ?>"
                                                       maxlength="<?php echo e($input_maxlength); ?>" <?php echo e($input_readonly); ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php
                                            $myArray = json_decode(json_encode($activitiesAss), true);

                                            $input_value = $end_date;
                                            $input_name = 'activities[]';
                                            $input_desc = __('projects.activities');
                                            $input_readonly = '';
                                            $input_css = 'text-red';
                                            ?>

                                            <div class="form-group">
                                                <i class="fas fa-list text-info"></i> <label class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?> *</label>
                                                <select class="select2bs4" style="width: 100%"
                                                        id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                        autocomplete="off" <?php echo e($input_readonly); ?>>
                                                    <?php if(count($activities) > 0): ?>
                                                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                value="<?php echo e($activity->id); ?>"
                                                                <?php echo e(in_array($activity->id, old('activities', array_column($myArray, 'id'))) ? 'selected' : ''); ?>>
                                                                <?php echo e($activity->name); ?> 
                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            $input_value = $start_date;
                                            $input_name = 'start_date';
                                            $input_desc = __('projects.start_date');
                                            $input_maxlength = 100;
                                            $input_readonly = 'readonly';
                                            $input_css = 'text-red';
                                            ?>
                                            <div class="form-group">
                                                <i class="fas fa-calendar text-info"></i>  <label for="<?php echo e($input_name); ?>" class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?>

                                                    *</label>
                                                <input type="text" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                       class="form-control" value="<?php echo e($input_value); ?>"
                                                       maxlength="<?php echo e($input_maxlength); ?>" <?php echo e($input_readonly); ?>>
                                                <!-- Сокриено поле што ќе ја испрати вредноста -->
                                                <input type="hidden" name="<?php echo e($input_name); ?>" id="<?php echo e($input_name); ?>_hidden" value="<?php echo e($input_value); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            $input_value = $end_date;
                                            $input_name = 'end_date';
                                            $input_desc = __('projects.end_date');
                                            $input_maxlength = 100;
                                            $input_readonly = 'readonly';
                                            $input_css = 'text-red';
                                            ?>
                                            <div class="form-group">
                                                <i class="fas fa-calendar text-info"></i> <label for="<?php echo e($input_name); ?>" class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?>

                                                    *</label>
                                                <input type="text" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                       class="form-control" value="<?php echo e($input_value); ?>"
                                                       maxlength="<?php echo e($input_maxlength); ?>" <?php echo e($input_readonly); ?>>
                                                <!-- Сокриено поле што ќе ја испрати вредноста -->
                                                <input type="hidden" name="<?php echo e($input_name); ?>" id="<?php echo e($input_name); ?>_hidden" value="<?php echo e($input_value); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php
                                            $input_value = $description;
                                            $input_name = 'description';
                                            $input_desc = __('projects.description');
                                            $input_maxlength = 255;
                                            $input_raws = 2;
                                            $input_readonly = '';
                                            $input_css = 'text';
                                            ?>
                                            <div class="form-group"><i class="fas fa-comment text-info"></i>
                                                <label class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?></label>
                                                <textarea class="form-control" id="<?php echo e($input_name); ?>"
                                                          name="<?php echo e($input_name); ?>"
                                                          rows="<?php echo e($input_raws); ?>"
                                                          placeholder="<?php echo e($input_desc); ?>"
                                                          maxlength="<?php echo e($input_maxlength); ?>"  <?php echo e($input_readonly); ?>><?php echo e($input_value); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if(isset($project)): ?>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <i class="fas fa-user text-success"></i>
                                                <strong><?php echo e(__('projects.insertedby')); ?>:</strong> <?php echo e($insertedby_); ?><br>
                                                <i class="fas fa-user text-success"></i>
                                                <strong><?php echo e(__('projects.updatedby')); ?>:</strong> <?php echo e($updatedby_); ?><br>
                                            </div>
                                            <div class="col-sm-6">
                                                <i class="fas fa-clock text-warning"></i>
                                                <strong><?php echo e(__('projects.dateinserted')); ?>:</strong> <?php echo e($dateinserted); ?><br>
                                                <i class="fas fa-clock text-warning"></i>
                                                <strong><?php echo e(__('projects.dateupdated')); ?>:</strong> <?php echo e($dateupdated); ?>

                                            </div>

                                                <?php
                                                $input_value = $insertedby;
                                                $input_name = 'insertedby';
                                                ?>
                                            <input type="hidden" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                   value="<?php echo e($input_value); ?>">
                                                <?php
                                                $input_value = $updatedby;
                                                $input_name = 'updatedby';
                                                ?>
                                            <input type="hidden" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                   value="<?php echo e($input_value); ?>">
                                                <?php
                                                $input_value = $dateinserted;
                                                $input_name = 'dateinserted';
                                                ?>
                                            <input type="hidden" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                   class="form-control" value="<?php echo e($input_value); ?>">
                                                <?php
                                                $input_value = $dateupdated;
                                                $input_name = 'dateupdated';
                                                ?>
                                            <input type="hidden" id="<?php echo e($input_name); ?>" name="<?php echo e($input_name); ?>"
                                                   class="form-control" value="<?php echo e($input_value); ?>"
                                                   maxlength="<?php echo e($input_maxlength); ?>" <?php echo e($input_readonly); ?>>
                                        </div>

                                     <?php endif; ?>
                                    
                                    <button type="button" onclick="form_edit.submit();"
                                            class="btn btn-success float-right"><?php echo e(__('global.save')); ?></button>
                                </div>
                                <!-- /.card-body -->




                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->


                            <!-- /.col-md-12 -->

                            <!-- /.row-->
                        </form>
                        <!-- /.form -->
                    </div>
                    <?php if(!empty($id)): ?>


                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xll-12">

                            <div class="card card">

                                <div class="card-header">
                                    <h3 class="card-title"><?php echo e(__('projects.assignments_new')); ?>

                                    </h3>
                                    <button type="button" class="btn btn-tool"
                                            onclick="getContentID('<?php echo e($url_create.'/'. $id); ?>','ModalShow','<?php echo e(__('projects.assignment')); ?>')">
                                        <i class="fas fa-plus-circle"></i></button>
                                    </button>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.card header-->
                                <div class="card-body scrollmenu">
                                    <?php if(count($assignments) > 0): ?>
                                            <?php
                                            $order = request()->query('order');
                                            $sort = (request()->query('sort') == 'asc') ? 'desc' : 'asc';
                                            ?>
                                        <div class="dataTables_wrapper dt-bootstrap4">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table id="example2" class="table_grid">
                                                        <thead>
                                                        <tr>


                                                            


                                                                <?php
                                                                $column_name = 'id';
                                                                $column_desc = __('projects.id');
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
                                                                onclick="orderBy('id','<?php echo e($sort); ?>')"><?php echo e($column_desc); ?>

                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                            
                                                            <th style="white-space: nowrap; width: 1px;" class="target-cell"></th>

                                                            
                                                                <?php
                                                                $column_name = 'name';
                                                                $column_desc = __('projects.name');
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
                                                                $column_name = 'code';
                                                                $column_desc = __('projects.code');
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
                                                                $column_name = 'start_date';
                                                                $column_desc = __('projects.start_date');
                                                                $query_sort = request()->query('sort');
                                                                $style_acs_desc = match (true) {
                                                                    $query_sort == 'asc' && $order == $column_name => 'asc',
                                                                    $query_sort == 'desc' && $order == $column_name => 'desc',
                                                                    default => $style_acs_desc = '',
                                                                };
                                                                ?>
                                                            <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                                onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><i class="fas fa-calendar"></i> <?php echo e($column_desc); ?>

                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                            
                                                                <?php
                                                                $column_name = 'end_date';
                                                                $column_desc = __('projects.end_date');
                                                                $query_sort = request()->query('sort');
                                                                $style_acs_desc = match (true) {
                                                                    $query_sort == 'asc' && $order == $column_name => 'asc',
                                                                    $query_sort == 'desc' && $order == $column_name => 'desc',
                                                                    default => $style_acs_desc = '',
                                                                };
                                                                ?>
                                                            <th class="sortable <?php echo e($style_acs_desc); ?>"
                                                                onclick="orderBy('<?php echo e($column_name); ?>','<?php echo e($sort); ?>')"><i class="fas fa-calendar"></i> <?php echo e($column_desc); ?>

                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                            
                                                            
                                                            

                                                            <th style="white-space: nowrap; width: 1px;"><i
                                                                    class="fas fa-list"
                                                                    title="<?php echo e(__('projects.records_assign')); ?>"></i>
                                                            </th>
                                                            




                                                            
                                                            <th style="white-space: nowrap; width: 1px;"><i
                                                                    class="fas fa-archive"
                                                                    title="<?php echo e(__('global.expired_status')); ?>"></i>
                                                            </th>
                                                            
                                                            <th style="white-space: nowrap; width: 1px;" class="source-cell"></th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $isExpired = isset($assignment->end_date) && \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($assignment->end_date));
                                                            ?>
                                                            <tr <?php if($isExpired): ?> style="color: #BD362F" <?php endif; ?> >
                                                                <td><?php echo $assignment->id; ?></td>
                                                                <td  class="target-cell"> </td>
                                                                <td title="<?php echo $assignment->id; ?>"><?php echo $assignment->name; ?></td>
                                                                <td><?php echo $assignment->code; ?></td>
                                                                <td title="<?php echo date("d.m.Y  H:m:s", strtotime($assignment->start_date )); ?>"><?php echo date("d.m.Y", strtotime($assignment->start_date )); ?></td>
                                                                <td title="<?php echo date("d.m.Y  H:m:s", strtotime($assignment->end_date )); ?>"><?php echo date("d.m.Y", strtotime($assignment->end_date )); ?></td>
                                                                <td class="text-center"><?php echo $assignment->records_count; ?></td>






                                                                <td>
                                                                    <?php if($isExpired): ?>
                                                                        <i class="fas fa fa-archive text-red"
                                                                           title="<?php echo e(__('global.expired')); ?>"></i>
                                                                    <?php endif; ?>
                                                                </td>

                                                                <td  class="source-cell">
                                                                    <div class="btn-group btn-group-sm">

                                                                        
                                                                        <button class="btn btn-outline-dark "
                                                                                type="button"
                                                                                onclick="getContentID('<?php echo e($url_show.'/'. $assignment->id); ?>','ModalShow','<?php echo e(__('projects.assignment')); ?>')">
                                                                            <i class="fas fa-eye"
                                                                               title="<?php echo e(__('global.show_hint')); ?>"></i>
                                                                        </button>
                                                                        

                                                                        
                                                                        <button class="btn btn-outline-dark "
                                                                                type="button"
                                                                                onclick="getContentID('<?php echo e($url_edit.'/'. $id.'/'. $assignment->id); ?>','ModalShow','<?php echo e(__('projects.assignment')); ?>')">
                                                                            <i class="fas fa-edit"
                                                                               title="<?php echo e(__('global.edit_hint')); ?>"></i>
                                                                        </button>
                                                                        
                                                                        <a href="#"
                                                                           class="btn btn-outline-dark modal_warning"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalWarning"

                                                                           data-title="<?php echo e(__('global.delete_record')); ?>"
                                                                           data-url="<?php echo e($url_delete.'/'.$assignment->id.'?'.$query); ?>"

                                                                           data-content_l="id: <?php echo e($assignment->id); ?>, "
                                                                           data-content_b="<?php echo e($assignment->name); ?>, "
                                                                           data-content_sub_l="<?php echo e($assignment->code); ?>"
                                                                           data-content_sub_b=""

                                                                           data-query="<?php echo e($query); ?>"
                                                                           data-url_return="<?php echo e($url_return); ?>"
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


                                        </div>
                                    <?php else: ?>
                                        <?php echo e(__('global.no_records')); ?>

                                    <?php endif; ?>

                                </div>
                                <!-- /.card body-->

                                <div class="card-footer">

                                </div>
                                <!-- /.card footer-->
                            </div>


                        </div>
                </div>

                <!-- /.row-->

                <?php endif; ?>

            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.Main content -->


    </div>
    <!-- /.Content Wrapper. Contains page content -->
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
        @media (min-width: 1300px) {
            .col-xll-6{
                flex: 0 0 70%;
                max-width: 70%;
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

            // Конфигурација за Date Range Picker со вклучено време
            const dateTimePickerConfig = {
                singleDatePicker: true,
                autoUpdateInput: false,
                timePicker: false, // Овозможете време
                timePicker24Hour: true, // 24-часовен формат
                timePickerSeconds: true, // Вклучете секунди
                showDropdowns: true,
                locale: {
                    format: "DD.MM.YYYY HH:mm:ss", // Формат за датум и време
                    // applyLabel: "Внеси",
                    // cancelLabel: "Бриши",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    // daysOfWeek: ["Не", "По", "Вт", "Ср", "Че", "Пе", "Са"],
                    // monthNames: [
                    //     "Јануари", "Февруари", "Март", "Април", "Мај", "Јуни",
                    //     "Јули", "Август", "Септември", "Октомври", "Ноември", "Декември"
                    // ],
                    firstDay: 1
                }
            };

            // Функција за иницијализација на Date Range Picker за дадено поле
            function initializeDateTimePicker(selector) {
                const inputField = $(selector);

                inputField.daterangepicker(dateTimePickerConfig);

                inputField.on('apply.daterangepicker', function (ev, picker) {
                    // Поставување на времето на 23:59:59 за end_date
                    // if (selector.includes('end_date')) {
                    //     const endOfDay = picker.startDate.clone().set({
                    //         hour: 23,
                    //         minute: 59,
                    //         second: 59
                    //     });
                    //     picker.setStartDate(endOfDay);  // Поставување нов датум со крај на денот
                    // }
                    // Форматирање и пополнување на полето
                    $(this).val(picker.startDate.format('DD.MM.YYYY HH:mm:ss'));
                    $('#start_date_hidden').val(picker.startDate.format('DD.MM.YYYY HH:mm:ss'));
                });

                inputField.on('cancel.daterangepicker', function () {
                    $(this).val('');
                });
            }
            // Функција за end_date која секогаш го поставува времето на 23:59:59
            function initializeEndDateTimePicker(selector) {
                const inputField = $(selector);

                inputField.daterangepicker(dateTimePickerConfig);

                inputField.on('apply.daterangepicker', function (ev, picker) {
                    // Присилно поставување на 23:59:59 за end_date
                    picker.startDate.set({
                        hour: 23,
                        minute: 59,
                        second: 59
                    });
                    $(this).val(picker.startDate.format('DD.MM.YYYY HH:mm:ss'));
                    $('#end_date_hidden').val(picker.startDate.format('DD.MM.YYYY HH:mm:ss'));
                });

                inputField.on('cancel.daterangepicker', function () {
                    $(this).val('');
                });
            }
            // Иницијализација за `start_date`
            initializeDateTimePicker('input[name="start_date"]');
            // Иницијализација за `end_date` (ако е потребно)
            initializeEndDateTimePicker('input[name="end_date"]');
        });



        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Projects/resources/views/projects/edit.blade.php ENDPATH**/ ?>