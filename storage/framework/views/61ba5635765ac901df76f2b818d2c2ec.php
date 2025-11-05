
<?php $__env->startSection('title', config('app.name') . ' || Services'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Services List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Services</li>
                        <li class="breadcrumb-item active" aria-current="page">Service List</li>
                    </ol>
                </nav>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Service')): ?>
                <a href="<?php echo e(route('admin.create.services')); ?>" class="btn btn-primary mt-2 mt-md-0">
                    + Add Service
                </a>
            <?php endif; ?>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Service List</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="serviceTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($service->category->title ?? 'N/A'); ?></td>
                                    <td><?php echo e($service->title); ?></td>

                                    <td>
                                        <?php if($service->image): ?>
                                            <img src="<?php echo e(asset($service->image)); ?>" width="60" height="60"
                                                style="object-fit:cover;">
                                        <?php else: ?>
                                            <span class="text-muted">No Image</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo e($service->created_at->format('d M, Y')); ?></td>

                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Service Edit')): ?>
                                            <a href="<?php echo e(route('admin.services.edit', $service->id)); ?>"
                                                class="btn btn-sm btn-info">Edit</a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Service Delete')): ?>
                                        <button data-id="<?php echo e($service->id); ?>"
                                            class="btn btn-sm btn-danger deleteServiceBtn">
                                            Delete
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No Services Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#serviceTable').DataTable();
            $(document).on('click', '.deleteServiceBtn', function() {
                let id = $(this).data('id');
        
                Swal.fire({
                    title: "Are you sure?",
                    text: "This service will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
        
                        $.ajax({
                            url: "<?php echo e(url('admin/services-delete')); ?>/" + id,
                            type: "DELETE",
                            data: { _token: "<?php echo e(csrf_token()); ?>" },
                            success: function(res) {
                                if (res.success) {
                                    Swal.fire("Deleted!", "Service deleted successfully!", "success");
                                    table.row(row).remove().draw(false);
                                } else {
                                    Swal.fire("Error", "Something went wrong!", "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Error", "Server error occurred!", "error");
                            }
                        });
        
                    }
                });
        
            });
        
        });
        </script>
        
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/service/list_service.blade.php ENDPATH**/ ?>