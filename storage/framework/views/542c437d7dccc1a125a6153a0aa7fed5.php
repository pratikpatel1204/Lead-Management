
<?php $__env->startSection('title', config('app.name') . ' || Field Types'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">

    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Field Types</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active">Field Types</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
            <div class="mb-2">
                <a href="<?php echo e(route('admin.create.field.type')); ?>" class="btn btn-primary d-flex align-items-center">
                    <i class="ti ti-circle-plus me-2"></i>Add Field Type
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Field Name</th>
                            <th>Field Value</th>
                            <th width="120" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $fieldTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr id="row-<?php echo e($type->id); ?>">
                                <td><?php echo e($key + 1); ?></td>
                                <td><?php echo e($type->name); ?></td>
                                <td><?php echo e($type->value); ?></td>                            
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.field.type.edit', $type->id)); ?>"
                                        class="btn btn-sm btn-info me-1">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger deleteFieldTypeBtn"
                                        data-id="<?php echo e($type->id); ?>">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No Field Types Found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Table -->

</div>

<!-- Delete Script -->
<script>
    $(document).on('click', '.deleteFieldTypeBtn', function() {
        let id = $(this).data('id');
        let url = "<?php echo e(url('admin/field-type-delete')); ?>/" + id;

        Swal.fire({
            title: "Are you sure?",
            text: "This field type will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire("Deleted!", res.message, "success");
                            $("#row-" + id).remove();
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/field/field_type_list.blade.php ENDPATH**/ ?>