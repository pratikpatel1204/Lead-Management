@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Lead Master')
@section('content')
    <style>
        .offcanvas.offcanvas-end {
            width: 70% !important;
        }
        table.table.dataTable > tbody > tr td{
            padding:4px !important;
        }
        table.table-bordered.dataTable thead tr:first-child th, table.table-bordered.dataTable thead tr:first-child td{
            padding:4px !important;
        }  
        .select2-container--default .select2-selection--multiple {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 12px;
        }     
    </style>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-2">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Lead List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Lead Master</li>
                        <li class="breadcrumb-item active" aria-current="page">Lead List</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm mt-2 mt-md-0" id="openLeadForm">
                    <i class="ti ti-plus"></i>
                    <span>New Lead</span>
                </a> 
                @role('super admin')              
                <a href="javascript:void(0)" class="btn btn-success btn-sm mt-2 mt-md-0" id="leadExcelUploadBtn">
                    <i class="ti ti-file-upload"></i>
                    <span>Lead Excel Upload</span>
                </a>     
                <a href="javascript:void(0)" class="btn btn-warning btn-sm mt-2 mt-md-0" id="leadMeetingExcelUploadBtn">
                    <i class="ti ti-file-upload"></i>
                    <span>Meeting Excel Upload</span>
                </a>                                        
                <button id="bulkDeleteBtn" class="btn btn-danger btn-sm mt-2 mt-md-0 disabled">
                    <i class="ti ti-trash"></i> Delete Selected
                </button>
                @endrole
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="accordion mb-2" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                🔍 Lead Summary & Filters
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">                
                            <div class="accordion-body p-2">    
                                <div class="card mb-1">
                                    <div class="card-header">                                                        
                                        <div class="row g-3">
                                            <div class="col-xl-2 col-lg-3 col-md-6 d-flex">
                                                <div class="card flex-fill mb-0">
                                                    <div class="card-body d-flex align-items-center justify-content-between p-2">
                                                        <div class="overflow-hidden">
                                                            <h6 class="text-muted mb-1 text-truncate">All Leads</h6>
                                                            <h4 class="mb-0">{{ $all_leads }}</h4>
                                                        </div>
                                                        <span class="avatar avatar-lg bg-primary flex-shrink-0">
                                                            <i class="ti ti-chart-bar fs-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-6 d-flex">
                                                <div class="card flex-fill mb-0">
                                                    <div class="card-body d-flex align-items-center justify-content-between p-2">
                                                        <div class="overflow-hidden">
                                                            <h6 class="text-muted mb-1 text-truncate">Active</h6>
                                                            <h4 class="mb-0">{{ $total_active }}</h4>
                                                        </div>
                                                        <span class="avatar avatar-lg bg-success flex-shrink-0">
                                                            <i class="ti ti-circle-check fs-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-6 d-flex">
                                                <div class="card flex-fill mb-0">
                                                    <div class="card-body d-flex align-items-center justify-content-between p-2">
                                                        <div class="overflow-hidden">
                                                            <h6 class="text-muted mb-1 text-truncate">Closed</h6>
                                                            <h4 class="mb-0">{{ $total_Closed }}</h4>
                                                        </div>
                                                        <span class="avatar avatar-lg bg-danger flex-shrink-0">
                                                            <i class="ti ti-circle-x fs-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-6 d-flex">
                                                <div class="card flex-fill mb-0">
                                                    <div class="card-body d-flex align-items-center justify-content-between p-2">
                                                        <div class="overflow-hidden">
                                                            <h6 class="text-muted mb-1 text-truncate">Private</h6>
                                                            <h4 class="mb-0">{{ $private_leads }}</h4>
                                                        </div>
                                                        <span class="avatar avatar-lg bg-warning flex-shrink-0">
                                                            <i class="ti ti-lock fs-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-6 d-flex">
                                                <div class="card flex-fill mb-0">
                                                    <div class="card-body d-flex align-items-center justify-content-between p-2">
                                                        <div class="overflow-hidden">
                                                            <h6 class="text-muted mb-1 text-truncate">Global</h6>
                                                            <h4 class="mb-0">{{ $globle_leads }}</h4>
                                                        </div>
                                                        <span class="avatar avatar-lg bg-info flex-shrink-0">
                                                            <i class="ti ti-world fs-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>                                        
                                        </div>

                                        <div class="row g-2 mt-1">                
                                            <div class="col-md-3">
                                                <input type="text" id="filterNextMeetingDate" class="form-control" placeholder="Select date range" autocomplete="off">
                                            </div>
                                            <div class="col-md-3">
                                                <select id="filterLabels" class="select2" multiple data-placeholder="Select Labels">
                                                    @foreach($labels as $label)
                                                        <option value="{{ $label }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterEmployee" class="select2" multiple data-placeholder="Select Employee">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterArea" class="select2" multiple data-placeholder="Select Area">
                                                    @foreach($areas as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterLeadType" class="select2" multiple data-placeholder="Select Lead Type">
                                                    @foreach($leadTypes as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterSiteStage" class="select2" multiple data-placeholder="Select Site Stage">
                                                    @foreach($siteStages as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterProjectType" class="select2" multiple data-placeholder="Select Project Type">
                                                    @foreach($projectTypes as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterCustomerType" class="select2" multiple data-placeholder="Select Customer Type">
                                                    @foreach($customerTypes as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterSPProduct" class="select2" multiple data-placeholder="Select SP Focused Product">
                                                    @foreach($spProducts as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterLeadSource" class="select2" multiple data-placeholder="Select Lead Source">
                                                    @foreach($leadSources as $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                
                                            <!-- Bathroom -->
                                            <div class="col-md-3 d-flex gap-1">
                                                <select id="bathroomOp" class="form-select form-select-sm w-25">
                                                    <option value="=">=</option>
                                                    <option value="<"><</option>
                                                    <option value=">">></option>
                                                </select>
                                                <input type="number" id="filterBathroom" class="form-control form-control-sm" placeholder="Bathroom">
                                            </div>
                
                                            <!-- Floor -->
                                            <div class="col-md-3 d-flex gap-1">
                                                <select id="floorOp" class="form-select form-select-sm w-25">
                                                    <option value="=">=</option>
                                                    <option value="<"><</option>
                                                    <option value=">">></option>
                                                </select>
                                                <input type="number" id="filterFloor" class="form-control form-control-sm" placeholder="Floor">
                                            </div>
                
                                            <!-- Tower -->
                                            <div class="col-md-3 d-flex gap-1">
                                                <select id="towerOp" class="form-select form-select-sm w-25">
                                                    <option value="=">=</option>
                                                    <option value="<"><</option>
                                                    <option value=">">></option>
                                                </select>
                                                <input type="number" id="filterTower" class="form-control form-control-sm" placeholder="Tower">
                                            </div>

                                            <!-- Meeting NULL Filter -->
                                            <div class="col-md-3 d-flex align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="meetingNull">
                                                    <label class="form-check-label" for="meetingNull">
                                                        Meeting is NULL
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="col-md-3 d-flex gap-2">
                                                <button id="applyFilters" class="btn btn-sm btn-primary w-50">Apply</button>
                                                <button id="clearFilters" class="btn btn-sm btn-outline-secondary w-50">Clear</button>
                                            </div>                
                                        </div>            
                                    </div>
                                </div>                
                            </div>
                        </div>
                    </div>                
                </div>
                      
                <div class="table-responsive-wrapper">
                    <table class="table table-bordered table-striped table-responsive-custom" id="datalistTable">
                        <thead class="table-light">
                            <tr class="bg-light">
                                @role('super admin')  
                                <th>#</th>
                                @endrole
                                {{-- Table headers --}}
                                @php
                                    $columns = !empty($fieldsorder) ? array_unique($fieldsorder) : $tablefield->pluck('field.name')->toArray();
                                @endphp
                
                                @foreach($columns as $col)
                                    <th>{{ $col }}</th>
                                @endforeach
                                @role('super admin')  
                                <th width="150">Actions</th>
                                @endrole
                            </tr>
                        </thead>
                
                        <tbody id="leadTableBody">
                            @foreach($finalData as $rowSet)
                                @php
                                    $groupId = $rowSet['form_group_id'];
                                    $leadRows    = collect($rowSet['lead'])->keyBy('field_name');
                                    $meetingRows = collect($rowSet['meeting'])->keyBy('label');
                                    $platform    = strtolower(optional($meetingRows->firstWhere('label', 'Platform'))->value ?? '');
                                @endphp
                
                                <tr>
                                    @role('super admin')  
                                    <td>
                                        <input type="checkbox" class="rowCheckbox" value="{{ $groupId }}">
                                    </td>
                                    @endrole
                
                                    {{-- Table cells --}}
                                    @foreach($columns as $col)
                                        @php
                                            $leadRec    = $leadRows[$col] ?? null;
                                            $meetingRec = $meetingRows[$col] ?? null;
                                        @endphp
                
                                        <td>
                                            {{-- Lead Data --}}
                                            @if($leadRec)
                                                @if($leadRec->field_name === 'Site Name')
                                                    <a href="javascript:void(0)" class="text-info viewLeadBtn" data-group="{{ $groupId }}">
                                                        {{ $leadRec->field_value }}
                                                    </a>
                                                @elseif($leadRec->field_name === 'Lead Type')
                                                    @php
                                                        $type = strtolower($leadRec->field_value);
                                                        $badgeClass = $type === 'private' ? 'bg-warning text-dark' : ($type === 'global' ? 'bg-success' : 'bg-secondary');
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($leadRec->field_value) }}</span>
                                                @elseif(Str::endsWith($leadRec->field_value, ['jpg','jpeg','png','gif','webp']))
                                                    <img src="{{ asset($leadRec->field_value) }}" width="50">
                                                @elseif(Str::endsWith($leadRec->field_value, 'pdf'))
                                                    <a href="{{ asset($leadRec->field_value) }}" target="_blank" class="btn btn-sm btn-danger">View PDF</a>
                                                @else
                                                    {{ $leadRec->field_value ?? '-' }}
                                                @endif
                
                                            {{-- Meeting Data --}}
                                            @elseif($meetingRec)
                                                @if($meetingRec->label === 'Meeting Status')
                                                    <span class="badge bg-warning">{{ ucfirst($meetingRec->value) }}</span>
                                                @elseif(in_array($meetingRec->label, ['Next Meeting Date','Platform']))
                                                    @php
                                                        $date = $meetingRec->value ?? null;
                                                    @endphp
                                                    
                                                    @if(!empty($date) && $date != 'NULL')
                                                        {{ \Carbon\Carbon::parse($date)->format('d-M-y (D)') }}
                                                    @else
                                                        -
                                                    @endif                                                
                                                    <br>
                                                    <span class="badge bg-info">{{ $rowSet['meeting_count'] }}</span>
                                                    @if($platform === 'desktop')
                                                        <i class="fa fa-desktop text-success" title="Desktop"></i>
                                                    @elseif($platform === 'mobile')
                                                        <i class="fa fa-mobile-alt text-success" title="Mobile"></i>
                                                    @endif
                                                @else
                                                    {{ $meetingRec->value ?? '-' }}
                                                @endif
                
                                            {{-- Default --}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                
                                    {{-- Actions --}}
                                    @role('super admin')  
                                    <td class="text-center">
                                        <a href="{{ route('admin.lead.master.edit', $groupId) }}" class="btn btn-info btn-sm text-white me-1">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm deleteDataBtn" data-group="{{ $groupId }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="pagediv">
                    {{ $finalData->links() }}
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
                        @if(auth()->user()->role === 'super admin')
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Select User <span class="text-danger">*</span></label>
                                    <select name="emp_id" class="form-control" id="mt_emp_error" required>
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
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
                                    'today'     => now()->toDateString(),
                                    'auth_name' => auth()->check() ? auth()->user()->name : null,
                                    default     => $field->default_value,
                                };
                                $colClass = match ($type) {
                                    'textarea' => 'col-12',
                                    default    => 'col-md-3',
                                };
                            @endphp
                            <div class="{{ $colClass }} mb-3">
                                @if ($type != 'hidden')
                                    <label class="form-label">{{ $label }} @if ($isRequired) <span class="text-danger">*</span> @endif </label>
                                @endif
                                {{-- Text / Email / Number --}}
                                @if (in_array($type, ['text', 'email', 'number']))
                                    <input type="{{ $type }}" name="{{ $field->id }}" class="form-control" id="{{ $name }}" {{ $isRequired }}>                            
                                @elseif ($type == 'date')                    
                                    <input type="{{ $type }}" name="{{ $field->id }}" class="form-control" id="{{ $name }}" min="{{$defaultValue}}" {{ $isRequired }}>                            
                                {{-- Hidden --}}
                                @elseif ($type == 'hidden')
                                    <input type="{{ $type }}" name="{{ $field->id }}" class="form-control" id="{{ $name }}" value="{{$defaultValue}}">
                                {{-- Textarea --}}
                                @elseif ($type == 'textarea')
                                    <textarea name="{{ $field->id }}" class="form-control" id="{{ $name }}" rows="3" {{ $isRequired }}></textarea>

                                {{-- Select --}}
                                @elseif ($type == 'select')
                                    <select name="{{ $field->id }}" id="{{ $name }}" class="form-select" {{ $isRequired }}>
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
                        <div id="contactRepeater"></div>
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
    <div id="leadSidebarForm" class="offcanvas offcanvas-end lead-sidebar" tabindex="-1">
        <div class="offcanvas-header bg-info py-2">
            <h5 class="offcanvas-title text-light">New Lead</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="dynamicForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    @if(auth()->user()->role === 'super admin')
                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label class="form-label">Select User <span class="text-danger">*</span></label>
                                <select name="lead_emp_id" class="form-control" id="lead_emp_error" required>
                                    <option value="">Select User</option>
                                    <option value="0">All User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="lead_emp_id" id="lead_emp_error" value="{{ auth()->id() }}">
                    @endif
                    @foreach ($templates as $t)
                        @php
                            $field = $t->field;
                            $label = $field->name;
                            $name = Str::slug($field->name, '_');
                            $type = $field->type;
                            $isRequired = $field->validation == 'required' ? 'required' : '';
                            $defaultValue = $field->default_value;
                        @endphp
                        <div class="col-md-3 mb-2">
                            <label class="form-label">{{ $label }} 
                                @if ($isRequired)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            {{-- Text / Email / Number --}}
                            @if (in_array($type, ['text', 'email', 'number']))
                                <input type="{{ $type }}" name="{{ $field->id }}" class="form-control" id="dy{{ $name }}" {{ $isRequired }}>
                                                        
                            {{-- Textarea --}}
                            @elseif ($type == 'textarea')
                                <textarea name="{{ $field->id }}" class="form-control" id="dy{{ $name }}" rows="1" {{ $isRequired }}></textarea>

                                {{-- Select --}}
                            @elseif ($type == 'select')
                                <select name="{{ $field->id }}" id="dy{{ $name }}" class="form-select" {{ $isRequired }}>
                                    <option value="">Select {{ $label }}</option>
                                    @foreach ($field->dropdowns as $opt)
                                        <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                                    @endforeach
                                </select>

                                {{-- Radio --}}
                            @elseif ($type == 'radio')
                                @php
                                    $options = is_array($field->options) ? $field->options : explode(',', $field->options);
                                @endphp
                                <div class="d-flex flex-wrap mt-2">
                                    @foreach ($options as $opt)
                                        @php $opt = trim($opt); @endphp
                                        <label class="me-3">
                                            <input type="radio" name="{{ $field->id }}" id="{{ $name . '_' . $opt }}" value="{{ $opt }}" {{ $defaultValue == $opt ? 'checked' : '' }} {{ $isRequired ? 'required' : '' }}>
                                            {{ $opt }}
                                        </label>
                                    @endforeach
                                </div>
                                {{-- File --}}
                            @elseif ($type == 'file')
                                <input type="file" name="{{ $field->id }}" id="dy{{ $name }}" class="form-control" {{ $isRequired }}>
                            @endif
                        </div>
                    @endforeach
                    <div class="col-md-3 mb-2 d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <span class="btn-text">Save</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="leadExcelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Lead Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <div class="modal-body">
                    <form id="leadExcelForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Excel File</label>
                            <input type="file" name="excel" class="form-control"
                                   accept=".xls,.xlsx" required>
                        </div>
                        <div class="text-danger d-none" id="excelError"></div>
                    </form>
                </div>
    
                <div class="modal-footer">                   
                    <button type="button" class="btn btn-success" id="uploadExcelBtn">
                        Upload
                    </button>
                </div>
    
            </div>
        </div>
    </div>   
    <div class="modal fade" id="leadMeetingExcelModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <div class="modal-header">
                    <h5 class="modal-title">Upload Lead Meeting Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form id="leadMeetingExcelForm" enctype="multipart/form-data">
                    @csrf
    
                    <div class="modal-body">
                        <input type="file"
                               name="excel"
                               class="form-control"
                               accept=".xlsx,.xls,.csv"
                               required>
    
                        <span class="text-danger d-none" id="leadMeetingExcelError"></span>
                    </div>
    
                    <div class="modal-footer">
                        <button type="submit"
                                class="btn btn-primary"
                                id="uploadMeetingExcelBtn">
                            Upload
                        </button>
                    </div>
                </form>
    
            </div>
        </div>
    </div>    
    <script>
        $(function () {
            $('#filterNextMeetingDate').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                }
            });

            // Apply selected range
            $('#filterNextMeetingDate').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(
                    picker.startDate.format('YYYY-MM-DD') +
                    ' to ' +
                    picker.endDate.format('YYYY-MM-DD')
                );
            });

            // Clear input
            $('#filterNextMeetingDate').on('cancel.daterangepicker', function () {
                $(this).val('');
            });
        });
    </script>
    <script>        
    document.getElementById('lead_emp_error').addEventListener('change', function () {
        let empId = this.value;
        let leadType = document.getElementById('dylead_type');

        if (empId === '0') {
            // If Global selected
            leadType.value = 'global';

            // Disable Private option
            leadType.querySelector('option[value="private"]').disabled = true;
        } else {
            // Enable Private option
            leadType.querySelector('option[value="private"]').disabled = false;
        }
    });    
    </script>     
    <script>
        let contactIndex = 1;
        // ADD ROW
        $('#addContactBtn').on('click', function () {
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
        $(document).on('click', '.removeRow', function () {
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
        $(document).on('change', '.rowCheckbox', function () {
            toggleBulkDeleteBtn();
        });       
    </script>       
    <script>
        document.getElementById('openLeadForm').addEventListener('click', function() {
            let sidebar = new bootstrap.Offcanvas(document.getElementById('leadSidebarForm'));
            sidebar.show();
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#dynamicForm").on("submit", function(e) {
                e.preventDefault();

                let empId = $('#lead_emp_error').val();
                $('#lead_emp_error').removeClass('is-invalid');

                if (!empId) {
                    $('#lead_emp_error').addClass('is-invalid');
                    return;
                }

                let form = this;
                let formData = new FormData(form);

                // Define submit button
                let btn = $("#saveBtn");

                // Clear previous errors
                $(form).find('.text-danger').remove();
                $(form).find('.is-invalid').removeClass('is-invalid');

                // Button Loader
                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".spinner-border").removeClass("d-none");

                $.ajax({
                    url: "{{ route('admin.lead.master.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");

                        if (res.status === true) {
                            form.reset();
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: res.message,
                                showConfirmButton: false, 
                                timer: 3000,               
                                timerProgressBar: true
                            }).then(() => {
                                location.reload();     
                            });
                        }
                    },
                    error: function(err) {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");

                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;
                            $.each(errors, function(key, messages) {
                                let input = $('#dy' + key);

                                input.next('.text-danger').remove();
                                input.after('<span class="text-danger small">' +
                                    messages[0] + '</span>');
                                input.addClass('is-invalid');
                            });

                            // Scroll to first error field
                            let firstKey = Object.keys(errors)[0];
                            let firstInput = $('#' + firstKey);

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
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let leadTable = $('#datalistTable').DataTable({
                pageLength: 25,
                searching: false,
                lengthChange: false,
                info: false,
                paging: false,
                scrollY: '500px',
                scrollX: true,
                scrollCollapse: true,
                fixedHeader: true,
                autoWidth: false,
                columnDefs: [
                    { targets: '_all', className: 'dt-wrap-text' }
                ]
            });
            $(document).on('click', '.deleteDataBtn', function() {

                let groupId = $(this).data('group');
                let row = $(this).closest('tr');
                Swal.fire({
                    title: "Are you sure?",
                    text: "This form group will be deleted permanently!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "{{ route('admin.lead.master.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                group_id: groupId,
                            },

                            success: function(res) {
                                if (res.status) {
                                    Swal.fire("Deleted", res.message, "success");
                                    row.remove();
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },

                            error: function() {
                                Swal.fire("Error", "Something went wrong!", "error");
                            }
                        });

                    }
                });

            });
        });
    </script>
    <script>
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
    <script>
        const ASSET_URL = "{{ asset('') }}";
    </script>
    <script>
        function loadLeadMeetings(groupId) {
            let sidebar = new bootstrap.Offcanvas(
                document.getElementById('leadViewSidebar')
            );
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
    </script>
    <script>
        $(document).on('click', '.deleteMeetingBtn', function() {

            let meetingId = $(this).data('id');
            let btn = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: 'This meeting will be deleted permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {

                if (!result.isConfirmed) return;

                $.ajax({
                    url: `/admin/meetings-delete/${meetingId}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        toastr.success(res.message ?? 'Deleted successfully');

                        // Remove card / row from DOM
                        btn.closest('.meeting-item').fadeOut(300, function() {
                            $(this).remove();
                        });
                    },
                    error: function() {
                        toastr.error('Something went wrong!');
                    }
                });
            });
        });
    </script>
    <script>
        $('#bulkDeleteBtn').on('click', function () {
            // Prevent click if disabled
            if ($(this).hasClass('disabled')) return;

            // Get all selected group IDs
            let groupIds = $('.rowCheckbox:checked').map(function () {
                return this.value;
            }).get();

            if (groupIds.length === 0) return;

            Swal.fire({
                title: 'Are you sure?',
                text: 'Selected leads will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('admin.lead.master.bulkDelete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            group_ids: groupIds
                        },
                        success: function () {

                            Swal.fire(
                                'Deleted!',
                                'Selected leads have been deleted.',
                                'success'
                            );

                            // Remove deleted rows
                            $('.rowCheckbox:checked').closest('tr').remove();

                            // Disable button again
                            $('#bulkDeleteBtn').addClass('disabled');
                        },
                        error: function () {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                        }
                    });

                }
            });
        });
    </script>   
    <script>
        $(document).ready(function () {
        
            // Open modal
            $('#leadExcelUploadBtn').on('click', function () {
                $('#leadExcelForm')[0].reset();
                $('#excelError').addClass('d-none').text('');
                $('#leadExcelModal').modal('show');
            });
        
            // Upload Excel via AJAX
            $('#uploadExcelBtn').on('click', function () {
        
                let formData = new FormData($('#leadExcelForm')[0]);
        
                $.ajax({
                    url: "{{ route('admin.leads.excel.upload') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#uploadExcelBtn').prop('disabled', true).text('Uploading...');
                    },
                    success: function (res) {
                        $('#leadExcelModal').modal('hide');
                        $('#uploadExcelBtn').prop('disabled', false).text('Upload');
        
                        Swal.fire('Success', res.message, 'success');
        
                        // Reload DataTable if exists
                        Swal.fire('Success', res.message, 'success').then(() => {                            
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        $('#uploadExcelBtn').prop('disabled', false).text('Upload');
        
                        let msg = xhr.responseJSON?.message || 'Upload failed';
                        $('#excelError').removeClass('d-none').text(msg);
                    }
                });
            });
        
        });
    </script>  
    <script>
        $(document).ready(function () {
        
            // Open modal
            $('#leadMeetingExcelUploadBtn').on('click', function () {
                $('#leadMeetingExcelModal').modal('show');
            });
        
            // Submit Excel via AJAX
            $('#leadMeetingExcelForm').on('submit', function (e) {
                e.preventDefault();
        
                let formData = new FormData(this);
                $('#uploadMeetingExcelBtn').prop('disabled', true).text('Uploading...');
        
                $.ajax({
                    url: "{{ route('admin.lead.meeting.excel.upload') }}", // update if needed
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
        
                    success: function (res) {
                        $('#leadMeetingExcelModal').modal('hide');
                        $('#uploadMeetingExcelBtn').prop('disabled', false).text('Upload');
        
                        Swal.fire('Success', res.message, 'success').then(() => {
                            location.reload();
                        });
                    },
        
                    error: function (xhr) {
                        $('#uploadMeetingExcelBtn').prop('disabled', false).text('Upload');
        
                        let msg = xhr.responseJSON?.message ?? 'Excel upload failed';
                        $('#leadMeetingExcelError')
                            .removeClass('d-none')
                            .text(msg);
                    }
                });
            });
        
        });
    </script>  
   <script>
    function getFilters() {
        return {
            next_meeting_date: $('#filterNextMeetingDate').val(),
            label: $('#filterLabels').val(),
            employee: $('#filterEmployee').val(),
            area: $('#filterArea').val(),
            lead_type: $('#filterLeadType').val(),
            site_stage: $('#filterSiteStage').val(),
            project_type: $('#filterProjectType').val(),
            customer_type: $('#filterCustomerType').val(),
            sp_product: $('#filterSPProduct').val(),
            lead_source: $('#filterLeadSource').val(),

            bathroom_op: $('#bathroomOp').val(),
            bathroom: $('#filterBathroom').val(),

            floor_op: $('#floorOp').val(),
            floor: $('#filterFloor').val(),

            tower_op: $('#towerOp').val(),
            tower: $('#filterTower').val(),
            meeting_null: $('#meetingNull').is(':checked') ? 1 : 0,
            _token: '{{ csrf_token() }}'
        };
    }

    $('#applyFilters').on('click', function () {
        $('#pagediv').hide();
        if ($.fn.DataTable.isDataTable('#datalistTable')) {
            $('#datalistTable').DataTable().destroy();
        }
        $.ajax({
            url: "{{ route('admin.lead.master.filter') }}",
            type: "POST",
            data: getFilters(),
            beforeSend: function () {
                $('#leadTableBody').html(
                    '<tr><td colspan="100%" class="text-center">Loading...</td></tr>'
                );
            },
            success: function (response) {
                if (!response.success) {
                    Swal.fire({
                        icon: 'info',
                        title: 'No Data Found',
                        text: 'No leads match the selected filters.',
                        confirmButtonText: 'OK'
                    });

                    return;
                }

                $('#leadTableBody').html(response.html);
                $('#datalistTable').DataTable({
                    pageLength: 25,
                    searching: true,    
                    lengthChange: true,  
                    info: true,
                    paging: true,       
                    scrollY: '500px',
                    scrollX: true,
                    scrollCollapse: true,
                    fixedHeader: true,
                    autoWidth: false,
                    columnDefs: [
                        { targets: '_all', className: 'dt-wrap-text' }
                    ]
                });
            },
            error: function () {
                $('#leadTableBody').html(
                    '<tr><td colspan="100%" class="text-center">Error while loading leads</td></tr>'
                );
            }
        });
    });

    $('#clearFilters').on('click', function () {
        window.location.reload();
    });   
</script>
              
@endsection
