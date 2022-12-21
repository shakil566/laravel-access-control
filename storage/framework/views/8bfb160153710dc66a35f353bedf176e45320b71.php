 <!-- sidebar menu area start -->
 <?php
     $usr = Auth::guard('admin')->user();
 ?>
 <div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <h2 class="text-white">Admin</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    <?php if($usr->can('dashboard.view')): ?>
                    <li class="active">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                        <ul class="collapse">
                            <li class="<?php echo e(Route::is('admin.dashboard') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>

                    <?php if($usr->can('role.create') || $usr->can('role.view') ||  $usr->can('role.edit') ||  $usr->can('role.delete')): ?>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                            Roles & Permissions
                        </span></a>
                        <ul class="collapse <?php echo e(Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'in' : ''); ?>">
                            <?php if($usr->can('role.view')): ?>
                                <li class="<?php echo e(Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.roles.index')); ?>">All Roles</a></li>
                            <?php endif; ?>
                            <?php if($usr->can('role.create')): ?>
                                <li class="<?php echo e(Route::is('admin.roles.create')  ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.roles.create')); ?>">Create Role</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                    
                    <?php if($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete')): ?>
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Admins
                        </span></a>
                        <ul class="collapse <?php echo e(Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : ''); ?>">
                            
                            <?php if($usr->can('admin.view')): ?>
                                <li class="<?php echo e(Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.admins.index')); ?>">All Admins</a></li>
                            <?php endif; ?>

                            <?php if($usr->can('admin.create')): ?>
                                <li class="<?php echo e(Route::is('admin.admins.create')  ? 'active' : ''); ?>"><a href="<?php echo e(route('admin.admins.create')); ?>">Create Admin</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end --><?php /**PATH F:\xampp\htdocs\laravel-role\resources\views/backend/layouts/partials/sidebar.blade.php ENDPATH**/ ?>