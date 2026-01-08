
<?php $__env->startSection('title', config('app.name') . ' || Lead Master'); ?>
<?php $__env->startSection('content'); ?>
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
    </style>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-2">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Lead List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Lead Master</li>
                        <li class="breadcrumb-item active" aria-current="page">Lead List</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm mt-2 mt-md-0" id="openLeadForm">
                    <i class="ti ti-plus"></i>
                    <span>Lead Master</span>
                </a>
                <a href="javascript:void(0)" class="btn btn-info btn-sm mt-2 mt-md-0" id="SerializeTableForm">
                    <i class="ti ti-arrows-exchange"></i>
                    <span>Serialize Table</span>
                </a>
                <a href="javascript:void(0)" class="btn btn-success btn-sm mt-2 mt-md-0" id="leadExcelUploadBtn">
                    <i class="ti ti-file-upload"></i>
                    <span>Lead Excel Upload</span>
                </a>     
                <a href="javascript:void(0)" class="btn btn-warning btn-sm mt-2 mt-md-0" id="leadMeetingExcelUploadBtn">
                    <i class="ti ti-file-upload"></i>
                    <span>Lead Meeting Excel Upload</span>
                </a>                                        
                <button id="bulkDeleteBtn" class="btn btn-danger btn-sm mt-2 mt-md-0 disabled">
                    <i class="ti ti-trash"></i> Delete Selected
                </button>
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
                                        <div class="row g-2">
                                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                                <div class="border rounded p-1 px-2 d-flex align-items-center gap-1">
                                                    <span class="fw-bold small">All Leads:</span>
                                                    <span class="fw-bold text-primary"><?php echo e($all_leads); ?></span>
                                                </div>
                                                <div class="border rounded p-1 px-2 d-flex align-items-center gap-1">
                                                    <span class="fw-bold small">Active:</span>
                                                    <span class="fw-bold text-success"><?php echo e($total_active); ?></span>
                                                </div>
                                                <div class="border rounded p-1 px-2 d-flex align-items-center gap-1">
                                                    <span class="fw-bold small">Closed:</span>
                                                    <span class="fw-bold text-danger"><?php echo e($total_Closed); ?></span>
                                                </div>
                                                <div class="border rounded p-1 px-2 d-flex align-items-center gap-1">
                                                    <span class="fw-bold small">Private:</span>
                                                    <span class="fw-bold text-warning"><?php echo e($private_leads); ?></span>
                                                </div>
                                                <div class="border rounded p-1 px-2 d-flex align-items-center gap-1">
                                                    <span class="fw-bold small">Global:</span>
                                                    <span class="fw-bold text-info"><?php echo e($globle_leads); ?></span>
                                                </div>
                                            </div>
                                        </div>
                
                                        <!-- Filters -->
                                        <div class="row g-2 mt-2">
                
                                            <div class="col-md-3">
                                                <input type="date" id="filterNextMeetingDate" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <select id="filterLabels" class="form-select select2" multiple data-placeholder="Select Labels">
                                                    <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($label); ?>"><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterEmployee" class="form-select select2" multiple data-placeholder="Select Employee">
                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($user->id); ?>">
                                                            <?php echo e($user->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterArea" class="form-select select2" multiple data-placeholder="Select Area">
                                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterLeadType" class="form-select select2" multiple data-placeholder="Select Lead Type">
                                                    <?php $__currentLoopData = $leadTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterSiteStage" class="form-select select2" multiple data-placeholder="Select Site Stage">
                                                    <?php $__currentLoopData = $siteStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterProjectType" class="form-select select2" multiple data-placeholder="Select Project Type">
                                                    <?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterCustomerType" class="form-select select2" multiple data-placeholder="Select Customer Type">
                                                    <?php $__currentLoopData = $customerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterSPProduct" class="form-select select2" multiple data-placeholder="Select SP Focused Product">
                                                    <?php $__currentLoopData = $spProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                
                                            <div class="col-md-3">
                                                <select id="filterLeadSource" class="form-select select2" multiple data-placeholder="Select Lead Source">
                                                    <?php $__currentLoopData = $leadSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <th>#</th>
                
                                
                                <?php
                                    $columns = !empty($fieldsorder) ? array_unique($fieldsorder) : $tablefield->pluck('field.name')->toArray();
                                ?>
                
                                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($col); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                
                        <tbody id="leadTableBody">
                            <?php $__currentLoopData = $finalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowSet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $groupId = $rowSet['form_group_id'];
                                    $leadRows    = collect($rowSet['lead'])->keyBy('field_name');
                                    $meetingRows = collect($rowSet['meeting'])->keyBy('label');
                                    $platform    = strtolower(optional($meetingRows->firstWhere('label', 'Platform'))->value ?? '');
                                ?>
                
                                <tr>
                                    <td>
                                        <input type="checkbox" class="rowCheckbox" value="<?php echo e($groupId); ?>">
                                    </td>
                
                                    
                                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $leadRec    = $leadRows[$col] ?? null;
                                            $meetingRec = $meetingRows[$col] ?? null;
                                        ?>
                
                                        <td>
                                            
                                            <?php if($leadRec): ?>
                                                <?php if($leadRec->field_name === 'Site Name'): ?>
                                                    <a href="javascript:void(0)" class="text-primary viewLeadBtn" data-group="<?php echo e($groupId); ?>">
                                                        <?php echo e($leadRec->field_value); ?>

                                                    </a>
                                                <?php elseif($leadRec->field_name === 'Lead Type'): ?>
                                                    <?php
                                                        $type = strtolower($leadRec->field_value);
                                                        $badgeClass = $type === 'private' ? 'bg-warning text-dark' : ($type === 'global' ? 'bg-success' : 'bg-secondary');
                                                    ?>
                                                    <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($leadRec->field_value)); ?></span>
                                                <?php elseif(Str::endsWith($leadRec->field_value, ['jpg','jpeg','png','gif','webp'])): ?>
                                                    <img src="<?php echo e(asset($leadRec->field_value)); ?>" width="50">
                                                <?php elseif(Str::endsWith($leadRec->field_value, 'pdf')): ?>
                                                    <a href="<?php echo e(asset($leadRec->field_value)); ?>" target="_blank" class="btn btn-sm btn-danger">View PDF</a>
                                                <?php else: ?>
                                                    <?php echo e($leadRec->field_value ?? '-'); ?>

                                                <?php endif; ?>
                
                                            
                                            <?php elseif($meetingRec): ?>
                                                <?php if($meetingRec->label === 'Meeting Status'): ?>
                                                    <span class="badge bg-warning"><?php echo e(ucfirst($meetingRec->value)); ?></span>
                                                <?php elseif(in_array($meetingRec->label, ['Next Meeting Date','Platform'])): ?>
                                                    <?php
                                                        $date = $meetingRec->value ?? null;
                                                    ?>
                                                    
                                                    <?php if(!empty($date) && $date != 'NULL'): ?>
                                                        <?php echo e(\Carbon\Carbon::parse($date)->format('d-M-y (D)')); ?>

                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>                                                
                                                    <br>
                                                    <span class="badge bg-info"><?php echo e($rowSet['meeting_count']); ?></span>
                                                    <?php if($platform === 'desktop'): ?>
                                                        <i class="fa fa-desktop text-success" title="Desktop"></i>
                                                    <?php elseif($platform === 'mobile'): ?>
                                                        <i class="fa fa-mobile-alt text-success" title="Mobile"></i>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php echo e($meetingRec->value ?? '-'); ?>

                                                <?php endif; ?>
                
                                            
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                                    
                                    <td class="text-center">
                                        <a href="<?php echo e(route('admin.lead.master.edit', $groupId)); ?>" class="btn btn-info btn-sm text-white me-1">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm deleteDataBtn" data-group="<?php echo e($groupId); ?>">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagediv">
                    <?php echo e($finalData->links()); ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Field Order Modal -->
    <div class="modal fade" id="fieldOrderModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Field Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="sortcrateform">
                    <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Field Order (Check & Drag to Sort)</label>                
                            <?php
                                $savedFields = !empty($fieldsorder) ? array_unique($fieldsorder) : [];
                                $allFields   = $tablefield->pluck('field.name')->toArray();
                                $remainingFields = array_diff($allFields, $savedFields);
                            ?>

                            <ul id="sortableFields" class="list-group mb-3">
                                <?php $__currentLoopData = $savedFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between"
                                        data-key="<?php echo e($fieldName); ?>">

                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-menu-2 text-muted drag-handle"></i>

                                            <input type="checkbox"
                                                class="field-checkbox"
                                                value="<?php echo e($fieldName); ?>"
                                                checked>

                                            <span><?php echo e($fieldName); ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $remainingFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between"
                                        data-key="<?php echo e($fieldName); ?>">

                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-menu-2 text-muted drag-handle"></i>

                                            <input type="checkbox"
                                                class="field-checkbox"
                                                value="<?php echo e($fieldName); ?>">

                                            <span><?php echo e($fieldName); ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <input type="hidden" name="field_order" id="fieldOrder">
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                
                        <button type="submit" class="btn btn-primary" id="saveFieldOrder">
                            <span class="btn-text">Save Order</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>                
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
    <div id="leadSidebarForm" class="offcanvas offcanvas-end lead-sidebar" tabindex="-1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Lead Master</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="dynamicForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <?php if(auth()->user()->role === 'super admin'): ?>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">Select User <span class="text-danger">*</span></label>
                                <select name="lead_emp_id" class="form-control" id="lead_emp_error" required>
                                    <option value="">Select User</option>
                                    <option value="0">All User</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>">
                                            <?php echo e($user->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="lead_emp_id" id="lead_emp_error" value="<?php echo e(auth()->id()); ?>">
                    <?php endif; ?>
                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $field = $t->field;
                            $label = $field->name;
                            $name = Str::slug($field->name, '_');
                            $type = $field->type;
                            $isRequired = $field->validation == 'required' ? 'required' : '';
                            $defaultValue = $field->default_value;
                        ?>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo e($label); ?> 
                                <?php if($isRequired): ?>
                                    <span class="text-danger">*</span>
                                <?php endif; ?>
                            </label>

                            
                            <?php if(in_array($type, ['text', 'email', 'number'])): ?>
                                <input type="<?php echo e($type); ?>" name="<?php echo e($field->id); ?>" class="form-control" id="dy<?php echo e($name); ?>" <?php echo e($isRequired); ?>>
                                                        
                            
                            <?php elseif($type == 'textarea'): ?>
                                <textarea name="<?php echo e($field->id); ?>" class="form-control" id="dy<?php echo e($name); ?>" rows="3" <?php echo e($isRequired); ?>></textarea>

                                
                            <?php elseif($type == 'select'): ?>
                                <select name="<?php echo e($field->id); ?>" id="dy<?php echo e($name); ?>" class="form-select" <?php echo e($isRequired); ?>>
                                    <option value="">Select <?php echo e($label); ?></option>
                                    <?php $__currentLoopData = $field->dropdowns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($opt->value); ?>"><?php echo e($opt->label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                
                            <?php elseif($type == 'radio'): ?>
                                <?php
                                    $options = is_array($field->options) ? $field->options : explode(',', $field->options);
                                ?>
                                <div class="d-flex flex-wrap mt-2">
                                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $opt = trim($opt); ?>
                                        <label class="me-3">
                                            <input type="radio" name="<?php echo e($field->id); ?>" id="<?php echo e($name . '_' . $opt); ?>" value="<?php echo e($opt); ?>" <?php echo e($defaultValue == $opt ? 'checked' : ''); ?> <?php echo e($isRequired ? 'required' : ''); ?>>
                                            <?php echo e($opt); ?>

                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                            <?php elseif($type == 'file'): ?>
                                <input type="file" name="<?php echo e($field->id); ?>" id="dy<?php echo e($name); ?>" class="form-control" <?php echo e($isRequired); ?>>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <span class="btn-text">Save</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
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
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Select Excel File</label>
                            <input type="file" name="excel" class="form-control"
                                   accept=".xls,.xlsx" required>
                        </div>
                        <div class="text-danger d-none" id="excelError"></div>
                    </form>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                        Cancel
                    </button>
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
                    <?php echo csrf_field(); ?>
    
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

        document.getElementById('SerializeTableForm').addEventListener('click', function () {        
            let modal = new bootstrap.Modal(
                document.getElementById('fieldOrderModal')
            );
            modal.show();
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).on('shown.bs.modal', '#fieldOrderModal', function () {
        
            let $sortable = $("#sortableFields");
        
            if (!$sortable.hasClass("ui-sortable")) {
        
                $sortable.sortable({
                    handle: ".ti-menu-2",
                    placeholder: "ui-state-highlight",
                    update: function () {
                        serializeFields();
                    }
                });
        
                $sortable.disableSelection();
            }
        
            serializeFields();
        });
        
        // Serialize ONLY checked fields (in sorted order)
        function serializeFields() {
            let order = [];
        
            $("#sortableFields li").each(function () {
                let checkbox = $(this).find('.field-checkbox');
        
                if (checkbox.is(':checked')) {
                    order.push($(this).data("key"));
                }
            });
        
            $("#fieldOrder").val(order.join(','));
        }
        
        // Re-serialize on checkbox toggle
        $(document).on('change', '.field-checkbox', function () {
            serializeFields();
        });
        
        // Save
        $(document).on('click', '#saveFieldOrder', function (e) {
            e.preventDefault();
        
            let $btn = $(this);
            serializeFields();
        
            $btn.prop('disabled', true);
            $btn.find('.btn-text').addClass('d-none');
            $btn.find('.btn-loader').removeClass('d-none');
        
            $.ajax({
                url: "<?php echo e(route('admin.lead.field.order.save')); ?>",
                type: "POST",
                data: $('#sortcrateform').serialize(),
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                success: function (res) {
                    toastr.success(res.message ?? 'Field order saved successfully');
                    $('#fieldOrderModal').modal('hide');
                    location.reload();
                },
                error: function () {
                    toastr.error('Failed to save field order');
                },
                complete: function () {
                    $btn.prop('disabled', false);
                    $btn.find('.btn-text').removeClass('d-none');
                    $btn.find('.btn-loader').addClass('d-none');
                }
            });
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
                    url: "<?php echo e(route('admin.lead.master.store')); ?>",
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
                                confirmButtonText: 'OK'
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
                            url: "<?php echo e(route('admin.lead.master.delete')); ?>",
                            type: "POST",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
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
        const ASSET_URL = "<?php echo e(asset('')); ?>";
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
                        _token: '<?php echo e(csrf_token()); ?>'
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
                        url: "<?php echo e(route('admin.lead.master.bulkDelete')); ?>",
                        type: "POST",
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>",
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
                    url: "<?php echo e(route('admin.leads.excel.upload')); ?>",
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
                    url: "<?php echo e(route('admin.lead.meeting.excel.upload')); ?>", // update if needed
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

            _token: '<?php echo e(csrf_token()); ?>'
        };
    }

    $('#applyFilters').on('click', function () {
        $('#pagediv').hide();
        if ($.fn.DataTable.isDataTable('#datalistTable')) {
            $('#datalistTable').DataTable().destroy();
        }
        $.ajax({
            url: "<?php echo e(route('admin.lead.master.filter')); ?>",
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
              
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/lead/list.blade.php ENDPATH**/ ?>