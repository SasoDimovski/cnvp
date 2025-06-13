<?php $__env->startSection('content'); ?>
    <?php
    $lang = request()->segment(2);
    ?>
    <!-- Content Wrapper. Contains page content -->
    <section class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo e(trans('main.index.welcome')); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('admin/'.$lang.'/main/')); ?>"><?php echo e(trans('global.header.home')); ?></a></li>

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="card card-info card-outline">
                            
                            
                            
                            <div class="card-body">

                                <p> <?php echo e(trans('main.index.intro1')); ?> <strong>„<?php echo e(config('app.TITLE')); ?>“</strong> <?php echo e(trans('main.index.intro2')); ?> .<br>
                                    <?php echo e(trans('main.index.intro3')); ?>  </p>
                                <?php echo $__env->make('admin._flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                                <?php if(Auth::id()==1): ?>






























































































































































                                <?php endif; ?>



                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->


    </section>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional_css'); ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(url('LTE/plugins/ionicons/ionicons.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('additional_js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Modules/Main/resources/views/main/index.blade.php ENDPATH**/ ?>