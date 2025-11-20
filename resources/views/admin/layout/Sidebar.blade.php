<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-normal">
            <img src="{{ asset('admin/img/logo.png') }}" alt="Logo">
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo-small">
            <img src="{{ asset('admin/img/logo-small.png') }}" alt="Logo">
        </a>
        <a href="{{ route('admin.dashboard') }}" class="dark-logo">
            <img src="{{ asset('admin/img/logo-white.png') }}" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title m-0"><span>MAIN MENU</span></li>
                @can('View dashboard')
                    <li class="m-0">
                        <a href="{{ route('admin.dashboard') }}" class="px-2">
                            <i class="ti ti-smart-home me-2"></i><span> Dashboard</span>
                        </a>
                    </li>
                @endcan                
                @canany(['About Us', 'Banner', 'Contact Us', 'Testimonial', 'Inquiry', 'All Blogs', 'Create Blogs',
                    'Blogs Categories', 'Why Choose Us', 'Create Services Categories', 'Services Categories List', 'Create
                    Service', 'Service List', 'Create Team', 'Team List'])
                    <li class="menu-title m-0"><span>Front Settings</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-settings"></i><span>Front Settings</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('About Us')
                                        <li>
                                            <a href="{{ route('admin.about.us.edit') }}">About Us</a>
                                        </li>
                                    @endcan
                                    @can('Banner')
                                        <li>
                                            <a href="{{ route('admin.banner.list') }}">Banner</a>
                                        </li>
                                    @endcan
                                    @can('Contact Us')
                                        <li>
                                            <a href="{{ route('admin.contact.settings') }}">Contact Us</a>
                                        </li>
                                    @endcan
                                    @can('Testimonial')
                                        <li>
                                            <a href="{{ route('admin.testimonials.list') }}">Testimonial</a>
                                        </li>
                                    @endcan
                                    @can('Why Choose Us')
                                        <li>
                                            <a href="{{ route('admin.why.choose.us') }}">Why Choose Us</a>
                                        </li>
                                    @endcan
                                    @can('Inquiry')
                                        <li><a href="{{ route('admin.inquery.list') }}">Inquiry</a></li>
                                    @endcan
                                    @can('All Blogs')
                                        <li><a href="{{ route('admin.blog.list') }}">All Blogs</a></li>
                                    @endcan
                                    @can('Create Blogs')
                                        <li><a href="{{ route('admin.create.blog') }}">Create Blogs</a></li>
                                    @endcan
                                    @can('Blogs Categories')
                                        <li><a href="{{ route('admin.blog.categories.list') }}">Blog Categories</a></li>
                                    @endcan
                                    @can('Create Services Categories')
                                        <li><a href="{{ route('admin.create.services.categories') }}">Create Services
                                                Categories</a></li>
                                    @endcanany
                                    @can('Services Categories List')
                                        <li><a href="{{ route('admin.services.categories.list') }}">Services Categories
                                                List</a></li>
                                    @endcanany
                                    @can('Create Service')
                                        <li><a href="{{ route('admin.create.services') }}">Create Service</a></li>
                                    @endcanany
                                    @can('Service List')
                                        <li><a href="{{ route('admin.services.list') }}">Service List</a></li>
                                    @endcanany
                                    @can('Create Team')
                                        <li><a href="{{ route('admin.create.team') }}">Create Team</a></li>
                                    @endcan
                                    @can('Team List')
                                        <li><a href="{{ route('admin.team.list') }}">Team List</a></li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['View Roles', 'View Permissions'])
                    <li class="menu-title m-0"><span>Roles & Permissions</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-shield"></i><span>Roles & Permissions</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul>
                                    @can('View Roles')
                                        <li><a href="{{ route('admin.roles.list') }}">Role List</a></li>
                                    @endcan
                                    @can('View Permissions')
                                        <li><a href="{{ route('admin.permissions.list') }}">Permission List</a></li>
                                    @endcan

                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['Create Employee', 'View Employee'])
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-users"></i><span>Employees</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('Create Employee')
                                        <li>
                                            <a href="{{ route('admin.create.employee') }}">Create Employee</a>
                                        </li>
                                    @endcan

                                    @can('View Employee')
                                        <li>
                                            <a href="{{ route('admin.employee.list') }}">Employee Lists</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['Field Master'])
                    <li class="menu-title m-0"><span>Field Master</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-layout-grid"></i><span>Field Type</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.field.type.list') }}">Field Type List</a></li>
                                    <li><a href="{{ route('admin.create.field.type') }}">Create Field Type</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-file-description"></i><span>Field Masters</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.field.list') }}">Field List</a></li>
                                    <li><a href="{{ route('admin.create.field') }}">Create Field</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-checkup-list"></i><span>Validation Masters</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.validation.list') }}">Validation List</a></li>
                                    <li><a href="{{ route('admin.create.validation') }}">Create Validation</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-arrows-sort"></i><span>Dropdown Masters</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.dropdown.list') }}">Dropdown List</a></li>
                                    <li><a href="{{ route('admin.create.dropdown') }}">Create Dropdown</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['Template Master', 'Template Data Master'])
                    <li class="menu-title m-0"><span>Template Master</span></li>
                    <li>
                        <ul class="m-0">
                            @can('Template Master')
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-layout-grid"></i><span>Template Master</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.template.list') }}">Template List</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.create.template') }}">Create Template</a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @php
                    $templateData = app('templatemaster-service')->getAllTemplateMaster();
                    $permissions = $templateData->pluck('name')->toArray();
                @endphp
                @canany($permissions)
                    <li class="menu-title m-0"><span>Data Master</span></li>
                    <li>
                        <ul class="m-0">
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="ti ti-database"></i><span>Data Master</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @foreach ($templateData as $item)
                                        @can($item->name)
                                            <li>
                                                <a href="{{ route('admin.data.list', $item->name) }}">
                                                    {{ $item->name ?? 'No Name' }}
                                                </a>
                                            </li>
                                        @endcan
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
