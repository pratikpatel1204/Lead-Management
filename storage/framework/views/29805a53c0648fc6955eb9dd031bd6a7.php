
<?php $__env->startSection('title', config('app.name') . ' || Employee List'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Employee List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active" aria-current="page">Employee List</li>
                    </ol>
                </nav>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Employee')): ?>
                <a href="<?php echo e(route('admin.create.employee')); ?>" class="btn btn-primary mt-2 mt-md-0">
                    + Add Employee
                </a>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Role List</h4>
                    </div>
                    <div class="card-body">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="empTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th width="120">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td>
                                                <?php if($emp->profile_image): ?>
                                                    <img src="<?php echo e(asset($emp->profile_image)); ?>" width="40"
                                                        height="40" style="border-radius:50%;">
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('default/no-img.jpg')); ?>" width="40"
                                                        height="40" style="border-radius:50%;">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($emp->name); ?></td>
                                            <td><?php echo e($emp->email); ?></td>
                                            <td>
                                                <?php $__currentLoopData = $emp->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-success"><?php echo e($role->name); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td>
                                                <?php if($emp->status == 1): ?>
                                                    <span class="badge bg-primary">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Employee')): ?>
                                                    <?php if(!$emp->hasRole('super admin')): ?>
                                                        <a href="<?php echo e(route('admin.employee.edit', $emp->id)); ?>"
                                                            class="btn btn-sm btn-info">Edit</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Employee')): ?>
                                                    <?php if(!$emp->hasRole('Super Admin')): ?>
                                                        <button class="btn btn-sm btn-danger deleteEmployeeBtn"
                                                            data-id="<?php echo e($emp->id); ?>">
                                                            Delete
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let table = $('#empTable').DataTable();

            $(document).on('click', '.deleteEmployeeBtn', function() {
                let id = $(this).data('id');
                let url = "<?php echo e(url('admin/employee-delete')); ?>/" + id;
                let row = $(this).closest('tr'); // Get table row

                Swal.fire({
                    title: "Are you sure?",
                    text: "This employee will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>"
                            },
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire("Deleted!", res.message, "success");

                                    // ✅ Remove row without reloading page
                                    table.row(row).remove().draw(false);
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },
                            error: function(xhr) {
                                let message = "Something went wrong!";

                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                Swal.fire("Error", message, "error");
                            }
                        });
                    }
                });
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/employees/list.blade.php ENDPATH**/ ?>