<?php
$lang = request()->segment(2);
$id_module = request()->segment(3);
?>
    <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(url('admin/'.$lang.'/main/')); ?>" class="brand-link navbar-info">
        <b class="justify_center"><?php echo e(config('app.TITLE_SHORT')); ?></b>
        
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview"
                role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <?php if(count($assignedModules) > 0): ?>

                    <?php $__currentLoopData = $assignedModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $module['children'] = collect($module['children'])->toArray();
                        ?>












                                <?php
                                $array = json_decode(json_encode($module['children']), true);
                                $key = App\Models\Modules::search_in_multidimensional_array($id_module, $array, array('$'));
//                                print_r('$key:'.$key.'<br>' );
//                                print_r('[children]:'.!empty($module['children']).'<br>'  );
//                                print_r('[id_parent]:'.!empty($module['id_parent']) );
                                ?>
                            <li class="nav-item <?php if(!empty($module['children'])): ?>  <?php echo e('has-treeview'); ?> <?php endif; ?> <?php if($key): ?> <?php echo e('menu-open'); ?><?php endif; ?>">
                                <a href="<?php echo e(url('admin/'.$lang.'/'.$module['link'])); ?>"
                                   class="nav-link <?php echo e($module['button_color']); ?> <?php if($id_module ==$module['id']): ?> <?php echo e('active'); ?> <?php endif; ?>">
                                    <i class="nav-icon <?php echo e($module['icon']); ?>"></i>
                                    <p class="<?php echo e($module['text_color']); ?>"><?php echo e($module['title']); ?><i
                                            class="<?php if(!empty($module['children'])): ?> <?php echo e('right fas fa-angle-left'); ?> <?php endif; ?>"></i>
                                    </p>
                                </a>
                                <?php if(!empty($module['children'])): ?>
                                    <?php echo $__env->make('admin._modules_sub', ['children' => $module['children']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            </li>


                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH /var/www/resources/views/admin/_modules.blade.php ENDPATH**/ ?>