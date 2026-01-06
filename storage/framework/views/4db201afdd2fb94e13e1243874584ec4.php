<?php $__env->startSection('title', config('app.name') . ' || Dashboard'); ?>
<?php $__env->startSection('content'); ?>
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
    .offcanvas.offcanvas-end {
        width: 70% !important;
    }
</style>
    <?php
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
    ?>
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
                    <h2 class="mb-1 text-white">Welcome Back, <?php echo e(auth()->user()->name); ?></h2>
                </div>               
            </div>
            <div class="welcome-bg">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-02.svg')); ?>" alt="img" class="welcome-bg-01">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-03.svg')); ?>" alt="img" class="welcome-bg-02">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-01.svg')); ?>" alt="img" class="welcome-bg-03">
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
                                <h2 class="bg-primary d-inline-block text-white text-end mb-1 px-3 py-1 rounded"><?php echo e($todayCommentCount); ?></h2>
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
                                <h2 class="bg-info d-inline-block text-white text-end mb-1 px-3 py-1 rounded"><?php echo e($weeklyCommentCount); ?></h2>
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
                                <h2 class="bg-success d-inline-block text-white text-end mb-1 px-3 py-1 rounded"><?php echo e($monthlyCommentCount); ?></h2>
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>   
        <div class="row">
            <?php
                $colors = [
                    'East' => 'primary',
                    'West' => 'success',
                    'North' => 'info',
                    'South' => 'secondary',
                    'Pending' => 'danger',
                    'Other Areas' => 'secondary',
                    'All' => 'dark',
                ];
            ?>
            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $direction => $directionAreas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 mb-4">    
                    <div class="card shadow-sm border-0 h-100">    
                        
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-<?php echo e($colors[$direction] ?? 'secondary'); ?>">
                                <?php echo e($direction); ?>

                            </span>
        
                            <span class="badge bg-<?php echo e($colors[$direction] ?? 'secondary'); ?>">
                                <?php echo e($directionAreas->sum('total')); ?>

                            </span>
                        </div>    
                        
                        <div class="card-body px-1 pt-0" style="max-height:320px; overflow:auto;">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>Area</th>
                                        <th class="text-end">Leads</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $directionAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="small"><?php echo e($row->area); ?></td>
                                            <td class="text-end fw-semibold">
                                                <span class="badge bg-<?php echo e($colors[$direction] ?? 'secondary'); ?>">
                                                    <?php echo e($row->total); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php
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
                                        ?>                         
                                        <?php $__currentLoopData = $leadTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$label, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="javascript:void(0)"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center lead-filter <?php echo e($loop->first ? 'active' : ''); ?>"
                                            data-type="<?php echo e($key); ?>">
                            
                                                <span><?php echo e($label); ?></span>
                            
                                                <span class="badge bg-<?php echo e($color); ?>">
                                                    <?php echo e($meetingCounts[$key] ?? 0); ?>

                                                </span>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <div class="card shadow-sm border-0">                
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
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
                                        <?php $__currentLoopData = $employeeLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $percent = $employeeTotalLeads > 0 ? ($lead->total / $employeeTotalLeads * 100) : 0;
                                            ?>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span><strong><?php echo e($lead->employee_name); ?></strong></span>
                                                    <span><strong><?php echo e($lead->total); ?></strong></span>
                                                </div>
                                                <div class="progress" style="height: 12px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($percent); ?>%"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                                        <?php if($employeeLeads->isEmpty()): ?>
                                            <div class="text-center text-muted">No leads found</div>
                                        <?php endif; ?>
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100">                                    
                                    <div class="card-header bg-white fw-bold text-black">
                                        Leads By Labels
                                    </div>                            
                                    <div class="card-body p-3" style="max-height: 400px; overflow-y: auto;">
                                        <?php $__currentLoopData = $labellead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $percent = $labelleadTotal > 0 ? ($lead->total / $labelleadTotal * 100) : 0;                                              
                                            ?>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span><strong><?php echo e($lead->label); ?></strong></span>
                                                    <span><strong><?php echo e($lead->total); ?></strong></span>
                                                </div>
                                                <div class="progress" style="height: 12px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($percent); ?>%"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            <?php $__currentLoopData = $focusProductLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $color = $chartColors[$loop->index % count($chartColors)];
                                                ?>
                                        
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <p class="f-13 mb-0">
                                                        <i class="ti ti-circle-filled me-1" style="color: <?php echo e($color); ?>"></i>
                                                        <?php echo e($lead->focus_product); ?>

                                                    </p>
                                                    <p class="f-13 fw-medium text-gray-9">
                                                        <?php echo e($lead->total); ?>

                                                    </p>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            <?php $__currentLoopData = $leadSourceLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <p class="f-13 mb-0">
                                                        <i class="ti ti-circle-filled me-1"
                                                        style="color: <?php echo e($chartColors[$loop->index % count($chartColors)]); ?>"></i>
                                                        <?php echo e($lead->source); ?>

                                                    </p>
                                                    <p class="f-13 fw-medium text-gray-9">
                                                        <?php echo e($lead->total); ?>

                                                    </p>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php $__currentLoopData = $siteStageLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                           
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="f-13 mb-0">
                                                    <i class="ti ti-circle-filled me-1" style="color: <?php echo e($chartColors[$loop->index % count($chartColors)]); ?>"></i>
                                                    <?php echo e($stage->stage); ?>

                                                </p>
                                                <p class="f-13 fw-medium text-gray-9">
                                                    <?php echo e($stage->total); ?>

                                                </p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php $__currentLoopData = $projectTypeLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectlead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="f-13 mb-0">
                                                    <i class="ti ti-circle-filled me-1"
                                                    style="color: <?php echo e($chartColors[$loop->index % count($chartColors)]); ?>"></i>
                                                    <?php echo e($projectlead->project_type); ?>

                                                </p>
                                                <p class="f-13 fw-medium text-gray-9">
                                                    <?php echo e($projectlead->total); ?>

                                                </p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php
                                            $meetingColors = [
                                                'today' => '#0d6efd',
                                                'tomorrow' => '#f26522',
                                                'missed' => '#dc3545',
                                            ];
                                        ?> 
                                        <?php $__currentLoopData = $meetingTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => [$label, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="mb-0 f-13">
                                                    <i class="ti ti-circle-filled me-1" style="color: <?php echo e($meetingColors[$key]); ?>"></i>
                                                    <?php echo e($label); ?>

                                                </p>
                                                <p class="fw-medium text-gray-9 mb-0">
                                                    <?php echo e($meetingCounts[$key] ?? 0); ?>

                                                </p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100">                                    
                                    <div class="card-header bg-white fw-bold text-black">
                                        Leads Meetings By Month (<?php echo e(\Carbon\Carbon::now()->year); ?>)
                                    </div>                                                                  
                                    <div class="card-body p-1" style="max-height: 400px; overflow-y: auto;">                                        
                                        <div id="monthly-meetings-bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100">                                    
                                    <div class="card-header bg-white fw-bold text-black">
                                        Leads / Meetings By Week (<?php echo e(\Carbon\Carbon::now()->year); ?>)
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
                            New Leads By Year (<?php echo e(\Carbon\Carbon::now()->year); ?>)
                        </div>
                        <div class="card-body p-3">
                            <div id="yearly-leads-bar"></div>
                        </div>
                    </div>
                </div>                  
            </div>
        </div>      
    </div>   
    <div id="leadViewSidebar" class="offcanvas offcanvas-end" tabindex="-1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Lead Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="meetingcreatform">
                <input type="hidden" name="form_group_id" class="form-control" id="form_group_id">
                <div id="leadDetails">
                    <div class="text-center">
                        <div class="spinner-border"></div>
                    </div>
                </div>
                <div id="authhideshow">
                    <div class="row">
                        <?php if(auth()->user()->role === 'super admin'): ?>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Select User <span class="text-danger">*</span></label>
                                    <select name="emp_id" class="form-control" id="mt_emp_error" required>
                                        <option value="">Select User</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>">
                                                <?php echo e($user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="emp_id" id="mt_emp_error" value="<?php echo e(auth()->id()); ?>">
                        <?php endif; ?>
                        <?php $__currentLoopData = $leadmeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leadm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $field = $leadm->field;
                                $label = $field->name;
                                $name = Str::slug($field->name, '_');
                                $type = $field->type;
                                $isRequired = $field->validation == 'required' ? 'required' : '';
                                $defaultValue = match ($field->default_value) {
                                    'today'     => now()->toDateString(),
                                    'auth_name' => auth()->check() ? auth()->user()->name : null,
                                    default     => $field->default_value,
                                };
                            ?>
                            <div class="col-md-4 mb-3">
                                <?php if($type != 'hidden'): ?>
                                    <label class="form-label"><?php echo e($label); ?> <?php if($isRequired): ?> <span class="text-danger">*</span> <?php endif; ?> </label>
                                <?php endif; ?>
                                
                                <?php if(in_array($type, ['text', 'email', 'number'])): ?>
                                    <input type="<?php echo e($type); ?>" name="<?php echo e($field->id); ?>" class="form-control" id="<?php echo e($name); ?>" <?php echo e($isRequired); ?>>                            
                                <?php elseif($type == 'date'): ?>                    
                                    <input type="<?php echo e($type); ?>" name="<?php echo e($field->id); ?>" class="form-control" id="<?php echo e($name); ?>" min="<?php echo e($defaultValue); ?>" <?php echo e($isRequired); ?>>                            
                                
                                <?php elseif($type == 'hidden'): ?>
                                    <input type="<?php echo e($type); ?>" name="<?php echo e($field->id); ?>" class="form-control" id="<?php echo e($name); ?>" value="<?php echo e($defaultValue); ?>">
                                
                                <?php elseif($type == 'textarea'): ?>
                                    <textarea name="<?php echo e($field->id); ?>" class="form-control" id="<?php echo e($name); ?>" rows="3"
                                        <?php echo e($isRequired); ?>>
                                    </textarea>

                                
                                <?php elseif($type == 'select'): ?>
                                    <select name="<?php echo e($field->id); ?>" id="<?php echo e($name); ?>" class="form-select" <?php echo e($isRequired); ?>>
                                        <option value="">Select <?php echo e($label); ?></option>
                                        <?php $__currentLoopData = $field->dropdowns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($opt->value); ?>"><?php echo e($opt->label); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                
                                <?php elseif($type == 'radio'): ?>
                                    <?php
                                        $options = is_array($field->options)
                                            ? $field->options
                                            : explode(',', $field->options);
                                    ?>
                                    <div class="d-flex flex-wrap mt-2">
                                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $opt = trim($opt); ?>
                                            <label class="me-3">
                                                <input type="radio" name="<?php echo e($field->id); ?>"
                                                    id="<?php echo e($name . '_' . $opt); ?>" value="<?php echo e($opt); ?>"
                                                    <?php echo e($defaultValue == $opt ? 'checked' : ''); ?>

                                                    <?php echo e($isRequired ? 'required' : ''); ?>>
                                                <?php echo e($opt); ?>

                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    
                                <?php elseif($type == 'file'): ?>
                                    <input type="file" name="<?php echo e($field->id); ?>" id="<?php echo e($name); ?>"
                                        class="form-control" <?php echo e($isRequired); ?>>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
   
        $(document).on('click', '.lead-filter', function () {

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
        $(window).on('load', function () {
            const firstType = $('.lead-filter.active').data('type');
            if (firstType) {
                getLeadData(firstType);
            }
        });

        function getLeadData(type) {
            $('#lead_list').html('<div class="text-center py-4">Loading...</div>');
            $.ajax({
                url: '<?php echo e(route("admin.dashboard.leads.filter")); ?>',
                method: 'GET',
                data: {
                    type: type
                },
                success: function (response) {
                    if (response.success) {
                        $('#lead_list').html(response.html);
                        let table = $('#datalistTable').DataTable();
                    }
                },
                error: function () {
                    $('#lead_list').html('<div class="text-center text-danger py-4">Error while loading leads</div>');
                    toastr.error('Error while loading leads.');
                }
            });
        }
    </script>  
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        
            const productLabels = <?php echo json_encode($focusProductLeads->pluck('focus_product'), 15, 512) ?>;
            const productCounts = <?php echo json_encode($focusProductLeads->pluck('total'), 15, 512) ?>;
            const chartColors  = <?php echo json_encode($chartColors, 15, 512) ?>;
        
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
        
            const labels = <?php echo json_encode($leadSourceLeads->pluck('source'), 15, 512) ?>;
            const series = <?php echo json_encode($leadSourceLeads->pluck('total'), 15, 512) ?>;
            const chartColors = <?php echo json_encode($chartColors, 15, 512) ?>;
        
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
        
            const labels = <?php echo json_encode($siteStageLeads->pluck('stage'), 15, 512) ?>;
            const series = <?php echo json_encode($siteStageLeads->pluck('total'), 15, 512) ?>;
            const colors = <?php echo json_encode($chartColors, 15, 512) ?>;
        
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
        
            const labels = <?php echo json_encode($projectTypeLeads->pluck('project_type'), 15, 512) ?>;
            const series = <?php echo json_encode($projectTypeLeads->pluck('total'), 15, 512) ?>;
            const chartColors = <?php echo json_encode($chartColors, 15, 512) ?>;
        
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
        
            const labels = <?php echo json_encode($chartLabels, 15, 512) ?>;
            const series = <?php echo json_encode($chartSeries, 15, 512) ?>;
        
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
            const seriesData = <?php echo json_encode($monthlyMeetings, 15, 512) ?>; // Your data
            const categories = <?php echo json_encode($months, 15, 512) ?>;          // Month names

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
            const weeklyLabelsData = <?php echo json_encode($weeklyLabels, 15, 512) ?>; 
            const weeklySeries = <?php echo json_encode($weeklyCounts, 15, 512) ?>;
        
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
            const weeklyLabelsCommentsData = <?php echo json_encode($weeklyLabelsComments, 15, 512) ?>;  
            const weeklyCommentsSeries = <?php echo json_encode($weeklyCountsComments, 15, 512) ?>;
        
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
        
            const months = <?php echo json_encode($yearsmonths, 15, 512) ?>;
            const leadsData = <?php echo json_encode($yearsleadsData, 15, 512) ?>;
        
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
    <script>
        const ASSET_URL = "<?php echo e(asset('')); ?>";
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
                url: "<?php echo e(route('admin.admin.lead.master.get.data', '')); ?>/" + groupId,
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
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <h4 class="mb-0">${fields['Site Name'] ?? 'N/A'}</h4>
                            <h6 class="mb-0 text-muted">${fields['Area'] ?? ''}</h6>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h4>Lead Details</h4>
                            </div>

                            <div class="col-md-4 mb-3">
                                <p class="mb-2"><strong>Site Stage :</strong> ${fields['Site Stage'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>Competition :</strong> ${fields['Competition'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>No. of Towers :</strong> ${fields['No. of Towers'] ?? 'N/A'}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <p class="mb-2"><strong>Project Type :</strong> ${fields['Project Type'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>No. of Bathrooms :</strong> ${fields['No. of Bathrooms'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>MEPF Consu :</strong> ${fields['MEPF Consu'] ?? 'N/A'}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <p class="mb-2"><strong>SP Focused Product :</strong> ${fields['SP Focused Product'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>No. of Floors :</strong> ${fields['No. of Floors'] ?? 'N/A'}</p>
                                <p class="mb-2"><strong>Labels :</strong> ${fields['Labels'] ?? 'N/A'}</p>
                            </div>
                        </div>
                        `;

                    $('#leadDetails').html(html);

                    let meetingHtml = '<h5 class="mb-3">Lead Meetings</h5>';
                    if (res.meetings && Object.keys(res.meetings).length) {

                        Object.entries(res.meetings).forEach(([groupName, items]) => {

                            // Separate contacts and other fields
                            let contacts = [];
                            let otherData = {};

                            items.forEach(item => {
                                const labelKey = item.label.toLowerCase().replace(/[^a-z0-9]+/g, '_');

                                if (['person_name', 'mobile_number', 'designation'].includes(labelKey)) {
                                    // Add contact
                                    if (!contacts.length || (contacts[contacts.length - 1][labelKey])) {
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
                                platformIcon = `<i class="fa fa-desktop text-success" title="Desktop"></i>`;
                            } else if (otherData.platform === 'mobile') {
                                platformIcon = `<i class="fa fa-mobile-alt text-success" title="Mobile"></i>`;
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
                                                <p class="mb-0"><strong>Employee Name:</strong> ${otherData.employee_name ?? '<?php echo e(Auth::user()->name); ?>'}</p>
                                                <p class="mb-0"><strong>Comment By:</strong> ${otherData.comment_by ?? '-'}</p>
                                            </div>

                                            <div class="col-3">
                                                <div class="d-flex flex-column align-items-end gap-2">
                                                    <div class="d-flex gap-2">
                                                        ${otherData.attachment && otherData.attachment !== 'NULL' ? `
                                                            <a href="${ASSET_URL}${otherData.attachment}" download class="btn btn-sm btn-outline-success">Download</a>
                                                        ` : ''}
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
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
                let btn = $('#savemeetingBtn');

                // Clear previous errors
                $(form).find('.text-danger.small').remove();
                $(form).find('.is-invalid').removeClass('is-invalid');

                // Button loader
                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: "<?php echo e(route('admin.meetings.store')); ?>", // change if needed
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message ?? 'Meeting saved successfully',
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
                                input.after('<span class="text-danger small">' + messages[0] + '</span>');
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

            const day = d.toLocaleDateString('en-GB', { weekday: 'short' });
            const date = d.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: '2-digit'
            });

            return `${date} (${day})`;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>