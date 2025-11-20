
<?php $__env->startSection('title', config('app.name') . ' || Create Employee'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Employee</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active">Create Employee</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Employee Details</h5>
                    </div>

                    <div class="card-body">
                        <form id="employeeForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <!-- Employee Name -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Employee Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Enter employee name">
                                    <span class="text-danger error-name"></span>
                                </div>

                                <!-- Email -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required
                                        placeholder="Enter email">
                                    <span class="text-danger error-email"></span>
                                </div>

                                <!-- Role -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-select" required>
                                        <option value="">Select Role</option>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="text-danger error-role"></span>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" required
                                        placeholder="Enter password">
                                    <span class="text-danger error-password"></span>
                                </div>

                                <!-- Profile Image -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control">
                                    <span class="text-danger error-profile_image"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label d-block">Status</label>
                                
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="status" value="1" id="status"
                                               <?php echo e(old('status', 1) ? 'checked' : ''); ?>>
                                
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="text-end">
                                <a href="<?php echo e(route('admin.employee.list')); ?>" class="btn btn-secondary">Cancel</a>

                                <button type="submit" id="saveBtn" class="btn btn-primary">
                                    <span class="btn-text">Create Employee</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#employeeForm").on('submit', function(e) {
                e.preventDefault();

                $("#saveBtn").attr("disabled", true);
                $("#saveBtn .btn-text").addClass('d-none');
                $("#saveBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "<?php echo e(route('admin.employee.store')); ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Employee created successfully");
                        $("#employeeForm")[0].reset();

                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');
                    },

                    error: function(xhr) {
                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-name').text(errors.name ?? '');
                            $('.error-email').text(errors.email ?? '');
                            $('.error-role').text(errors.role ?? '');
                            $('.error-password').text(errors.password ?? '');
                            $('.error-profile_image').text(errors.profile_image ?? '');
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });
        </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/employees/create.blade.php ENDPATH**/ ?>