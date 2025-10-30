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
                <li class="menu-title"><span>MAIN MENU</span></li>
                @can('View dashboard')
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="ti ti-smart-home"></i><span>Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany(['Create Employee', 'View Employee'])
                    <li class="menu-title"><span>HRM</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="subdrop">
                                    <i class="ti ti-users"></i><span>Employees</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul style="display: block;">
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
                @canany(['View Roles', 'View Permissions', 'Create Permissions'])
                    <li class="menu-title"><span>Roles & Permissions</span></li>

                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="subdrop">
                                    <i class="ti ti-shield"></i><span>Roles & Permissions</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul style="display: block;">                                   
                                    @can('View Roles')
                                        <li><a href="{{ route('admin.roles.list') }}">Role List</a></li>
                                    @endcan

                                    @can('Create Permissions')
                                        <li><a href="{{ route('admin.permissions.create') }}">Create Permission</a></li>
                                    @endcan
                                    @can('View Permissions')
                                        <li><a href="{{ route('admin.permissions.list') }}">Permission List</a></li>
                                    @endcan

                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany

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
