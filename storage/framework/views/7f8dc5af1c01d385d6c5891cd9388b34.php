
<?php $__env->startSection('title', config('app.name') . ' || Create Category'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Category</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Categories</li>
                        <li class="breadcrumb-item active">Create Category</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Category Details</h5>
                    </div>

                    <div class="card-body">
                        <form id="categoryForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Category Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required
                                        placeholder="Enter Category Title">
                                    <span class="text-danger error-title"></span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                    <textarea name="short_description" class="form-control" rows="3" required placeholder="Enter Short Description"></textarea>
                                    <span class="text-danger error-short_description"></span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category Image <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control" required>
                                    <span class="text-danger error-image"></span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Active" selected>Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <span class="text-danger error-status"></span>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="<?php echo e(route('admin.services.categories.list')); ?>" class="btn btn-secondary">Cancel</a>

                                <button type="submit" id="saveBtn" class="btn btn-primary">
                                    <span class="btn-text">Create Category</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("#categoryForm").on('submit', function(e) {
                e.preventDefault();

                $("#saveBtn").attr("disabled", true);
                $("#saveBtn .btn-text").addClass('d-none');
                $("#saveBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "<?php echo e(route('admin.services.categories.store')); ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Category created successfully");
                        $("#categoryForm")[0].reset();
                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');
                        // setTimeout(() => {
                        //     window.location.href = "<?php echo e(route('admin.services.categories.list')); ?>";
                        // }, 800);
                    },

                    error: function(xhr) {
                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-title').text(errors.title ?? '');
                            $('.error-short_description').text(errors.short_description ?? '');
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

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/service/create_categories.blade.php ENDPATH**/ ?>