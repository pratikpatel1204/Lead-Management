
<?php $__env->startSection('title', config('app.name') . ' || Create Validation Type'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Validation Type</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Validation Master</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form id="validationForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <!-- Validation Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Validation Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Validation Name" required>
                            <span class="text-danger error-name"></span>
                        </div>

                        <!-- Validation Rule -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Validation Rule <span class="text-danger">*</span></label>
                            <input type="text" name="rule" class="form-control" placeholder="Enter Validation Rule (e.g. required, email, max:255)" required>
                            <span class="text-danger error-rule"></span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end">
                        <a href="<?php echo e(route('admin.validation.list')); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <span class="btn-text">Create Validation</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        $(document).ready(function() {
            $("#validationForm").on('submit', function(e) {
                e.preventDefault();

                // Disable button and show loader
                $("#saveBtn").attr("disabled", true);
                $("#saveBtn .btn-text").addClass('d-none');
                $("#saveBtn .spinner-border").removeClass('d-none');

                let formData = new FormData(this);

                $.ajax({
                    url: "<?php echo e(route('admin.validation.store')); ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(res) {
                        toastr.success("Validation Type created successfully");
                        $("#validationForm")[0].reset();

                        // Reset button
                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');

                        // Redirect after success
                        setTimeout(() => {
                            window.location.href = "<?php echo e(route('admin.validation.list')); ?>";
                        }, 800);
                    },

                    error: function(xhr) {
                        // Reset button
                        $("#saveBtn").attr("disabled", false);
                        $("#saveBtn .btn-text").removeClass('d-none');
                        $("#saveBtn .spinner-border").addClass('d-none');

                        // Validation Errors
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.error-name').text(errors.name ?? '');
                            $('.error-rule').text(errors.rule ?? '');
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/field/create_validation.blade.php ENDPATH**/ ?>