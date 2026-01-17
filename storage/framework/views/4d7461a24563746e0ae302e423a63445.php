
<?php $__env->startSection('title', config('app.name') . ' || Edit Employee'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Employee</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active">Edit Employee</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Update Employee</h5>
                    </div>

                    <div class="card-body">
                        <form id="employeeEditForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" name="employee_id" value="<?php echo e($employee->employee_id); ?>" class="form-control" placeholder="Enter Employee ID">
                                    <span class="text-danger error-employee_id"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Employee Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="<?php echo e($employee->name); ?>" class="form-control"
                                        required placeholder="Enter employee name">
                                    <span class="text-danger error-name"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Select Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-select" id="designation">
                                        <option value="">Select Designation</option>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->name); ?>" data-id="<?php echo e($role->id); ?>"
                                                <?php echo e($employee->role == $role->name ? 'selected' : ''); ?>>
                                                <?php echo e($role->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>                                    
                                    <span class="text-danger error-role"></span>
                                </div>                            
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="<?php echo e($employee->email); ?>" class="form-control"
                                        required placeholder="Enter email">
                                    <span class="text-danger error-email"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter new password (leave blank to keep current)">
                                    <span class="text-danger error-password"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Personal Email</label>
                                    <input type="email" name="personal_email" value="<?php echo e($employee->personal_email); ?>" class="form-control" placeholder="Enter personal email">
                                    <span class="text-danger error-personal_email"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="number" name="mobile" class="form-control" value="<?php echo e($employee->mobile); ?>" placeholder="Enter mobile number">
                                    <span class="text-danger error-mobile"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                                    <input type="number" name="whatsapp_number" class="form-control" value="<?php echo e($employee->whatsapp_number); ?>" placeholder="Enter WhatsApp number">
                                    <span class="text-danger error-whatsapp_number"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>                                
                                    <textarea name="address" class="form-control" rows="3" placeholder="Enter address"><?php echo e($employee->address); ?></textarea>                                
                                    <span class="text-danger error-address"></span>
                                </div>                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select class="form-select" id="state_id" name="state_id">
                                        <option value="">Select State</option>
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->id); ?>" <?php echo e($employee->state_id == $state->id ? 'selected' : ''); ?>>
                                            <?php echo e($state->name); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="text-danger error-state_id"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select class="form-select" id="city_id" name="city_id" data-selected="<?php echo e($employee->city_id); ?>">
                                        <option value="">Select City</option>
                                    </select>
                                    <span class="text-danger error-city_id"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" name="pincode" value="<?php echo e($employee->pincode); ?>" class="form-control" placeholder="Enter pincode">
                                    <span class="text-danger error-pincode"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Reporting Manager <span class="text-danger">*</span></label>
                                    <select name="reporting_manager" value="<?php echo e($employee->reporting_manager); ?>" class="form-select" id="reporting_manager" data-selected="<?php echo e($employee->reporting_manager); ?>">
                                        <option value="">Select Manager</option>
                                    </select>
                                    <span class="text-danger error-reporting_manager"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">FCM Token</label>
                                    <input type="text" name="fcm_token" value="<?php echo e($employee->fcm_token); ?>" class="form-control" placeholder="Enter FCM Token">                                    
                                    <span class="text-danger error-fcm_token"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">PAN Card Number</label>
                                    <input type="text" name="pan_number" value="<?php echo e($employee->pan_number); ?>" class="form-control" placeholder="Enter PAN number">                                    
                                    <span class="text-danger error-pan_number"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">PAN Card Image</label>
                                    <input type="file" name="pan_image" class="form-control">
                                    <span class="text-danger error-pan_image"></span>
                                    <?php if($employee->pan_image): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e(asset($employee->pan_image)); ?>" width="80" class="rounded border">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Aadhar Card Number</label>
                                    <input type="number" name="aadhar_number" value="<?php echo e($employee->aadhar_number); ?>" class="form-control" placeholder="Enter Aadhar number">
                                    <span class="text-danger error-aadhar_number"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Aadhar Card Image</label>
                                    <input type="file" name="aadhar_image" class="form-control">
                                    <span class="text-danger error-aadhar_image"></span>
                                    <?php if($employee->aadhar_image): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e(asset($employee->aadhar_image)); ?>" width="80" class="rounded border">
                                        </div>
                                    <?php endif; ?>
                                </div>                               
                                <!-- Profile Image -->
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control">
                                    <span class="text-danger error-profile_image"></span>

                                    <?php if($employee->profile_image): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e(asset($employee->profile_image)); ?>" width="80" class="rounded border">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label d-block">Status</label>
                                
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="status" value="1" id="status"
                                               <?php echo e(old('status', $employee->status) == 1 ? 'checked' : ''); ?>>
                                
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>                                
                            </div>

                            <div class="text-end">
                                <a href="<?php echo e(route('admin.employee.list')); ?>" class="btn btn-secondary">Cancel</a>
                                <button type="submit" id="updateBtn" class="btn btn-primary">
                                    <span class="btn-text">Update Employee</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#employeeEditForm").on('submit', function(e) {
                e.preventDefault();

                $("#updateBtn").attr("disabled", true);
                $("#updateBtn .btn-text").addClass('d-none');
                $("#updateBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "<?php echo e(route('admin.employee.update')); ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Employee updated successfully");

                        $("#updateBtn").attr("disabled", false);
                        $("#updateBtn .btn-text").removeClass('d-none');
                        $("#updateBtn .spinner-border").addClass('d-none');

                        setTimeout(() => {
                            window.location.href = "<?php echo e(route('admin.employee.list')); ?>";
                        }, 1000);
                    },

                    error: function(xhr) {

                        $("#updateBtn").attr("disabled", false);
                        $("#updateBtn .btn-text").removeClass('d-none');
                        $("#updateBtn .spinner-border").addClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $('.error-' + key).text(value[0]);
                            });
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                function loadCities(stateId, selectedCityId = null) {
                    const $city = $('#city_id');
                    $city.html('<option value="">Select City</option>');

                    if (!stateId) return;

                    $.ajax({
                        url: `/get-cities/${stateId}`,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(city => {
                                $city.append(
                                    `<option value="${city.id}" ${selectedCityId == city.id ? 'selected' : ''}>${city.name}</option>`
                                );
                            });
                        },
                        error: function() {
                            console.error("Failed to load cities");
                        }
                    });
                }

                // On state change
                $('#state_id').on('change', function() {
                    loadCities($(this).val());
                });

                // On page load (edit case)
                const selectedState = $('#state_id').val();
                const selectedCity = $('#city_id').data('selected');

                if (selectedState) {
                    loadCities(selectedState, selectedCity);
                }

                function loadReportingManagers(roleId, selectedManagerId = null) {
                    const $manager = $('#reporting_manager');
                    $manager.html('<option value="">Select Manager</option>');

                    if (!roleId) return;

                    $.ajax({
                        url: `/get-reporting-managers/${roleId}`,
                        type: 'GET',
                        success: function(data) {
                            if (data.length === 0) {
                                $manager.append('<option value="">No Manager Found</option>');
                            }

                            data.forEach(manager => {
                                $manager.append(`
                        <option value="${manager.id}" ${selectedManagerId == manager.id ? 'selected' : ''}>
                            ${manager.name}
                        </option>
                    `);
                            });
                        },
                        error: function() {
                            console.error('Failed to load reporting managers');
                        }
                    });
                }

                // On designation change                
                $('#designation').on('change', function() {
                    loadReportingManagers($(this).val());
                });
                // Edit page load support            
                const selectedRoleId = $('#designation').val();
                const selectedManager = $('#reporting_manager').data('selected');
                if (selectedRoleId) {
                    loadReportingManagers(selectedRoleId, selectedManager);
                }

            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/employees/edit.blade.php ENDPATH**/ ?>