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
                                <a href="javascript:void(0);">
                                    <i class="ti ti-users"></i><span>Employees</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
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
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['About Us', 'Banner', 'Contact Us', 'Testimonial'])): ?>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-settings"></i><span>Settings</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('About Us')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.about.us.edit')); ?>">About Us</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Banner')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.banner.list')); ?>">Banner</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Contact Us')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.contact.settings')); ?>">Contact Us</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Testimonial')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.testimonials.list')); ?>">Testimonial</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['All Blogs', 'Blogs Categories', 'Create Blogs'])): ?>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-brand-blogger"></i><span>Blogs</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('All Blogs')): ?>
                                        <li><a href="<?php echo e(route('admin.blog.list')); ?>">All Blogs</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Blogs')): ?>
                                        <li><a href="<?php echo e(route('admin.create.blog')); ?>">Create Blogs</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Blogs Categories')): ?>
                                        <li><a href="<?php echo e(route('admin.blog.categories.list')); ?>">Blog Categories</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Create Services Categories', 'Services Categories List', 'Create Service', 'Service List'])): ?>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-user-star"></i><span>Services</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Services Categories')): ?>
                                        <li><a href="<?php echo e(route('admin.create.services.categories')); ?>">Create Services
                                                Categories</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Services Categories List')): ?>
                                        <li><a href="<?php echo e(route('admin.services.categories.list')); ?>">Services Categories
                                                List</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Service')): ?>
                                        <li><a href="<?php echo e(route('admin.create.services')); ?>">Create Service</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Service List')): ?>
                                        <li><a href="<?php echo e(route('admin.services.list')); ?>">Service List</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Create Team', 'Team List'])): ?>                
                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-users-group"></i><span>Teams</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Team')): ?>
                                    <li><a href="<?php echo e(route('admin.create.team')); ?>">Create Team</a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Team List')): ?>
                                    <li><a href="<?php echo e(route('admin.team.list')); ?>">Team List</a></li>
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
                                <a href="javascript:void(0);">
                                    <i class="ti ti-shield"></i><span>Roles & Permissions</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul>
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
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
<?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/layout/Sidebar.blade.php ENDPATH**/ ?>