
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

                            <div class="mb-3">
                                <label class="form-label">Employee Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="<?php echo e($employee->name); ?>" class="form-control"
                                    required>
                                <span class="text-danger error-name"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="<?php echo e($employee->email); ?>" class="form-control"
                                    required>
                                <span class="text-danger error-email"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role->name); ?>"
                                            <?php if($employee->roles->first()->name == $role->name): ?> selected <?php endif; ?>>
                                            <?php echo e($role->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="text-danger error-role"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password">
                                <span class="text-danger error-password"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                                <span class="text-danger error-profile_image"></span>

                                <?php if($employee->profile_image): ?>
                                    <img src="<?php echo e(asset($employee->profile_image)); ?>" width="80" class="mt-2 rounded">
                                <?php endif; ?>
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
                            $('.error-name').text(errors.name ?? '');
                            $('.error-email').text(errors.email ?? '');
                            $('.error-role').text(errors.role ?? '');
                            $('.error-profile_image').text(errors.profile_image ?? '');
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });
        </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/employees/edit.blade.php ENDPATH**/ ?>