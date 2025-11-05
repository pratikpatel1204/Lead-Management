
<?php $__env->startSection('title', config('app.name') . ' || Edit Service'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Edit Service</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Services</li>
                    <li class="breadcrumb-item active">Edit Service</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Service Details</h5>
                </div>

                <div class="card-body">
                    <form id="serviceEditForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($service->id); ?>">
                        <div class="mb-3">
                            <label class="form-label">Service Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e($service->category_id == $cat->id ? 'selected' : ''); ?>>
                                        <?php echo e($cat->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-danger error-category_id"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Service Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?php echo e($service->title); ?>" required>
                            <span class="text-danger error-title"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="summernote" name="description"><?php echo $service->description; ?></textarea>
                            <span class="text-danger error-description"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Service Image</label>
                            <input type="file" name="image" class="form-control">
                            <span class="text-danger error-image"></span>

                            <?php if($service->image): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e(asset($service->image)); ?>" width="100">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="text-end">
                            <a href="<?php echo e(route('admin.services.list')); ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" id="updateBtn" class="btn btn-primary">
                                <span class="btn-text">Update Service</span>
                                <span class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
$("#serviceEditForm").on('submit', function(e) {
    e.preventDefault();

    $("#updateBtn").attr("disabled", true);
    $("#updateBtn .btn-text").addClass('d-none');
    $("#updateBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);

    $.ajax({
        url: "<?php echo e(route('admin.services.update')); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(res) {
            toastr.success("Service updated successfully");

            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');
            
            setTimeout(() => {
                window.location.href = "<?php echo e(route('admin.services.list')); ?>";
            }, 800);
        },

        error: function(xhr) {
            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-category_id').text(errors.category_id ?? '');
                $('.error-title').text(errors.title ?? '');
                $('.error-description').text(errors.description ?? '');
                $('.error-image').text(errors.image ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/service/edit_service.blade.php ENDPATH**/ ?>