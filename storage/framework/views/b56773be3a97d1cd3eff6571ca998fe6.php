
<?php $__env->startSection('title', config('app.name') . ' || Template Data List'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Template Data List</h2>

        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.create.template.data')); ?>" class="btn btn-primary">
                <i class="ti ti-circle-plus"></i> Create New Form
            </a>

            <a href="#" class="btn btn-success">
                <i class="ti ti-upload"></i> Bulk Upload
            </a>
        </div>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $templateData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $templateName => $dataSet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card mb-5 shadow-sm">

            <div class="card-header bg-primary text-white">
                <h4 class="text-white mb-0"><?php echo e($templateName); ?></h4>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-light">

                            <!-- Dynamic Header From Template Fields -->
                            <?php $__currentLoopData = $dataSet['fields']->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($fieldName); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $dataSet['groups']->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupId => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <!-- Field Values -->
                                <?php $__currentLoopData = $dataSet['fields']->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldId => $fieldName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $value = $records->firstWhere('field_id', $fieldId)->field_value ?? '-';
                                    ?>
                                    <td><?php echo e($value); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <!-- Actions -->
                                <td>
                                    <a href="<?php echo e(route('admin.template.data.edit' , $groupId)); ?>" class="btn btn-info btn-sm text-white">
                                        Edit
                                    </a>

                                    <button class="btn btn-danger btn-sm deleteDataBtn" data-id="<?php echo e($groupId); ?>">
                                        Delete
                                    </button>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>

            </div>
        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-info text-center">No Template Data Found</div>
    <?php endif; ?>

</div>

<!-- Delete Script -->
<script>
    $(document).on('click', '.deleteDataBtn', function () {

        let id = $(this).data('id');
        let url = "<?php echo e(url('admin/template-data-delete')); ?>/" + id;
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
                    url: url,
                    type: "DELETE",
                    data: { _token: "<?php echo e(csrf_token()); ?>" },
                    success: function (res) {
                        if (res.status) {
                            Swal.fire("Deleted", res.message, "success");
                            row.remove();
                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "Something went wrong!", "error");
                    }
                });

            }
        });

    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/template_data/list.blade.php ENDPATH**/ ?>