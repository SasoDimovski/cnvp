
<?php
$lang = Request::segment(2);
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-cyan navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">

            <a href="<?php echo e(url('admin/'.$lang.'/main/')); ?>" class="nav-link"><?php echo e(trans('global.header.home')); ?></a>
        </li>
        <?php if(count($languages) > 0): ?>
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($language->lang != $lang): ?>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo e(url('admin/'.$language->lang.'/main/')); ?>" class="nav-link"><?php echo e($language->lang); ?></a>
        </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>



    </ul>

    <!-- SEARCH FORM -->











    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">


                <i class="fa fa-user text-danger"></i>
                <span class="hidden-xs"><small><?php echo e(trans('global.header.user')); ?>: </small> <strong><?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->surname); ?> </strong></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">
                <div class="dropdown-item">
                    <!-- Message Start -->
                    <small>ID: </small><strong><?php echo e(Auth::user()->id); ?></strong>
                    <br>
                    <small><?php echo e(trans('global.header.username')); ?>: </small><strong><?php echo e(Auth::user()->username); ?></strong>
                    <br>
                    <small><?php echo e(trans('global.header.name')); ?>: </small><strong><?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->surname); ?></strong>
                    <br>
                    <small><?php echo e(trans('global.header.email')); ?>: </small><strong><?php echo e(Auth::user()->email); ?></strong>
                    <!-- Message End -->
                </div>


                <div class="dropdown-divider"></div>
                <a href="<?php echo e(url('/logout')); ?>" > <button type="button" class="btn btn-block btn-danger btn-sm"> <?php echo e(trans('global.header.logout')); ?></button></a>






            </div>
        </li>
        <!-- Notifications Dropdown Menu -->































    </ul>
</nav>
<!-- /.navbar -->
<?php /**PATH /var/www/resources/views/admin/_header.blade.php ENDPATH**/ ?>