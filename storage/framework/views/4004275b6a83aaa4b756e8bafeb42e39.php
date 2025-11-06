
<?php $__env->startSection('title', config('app.name') . ' || Why Choose Us'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Why Choose Us</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">CMS</li>
                    <li class="breadcrumb-item active">Why Choose Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Why Choose Us Details</h5>
                </div>

                <div class="card-body">
                    <form id="whyChooseUsForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?php echo e($choose_us->title ?? ''); ?>" placeholder="Enter Title" required>
                            <span class="text-danger error-title"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3" placeholder="Enter Short Description"><?php echo e($choose_us->short_description ?? ''); ?></textarea>
                            <span class="text-danger error-short_description"></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">List Item 1</label>
                                <input type="text" name="list_one" class="form-control" value="<?php echo e($choose_us->list_one ?? ''); ?>" placeholder="Enter list item">
                                <span class="text-danger error-list_one"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">List Item 2</label>
                                <input type="text" name="list_two" class="form-control" value="<?php echo e($choose_us->list_two ?? ''); ?>" placeholder="Enter list item">
                                <span class="text-danger error-list_two"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">List Item 3</label>
                                <input type="text" name="list_three" class="form-control" value="<?php echo e($choose_us->list_three ?? ''); ?>" placeholder="Enter list item">
                                <span class="text-danger error-list_three"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">List Item 4</label>
                                <input type="text" name="list_four" class="form-control" value="<?php echo e($choose_us->list_four ?? ''); ?>" placeholder="Enter list item">
                                <span class="text-danger error-list_four"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            <?php if(!empty($choose_us->image)): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e(asset($choose_us->image)); ?>" alt="Current Image" width="120" class="rounded">
                                </div>
                            <?php endif; ?>
                            <span class="text-danger error-image"></span>
                        </div>

                        <div class="text-end">
                            <button type="submit" id="saveBtn" class="btn btn-primary">
                                <span class="btn-text"><?php echo e($choose_us ? 'Update' : 'Save'); ?></span>
                                <span class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$("#whyChooseUsForm").on('submit', function(e) {
    e.preventDefault();

    $("#saveBtn").attr("disabled", true);
    $("#saveBtn .btn-text").addClass('d-none');
    $("#saveBtn .spinner-border").removeClass('d-none');

    let formData = new FormData(this);

    $.ajax({
        url: "<?php echo e(route('admin.why.choose.us.update')); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            toastr.success(res.message || "Data saved successfully");
            $("#saveBtn").attr("disabled", false);
            $("#saveBtn .btn-text").removeClass('d-none');
            $("#saveBtn .spinner-border").addClass('d-none');
            setTimeout(() => {
                window.location.reload();
            }, 800);
        },
        error: function(xhr) {
            $("#saveBtn").attr("disabled", false);
            $("#saveBtn .btn-text").removeClass('d-none');
            $("#saveBtn .spinner-border").addClass('d-none');

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-title').text(errors.title ?? '');
                $('.error-short_description').text(errors.short_description ?? '');
                $('.error-list_one').text(errors.list_one ?? '');
                $('.error-list_two').text(errors.list_two ?? '');
                $('.error-list_three').text(errors.list_three ?? '');
                $('.error-list_four').text(errors.list_four ?? '');
                $('.error-image').text(errors.image ?? '');
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/why_choose_us.blade.php ENDPATH**/ ?>