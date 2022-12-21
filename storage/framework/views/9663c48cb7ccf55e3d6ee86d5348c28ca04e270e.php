<div class="user-profile pull-right">
    
    <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
    <?php echo e(Auth::guard('admin')->user()->name); ?>

    <i class="fa fa-angle-down"></i></h4>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="<?php echo e(route('admin.logout.submit')); ?>"
        onclick="event.preventDefault();
                      document.getElementById('admin-logout-form').submit();">Log Out</a>
    </div>

    <form id="admin-logout-form" action="<?php echo e(route('admin.logout.submit')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>
</div><?php /**PATH F:\xampp\htdocs\laravel-role\resources\views/backend/layouts/partials/logout.blade.php ENDPATH**/ ?>