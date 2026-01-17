

<?php $__env->startSection('title', config('app.name') . ' || Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Profile</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="border-bottom mb-3 pb-3">
                <h4>Profile</h4>
            </div>

            <form id="adminProfileForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>            

                
                <div class="border-bottom mb-3 pb-3">
                    <h6 class="mb-3">Basic Information</h6>

                    <div class="row mb-3">
                        <div class="col-md-12 d-flex align-items-center bg-light rounded p-3">
                            <div class="avatar avatar-xxl rounded-circle border border-dashed me-3 text-dark">
                                <?php if(auth()->user()->profile_image): ?>
                                    <img src="<?php echo e(asset(auth()->user()->profile_image)); ?>" class="rounded-circle" width="100">
                                <?php else: ?>
                                    <i class="ti ti-user fs-16"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="photo" class="form-control">
                                <small class="text-muted">Recommended size: 150x150</small><br>
                                <?php if(auth()->user()->role): ?>
                                    <span class="badge bg-primary text-uppercase">
                                        <?php echo e(auth()->user()->role); ?>

                                    </span>
                                <?php endif; ?>
                            </div>                                                        
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo e(auth()->user()->name); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(auth()->user()->email); ?>">
                        </div>
                    </div>
                </div>

                
                <div class="border-bottom mb-3 pb-3">
                    <h6 class="mb-3">Change Password</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <span class="btn-text">Save</span>
                        <span class="spinner-border spinner-border-sm d-none btn-spinner"></span>
                    </button>                    
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    
        $("#adminProfileForm").on("submit", function (e) {
            e.preventDefault();
    
            $(".error-text").remove(); // Remove old errors
            $("input, select").removeClass("is-invalid");
    
            let formData = new FormData(this);
    
            // Button loading
            $("#saveBtn .btn-text").addClass("d-none");
            $("#saveBtn .btn-spinner").removeClass("d-none");
            $("#saveBtn").prop("disabled", true);
    
            $.ajax({
                url: "<?php echo e(route('admin.profile.update')); ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
    
                success: function(response) {
                    if (response.status === true) {
                        toastr.success(response.message);                        
                    } else {
                        toastr.error(response.message);
                    }
                },
    
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let input = $('[name="'+ key +'"]');
                            input.addClass("is-invalid");
                            input.after('<span class="text-danger error-text">' + value[0] + '</span>');
                        });
                    } else {
                        toastr.error("Something went wrong!");
                    }
                },
    
                complete: function() {
                    $("#saveBtn .btn-text").removeClass("d-none");
                    $("#saveBtn .btn-spinner").addClass("d-none");
                    $("#saveBtn").prop("disabled", false);
                }
            });
    
        });
    
    });
    </script>    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/auth/profile.blade.php ENDPATH**/ ?>