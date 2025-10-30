<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo logo-normal">
            <img src="<?php echo e(asset('admin/img/logo.png')); ?>" alt="Logo">
        </a>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo-small">
            <img src="<?php echo e(asset('admin/img/logo-small.png')); ?>" alt="Logo">
        </a>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="dark-logo">
            <img src="<?php echo e(asset('admin/img/logo-white.png')); ?>" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>MAIN MENU</span></li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View dashboard')): ?>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="<?php echo e(route('admin.dashboard')); ?>">
                                    <i class="ti ti-smart-home"></i><span>Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Create Employee', 'View Employee'])): ?>
                    <li class="menu-title"><span>HRM</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="subdrop">
                                    <i class="ti ti-users"></i><span>Employees</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul style="display: block;">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Employee')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.create.employee')); ?>">Create Employee</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Employee')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.employee.list')); ?>">Employee Lists</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Roles', 'View Permissions', 'Create Permissions'])): ?>
                    <li class="menu-title"><span>Roles & Permissions</span></li>

                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="subdrop">
                                    <i class="ti ti-shield"></i><span>Roles & Permissions</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul style="display: block;">                                   
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Roles')): ?>
                                        <li><a href="<?php echo e(route('admin.roles.list')); ?>">Role List</a></li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Permissions')): ?>
                                        <li><a href="<?php echo e(route('admin.permissions.create')); ?>">Create Permission</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Permissions')): ?>
                                        <li><a href="<?php echo e(route('admin.permissions.list')); ?>">Permission List</a></li>
                                    <?php endif; ?>

                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-box"></i><span>Projects</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="javascript:void(0);">Projects</a></li>
                                <li><a href="javascript:void(0);">Tasks</a></li>
                                <li><a href="javascript:void(0);">Task Board</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
<?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/layout/Sidebar.blade.php ENDPATH**/ ?>