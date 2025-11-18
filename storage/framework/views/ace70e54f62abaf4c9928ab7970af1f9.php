
<?php $__env->startSection('title', config('app.name') . ' || Create Template'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Template</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Template Master</li>
                        <li class="breadcrumb-item active">Create Template</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="templateForm">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Template Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Template Name"
                                required>
                        </div>

                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Select Fields <span class="text-danger">*</span></label>
                            <input type="text" id="fieldSearch" class="form-control mb-2" placeholder="Search field...">

                            <div id="fieldList" class="border rounded p-3 d-flex flex-wrap gap-3"
                                style="max-height: 250px; overflow-y: auto;">

                                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check d-flex align-items-center" style="width: 30%;">
                                        <input class="form-check-input field-checkbox me-2" type="checkbox"
                                            name="field_ids[]" value="<?php echo e($field->id); ?>" id="field_<?php echo e($field->id); ?>">
                                        <label class="form-check-label" for="field_<?php echo e($field->id); ?>">
                                            <?php echo e($field->name); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="<?php echo e(route('admin.template.list')); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <span class="btn-text">Create Template</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const $fieldList = $('#fieldList');
            const $allFields = $fieldList.children('.form-check').clone();

            // Search and show matched items on top
            $('#fieldSearch').on('keyup', function() {
                const value = $(this).val().toLowerCase();

                const matched = [];
                const unmatched = [];

                $allFields.each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.includes(value)) {
                        matched.push($(this));
                    } else {
                        unmatched.push($(this));
                    }
                });

                // Clear and append matched first, then unmatched
                $fieldList.empty();
                matched.forEach(el => $fieldList.append(el));
                unmatched.forEach(el => $fieldList.append(el));
            });

            // Submit Template Form
            $('#templateForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let button = $('#saveBtn');
                let spinner = button.find('.spinner-border');
                let btnText = button.find('.btn-text');

                button.prop('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('Saving...');

                $.ajax({
                    url: "<?php echo e(route('admin.template.store')); ?>",
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        toastr.clear();
                        if (response.status) {
                            toastr.success(response.message ||
                            'Template created successfully!');
                            form[0].reset();
                            setTimeout(() => {
                                window.location.href =
                                    "<?php echo e(route('admin.template.list')); ?>";
                            }, 1500);
                        } else {
                            toastr.error(response.message || 'Something went wrong!');
                        }
                    },
                    error: function(xhr) {
                        let message = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        toastr.error(message);
                    },
                    complete: function() {
                        button.prop('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('Create Template');
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/template/create.blade.php ENDPATH**/ ?>