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
                        <form id="updatetemplatedata" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="template_name" class="form-control" value="<?php echo e($templateName); ?>"
                                readonly>
                            <input type="hidden" name="group_id" class="form-control" value="<?php echo e($groupId); ?>" readonly>
                            <div class="row p-2 my-2">
                                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $field = $item->field;
                                        $label = $field->name ?? '';
                                        $type = $field->type ?? 'text';
                                        $value = $item->field_value;
                                        $validation = $field->validation;
                                        $validationType = $field->validation_type;
                                        $isRequired = str_contains($validation, 'required');
                                    ?>
                                    <?php if($type === 'textarea'): ?>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                <?php echo e($label); ?> <?php if($isRequired): ?>
                                                    <span class="text-danger">*</span>
                                                <?php endif; ?>
                                            </label>
                                            <textarea name="<?php echo e($item->field_id); ?>" class="form-control" rows="3" <?php echo e($isRequired ? 'required' : ''); ?>><?php echo e($value); ?></textarea>
                                        </div>
                                    <?php elseif($type === 'radio'): ?>
                                        <?php
                                            $options = is_array($field->options) ? $field->options : explode(',', $field->options);
                                        ?>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"> <?php echo e($label); ?> 
                                                <?php if($isRequired): ?>
                                                    <span class="text-danger">*</span>
                                                <?php endif; ?>
                                            </label>
                                            <div class="d-flex flex-wrap mt-2">
                                                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $opt = trim($opt); ?>
                                                    <label class="me-3">
                                                        <input type="radio" name="<?php echo e($item->field_id); ?>"
                                                            value="<?php echo e($opt); ?>"
                                                            <?php echo e($value == $opt ? 'checked' : ''); ?>

                                                            <?php echo e($isRequired ? 'required' : ''); ?>>
                                                        <?php echo e($opt); ?>

                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php elseif($type === 'checkbox'): ?>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                <input type="checkbox" name="<?php echo e($item->field_id); ?>" value="1"
                                                    <?php echo e($value == 1 ? 'checked' : ''); ?>

                                                    <?php echo e($isRequired ? 'required' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </label>
                                        </div>
                                    <?php elseif($type === 'select'): ?>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><?php echo e($label); ?> 
                                                <?php if($isRequired): ?>
                                                    <span class="text-danger">*</span>
                                                <?php endif; ?>
                                            </label>
                                            <select class="form-select" name="<?php echo e($item->field_id); ?>"
                                                <?php echo e($isRequired ? 'required' : ''); ?>>
                                                <?php $__currentLoopData = $field->dropdowns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($opt->value); ?>"
                                                        <?php echo e($value == $opt->value ? 'selected' : ''); ?>>
                                                        <?php echo e($opt->label); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>       
                                    <?php elseif($type === 'file'): ?>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"> <?php echo e($label); ?> 
                                                <?php if($isRequired): ?>
                                                    <span class="text-danger">*</span>
                                                <?php endif; ?>
                                            </label>
                                            <input type="file" name="<?php echo e($item->field_id); ?>" class="form-control" <?php echo e($isRequired ? 'required' : ''); ?> <?php echo $validationType; ?>>
                                        </div>                                                                                             
                                    <?php else: ?>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"> <?php echo e($label); ?> 
                                                <?php if($isRequired): ?>
                                                    <span class="text-danger">*</span>
                                                <?php endif; ?>
                                            </label>
                                            <input type="<?php echo e($type); ?>" name="<?php echo e($item->field_id); ?>" value="<?php echo e($value); ?>" class="form-control"
                                                <?php echo e($isRequired ? 'required' : ''); ?> <?php echo $validationType; ?>>
                                        </div>
                                    <?php endif; ?>                                       
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-success my-3">
                                <span id="btnText">Save Changes</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.remove-row', function() {
            $(this).closest('.row').remove();
        });
        $("#updatetemplatedata").on("submit", function(e) {
            e.preventDefault();

            // SHOW LOADER + DISABLE BUTTON
            $("#submitBtn").prop("disabled", true);
            $("#btnText").addClass("d-none");
            $("#btnLoader").removeClass("d-none");

            let form = document.getElementById("updatetemplatedata");
            let formData = new FormData(form);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');

            $.ajax({
                url: "<?php echo e(route('admin.data.update')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {
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

                    setTimeout(function() {
                        window.location.href = "<?php echo e(route('admin.data.list', $templateName)); ?>";
                    }, 1500);
                },

                error: function(xhr) {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").removeClass("d-none");
                    $("#btnLoader").addClass("d-none");

                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Something went wrong. Please try again."
                    });

                    console.log(xhr.responseText);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/form_data/edit.blade.php ENDPATH**/ ?>