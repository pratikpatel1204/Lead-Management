@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Dashboard')
@section('content')
    <style>
        /* Dashnav Component Styles */
        .dashnav-tabs .nav-link {
            color: #495057;
            border: 3px solid transparent;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            background: none;
        }

        .dashnav-tabs .nav-link:hover {
            border-color: #dee2e6;
            background-color: #f8f9fa;
        }

        .dashnav-tabs .nav-link.active {
            color: #0d6efd;
            background-color: #f0f7ff;
            border-color: #0d6efd;
        }

        .dashnav-pills .nav-link {
            padding: 0.75rem 1.5rem;
            margin: 0 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            border: 1px solid #F26522;
            color: #F26522;
        }

        .dashnav-pills .nav-link:hover {
            background-color: #e9ecef;
            color: #F26522;
        }

        .dashnav-pills .nav-link.active {
            background-color: #0d6efd;
            border: 1px solid #0d6efd;
            color: white;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
        }

        .offcanvas.offcanvas-end {
            width: 70% !important;
        }

        table.table.dataTable>tbody>tr td {
            padding: 4px !important;
        }

        table.table-bordered.dataTable thead tr:first-child th,
        table.table-bordered.dataTable thead tr:first-child td {
            padding: 4px !important;
        }

        div.dataTables_wrapper div.dataTables_filter {
            padding: 10px;
            margin-bottom: 0px;
        }

        .dataTables_length {
            padding: 10px;
        }

        div.dataTables_wrapper div.dataTables_info {
            padding: 10px;
        }
    </style>
    @php
        $chartColors = [
            '#F26522', // Orange
            '#03C95A', // Green
            '#FFC107', // Yellow
            '#FD3995', // Pink
            '#AB47BC', // Purple
            '#1B84FF', // Blue
            '#E70D0D', // Red
            '#20C997', // Teal
            '#6F42C1', // Deep Purple
            '#0DCAF0', // Cyan
            '#198754', // Dark Green
            '#495057', // Dark Gray
        ];
    @endphp
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-1">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Superadmin</li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Welcome Wrap -->
        <div class="welcome-wrap mb-2 p-2">
            <div class=" d-flex align-items-center justify-content-between flex-wrap">
                <h2 class="text-white">Welcome Back, {{ auth()->user()->name }}</h2>
            </div>
            <div class="welcome-bg">
                <img src="{{ asset('admin/img/bg/welcome-bg-02.svg') }}" alt="img" class="welcome-bg-01"
                    style="height: 50px;">
                <img src="{{ asset('admin/img/bg/welcome-bg-03.svg') }}" alt="img" class="welcome-bg-02"
                    style="top: -25px;">
                <img src="{{ asset('admin/img/bg/welcome-bg-01.svg') }}" alt="img" class="welcome-bg-03">
            </div>
        </div>
        <!-- /Welcome Wrap -->

        <div class="row">
            <div class="col-xl-4 col-sm-12 d-flex">
                <div class="card flex-fill mb-2">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark">
                                <i class="fa-solid fa-comment-dots fs-16 text-white"></i>
                            </span>
                            <h4>Today’s Comments</h4>
                            <h2 class="bg-primary d-inline-block text-white text-end px-3 py-1 rounded">
                                {{ $todayCommentCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-12 d-flex">
                <div class="card flex-fill mb-2">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark">
                                <i class="fa-solid fa-calendar-week fs-16 text-white"></i>
                            </span>
                            <h4>Weekly Comments</h4>
                            <h2 class="bg-info d-inline-block text-white text-end px-3 py-1 rounded">
                                {{ $weeklyCommentCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-12 d-flex">
                <div class="card flex-fill mb-2">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark">
                                <i class="fa-solid fa-calendar-days fs-16 text-white"></i>
                            </span>
                            <h4>Monthly Comments</h4>
                            <h2 class="bg-success d-inline-block text-white text-end px-3 py-1 rounded">
                                {{ $monthlyCommentCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $colors = [
                    'East' => 'primary',
                    'West' => 'success',
                    'North' => 'info',
                    'South' => 'secondary',
                    'Pending' => 'danger',
                    'Other Areas' => 'secondary',
                    'All' => 'dark',
                ];
                $firstKey = array_key_first($areas->toArray());
            @endphp

            {{-- LEFT SIDE NAV --}}
            <div class="col-lg-3 col-md-4 mb-3">
                <div class="list-group shadow-sm" id="areaTabs" role="tablist" style="height: 212px;">
                    @foreach ($areas as $direction => $directionAreas)
                        @php $color = $colors[$direction] ?? 'secondary'; @endphp
                        <button
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                                {{ $direction === $firstKey ? 'active' : '' }}"
                            data-bs-toggle="tab" data-bs-target="#tab-{{ \Str::slug($direction) }}" type="button"
                            role="tab">

                            <span>{{ $direction }}</span>

                            <span class="badge bg-{{ $color }}">
                                {{ $directionAreas->sum('total') }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="tab-content">
                    @foreach ($areas as $direction => $directionAreas)
                        @php
                            $color = $colors[$direction] ?? 'secondary';
                        @endphp
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            id="tab-{{ \Str::slug($direction) }}" role="tabpanel">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                                    <span class="fw-semibold text-{{ $color }}">
                                        {{ $direction }} Areas
                                    </span>
                                    <span class="badge bg-{{ $color }}">
                                        {{ $directionAreas->sum('total') }}
                                    </span>
                                </div>
                                <div class="card-body p-2" style="height:175px; overflow:auto;">
                                    <div class="row g-1">
                                        @foreach ($directionAreas as $row)
                                            <div class="col-4">
                                                <div
                                                    class="border rounded px-2 py-1 small d-flex justify-content-between align-items-center">
                                                    <span class="text-truncate text-dark">
                                                        {{ $row->area }}
                                                    </span>
                                                    <span class="badge bg-{{ $color }}">
                                                        {{ $row->total }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="nav nav-pills dashnav-pills d-flex justify-content-around mb-3" id="areaViewTab" role="tablist">
            <button class="nav-link fw-semibold active" id="table-tab" data-bs-toggle="pill" data-bs-target="#tableView"
                type="button" role="tab">
                <i class="fas fa-table me-2"></i>Table View
            </button>
            <button class="nav-link fw-semibold" id="chart-tab" data-bs-toggle="pill" data-bs-target="#chartView"
                type="button" role="tab">
                <i class="fas fa-chart-bar me-2"></i>Chart View
            </button>
        </div>
        <div class="tab-content" id="areaViewTabContent">
            <div class="tab-pane fade show active" id="tableView" role="tabpanel" aria-labelledby="table-tab">
                <div class="row">
                    @php
                        $leadTypes = [
                            'today' => ["Today's Leads", 'primary'],
                            'tomorrow' => ["Tomorrow's Leads", 'indigo'],
                            'missed' => ['Missed Leads', 'danger'],
                            'next_week' => ['Next Week Leads', 'warning'],
                            'current_month' => ['Current Month Leads', 'success'],
                            'most_urgent' => ['Most Urgent Leads', 'danger'],
                            'urgent' => ['Urgent Leads', 'warning'],
                            'must' => ['Must Leads', 'dark'],
                        ];
                    @endphp
                    @foreach ($leadTypes as $key => [$label, $color])
                        <div class="col-lg-3 col-md-3 col-sm-12 mb-1">
                            <a href="javascript:void(0)"
                                class="btn btn-outline-secondary d-flex justify-content-between align-items-center lead-filter {{ $loop->first ? 'active' : '' }}"
                                data-type="{{ $key }}">
                                <span>{{ $label }}</span>
                                <span class="badge bg-{{ $color }}">
                                    {{ $meetingCounts[$key] ?? 0 }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card shadow-sm border-0 mt-2">
                            <div class="card-header bg-white fw-bold" id="tableTitle">
                                Today's Leads
                            </div>
                            <div class="card-body p-0">
                                <div id="lead_list"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="chartView" role="tabpanel" aria-labelledby="chart-tab">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads By Employee
                            </div>
                            <div class="card-body p-3">
                                @foreach ($employeeLeads as $lead)
                                    @php
                                        $percent =
                                            $employeeTotalLeads > 0 ? ($lead->total / $employeeTotalLeads) * 100 : 0;
                                    @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span><strong>{{ $lead->employee_name }}</strong></span>
                                            <span><strong>{{ $lead->total }}</strong></span>
                                        </div>
                                        <div class="progress" style="height: 12px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($employeeLeads->isEmpty())
                                    <div class="text-center text-muted">No leads found</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads By Labels
                            </div>
                            <div class="card-body p-3">
                                @foreach ($labellead as $lead)
                                    @php
                                        $percent = $labelleadTotal > 0 ? ($lead->total / $labelleadTotal) * 100 : 0;
                                    @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span><strong>{{ $lead->label }}</strong></span>
                                            <span><strong>{{ $lead->total }}</strong></span>
                                        </div>
                                        <div class="progress" style="height: 12px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads By SP Focused Product
                            </div>
                            <div class="card-body p-3">
                                <div id="donut-chart-2" class="mb-3"></div>
                                <div>
                                    <h6 class="mb-3">Status</h6>
                                    @foreach ($focusProductLeads as $lead)
                                        @php
                                            $color = $chartColors[$loop->index % count($chartColors)];
                                        @endphp

                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="f-13 mb-0">
                                                <i class="ti ti-circle-filled me-1"
                                                    style="color: {{ $color }}"></i>
                                                {{ $lead->focus_product }}
                                            </p>
                                            <p class="f-13 fw-medium text-gray-9">
                                                {{ $lead->total }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads By Lead Source
                            </div>
                            <div class="card-body p-3">
                                <div id="lead-source-donut" class="mb-3"></div>
                                <div>
                                    <h6 class="mb-3">Sources</h6>
                                    @foreach ($leadSourceLeads as $lead)
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="f-13 mb-0">
                                                <i class="ti ti-circle-filled me-1"
                                                    style="color: {{ $chartColors[$loop->index % count($chartColors)] }}"></i>
                                                {{ $lead->source }}
                                            </p>
                                            <p class="f-13 fw-medium text-gray-9">
                                                {{ $lead->total }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads By Site Stage
                            </div>
                            <div class="card-body p-3">
                                <div id="site-stage-donut" class="mb-3"></div>
                                @foreach ($siteStageLeads as $stage)
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <p class="f-13 mb-0">
                                            <i class="ti ti-circle-filled me-1"
                                                style="color: {{ $chartColors[$loop->index % count($chartColors)] }}"></i>
                                            {{ $stage->stage }}
                                        </p>
                                        <p class="f-13 fw-medium text-gray-9">
                                            {{ $stage->total }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads By Project Types
                            </div>
                            <div class="card-body p-3">
                                <div id="project-type-donut" class="mb-3"></div>
                                @foreach ($projectTypeLeads as $projectlead)
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <p class="f-13 mb-0">
                                            <i class="ti ti-circle-filled me-1"
                                                style="color: {{ $chartColors[$loop->index % count($chartColors)] }}"></i>
                                            {{ $projectlead->project_type }}
                                        </p>
                                        <p class="f-13 fw-medium text-gray-9">
                                            {{ $projectlead->total }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads Meetings By Day
                            </div>
                            <div class="card-body p-3">
                                <div id="meeting-day-donut" class="mb-3"></div>
                                @php
                                    $meetingColors = [
                                        'today' => '#0d6efd',
                                        'tomorrow' => '#f26522',
                                        'missed' => '#dc3545',
                                    ];
                                @endphp
                                @foreach ($meetingTypes as $key => [$label, $color])
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <p class="mb-0 f-13">
                                            <i class="ti ti-circle-filled me-1"
                                                style="color: {{ $meetingColors[$key] }}"></i>
                                            {{ $label }}
                                        </p>
                                        <p class="fw-medium text-gray-9 mb-0">
                                            {{ $meetingCounts[$key] ?? 0 }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads Meetings By Month ({{ \Carbon\Carbon::now()->year }})
                            </div>
                            <div class="card-body p-1">
                                <div id="monthly-meetings-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                Leads / Meetings By Week ({{ \Carbon\Carbon::now()->year }})
                            </div>
                            <div class="card-body p-1">
                                <div id="weekly-meetings-bar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white fw-bold text-black">
                                New Comments This Week
                            </div>
                            <div class="card-body p-1">
                                <div id="weekly-comments-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold text-black">
                        New Leads By Year ({{ \Carbon\Carbon::now()->year }})
                    </div>
                    <div class="card-body p-3">
                        <div id="yearly-leads-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="leadViewSidebar" class="offcanvas offcanvas-end" tabindex="-1">
        <div class="offcanvas-header bg-gray">
            <div id="meeting_header"></div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div id="leadDetails">
            </div>
            <form id="meetingcreatform">
                <input type="hidden" name="form_group_id" class="form-control" id="form_group_id">
                <div id="authhideshow">
                    <div class="row">
                        @if (auth()->user()->role === 'super admin')
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Select User <span class="text-danger">*</span></label>
                                    <select name="emp_id" class="form-control" id="mt_emp_error" required>
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="emp_id" id="mt_emp_error" value="{{ auth()->id() }}">
                        @endif
                        @foreach ($leadmeetings as $leadm)
                            @php
                                $field = $leadm->field;
                                $label = $field->name;
                                $name = Str::slug($field->name, '_');
                                $type = $field->type;
                                $isRequired = $field->validation == 'required' ? 'required' : '';
                                $defaultValue = match ($field->default_value) {
                                    'today' => now()->toDateString(),
                                    'auth_name' => auth()->check() ? auth()->user()->name : null,
                                    default => $field->default_value,
                                };
                                $colClass = match ($type) {
                                    'textarea' => 'col-12',
                                    default => 'col-md-3',
                                };
                            @endphp
                            <div class="{{ $colClass }} mb-3">
                                @if ($type != 'hidden')
                                    <label class="form-label">{{ $label }} @if ($isRequired)
                                            <span class="text-danger">*</span>
                                        @endif </label>
                                @endif
                                {{-- Text / Email / Number --}}
                                @if (in_array($type, ['text', 'email', 'number']))
                                    <input type="{{ $type }}" name="{{ $field->id }}" class="form-control"
                                        id="{{ $name }}" {{ $isRequired }}>
                                @elseif ($type == 'date')
                                    <input type="{{ $type }}" name="{{ $field->id }}" class="form-control"
                                        id="{{ $name }}" min="{{ $defaultValue }}" {{ $isRequired }}>
                                    {{-- Hidden --}}
                                @elseif ($type == 'hidden')
                                    <input type="{{ $type }}" name="{{ $field->id }}" class="form-control"
                                        id="{{ $name }}" value="{{ $defaultValue }}">
                                    {{-- Textarea --}}
                                @elseif ($type == 'textarea')
                                    <textarea name="{{ $field->id }}" class="form-control" id="{{ $name }}" rows="3"
                                        {{ $isRequired }}></textarea>

                                    {{-- Select --}}
                                @elseif ($type == 'select')
                                    <select name="{{ $field->id }}" id="{{ $name }}" class="form-select"
                                        {{ $isRequired }}>
                                        <option value="">Select {{ $label }}</option>
                                        @foreach ($field->dropdowns as $opt)
                                            <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                                        @endforeach
                                    </select>

                                    {{-- Radio --}}
                                @elseif ($type == 'radio')
                                    @php
                                        $options = is_array($field->options)
                                            ? $field->options
                                            : explode(',', $field->options);
                                    @endphp
                                    <div class="d-flex flex-wrap mt-2">
                                        @foreach ($options as $opt)
                                            @php $opt = trim($opt); @endphp
                                            <label class="me-3">
                                                <input type="radio" name="{{ $field->id }}"
                                                    id="{{ $name . '_' . $opt }}" value="{{ $opt }}"
                                                    {{ $defaultValue == $opt ? 'checked' : '' }}
                                                    {{ $isRequired ? 'required' : '' }}>
                                                {{ $opt }}
                                            </label>
                                        @endforeach
                                    </div>
                                    {{-- File --}}
                                @elseif ($type == 'file')
                                    <input type="file" name="{{ $field->id }}" id="{{ $name }}"
                                        class="form-control" {{ $isRequired }}>
                                @endif
                            </div>
                        @endforeach
                        <div id="contactRepeater">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-info" id="addContactBtn">
                            <i class="ti ti-plus"></i> Add Person
                        </button>
                        <button type="submit" class="btn btn-primary" id="savemeetingBtn">
                            <span class="btn-text">Save</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </div>
            </form>
            <hr>
            <div id="MetDetails">
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.viewLeadBtn', function() {
            let groupId = $(this).data('group');
            loadLeadMeetings(groupId);
        });

        $(document).on('click', '.lead-filter', function() {

            // Active class
            $('.lead-filter').removeClass('active');
            $(this).addClass('active');

            // Get selected type
            const type = $(this).data('type');

            // Update table title
            $('#tableTitle').text(
                $(this).find('span').first().text()
            );

            // Load leads
            getLeadData(type);
        });

        // Load first active filter on page load
        $(window).on('load', function() {
            const firstType = $('.lead-filter.active').data('type');
            if (firstType) {
                getLeadData(firstType);
            }
        });

        function getLeadData(type) {
            $('#lead_list').html('<div class="text-center py-4">Loading...</div>');
            $.ajax({
                url: '{{ route('admin.dashboard.leads.filter') }}',
                method: 'GET',
                data: {
                    type: type
                },
                success: function(response) {
                    if (response.success) {
                        $('#lead_list').html(response.html);
                        let table = $('#datalistTable').DataTable({
                            pageLength: 10,
                            searching: true,
                            lengthChange: true,
                            info: true,
                            paging: true,
                            scrollY: '500px',
                            scrollX: true,
                            scrollCollapse: true,
                            fixedHeader: true,
                            autoWidth: false,
                            columnDefs: [{
                                targets: '_all',
                                className: 'dt-wrap-text'
                            }]
                        });
                    }
                },
                error: function() {
                    $('#lead_list').html('<div class="text-center text-dark py-4">No Data Found</div>');
                }
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const productLabels = @json($focusProductLeads->pluck('focus_product'));
            const productCounts = @json($focusProductLeads->pluck('total'));
            const chartColors = @json($chartColors);

            const options = {
                chart: {
                    type: 'donut',
                    height: 280
                },

                series: productCounts,
                labels: productLabels,
                colors: chartColors,

                legend: {
                    show: false
                },

                dataLabels: {
                    enabled: true,
                    formatter: function(_, opts) {
                        return opts.w.config.series[opts.seriesIndex]; // show count
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val;
                        }
                    }
                },

                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                }
            };

            new ApexCharts(document.querySelector("#donut-chart-2"), options).render();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const labels = @json($leadSourceLeads->pluck('source'));
            const series = @json($leadSourceLeads->pluck('total'));
            const chartColors = @json($chartColors);

            const options = {
                chart: {
                    type: 'donut',
                    height: 280
                },

                series: series,
                labels: labels,
                colors: chartColors,

                legend: {
                    show: false
                },

                dataLabels: {
                    enabled: true,
                    formatter: function(_, opts) {
                        return opts.w.config.series[opts.seriesIndex]; // show count
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + ' Leads';
                        }
                    }
                },

                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },

                responsive: [{
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 220
                        }
                    }
                }]
            };

            new ApexCharts(
                document.querySelector("#lead-source-donut"),
                options
            ).render();

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const labels = @json($siteStageLeads->pluck('stage'));
            const series = @json($siteStageLeads->pluck('total'));
            const colors = @json($chartColors);

            const options = {
                chart: {
                    type: 'donut',
                    height: 280
                },

                labels: labels,
                series: series,
                colors: colors,

                legend: {
                    show: false
                },

                dataLabels: {
                    enabled: true,
                    formatter: function(_, opts) {
                        return opts.w.config.series[opts.seriesIndex];
                    }
                },

                tooltip: {
                    y: {
                        formatter: val => val + ' Leads'
                    }
                },

                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: w =>
                                        w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            };

            new ApexCharts(
                document.querySelector("#site-stage-donut"),
                options
            ).render();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const labels = @json($projectTypeLeads->pluck('project_type'));
            const series = @json($projectTypeLeads->pluck('total'));
            const chartColors = @json($chartColors);

            const options = {
                chart: {
                    type: 'donut',
                    height: 280
                },
                series: series,
                labels: labels,
                colors: chartColors,

                legend: {
                    show: false
                },

                dataLabels: {
                    enabled: true,
                    formatter: function(_, opts) {
                        return opts.w.config.series[opts.seriesIndex]; // show count
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + ' Leads';
                        }
                    }
                },

                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                }
            };

            new ApexCharts(
                document.querySelector("#project-type-donut"),
                options
            ).render();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const labels = @json($chartLabels);
            const series = @json($chartSeries);

            const options = {
                chart: {
                    type: 'donut',
                    height: 260
                },

                series: series,
                labels: labels,

                colors: ['#0d6efd', '#f26522', '#dc3545'],

                legend: {
                    show: false
                },

                dataLabels: {
                    enabled: true,
                    formatter: function(_, opts) {
                        return opts.w.globals.series[opts.seriesIndex]; // show count
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + ' Meetings';
                        }
                    }
                },

                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                }
            };

            new ApexCharts(
                document.querySelector("#meeting-day-donut"),
                options
            ).render();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const seriesData = @json($monthlyMeetings); // Your data
            const categories = @json($months); // Month names

            const options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        colors: ['#000'],
                        fontWeight: 'bold'
                    },
                    offsetY: -4,
                    rotate: 0 // Desktop horizontal
                },
                colors: ['#0d6efd'],
                series: [{
                    name: 'Meetings',
                    data: seriesData
                }],
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            fontSize: '13px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: val => val + " Meetings"
                    }
                },
                responsive: [{
                        breakpoint: 768, // Tablet
                        options: {
                            chart: {
                                height: 300
                            }
                        }
                    },
                    {
                        breakpoint: 480, // Mobile
                        options: {
                            chart: {
                                height: 260
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '80%'
                                }
                            },
                            xaxis: {
                                labels: {
                                    rotate: -90,
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            },
                            dataLabels: {
                                offsetY: 0,
                                rotate: -90, // Rotate the value label
                                style: {
                                    fontSize: '9px',
                                    colors: ['#000']
                                }
                            }
                        }
                    }
                ]
            };
            new ApexCharts(document.querySelector("#monthly-meetings-bar"), options).render();
        });

        document.addEventListener("DOMContentLoaded", function() {

            // --- Weekly Meetings Chart ---
            const weeklyLabelsData = @json($weeklyLabels);
            const weeklySeries = @json($weeklyCounts);

            const weeklyOptions = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%'
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        colors: ['#000']
                    }
                },
                colors: ['#0d6efd'],
                series: [{
                    name: 'Meetings',
                    data: weeklySeries
                }],
                xaxis: {
                    categories: weeklyLabelsData,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: val => val + " Meetings"
                    }
                },
                responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 280
                            }
                        }
                    },
                    {
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 260
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '80%'
                                }
                            },
                            xaxis: {
                                labels: {
                                    rotate: -90,
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }
                ]
            };
            new ApexCharts(document.querySelector("#weekly-meetings-bar"), weeklyOptions).render();


            // --- Weekly Comments Chart ---
            const weeklyLabelsCommentsData = @json($weeklyLabelsComments);
            const weeklyCommentsSeries = @json($weeklyCountsComments);

            const commentsOptions = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%'
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        colors: ['#000']
                    }
                },
                colors: ['#198754'], // green
                series: [{
                    name: 'Comments',
                    data: weeklyCommentsSeries
                }],
                xaxis: {
                    categories: weeklyLabelsCommentsData,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: val => val + " Comments"
                    }
                },
                responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 280
                            }
                        }
                    },
                    {
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 260
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '80%'
                                }
                            },
                            xaxis: {
                                labels: {
                                    rotate: -90,
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }
                ]
            };
            new ApexCharts(document.querySelector("#weekly-comments-bar"), commentsOptions).render();

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const months = @json($yearsmonths);
            const leadsData = @json($yearsleadsData);

            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        colors: ['#000']
                    }
                },
                colors: ['#0d6efd'], // You can add more colors if you like
                series: [{
                    name: 'Leads',
                    data: leadsData
                }],
                xaxis: {
                    categories: months,
                    labels: {
                        style: {
                            fontSize: '13px'
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: val => val + " Leads"
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 260
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '80%'
                            }
                        },
                        xaxis: {
                            labels: {
                                rotate: -90,
                                style: {
                                    fontSize: '9px'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                rotate: -90,
                                style: {
                                    fontSize: '9px'
                                }
                            }
                        },
                        dataLabels: {
                            rotate: -90,
                            style: {
                                fontSize: '9px',
                                colors: ['#000']
                            },
                            offsetY: 0
                        }
                    }
                }]
            };

            new ApexCharts(document.querySelector("#yearly-leads-bar"), options).render();
        });
    </script>
    <script>
        const ASSET_URL = "{{ asset('') }}";
    </script>
    <script>
        function loadLeadMeetings(groupId) {
            let sidebarEl = document.getElementById('leadViewSidebar');

            if (!sidebarEl) {
                console.error('Offcanvas element not found');
                return;
            }

            let sidebar = bootstrap.Offcanvas.getInstance(sidebarEl);

            if (!sidebar) {
                sidebar = new bootstrap.Offcanvas(sidebarEl, {
                    backdrop: true,
                    scroll: false
                });
            }

            sidebar.show();

            $('#leadDetails').html(`
                <div class="text-center">
                    <div class="spinner-border"></div>
                </div>
            `);
            $('#MetDetails').html(`
                <div class="text-center">
                    <div class="spinner-border"></div>
                </div>
            `);

            $.ajax({
                url: "{{ route('admin.admin.lead.master.get.data', '') }}/" + groupId,
                type: "GET",
                success: function(res) {

                    if (!res.status) return;

                    // Convert array to key-value object
                    let fields = {};
                    res.data.forEach(item => {
                        fields[item.field.name] = item.field_value ?? 'N/A';
                    });
                    $('#form_group_id').val(groupId);

                    if (res.showForm) {
                        $('#authhideshow').show();
                    } else {
                        $('#authhideshow').hide();
                    }

                    if (fields['Contact Name']) {
                        $('#person_name').val(fields['Contact Name']);
                    }

                    // Mobile Number
                    if (fields['Mobile Number']) {
                        $('#mobile_number').val(fields['Mobile Number']);
                    }

                    let html = `                      
                        <div class="row mb-2">
                            <div class="col-md-12 mb-2">
                                <h4>Lead Details</h4>
                            </div>
                            <div class="col-md-4 mb-0">
                                <p class="mb-2"><strong>Site Stage :</strong> ${fields['Site Stage'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>Competition :</strong> ${fields['Competition'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>No. of Towers :</strong> ${fields['No. of Towers'] ?? 'N/A'}</p>
                            </div>
                            <div class="col-md-4 mb-0">
                                <p class="mb-2"><strong>Project Type :</strong> ${fields['Project Type'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>No. of Bathrooms :</strong> ${fields['No. of Bathrooms'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>MEPF Consu :</strong> ${fields['MEPF Consu'] ?? 'N/A'}</p>
                            </div>
                            <div class="col-md-4 mb-0">
                                <p class="mb-2"><strong>SP Focused Product :</strong> ${fields['SP Focused Product'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>No. of Floors :</strong> ${fields['No. of Floors'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>Labels :</strong> ${fields['Labels'] ?? 'N/A'}</p>
                            </div>
                        </div>
                    `;

                    $('#leadDetails').html(html);
                    let htmlheader = `
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <h4 class="mb-0">${fields['Site Name'] ?? 'N/A'} , </h4>
                            <h6 class="mb-0">${fields['Area'] ?? ''} , ${fields['Direction'] ?? ''}</h6>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <h6 class="mb-0">${fields['Contact Name'] ?? ''} , ${fields['Mobile Number'] ?? ''}</h6>                             
                        </div>
                        `;
                    $('#meeting_header').html(htmlheader);

                    let meetingHtml = '<h5 class="mb-3">Lead Meetings</h5>';
                    if (res.meetings && Object.keys(res.meetings).length) {

                        Object.entries(res.meetings).forEach(([groupName, items]) => {

                            // Separate contacts and other fields
                            let contacts = [];
                            let otherData = {};

                            items.forEach(item => {
                                const labelKey = item.label.toLowerCase().replace(/[^a-z0-9]+/g,
                                    '_');

                                if (['person_name', 'mobile_number', 'designation'].includes(
                                        labelKey)) {
                                    // Add contact
                                    if (!contacts.length || (contacts[contacts.length - 1][
                                            labelKey
                                        ])) {
                                        contacts.push({});
                                    }
                                    contacts[contacts.length - 1][labelKey] = item.value;
                                } else {
                                    otherData[labelKey] = item.value;
                                }
                            });

                            // Platform icon
                            let platformIcon = '';
                            if (otherData.platform === 'Desktop') {
                                platformIcon =
                                    `<i class="fa fa-desktop text-success" title="Desktop"></i>`;
                            } else if (otherData.platform === 'mobile') {
                                platformIcon =
                                    `<i class="fa fa-mobile-alt text-success" title="Mobile"></i>`;
                            }

                            // Render HTML
                            meetingHtml += `
                                <div class="card mb-3 shadow-sm meeting-item">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="d-flex align-items-center gap-3 mb-2">
                                                    <p class="mb-1"><strong>Status:</strong> ${otherData.meeting_status ?? ''}</p>
                                                    <p class="mb-1">${otherData.meeting_date ? formatDate(otherData.meeting_date) : '-'}</p>
                                                    <p class="mb-1"><strong>Next Meeting:</strong> ${otherData.next_meeting_date ? formatDate(otherData.next_meeting_date) : '-'}</p>
                                                    <p class="mb-1"><strong>Calling Date:</strong> ${otherData.calling_date ? formatDate(otherData.calling_date) : '-'}</p>
                                                </div>

                                                ${contacts.map(c => `
                                                        <p class="mb-1">
                                                            <strong>Person:</strong>
                                                            ${c.person_name ?? '-'}
                                                            ${c.mobile_number ? ', ' + c.mobile_number : ''}
                                                            ${c.designation ? ', ' + c.designation : ''}
                                                        </p>
                                                    `).join('')}

                                                <p class="mb-1"><strong>Comments:</strong> ${otherData.comments ?? '-'}</p>
                                                <p class="mb-0"><strong>Employee Name:</strong> ${otherData.employee_name ?? '{{ Auth::user()->name }}'}</p>
                                                <p class="mb-0"><strong>Comment By:</strong> ${otherData.comment_by ?? '-'}</p>
                                            </div>

                                            <div class="col-3">
                                                <div class="d-flex flex-column align-items-end gap-2">
                                                    <div class="d-flex gap-2">                                                       
                                                        <button class="btn btn-sm btn-outline-danger deleteMeetingBtn" data-id="${groupName}">Delete</button>
                                                    </div>
                                                    ${otherData.attachment && otherData.attachment !== 'NULL' ? `
                                                            <a href="${ASSET_URL}${otherData.attachment}" target="_blank">
                                                                <img src="${ASSET_URL}${otherData.attachment}" class="img-thumbnail mt-2" style="max-width:120px; cursor:pointer;">
                                                            </a>
                                                        ` : ''}
                                                    <div><span>${platformIcon}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                    } else {
                        meetingHtml += `<div class="alert alert-warning">No meeting records found.</div>`;
                    }

                    $('#MetDetails').html(meetingHtml);

                },
                error: function() {
                    $('#leadDetails').html(
                        '<p class="text-danger">Failed to load data</p>'
                    );
                }
            });
        };
    </script>
    <script>
        $(document).on('click', '.viewLeadBtn', function() {
            let groupId = $(this).data('group');
            loadLeadMeetings(groupId);
        });
    </script>
    <script>
        let contactIndex = 1;
        // ADD ROW
        $('#addContactBtn').on('click', function() {
            let contactIndex = 1;
            let row = `
                <div class="row contactRow align-items-end mb-2">
                    <div class="col-md-4">
                        <label class="form-label">Person Name <span class="text-danger">*</span></label>
                        <input type="text" name="contacts[${contactIndex}][name]" id="contacts_${contactIndex}_name" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                        <input type="number" name="contacts[${contactIndex}][mobile]" id="contacts_${contactIndex}_mobile" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="contacts[${contactIndex}][designation]" id="contacts_${contactIndex}_designation" class="form-control">
                    </div>

                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-danger btn-sm removeRow">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            $('#contactRepeater').append(row);
            contactIndex++;
        });

        // REMOVE ROW
        $(document).on('click', '.removeRow', function() {
            $(this).closest('.contactRow').remove();
        });

        function toggleBulkDeleteBtn() {
            let checkedCount = $('.rowCheckbox:checked').length;

            if (checkedCount > 0) {
                $('#bulkDeleteBtn').removeClass('disabled');
            } else {
                $('#bulkDeleteBtn').addClass('disabled');
            }
        }

        // Checkbox change
        $(document).on('change', '.rowCheckbox', function() {
            toggleBulkDeleteBtn();
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#meetingcreatform').on('submit', function(e) {
                e.preventDefault();

                let empId = $('#mt_emp_error').val();
                $('#mt_emp_error').removeClass('is-invalid');

                if (!empId) {
                    $('#mt_emp_error').addClass('is-invalid');
                    return;
                }

                let form = this;
                let formData = new FormData(form);
                formData.append('_token', '{{ csrf_token() }}');
                let btn = $('#savemeetingBtn');

                // Clear previous errors
                $(form).find('.text-danger.small').remove();
                $(form).find('.is-invalid').removeClass('is-invalid');

                // Button loader
                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: "{{ route('admin.meetings.store') }}", // change if needed
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message ?? 'Meeting saved successfully',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });

                        form.reset();
                        loadLeadMeetings(res.group_id);
                    },

                    error: function(err) {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");

                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;
                            $.each(errors, function(key, messages) {

                                // Convert Laravel key "contacts.1.name" → HTML id "contacts_1_name"
                                let inputId = key.replace(/\./g, '_');
                                let input = $('#' + inputId);

                                input.next('.text-danger').remove();
                                input.after('<span class="text-danger small">' +
                                    messages[0] + '</span>');
                                input.addClass('is-invalid');
                            });

                            // Scroll to first error field
                            let firstKey = Object.keys(errors)[0];
                            let firstInputId = firstKey.replace(/\./g, '_');
                            let firstInput = $('#' + firstInputId);

                            if (firstInput.length) {
                                $('html, body').animate({
                                    scrollTop: firstInput.offset().top - 100
                                }, 400);
                            }

                            return;
                        }
                        Swal.fire("Error", "Something went wrong!", "error");
                    },

                    complete: function() {
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });

        });

        function formatDate(dateStr) {
            if (!dateStr || dateStr === 'NULL') return '-';

            const d = new Date(dateStr);

            if (isNaN(d.getTime())) return '-';

            const day = d.toLocaleDateString('en-GB', {
                weekday: 'short'
            });
            const date = d.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: '2-digit'
            });

            return `${date} (${day})`;
        }
    </script>
@endsection
