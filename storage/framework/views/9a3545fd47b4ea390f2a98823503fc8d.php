<?php
$id_module = $module->id ?? '';
$lang = request()->segment(2);
$query = request()->getQueryString();

$id = $user->id ?? '';
$name = $user->name ?? '';
$surname = $user->surname ?? '';
$id_country = optional($user->country)->name ?? '';
$address = $user->address ?? '';
$phone = $user->phone ?? '';
$picture = $user->picture ?? '';
$email = $user->email ?? '';
$email_verified_at = $user->email_verified_at ?? '';
$username = $user->username ?? '';
$user_type = $user->user_type ?? '';
$password = $user->password ?? '';
$password_reset_hash = $user->password_reset_hash ?? '';
$id_expiration_time = optional($user->expirationTime)->name ?? '';
$active = $user->active ?? '';
$deleted = $user->deleted ?? '';
$created_at = (isset($user->created_at)) ? date("d.m.Y  H:i:s", strtotime($user->created_at)) : '';
$updated_at = (isset($user->updated_at)) ? date("d.m.Y  H:i:s", strtotime($user->updated_at)) : '';

$path_upload = 'uploads/users/';
?>
<div class="col-12">
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col" >
            <div class="timeline">
                <!-- timeline time label -->

                <!--   ================================================================================-->
                <div class="time-label">
                    <?php if($active==0): ?>
                        <span class="bg-gradient-red"><?php echo e(__('global.deactivated')); ?></span>
                    <?php else: ?>
                        <span class="bg-gradient-success"><?php echo e(__('users.active')); ?></span>
                    <?php endif; ?>

                    <br>
                    <span class="bg-gradient-gray" style="margin-top: 3px">  <i class="fas fa-circle text-warning"></i> <strong><?php echo e(__('users.id')); ?></strong>: <?php echo e($id); ?></span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"><i class="fas fa-clock text-warning"></i> <strong><?php echo e(__('users.created_at')); ?></strong>: <?php echo e($created_at); ?></span>
                    <span class="bg-gradient-gray" style="margin-top: 3px"> <i class="fas fa-clock text-warning "></i></i> <strong> <?php echo e(__('users.updated_at')); ?></strong>: <?php echo e($updated_at); ?></span>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-user bg-info"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong><?php echo e(__('users.name')); ?></strong>: <?php echo e($name); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.surname')); ?></strong>: <?php echo e($surname); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.username')); ?></strong>: <?php echo e($username); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.email')); ?></strong>: <?php echo e($email); ?>

                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.phone')); ?></strong>: <?php echo e($phone); ?>

                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-id-badge bg-gradient-success"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong><?php echo e(__('users.address')); ?></strong>: <?php echo e($address); ?>

                            <hr>
                            <strong><?php echo e(__('users.id_country')); ?></strong>: <br><br>
                            <?php if(count($assignCountries) > 0): ?>
                                <ul>
                                    <?php $__currentLoopData = $assignCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <span><?php echo e($country->name); ?> (<?php echo e($country->id); ?>)</span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                <div>
                    <i class="fas fa-book-open bg-gradient-red"></i>
                    <div class="timeline-item">
                        <div class="timeline-header">
                            <strong><?php echo e(__('users.user_type')); ?></strong>:
                            <strong class="text-red">
                                <?php echo e(collect(config('users.user_type'))->where('value', $user_type)->first()['name'] ?? ''); ?>

                            </strong>
                            <div class="row" style="height: 7px"></div>
                            <strong><?php echo e(__('users.id_expiration_time_des')); ?></strong>: <strong class="text-red"><?php echo e($id_expiration_time); ?></strong>


                        </div>
                    </div>
                </div>
                <!--   ================================================================================-->
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <?php if(!empty($picture)): ?>
                    <!--   ================================================================================-->
                    <?php
                        $css = empty($picture) ? 'display: none' : '';
                        $src = !empty($picture) ? $path_upload . $id . '/' . $picture : '';
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
                        $domain = $protocol . $_SERVER['HTTP_HOST'];
                    ?>
                    <div class="time-label">
                        <img id="upload_image" class="img-circle img-bordered-sm modal_image"
                             data-target="#ModalImage"
                             width="70px" height="70px" alt="image" data-toggle="modal"
                             src="<?php echo e(asset($src)); ?>"
                             data-url="<?php echo e($domain); ?>/<?php echo e($path_upload); ?><?php echo e($id); ?>/<?php echo e($picture); ?>"
                             data-title="<?php echo e($picture); ?>"
                             title="<?php echo e($picture); ?>"
                             style="cursor: pointer">
                        <strong><?php echo e($picture); ?></strong>

                    </div>

                <?php endif; ?>
                <!--   ================================================================================-->


            </div>
        </div>
    </div>
</div>




<?php /**PATH /var/www/Modules/Users/resources/views/users/show.blade.php ENDPATH**/ ?>