
<?php $__env->startSection('title', config('app.name') . ' || Create Team'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Team Member</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Team</li>
                        <li class="breadcrumb-item active">Create Team Member</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Team Member Details</h5>
                    </div>

                    <div class="card-body">
                        <form id="teamForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Enter Name">
                                    <span class="text-danger error-name"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Designation <span class="text-danger">*</span></label>
                                    <input type="text" name="designation" class="form-control" required
                                        placeholder="Enter Designation">
                                    <span class="text-danger error-designation"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Team Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <span class="text-danger error-image"></span>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="<?php echo e(route('admin.team.list')); ?>" class="btn btn-secondary">Cancel</a>

                                <button type="submit" id="saveBtn" class="btn btn-primary">
                                    <span class="btn-text">Create Team Member</span>
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
        $("#teamForm").on('submit', function(e) {
            e.preventDefault();

            $("#saveBtn").attr("disabled", true);
            $("#saveBtn .btn-text").addClass('d-none');
            $("#saveBtn .spinner-border").removeClass('d-none');

            let formData = new FormData(this);

            $.ajax({
                url: "<?php echo e(route('admin.team.store')); ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function(res) {
                    toastr.success("Team member added successfully");
                    $("#teamForm")[0].reset();

                    $("#saveBtn").attr("disabled", false);
                    $("#saveBtn .btn-text").removeClass('d-none');
                    $("#saveBtn .spinner-border").addClass('d-none');

                    setTimeout(() => {
                        window.location.href = "<?php echo e(route('admin.team.list')); ?>";
                    }, 800);
                },

                error: function(xhr) {
                    $("#saveBtn").attr("disabled", false);
                    $("#saveBtn .btn-text").removeClass('d-none');
                    $("#saveBtn .spinner-border").addClass('d-none');

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('.error-name').text(errors.name ?? '');
                        $('.error-designation').text(errors.designation ?? '');
                        $('.error-image').text(errors.image ?? '');
                    } else {
                        toastr.error("Something went wrong!");
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/team/create.blade.php ENDPATH**/ ?>