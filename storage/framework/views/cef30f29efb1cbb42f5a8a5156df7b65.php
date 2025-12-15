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
                <li class="menu-title m-0"><span>MAIN MENU</span></li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View dashboard')): ?>
                    <li>
                        <ul class="m-0">
                            <li>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-2">
                                    <i class="ti ti-smart-home me-2"></i><span> Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any([
                    'About Us',
                    'Banner',
                    'Contact Us',
                    'Testimonial',
                    'Inquiry',
                    'All Blogs',
                    'Create Blogs',
                    'Blogs Categories',
                    'Why Choose Us',
                    'Create Services Categories',
                    'Services Categories List',
                    'Create Service',
                    'Service List',
                    'Create Team',
                    'Team List',
                    ])): ?>
                    <li class="menu-title m-0"><span>Front Settings</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-settings"></i><span>Front Settings</span>
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
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Why Choose Us')): ?>
                                        <li>
                                            <a href="<?php echo e(route('admin.why.choose.us')); ?>">Why Choose Us</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Inquiry')): ?>
                                        <li><a href="<?php echo e(route('admin.inquery.list')); ?>">Inquiry</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('All Blogs')): ?>
                                        <li><a href="<?php echo e(route('admin.blog.list')); ?>">All Blogs</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Blogs')): ?>
                                        <li><a href="<?php echo e(route('admin.create.blog')); ?>">Create Blogs</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Blogs Categories')): ?>
                                        <li><a href="<?php echo e(route('admin.blog.categories.list')); ?>">Blog Categories</a></li>
                                    <?php endif; ?>
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
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Roles', 'View Permissions'])): ?>
                    <li class="menu-title m-0"><span>Roles & Permissions</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-shield"></i><span>Roles & Permissions</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Roles')): ?>
                                        <li><a href="<?php echo e(route('admin.roles.list')); ?>">Role List</a></li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Permissions')): ?>
                                        <li><a href="<?php echo e(route('admin.permissions.list')); ?>">Permission List</a></li>
                                    <?php endif; ?>

                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Create Employee', 'View Employee'])): ?>
                    <li>
                        <ul class="m-0">
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
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Lead Mater'])): ?>
                <li class="menu-title m-0"><span>Lead Mater</span></li>
                <li>
                    <ul class="m-0">
                        <li>
                            <a href="<?php echo e(route('admin.lead.mater')); ?>" class="px-2">
                                <i class="ti ti-user-star me-2"></i><span> Lead Mater</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Field Master'])): ?>
                    <li class="menu-title m-0"><span>Field Master</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-layout-grid"></i><span>Field Type</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="<?php echo e(route('admin.field.type.list')); ?>">Field Type List</a></li>
                                    <li><a href="<?php echo e(route('admin.create.field.type')); ?>">Create Field Type</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-file-description"></i><span>Field Masters</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="<?php echo e(route('admin.field.list')); ?>">Field List</a></li>
                                    <li><a href="<?php echo e(route('admin.create.field')); ?>">Create Field</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-checkup-list"></i><span>Validation Masters</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="<?php echo e(route('admin.validation.list')); ?>">Validation List</a></li>
                                    <li><a href="<?php echo e(route('admin.create.validation')); ?>">Create Validation</a></li>
                                </ul>
                            </li>                          
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Template Master', 'Template Data Master'])): ?>
                    <li class="menu-title m-0"><span>Template Master</span></li>
                    <li>
                        <ul class="m-0">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Template Master')): ?>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-layout-grid"></i><span>Template Master</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo e(route('admin.template.list')); ?>">Template List</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('admin.create.template')); ?>">Create Template</a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Field Master'])): ?>
                <?php
                    $FieldData = \App\Models\Field::where('type', 'select')->get();
                ?>                
                <li class="menu-title m-0"><span>Dropdown Master</span></li>
                
                <li>
                    <ul class="m-0">
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-arrows-sort"></i>
                                <span>Dropdown Master</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <?php $__empty_1 = true; $__currentLoopData = $FieldData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li>
                                        <a href="<?php echo e(route('admin.dropdown.list', $item->id)); ?>">
                                            <?php echo e($item->name); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li>
                                        <a href="javascript:void(0)" class="text-muted">
                                            No dropdown fields found
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>   
                <?php
                    $templateData = app('templatemaster-service')->getAllTemplateMaster();
                    $permissions = $templateData->pluck('name')->toArray();
                ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any($permissions)): ?>
                    <li class="menu-title m-0"><span>Data Master</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-database"></i><span>Data Master</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <?php $__currentLoopData = $templateData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($item->name)): ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.data.list', $item->name)); ?>">
                                                    <?php echo e($item->name ?? 'No Name'); ?>

                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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