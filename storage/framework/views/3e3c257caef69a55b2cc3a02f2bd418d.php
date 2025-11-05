
<?php $__env->startSection('title', config('app.name') . ' || Create Banner'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Create Banner</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Banner</li>
                    <li class="breadcrumb-item active">Create Banner</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Banner Details</h5>
                </div>

                <div class="card-body">
                    <form id="bannerForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label">Banner Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="Enter Banner Title">
                            <span class="text-danger error-title"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Banner Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" required>
                            <span class="text-danger error-image"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <span class="text-danger error-status"></span>
                        </div>
                        
                        <div class="text-end">
                            <a href="<?php echo e(route('admin.banner.list')); ?>" class="btn btn-secondary">Cancel</a>

                            <button type="submit" id="saveBtn" class="btn btn-primary">
                                <span class="btn-text">Create Banner</span>
                                <span class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
$("#bannerForm").on('submit', function(e) {
    e.preventDefault();

    $("#saveBtn").attr("disabled", true);
    $("#saveBtn .btn-text").addClass('d-none');
    $("#saveBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);

    $.ajax({
        url: "<?php echo e(route('admin.banner.store')); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(res) {
            toastr.success("Banner created successfully");
            $("#bannerForm")[0].reset();

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
                $('.error-title').text(errors.title ?? '');
                $('.error-image').text(errors.image ?? '');
                $('.error-status').text(errors.status ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/banner/create.blade.php ENDPATH**/ ?>