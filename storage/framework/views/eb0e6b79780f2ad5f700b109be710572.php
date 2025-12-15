
<?php $__env->startSection('title', config('app.name') . ' || Edit ' . $templateName . ' Data'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit <?php echo e($templateName); ?> Data</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active">Edit <?php echo e($templateName); ?> Data</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit <?php echo e($templateName); ?> Data</h5>
                    </div>
                    <div class="card-body">
                        <form id="editdaynamicform" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="form_group_id" value="<?php echo e($formGroupId); ?>">
                            <div class="row">
                                <?php $__currentLoopData = $leadData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $field = $t->field;
                                        $label = $field->name;
                                        $name = $field->id;
                                        $slug = Str::slug($field->name, '_');
                                        $type = $field->type;
                                        $isRequired = $field->validation == 'required';
                                        $value = old($name, $t->field_value);
                                    ?>
                                    <div class="col-4 mb-3">
                                        <label class="form-label"><?php echo e($label); ?><?php if($isRequired): ?><span class="text-danger">*</span><?php endif; ?></label>
                                        
                                        <?php if(in_array($type, ['text', 'email', 'number'])): ?>
                                            <input type="<?php echo e($type); ?>" name="<?php echo e($name); ?>"
                                                id="<?php echo e($slug); ?>" class="form-control" value="<?php echo e($value); ?>"
                                                <?php echo e($isRequired ? 'required' : ''); ?>>

                                            
                                        <?php elseif($type == 'textarea'): ?>
                                            <textarea name="<?php echo e($name); ?>" id="<?php echo e($slug); ?>" class="form-control" rows="3"
                                                <?php echo e($isRequired ? 'required' : ''); ?>><?php echo e($value); ?></textarea>

                                            
                                        <?php elseif($type == 'select'): ?>
                                            <select name="<?php echo e($name); ?>" id="<?php echo e($slug); ?>"
                                                class="form-select" <?php echo e($isRequired ? 'required' : ''); ?>>
                                                <option value="">Select <?php echo e($label); ?></option>
                                                <?php $__currentLoopData = $field->dropdowns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($opt->value); ?>"
                                                        <?php echo e($value == $opt->value ? 'selected' : ''); ?>>
                                                        <?php echo e($opt->label); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                            
                                        <?php elseif($type == 'radio'): ?>
                                            <?php
                                                $options = is_array($field->options)
                                                    ? $field->options
                                                    : explode(',', $field->options);
                                            ?>
                                            <div class="d-flex flex-wrap mt-2">
                                                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $opt = trim($opt); ?>
                                                    <label class="me-3">
                                                        <input type="radio" name="<?php echo e($name); ?>"
                                                            value="<?php echo e($opt); ?>"
                                                            <?php echo e($value == $opt ? 'checked' : ''); ?>

                                                            <?php echo e($isRequired ? 'required' : ''); ?>>
                                                        <?php echo e($opt); ?>

                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>

                                            
                                        <?php elseif($type == 'file'): ?>
                                            <input type="file" name="<?php echo e($name); ?>" id="<?php echo e($slug); ?>"
                                                class="form-control" <?php echo e($isRequired ? 'required' : ''); ?>>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="saveBtn">
                                    <span class="btn-text">Update</span>
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
        $(document).ready(function () {
        
            $("#editdaynamicform").on("submit", function (e) {
                e.preventDefault();
        
                // Loader ON
                $("#submitBtn").prop("disabled", true);
                $("#btnText").addClass("d-none");
                $("#btnLoader").removeClass("d-none");
        
                let formData = new FormData(this);
        
                $.ajax({
                    url: "<?php echo e(route('admin.lead.mater.update')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
        
                    success: function (response) {
                        $("#submitBtn").prop("disabled", false);
                        $("#btnText").removeClass("d-none");
                        $("#btnLoader").addClass("d-none");
        
                        Swal.fire({
                            icon: "success",
                            title: "Updated!",
                            text: "Template Data updated successfully!",
                            timer: 1500,
                            showConfirmButton: false
                        });
        
                        setTimeout(() => {
                            window.location.href = "<?php echo e(route('admin.lead.mater')); ?>";
                        }, 1500);
                    },
                    error: function(err) {
                        $("#submitBtn").prop("disabled", false);
                        $("#btnText").removeClass("d-none");
                        $("#btnLoader").addClass("d-none");

                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;

                            $.each(errors, function(key, messages) {
                                let input = $('#' + key);

                                input.next('.text-danger').remove();
                                input.after('<span class="text-danger small">' +
                                    messages[0] + '</span>');
                                input.addClass('is-invalid');
                            });

                            // Scroll to first error field
                            let firstKey = Object.keys(errors)[0];
                            let firstInput = $('#' + firstKey);

                            if (firstInput.length) {
                                $('html, body').animate({
                                    scrollTop: firstInput.offset().top - 100
                                }, 400);
                            }

                            return;
                        }

                        Swal.fire("Error", "Something went wrong!", "error");
                    }                   
                });
            });
        
        });
    </script>    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/lead/edit.blade.php ENDPATH**/ ?>