
<?php $__env->startSection('title', config('app.name') . ' || Edit Blog Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Edit Blog Category</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Blog Categories</li>
                    <li class="breadcrumb-item active">Edit Blog Category</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update Blog Category</h5>
                </div>

                <div class="card-body">
                    <form id="blogCategoryEditForm">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="id" value="<?php echo e($category->id); ?>">

                        <div class="mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   value="<?php echo e($category->name); ?>" required>
                            <span class="text-danger error-name"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" <?php echo e($category->status == 'Active' ? 'selected' : ''); ?>>Active</option>
                                <option value="Inactive" <?php echo e($category->status == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                            <span class="text-danger error-status"></span>
                        </div>

                        <div class="text-end">
                            <a href="<?php echo e(route('admin.blog.categories.list')); ?>" class="btn btn-secondary">Cancel</a>

                            <button type="submit" id="updateBtn" class="btn btn-primary">
                                <span class="btn-text">Update Category</span>
                                <span class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

<script>
$("#blogCategoryEditForm").on('submit', function(e) {
    e.preventDefault();

    $("#updateBtn").attr("disabled", true);
    $("#updateBtn .btn-text").addClass('d-none');
    $("#updateBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);

    $.ajax({
        url: "<?php echo e(route('admin.blog.categories.update')); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(res) {
            toastr.success("Category updated successfully");
            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            setTimeout(() => {
                window.location.href = "<?php echo e(route('admin.blog.categories.list')); ?>";
            }, 800);
        },

        error: function(xhr) {
            $("#updateBtn").attr("disabled", false);
            $("#updateBtn .btn-text").removeClass('d-none');
            $("#updateBtn .spinner-border").addClass('d-none');

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-name').text(errors.name ?? '');
                $('.error-status').text(errors.status ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/blog-categories/edit.blade.php ENDPATH**/ ?>