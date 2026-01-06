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
    }

    .dashnav-pills .nav-link:hover {
        background-color: #e9ecef;
    }

    .dashnav-pills .nav-link.active {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
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
            <div class="my-auto mb-2">
                <h2 class="mb-1">Dashboard</h2>
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
        <div class="welcome-wrap mb-4">
            <div class=" d-flex align-items-center justify-content-between flex-wrap">
                <div class="mb-1">
                    <h2 class="mb-1 text-white">Welcome Back, {{auth()->user()->name}}</h2>
                </div>               
            </div>
            <div class="welcome-bg">
                <img src="{{ asset('admin/img/bg/welcome-bg-02.svg') }}" alt="img" class="welcome-bg-01">
                <img src="{{ asset('admin/img/bg/welcome-bg-03.svg') }}" alt="img" class="welcome-bg-02">
                <img src="{{ asset('admin/img/bg/welcome-bg-01.svg') }}" alt="img" class="welcome-bg-03">
            </div>
        </div>
        <!-- /Welcome Wrap -->

        <div class="row">
            <div class="col-xl-4 col-sm-12 d-flex">
                <div class="card flex-fill h-auto">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="fa-solid fa-comment-dots fs-16 text-white"></i>
                            </span>
                            <div>
                                <h4 class="mb-3">Today’s Comments</h4>                               
                                <h2 class="bg-primary d-inline-block text-white text-end mb-1 px-3 py-1 rounded">{{$todayCommentCount}}</h2>
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-12 d-flex">
                <div class="card flex-fill h-auto">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="fa-solid fa-calendar-week fs-16 text-white"></i>
                            </span>
                            <div>
                                <h4 class="mb-3">Weekly Comments</h4>                               
                                <h2 class="bg-info d-inline-block text-white text-end mb-1 px-3 py-1 rounded">{{$weeklyCommentCount}}</h2>
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-12 d-flex">
                <div class="card flex-fill h-auto">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="fa-solid fa-calendar-days fs-16 text-white"></i>
                            </span>
                            <div>
                                <h4 class="mb-3">Monthly Comments</h4>                               
                                <h2 class="bg-success d-inline-block text-white text-end mb-1 px-3 py-1 rounded">{{$monthlyCommentCount}}</h2>
                            </div>
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
            @endphp
            @foreach($areas as $direction => $directionAreas)
                <div class="col-lg-4 col-md-6 mb-4">    
                    <div class="card shadow-sm border-0 h-100">    
                        {{-- Card Header --}}
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-{{ $colors[$direction] ?? 'secondary' }}">
                                {{ $direction }}
                            </span>
        
                            <span class="badge bg-{{ $colors[$direction] ?? 'secondary' }}">
                                {{ $directionAreas->sum('total') }}
                            </span>
                        </div>    
                        {{-- Card Body --}}
                        <div class="card-body px-1 pt-0" style="max-height:320px; overflow:auto;">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>Area</th>
                                        <th class="text-end">Leads</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($directionAreas as $row)
                                        <tr>
                                            <td class="small">{{ $row->area }}</td>
                                            <td class="text-end fw-semibold">
                                                <span class="badge bg-{{ $colors[$direction] ?? 'secondary' }}">
                                                    {{ $row->total }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            @endforeach
        </div>        
        <div class="card bg-transparent shadow-sm border-0">
            <div class="card-header bg-white">
                <div class="nav nav-pills dashnav-pills d-flex justify-content-around" id="areaViewTab" role="tablist">    
                    <button class="nav-link fw-semibold active" id="table-tab" data-bs-toggle="pill" data-bs-target="#tableView" type="button" role="tab">
                        <i class="fas fa-table me-2"></i>Table View
                    </button>        
                    <button class="nav-link fw-semibold" id="chart-tab" data-bs-toggle="pill" data-bs-target="#chartView" type="button" role="tab">
                        <i class="fas fa-chart-bar me-2"></i>Chart View
                    </button>
        
                </div>
            </div>
            <div class="card-body bg-transparent px-0 py-3">        
                <div class="tab-content" id="areaViewTabContent">    
                    <div class="tab-pane fade show active" id="tableView" role="tabpanel" aria-labelledby="table-tab">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 mb-3">
                                <div class="card shadow-sm border-0">                        
                                    <div class="list-group list-group-flush">                        
                                        @php
                                            $leadTypes = [
                                                'today' => ["Today's Leads", 'primary'],
                                                'tomorrow' => ["Tomorrow's Leads", 'info'],
                                                'missed' => ["Missed Leads", 'danger'],
                                                'next_week' => ["Next Week Leads", 'warning'],
                                                'current_month' => ["Current Month Leads", 'success'],
                                                'most_urgent' => ["Most Urgent Leads", 'danger'],
                                                'urgent' => ["Urgent Leads", 'warning'],
                                                'must' => ["Must Leads", 'dark'],
                                            ];
                                        @endphp                         
                                        @foreach($leadTypes as $key => [$label, $color])
                                            <a href="javascript:void(0)"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center lead-filter {{ $loop->first ? 'active' : '' }}"
                                            data-type="{{ $key }}">
                            
                                                <span>{{ $label }}</span>
                            
                                                <span class="badge bg-{{ $color }}">
                                                    {{ $meetingCounts[$key] ?? 0 }}
                                                </span>
                                            </a>
                                        @endforeach
                            
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <div class="card shadow-sm border-0">                
                                    <div class="card-header bg-white fw-bold" id="tableTitle">
                                        Today's Leads
                                    </div>            
                                    <div class="card-body p-0">                
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Lead Name</th>
                                                        <th>Area</th>
                                                        <th>Mobile</th>
                                                        <th>Status</th>
                                                        <th>Follow-up Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="leadTableBody">
                                                    {{-- AJAX / Dynamic Rows --}}
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">
                                                            Select a category to load leads
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>                
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
                                        @foreach($employeeLeads as $lead)
                                            @php
                                                $percent = $employeeTotalLeads > 0 ? ($lead->total / $employeeTotalLeads * 100) : 0;
                                            @endphp
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span><strong>{{ $lead->employee_name }}</strong></span>
                                                    <span><strong>{{ $lead->total }}</strong></span>
                                                </div>
                                                <div class="progress" style="height: 12px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percent }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach                            
                                        @if($employeeLeads->isEmpty())
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
                                        @foreach($labellead as $lead)
                                            @php
                                                $percent = $labelleadTotal > 0 ? ($lead->total / $labelleadTotal * 100) : 0;                                              
                                            @endphp
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span><strong>{{ $lead->label }}</strong></span>
                                                    <span><strong>{{ $lead->total }}</strong></span>
                                                </div>
                                                <div class="progress" style="height: 12px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percent }}%"></div>
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="donut-chart-2" class="mb-3"></div>
                                        <div>
                                            <h6 class="mb-3">Status</h6>                                        
                                            @foreach($focusProductLeads as $lead)
                                                @php
                                                    $color = $chartColors[$loop->index % count($chartColors)];
                                                @endphp
                                        
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <p class="f-13 mb-0">
                                                        <i class="ti ti-circle-filled me-1" style="color: {{ $color }}"></i>
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="lead-source-donut" class="mb-3"></div>
                                        <div>
                                            <h6 class="mb-3">Sources</h6>                                        
                                            @foreach($leadSourceLeads as $lead)
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="site-stage-donut" class="mb-3"></div>
                                        @foreach($siteStageLeads as $stage)                                                                           
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="f-13 mb-0">
                                                    <i class="ti ti-circle-filled me-1" style="color: {{ $chartColors[$loop->index % count($chartColors)] }}"></i>
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="project-type-donut" class="mb-3"></div>
                                        @foreach($projectTypeLeads as $projectlead)
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="meeting-day-donut" class="mb-3"></div>
                                        @php
                                            $meetingColors = [
                                                'today' => '#0d6efd',
                                                'tomorrow' => '#f26522',
                                                'missed' => '#dc3545',
                                            ];
                                        @endphp 
                                        @foreach($meetingTypes as $key => [$label, $color])
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="mb-0 f-13">
                                                    <i class="ti ti-circle-filled me-1" style="color: {{ $meetingColors[$key] }}"></i>
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
                                    <div class="card-body p-1" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="monthly-meetings-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100">                                    
                                    <div class="card-header bg-white fw-bold text-black">
                                        Leads / Meetings By Week ({{ \Carbon\Carbon::now()->year }})
                                    </div>                                                                  
                                    <div class="card-body p-1" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="weekly-meetings-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100">                                    
                                    <div class="card-header bg-white fw-bold text-black">
                                        New Comments This Week
                                    </div>                                                                  
                                    <div class="card-body p-1" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="weekly-comments-bar"></div>
                                    </div>
                                </div>
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
    </div>   
    
    <script>
        document.querySelectorAll('.lead-filter').forEach(el => {
            el.addEventListener('click', function () {
                document.getElementById('tableTitle').innerText =
                    this.querySelector('span').innerText;
            });
        });
    </script>  
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        
            const productLabels = @json($focusProductLeads->pluck('focus_product'));
            const productCounts = @json($focusProductLeads->pluck('total'));
            const chartColors  = @json($chartColors);
        
            const options = {
                chart: {
                    type: 'donut',
                    height: 280
                },
        
                series: productCounts,
                labels: productLabels,
                colors: chartColors,
        
                legend: { show: false },
        
                dataLabels: {
                    enabled: true,
                    formatter: function (_, opts) {
                        return opts.w.config.series[opts.seriesIndex]; // show count
                    }
                },
        
                tooltip: {
                    y: {
                        formatter: function (val) {
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
                                    formatter: function (w) {
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
        document.addEventListener("DOMContentLoaded", function () {
        
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
        
                legend: { show: false },
        
                dataLabels: {
                    enabled: true,
                    formatter: function (_, opts) {
                        return opts.w.config.series[opts.seriesIndex]; // show count
                    }
                },
        
                tooltip: {
                    y: {
                        formatter: function (val) {
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
                                    formatter: function (w) {
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
                        chart: { height: 220 }
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
        document.addEventListener("DOMContentLoaded", function () {
        
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
        
                legend: { show: false },
        
                dataLabels: {
                    enabled: true,
                    formatter: function (_, opts) {
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
        document.addEventListener("DOMContentLoaded", function () {
        
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
        
                legend: { show: false },
        
                dataLabels: {
                    enabled: true,
                    formatter: function (_, opts) {
                        return opts.w.config.series[opts.seriesIndex]; // show count
                    }
                },
        
                tooltip: {
                    y: {
                        formatter: function (val) {
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
                                    formatter: function (w) {
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
        document.addEventListener("DOMContentLoaded", function () {
        
            const labels = @json($chartLabels);
            const series = @json($chartSeries);
        
            const options = {
                chart: {
                    type: 'donut',
                    height: 260
                },
        
                series: series,
                labels: labels,
        
                colors: ['#0d6efd','#f26522','#dc3545'],
        
                legend: { show: false },
        
                dataLabels: {
                    enabled: true,
                    formatter: function (_, opts) {
                        return opts.w.globals.series[opts.seriesIndex]; // show count
                    }
                },
        
                tooltip: {
                    y: {
                        formatter: function (val) {
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
                                    formatter: function (w) {
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
            const categories = @json($months);          // Month names

            const options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false }
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
                    rotate: 0  // Desktop horizontal
                },
                colors: ['#0d6efd'],
                series: [{
                    name: 'Meetings',
                    data: seriesData
                }],
                xaxis: {
                    categories: categories,
                    labels: { style: { fontSize: '13px' } }
                },
                yaxis: {
                    labels: { style: { fontSize: '12px' } }
                },
                tooltip: {
                    y: {
                        formatter: val => val + " Meetings"
                    }
                },
                responsive: [
                    {
                        breakpoint: 768, // Tablet
                        options: { chart: { height: 300 } }
                    },
                    {
                        breakpoint: 480, // Mobile
                        options: {
                            chart: { height: 260 },
                            plotOptions: { bar: { columnWidth: '80%' } },
                            xaxis: { labels: { rotate: -90, style: { fontSize: '9px' } } },
                            dataLabels: {
                                offsetY: 0,
                                rotate: -90,       // Rotate the value label
                                style: { fontSize: '9px', colors: ['#000'] }
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
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: { bar: { horizontal: false, columnWidth: '55%' } },
                dataLabels: { enabled: true, style: { fontSize: '12px', colors: ['#000'] } },
                colors: ['#0d6efd'],
                series: [{ name: 'Meetings', data: weeklySeries }],
                xaxis: { categories: weeklyLabelsData, labels: { style: { fontSize: '12px' } } },
                yaxis: { labels: { style: { fontSize: '12px' } } },
                tooltip: { y: { formatter: val => val + " Meetings" } },
                responsive: [
                    { breakpoint: 768, options: { chart: { height: 280 } } },
                    { 
                        breakpoint: 480, 
                        options: { 
                            chart: { height: 260 }, 
                            plotOptions: { bar: { columnWidth: '80%' } }, 
                            xaxis: { labels: { rotate: -90, style: { fontSize: '9px' } } },
                            yaxis: { labels: { style: { fontSize: '9px' } } } 
                        } 
                    }
                ]
            };
            new ApexCharts(document.querySelector("#weekly-meetings-bar"), weeklyOptions).render();
        
        
            // --- Weekly Comments Chart ---
            const weeklyLabelsCommentsData = @json($weeklyLabelsComments);  
            const weeklyCommentsSeries = @json($weeklyCountsComments);
        
            const commentsOptions = {
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: { bar: { horizontal: false, columnWidth: '55%' } },
                dataLabels: { enabled: true, style: { fontSize: '12px', colors: ['#000'] } },
                colors: ['#198754'], // green
                series: [{ name: 'Comments', data: weeklyCommentsSeries }],
                xaxis: { categories: weeklyLabelsCommentsData, labels: { style: { fontSize: '12px' } } },
                yaxis: { labels: { style: { fontSize: '12px' } } },
                tooltip: { y: { formatter: val => val + " Comments" } },
                responsive: [
                    { breakpoint: 768, options: { chart: { height: 280 } } },
                    { 
                        breakpoint: 480, 
                        options: { 
                            chart: { height: 260 }, 
                            plotOptions: { bar: { columnWidth: '80%' } }, 
                            xaxis: { labels: { rotate: -90, style: { fontSize: '9px' } } },
                            yaxis: { labels: { style: { fontSize: '9px' } } } 
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
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: { fontSize: '12px', colors: ['#000'] }
                },
                colors: ['#0d6efd'], // You can add more colors if you like
                series: [{
                    name: 'Leads',
                    data: leadsData
                }],
                xaxis: {
                    categories: months,
                    labels: { style: { fontSize: '13px' } }
                },                
                tooltip: {
                    y: {
                        formatter: val => val + " Leads"
                    }
                },
                responsive: [
                    {
                        breakpoint: 480,
                        options: {
                            chart: { height: 260 },
                            plotOptions: { bar: { columnWidth: '80%' } },
                            xaxis: { labels: { rotate: -90, style: { fontSize: '9px' } } },
                            yaxis: { labels: { rotate: -90, style: { fontSize: '9px' } } },
                            dataLabels: { rotate: -90, style: { fontSize: '9px', colors: ['#000'] }, offsetY: 0 }
                        }
                    }
                ]
            };
        
            new ApexCharts(document.querySelector("#yearly-leads-bar"), options).render();
        });
    </script>
        
@endsection
