
<?php $__env->startSection('title', config('app.name') . ' || Aboute Us'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">About Us</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            About Us
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">About Us Update</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="card">
            <div class="card-body">
                <form id="aboutUsForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">

                        <!-- MAIN IMAGE -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Main Image</label>
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <div id="previewMain"
                                    class="me-3 d-flex align-items-center justify-content-center rounded border border-dashed bg-white"
                                    style="width: 120px; height: 120px;">
                                    <?php if(!empty($about->main_image)): ?>
                                        <img src="<?php echo e(asset($about->main_image)); ?>" class="rounded" width="120"
                                            height="120" style="object-fit:cover;">
                                    <?php else: ?>
                                        <i class="ti ti-photo text-muted fs-3"></i>
                                    <?php endif; ?>
                                </div>
                                <input type="file" name="main_image" class="form-control" id="mainImageInput"
                                    accept="image/*">
                            </div>
                            <small class="text-muted">Max size 1 MB</small>
                        </div>

                        <!-- SECOND IMAGE -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Second Image</label>
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <div id="previewSecond"
                                    class="me-3 d-flex align-items-center justify-content-center rounded border border-dashed bg-white"
                                    style="width: 120px; height: 120px;">
                                    <?php if(!empty($about->second_image)): ?>
                                        <img src="<?php echo e(asset($about->second_image)); ?>" class="rounded" width="120"
                                            height="120" style="object-fit:cover;">
                                    <?php else: ?>
                                        <i class="ti ti-photo text-muted fs-3"></i>
                                    <?php endif; ?>
                                </div>
                                <input type="file" name="second_image" class="form-control" id="secondImageInput"
                                    accept="image/*">
                            </div>
                            <small class="text-muted">Max size 1 MB</small>
                        </div>


                        <!-- TITLE -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="<?php echo e($about->title ?? ''); ?>" required>
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea class="summernote" name="description"><?php echo $about->description ?? ''; ?></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" id="saveBtn" class="btn btn-primary">Save About Us</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function preview(input, target) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = e => $(target).html(
                    `<img src="${e.target.result}" class="rounded w-100 h-100" style="object-fit:cover;">`);
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#mainImageInput").change(function() {
            preview(this, "#previewMain");
        });
        $("#secondImageInput").change(function() {
            preview(this, "#previewSecond");
        });
        $('#aboutUsForm').submit(function(e) {
            e.preventDefault();

            let saveBtn = $('#saveBtn');
            let originalText = saveBtn.html();

            saveBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Saving...'
            );

            let formData = new FormData(this);
            formData.append("description", $('.summernote').summernote('code'));

            $.ajax({
                url: "<?php echo e(route('admin.about.us.update')); ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                beforeSend: function() {
                    toastr.info("Saving...", "Please wait");
                },

                success: function(res) {
                    if (res.status === true) {
                        toastr.success("About Us updated successfully!", "Success");
                    } else {
                        toastr.error(res.message ?? "Something went wrong", "Error");
                    }

                    saveBtn.prop('disabled', false).html(originalText);
                },

                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            toastr.error(value, "Validation Error");
                        });
                    } else {
                        toastr.error("Failed to save data!", "Error");
                    }

                    saveBtn.prop('disabled', false).html(originalText);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/aboutus.blade.php ENDPATH**/ ?>