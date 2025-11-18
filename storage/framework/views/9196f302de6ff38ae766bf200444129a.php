
<?php $__env->startSection('title', config('app.name') . ' || Template List'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Template List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Configuration</li>
                        <li class="breadcrumb-item active">Templates</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    <a href="<?php echo e(route('admin.create.template')); ?>" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Add Template
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $templateName => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-xxl-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Header -->
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white"><?php echo e($templateName); ?></h5>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.template.edit', $templateName)); ?>"
                                    class="btn btn-sm btn-light text-primary">
                                    <i class="ti ti-edit me-1"></i> Edit
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger deleteTemplateBtn"
                                    data-name="<?php echo e($templateName); ?>">
                                    <i class="ti ti-trash me-1"></i> Delete
                                </a>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div
                                        class="border rounded p-2 px-3 bg-light d-flex align-items-center justify-content-between">
                                        <span class="fw-semibold text-dark small mb-0 text-truncate">
                                            <?php echo e($template->field->name ?? 'N/A'); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="alert alert-info text-center">
                    No templates found.
                </div>
            <?php endif; ?>
        </div>
        <div class="my-4">
            <?php echo e($templates->links()); ?>

        </div> 
    </div>

    <!-- JS Section -->
    <script>
        $(document).on('click', '.deleteTemplateBtn', function() {
            let name = $(this).data('name'); // corrected from 'id' to 'name'
            let url = "<?php echo e(url('admin/template-delete')); ?>/" + name; // group delete route
            let card = $(this).closest('.col-md-6');

            Swal.fire({
                title: "Are you sure?",
                text: "This entire template group will be permanently deleted!",
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
                            if (res.status) {
                                Swal.fire("Deleted!", res.message, "success");
                                card.remove();
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

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/template/list.blade.php ENDPATH**/ ?>