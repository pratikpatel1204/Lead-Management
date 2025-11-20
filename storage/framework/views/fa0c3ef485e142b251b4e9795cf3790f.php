
<?php $__env->startSection('title', config('app.name') . ' || Create Template Permission'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Create Template Permission</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Permissions</li>
                    <li class="breadcrumb-item active" aria-current="page">Template Permission</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Create Template Permission</h5>
                </div>
                <div class="card-body">
                    <form id="templatePermissionForm">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">
                                Select Template <span class="text-danger">*</span>
                            </label>
                            <select name="name" class="form-control" required>
                                <option value="">-- Select Template --</option>
                                <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->name); ?>">
                                        <?php echo e($item->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-danger error-name"></span>
                        </div>

                        <div class="text-end">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Permissions')): ?>
                            <a href="<?php echo e(route('admin.permissions.list')); ?>" class="btn btn-secondary">Cancel</a>
                            <?php endif; ?>

                            <button type="submit" id="saveBtn" class="btn btn-primary">
                                <span class="btn-text">Create Permission</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        $("#templatePermissionForm").on('submit', function(e) {
            e.preventDefault();

            $("#saveBtn").attr("disabled", true);
            $("#saveBtn .btn-text").addClass('d-none');
            $("#saveBtn .spinner-border").removeClass('d-none');

            $.ajax({
                url: "<?php echo e(route('admin.permissions.store')); ?>",
                type: "POST",
                data: $(this).serialize(),

                success: function(res) {
                    toastr.success("Permission created successfully");
                    $("#templatePermissionForm")[0].reset();

                    $("#saveBtn").attr("disabled", false);
                    $("#saveBtn .btn-text").removeClass('d-none');
                    $("#saveBtn .spinner-border").addClass('d-none');
                },

                error: function(xhr) {
                    $("#saveBtn").attr("disabled", false);
                    $("#saveBtn .btn-text").removeClass('d-none');
                    $("#saveBtn .spinner-border").addClass('d-none');

                    if (xhr.status === 422) {
                        $('.error-name').text(xhr.responseJSON.errors.name);
                        toastr.error(xhr.responseJSON.errors.name);
                    } else {
                        toastr.error("Something went wrong!");
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/permissions/create_template_permissions.blade.php ENDPATH**/ ?>