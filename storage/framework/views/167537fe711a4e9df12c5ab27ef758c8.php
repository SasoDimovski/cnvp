<?php $__env->startSection('content'); ?>

    <?php
    $id_module = $module->id ?? '';
    $lang = request()->segment(2);
    $query = request()->getQueryString();

    $id = $user->id ?? '';
    $id_user_logged = Auth::id();
    $name = $user->name ?? old('name');
    $surname = $user->surname ?? old('surname');
    $id_country = $user->id_country ?? old('id_country');
    $address = $user->address ?? old('address');
    $phone = $user->phone ?? old('phone');
    $picture = $user->picture ?? old('photo');
    $email = $user->email ?? old('email');
    $email_verified_at = $user->email_verified_at ?? old('email_verified_at');
    $username = $user->username ?? old('username');
    $user_type = $user->user_type ?? old('user_type');
    $password = $user->password ?? '';
    $password_reset_hash = $user->password_reset_hash ?? old('password_reset_hash');
    $id_expiration_time = $user->id_expiration_time ?? old('id_expiration_time');
    $edb = $user->edb ?? old('edb');
    $active = $user->active ?? '';

    $created_at = (isset($user->created_at)) ? date("d.m.Y  H:i:s", strtotime($user->created_at)) : '';
    $updated_at = (isset($user->updated_at)) ? date("d.m.Y  H:i:s", strtotime($user->updated_at)) : '';


    $url = url('admin/' . $lang . '/' . $module->link);

    $url_store = url('admin/' . $lang . '/' . $id_module . '/users/store/');
    $url_update = url('admin/' . $lang . '/' . $id_module . '/users/update/' . $id);
    $url_action = !empty($id) ? $url_update : $url_store;

    $url_return = url('admin/' . $lang . '/' . $id_module . '/users/edit/' . $id);
    $url_send_email = url('admin/' . $lang . '/' . $id_module . '/users/send-email-reg/' . $id);

    $url_store_doc = url('admin/' . $lang . '/' . $id_module . '/users/store_doc/' . $id);
    $url_update_doc = url('admin/' . $lang . '/' . $id_module . '/users/update_doc/' . $id);
    $url_delete_doc = url('admin/' . $lang . '/' . $id_module . '/users/delete_doc/' . $id);


    $path_upload = 'uploads/users/';

    $message_error = (isset($id)) ? __('global.update_error') : __('global.save_error');
    $message_success = (isset($id)) ? __('global.update_success') : __('global.save_success');

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

                <!-- Form-->
                <form class="needs-validation" role="form" id="form_edit" name="form_edit"
                      action="<?php echo e("{$url_action}"); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="url_return" name="url_return" value="<?php echo e($url_return); ?>">
                    <input type="hidden" id="query" name="query" value="<?php echo e($query); ?>">
                    <input type="hidden" id="message_error" name="message_error" value="<?php echo e($message_error); ?>">
                    <input type="hidden" id="message_success" name="message_success" value="<?php echo e($message_success); ?>">

                    <input type="hidden" id="id_user_logged" name="id_user_logged" value="<?php echo e($id_user_logged); ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo e($id); ?>">
                    <input type="hidden" id="id_module" name="id_module" value="<?php echo e($id_module); ?>">
                    <?php echo e(csrf_field()); ?>

                    <?php echo method_field('PUT'); ?>

                    <div class="row">


                        <div class="col-md-6">

                            <!-- Errors ---------->
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
                            <!-- ./Errors ---------->

                            <div class="card card">

                                <div class="card-header">
                                    <?php if($active==0): ?> &nbsp;<i class="fas fa-lock text-danger" title="<?php echo e(__('global.deactivated')); ?>"></i><?php endif; ?>
                                    <h3 class="card-title">  <?php if(isset($user)): ?> id: <?php echo e($id); ?><?php else: ?> <?php echo e(__('global.new_record')); ?> <?php endif; ?></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="active"
                                                           name="active"
                                                           value="1" <?php if($active==1||$active==''): ?>
                                                        <?php echo e('checked'); ?>

                                                        <?php endif; ?> >
                                                    <label for="active"
                                                           class="custom-control-label"
                                                           id="active"><?php echo e(__('users.active')); ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="name" class="text-red"><?php echo e(__('users.name')); ?></label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                       value="<?php echo e($name); ?>"
                                                       maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="surname" class="text-red"><?php echo e(__('users.surname')); ?></label>
                                                <input type="text" id="surname" name="surname" class="form-control"
                                                       value="<?php echo e($surname); ?>"
                                                       maxlength="100">
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="username" class="text-red"><?php echo e(__('users.username')); ?></label>
                                                <input type="text" id="username" name="username" class="form-control"
                                                       value="<?php echo e($username); ?>"
                                                       maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="email" class="text-red"><?php echo e(__('users.email')); ?></label>
                                                <input type="text" id="email" name="email" class="form-control"
                                                       value="<?php echo e($email); ?>"
                                                       maxlength="100">
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="address"><?php echo e(__('users.address')); ?></label>
                                                <input type="text" id="address" name="address" class="form-control"
                                                       value="<?php echo e($address); ?>"
                                                       maxlength="100">
                                            </div>
                                        </div>



















                                        <div class="col-sm-6">
                                            <?php
                                            $myArray = json_decode(json_encode($assignCountries), true);

                                            $input_value = $id_country;
                                            $input_name = 'id_country[]';
                                            $input_desc = __('users.id_country');
                                            $input_readonly = '';
                                            $input_css = 'text-red';
                                            ?>

                                            <div class="form-group">
                                                <label class="<?php echo e($input_css); ?>"><?php echo e($input_desc); ?></label>
                                                <select class="select2bs4" style="width: 100%" multiple="multiple"
                                                        id="<?php echo e($input_name); ?>"
                                                        name="<?php echo e($input_name); ?>"
                                                        autocomplete="off" <?php echo e($input_readonly); ?>>
                                                    <?php if(count($countries) > 0): ?>
                                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                value="<?php echo e($country->id); ?>"
                                                                <?php echo e(in_array($country->id, old('id_country', array_column($myArray, 'id'))) ? 'selected' : ''); ?>>
                                                                <?php echo e($country->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="phone"><?php echo e(__('users.phone')); ?></label>
                                                <input type="text" id="phone" name="phone" class="form-control"
                                                       value="<?php echo e($phone); ?>"
                                                       maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="id_expiration_time"
                                                    class="text-red"><?php echo e(__('users.id_expiration_time_des')); ?></label>
                                                <select class="select2bs4" style="width:100%;" id="id_expiration_time"
                                                        name="id_expiration_time">
                                                    <?php if(count($expiration_time) > 0): ?>
                                                        <option value="">&nbsp;</option>
                                                        <?php $__currentLoopData = $expiration_time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expiration_time_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                value="<?php echo e($expiration_time_->id); ?>" <?php echo e(($id_expiration_time==$expiration_time_->id)? 'selected' : ''); ?>><?php echo e($expiration_time_->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label
                                                    for="user_type'"
                                                    class="text-red"><?php echo e(trans('users.user_type')); ?></label>
                                                <select class="select2bs4" style="width:100%;" id="user_type" name="user_type" required>
                                                    <option value="">&nbsp;</option>
                                                    <?php $__currentLoopData = config('users.user_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($type['value']); ?>" <?php echo e(($user_type == $type['value']) ? 'selected' : ''); ?>>
                                                            <?php echo e($type['name']); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <?php if((!isset($user) && config('users.users_enable_pass_new') == 1) ||
                                        (isset($user) && config('users.users_enable_pass_edit') == 1)): ?>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label
                                                        for="password"><?php echo e(__('users.password')); ?></label>
                                                    <input type="password" id="password" name="password"
                                                           class="form-control"
                                                           value=""
                                                           maxlength="20">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label
                                                        for="confirm-password"><?php echo e(__('users.password_confirm')); ?></label>
                                                    <input type="password" id="confirm-password" name="confirm-password"
                                                           class="form-control"
                                                           value=""
                                                           maxlength="20">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="label" style="width: 100%;text-align: right;"
                                                     id="toggle_img">
                                                    <img src="/app_admin/images/eye-close.png"
                                                         style="cursor: pointer;" id="toggle" onclick="toggleSwap()"
                                                         title="<?php echo e(__('global.toggle')); ?>">
                                                </div>
                                            </div>

                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(isset($user)): ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group"><i class="fas fa-clock text-warning"></i>
                                                    <label
                                                        for="created_at"><?php echo e(__('users.created_at')); ?></label>
                                                    <input type="text" id="created_at" class="form-control"
                                                           value="<?php echo e($created_at); ?>"
                                                           readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group"><i class="fas fa-clock text-warning "></i>
                                                    <label
                                                        for="updated_at"><?php echo e(__('users.updated_at')); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" id="updated_at" class="form-control"
                                                               value="<?php echo e($updated_at); ?>"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <?php if(isset($user)): ?>
                                        <a href="#" class="btn btn-danger modal_warning"
                                           data-toggle="modal"
                                           data-target="#ModalWarning"

                                           data-title="<?php echo __('users.edit.send_email_title'); ?>"
                                           data-url="<?php echo $url_send_email; ?>"

                                           data-content_l="<?php echo __('users.edit.send_email_description'); ?>"
                                           data-content_b=""

                                           data-query="<?php echo e($query); ?>"
                                           data-url_return="<?php echo e($url_return); ?>"
                                           data-success="<?php echo e(__('users.edit.send_email_success')); ?>"
                                           data-error="<?php echo e(__('users.edit.send_email_error')); ?>"

                                           title="<?php echo e(__('users.edit.send_email_hint')); ?>">
                                            <i class="fa fa-mail-bulk"></i>
                                        </a>
                                    <?php endif; ?>
                                    <button type="button" onclick="form_edit.submit();"
                                            class="btn btn-success float-right"><?php echo e(__('global.save')); ?></button>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->

                        <!--   Image ================================================================================-->
                        <div class="col-md-6">
                            <div class="card card">

                                <div class="card-header">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label><?php echo __('users.edit.image.attach'); ?></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="picture" name="picture"
                                                       onchange="checkImage(this,'<?php echo __('users.edit.image.title_res'); ?>','<?php echo __('users.edit.image.type'); ?>','<?php echo __('users.edit.image.size',['size'=>config('users.allowed_image_size')]); ?>','<?php echo config('users.allowed_image_size'); ?>','<?php echo __('users.edit.image.save_warning'); ?>','<?php echo $picture; ?>')"

                                                       autocomplete="off">
                                                <label class="custom-file-label" id="custom-file-label"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        $css = empty($picture) ? 'display: none' : '';
                                        $src = !empty($picture) ? $path_upload . $id . '/' . $picture : '';
                                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
                                        $domain = $protocol . $_SERVER['HTTP_HOST'];
                                    ?>
                                    <input type="hidden" id="file_name_hidden" name="file_name_hidden"
                                           value="<?php echo e($picture); ?>" autocomplete="off">
                                    <div class="form-group" id="picture_content" name="picture_content"
                                         style="<?php echo e($css); ?>">

                                        <div class="time-label">
                                            <img id="upload_image" class="img-circle img-bordered-sm modal_image"
                                                 data-target="#ModalImage"
                                                 width="70px" height="70px" alt="image" data-toggle="modal"
                                                 src="<?php echo e(asset($src)); ?>"
                                                 data-url="<?php echo e($domain); ?>/<?php echo e($path_upload); ?><?php echo e($id); ?>/<?php echo e($picture); ?>"
                                                 data-title="<?php echo e($picture); ?>"
                                                 title="<?php echo e($picture); ?>"
                                                 style="cursor: pointer">
                                            <a href="#" class="btn btn-outline-danger"
                                               onclick="delPhoto('<?php echo __('users.edit.image.delete_warning'); ?>','<?php echo e($picture); ?>')"
                                               title="<?php echo e(__('users.edit.image.detach')); ?>">
                                                <i class="fa fa-file-archive"></i>
                                            </a>
                                            <div class="timeline-item" id="file_name_"
                                                 title="<?php echo e($picture); ?>"><?php echo e($picture); ?></div>
                                        </div>
                                    </div>
                                    <div class="timeline-item text-red" id="warning_message"></div>
                                </div>

                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->
                        <!--   End Image ================================================================================-->

                    </div>

                </form>
                <!-- /.form -->
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
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/toastr/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional_js'); ?>

    <!-- Select2 -->
    <script src="<?php echo e(url('LTE/plugins/select2/js/select2.full.min.js')); ?>"></script>

    <style>
        .daterangepicker.single .drp-buttons {
            display: block !important;
        }
    </style>
    <script>
        ////////////////////////////////////////////////////////////////////////
        // Query the elements

        const passwordEle = document.getElementById('password');
        const passwordEle1 = document.getElementById('confirm-password');
        const toggleEle = document.getElementById('toggle');
        if (passwordEle && passwordEle1 && toggleEle) {
            toggleEle.addEventListener('click', function () {
                const type = passwordEle.getAttribute('type');
                passwordEle.setAttribute(
                    'type',
                    type === 'password' ? 'text' : 'password'
                );
                const type1 = passwordEle1.getAttribute('type');
                passwordEle1.setAttribute(
                    'type',
                    type1 === 'password' ? 'text' : 'password'
                );
            });
        }
        ////////////////////////////////////////////////////////////////////////

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Users/resources/views/users/edit.blade.php ENDPATH**/ ?>