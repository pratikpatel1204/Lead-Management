
<?php $__env->startSection('title', config('app.name') . ' || Edit Field'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Field</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Fields</li>
                        <li class="breadcrumb-item active">Edit Field</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form id="editFieldForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($field->id); ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="<?php echo e($field->name); ?>" placeholder="Enter Field Name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Type <span class="text-danger">*</span></label>
                            <select name="type" id="fieldType" class="form-select" required>
                                <option value="">Select Type</option>
                                <?php $__currentLoopData = $fieldTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->value); ?>"
                                        <?php echo e($field->type == $type->value ? 'selected' : ''); ?>>
                                        <?php echo e($type->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Validation <span class="text-danger">*</span></label>
                            <select name="validation" class="form-select" required>
                                <option value="">Select Validation</option>
                                <option value="required" <?php echo e($field->validation == 'required' ? 'selected' : ''); ?>>Required</option>
                                <option value="nullable" <?php echo e($field->validation == 'nullable' ? 'selected' : ''); ?>>Nullable</option>
                                <option value="readonly" <?php echo e($field->validation == 'readonly' ? 'selected' : ''); ?>>Readonly</option>
                                <option value="checked" <?php echo e($field->validation == 'checked' ? 'selected' : ''); ?>>Checked</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Validation Type</label>
                            <select name="validation_type" id="validationType" class="form-select">
                                <option value="">Select Validation Type</option>
                                <?php $__currentLoopData = $validationTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $validation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($validation->rule); ?>"
                                        <?php echo e($field->validation_type == $validation->rule ? 'selected' : ''); ?>>
                                        <?php echo e($validation->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Default Value</label>
                            <input type="text" name="default_value" class="form-control"
                                value="<?php echo e($field->default_value); ?>" placeholder="Enter Default Value">
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="<?php echo e(route('admin.field.list')); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="updateBtn" class="btn btn-primary">
                            <span class="btn-text">Update Field</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        $(document).ready(function() {

            $('#editFieldForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let button = $('#updateBtn');
                let spinner = button.find('.spinner-border');
                let btnText = button.find('.btn-text');
                let id = $('input[name="id"]').val();

                button.prop('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('Updating...');

                $.ajax({
                    url: "<?php echo e(route('admin.field.update')); ?>",
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Field updated successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let message = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message
                        });
                    },
                    complete: function() {
                        button.prop('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('Update Field');
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/field/edit_field.blade.php ENDPATH**/ ?>