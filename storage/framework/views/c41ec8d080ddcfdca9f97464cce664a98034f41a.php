


<?php $__env->startSection('title'); ?>
Role Edit - Admin Panel
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('admin-content'); ?>

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Role Edit - <?php echo e($role->name); ?></h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                    <li><a href="<?php echo e(route('admin.roles.index')); ?>">All Roles</a></li>
                    <li><span>Edit Role</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <?php echo $__env->make('backend.layouts.partials.logout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit Role</h4>
                    <?php echo $__env->make('backend.layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                    <form action="<?php echo e(route('admin.roles.update', $role->id)); ?>" method="POST">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" value="<?php echo e($role->name); ?>" name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" <?php echo e(App\User::roleHasPermissions($role, $all_permissions) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            <?php $i = 1; ?>
                            <?php $__currentLoopData = $permission_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <?php
                                        $permissions = App\User::getpermissionsByGroupName($group->name);
                                        $j = 1;
                                    ?>
                                    
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="<?php echo e($i); ?>Management" value="<?php echo e($group->name); ?>" onclick="checkPermissionByGroup('role-<?php echo e($i); ?>-management-checkbox', this)" <?php echo e(App\User::roleHasPermissions($role, $permissions) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="checkPermission"><?php echo e($group->name); ?></label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-<?php echo e($i); ?>-management-checkbox">
                                       
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-<?php echo e($i); ?>-management-checkbox', '<?php echo e($i); ?>Management', <?php echo e(count($permissions)); ?>)" name="permissions[]" <?php echo e($role->hasPermissionTo($permission->name) ? 'checked' : ''); ?> id="checkPermission<?php echo e($permission->id); ?>" value="<?php echo e($permission->name); ?>">
                                                <label class="form-check-label" for="checkPermission<?php echo e($permission->id); ?>"><?php echo e($permission->name); ?></label>
                                            </div>
                                            <?php  $j++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <br>
                                    </div>

                                </div>
                                <?php  $i++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
     <?php echo $__env->make('backend.pages.roles.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\laravel-access-control\resources\views/backend/pages/roles/edit.blade.php ENDPATH**/ ?>