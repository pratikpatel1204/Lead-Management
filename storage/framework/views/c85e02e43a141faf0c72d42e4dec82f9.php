
<?php $__env->startSection('title', config('app.name') . ' || Lead Master'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .offcanvas.offcanvas-end {
            width: 70% !important;
        }
    </style>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Lead Master</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Lead Master</li>
                        <li class="breadcrumb-item active" aria-current="page">Lead List</li>
                    </ol>
                </nav>
            </div>
            <a href="javascript:void(0)" class="btn btn-primary mt-2 mt-md-0" id="openLeadForm">
                <i class="ti ti-plus"></i>
                <span>Lead Master</span>
            </a>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Lead Master</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="datalistTable">
                            <thead>
                                <tr class="bg-light">
                                    <th>#</th>
                                    <?php if(isset($leadData) && count($leadData) > 0): ?>
                                        <?php
                                            $firstGroup = $leadData->first();
                                        ?>
                                        <?php $__currentLoopData = $firstGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e($item->field_name); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $row = 1; ?>
                                <?php $__currentLoopData = $leadData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupId => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($row++); ?></td>
                                        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td>
                                                <?php if(Str::endsWith($rec->field_value, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                                    <img src="<?php echo e(asset($rec->field_value)); ?>" width="50">
                                                <?php elseif(Str::endsWith($rec->field_value, 'pdf')): ?>
                                                    <a href="<?php echo e(asset($rec->field_value)); ?>" target="_blank"
                                                        class="btn btn-sm btn-danger">View PDF</a>
                                                <?php else: ?>
                                                    <?php echo e($rec->field_value ?? '-'); ?>

                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            <a href="<?php echo e(route('admin.lead.mater.edit', $groupId)); ?>" class="btn btn-info btn-sm text-white me-1">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm deleteDataBtn" data-group="<?php echo e($groupId); ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="leadSidebarForm" class="offcanvas offcanvas-end lead-sidebar" tabindex="-1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Lead Master</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="dynamicForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $field = $t->field;
                            $label = $field->name;
                            $name = Str::slug($field->name, '_'); // slug input name
                            $type = $field->type;
                            $isRequired = $field->validation == 'required' ? 'required' : '';
                            $defaultValue = $field->default_value;
                        ?>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><?php echo e($label); ?> <?php if($isRequired): ?>
                                    <span class="text-danger">*</span>
                                <?php endif; ?>
                            </label>

                            
                            <?php if(in_array($type, ['text', 'email', 'number'])): ?>
                                <input type="<?php echo e($type); ?>" name="<?php echo e($field->id); ?>" class="form-control"
                                    id="<?php echo e($name); ?>" <?php echo e($isRequired); ?>>

                                
                            <?php elseif($type == 'textarea'): ?>
                                <textarea name="<?php echo e($field->id); ?>" class="form-control" id="<?php echo e($name); ?>" rows="3"
                                    <?php echo e($isRequired); ?>></textarea>

                                
                            <?php elseif($type == 'select'): ?>
                                <select name="<?php echo e($field->id); ?>" id="<?php echo e($name); ?>" class="form-select"
                                    <?php echo e($isRequired); ?>>
                                    <option value="">Select <?php echo e($label); ?></option>
                                    <?php $__currentLoopData = $field->dropdowns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($opt->value); ?>"><?php echo e($opt->label); ?></option>
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
                                            <input type="radio" name="<?php echo e($field->id); ?>" id="<?php echo e($name . '_' . $opt); ?>"
                                                value="<?php echo e($opt); ?>" <?php echo e($defaultValue == $opt ? 'checked' : ''); ?>

                                                <?php echo e($isRequired ? 'required' : ''); ?>>
                                            <?php echo e($opt); ?>

                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                            <?php elseif($type == 'file'): ?>
                                <input type="file" name="<?php echo e($field->id); ?>" id="<?php echo e($name); ?>"
                                    class="form-control" <?php echo e($isRequired); ?>>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <span class="btn-text">Save</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('openLeadForm').addEventListener('click', function() {
            let sidebar = new bootstrap.Offcanvas(document.getElementById('leadSidebarForm'));
            sidebar.show();
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#dynamicForm").on("submit", function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Define submit button
                let btn = $("#saveBtn");

                // Clear previous errors
                $(form).find('.text-danger').remove();
                $(form).find('.is-invalid').removeClass('is-invalid');

                // Button Loader
                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".spinner-border").removeClass("d-none");

                $.ajax({
                    url: "<?php echo e(route('admin.lead.mater.store')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");

                        if (res.status === true) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: res.message,
                            });
                            form.reset();
                        }
                    },
                    error: function(err) {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");

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
                    },

                    complete: function() {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".spinner-border").addClass("d-none");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let table = $('#datalistTable').DataTable();
            $(document).on('click', '.deleteDataBtn', function() {

                let groupId = $(this).data('group');        
                let row = $(this).closest('tr');
                Swal.fire({
                    title: "Are you sure?",
                    text: "This form group will be deleted permanently!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "<?php echo e(route('admin.lead.mater.delete')); ?>",
                            type: "POST",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                                group_id: groupId,
                            },

                            success: function(res) {
                                if (res.status) {
                                    Swal.fire("Deleted", res.message, "success");
                                    row.remove();
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },

                            error: function() {
                                Swal.fire("Error", "Something went wrong!", "error");
                            }
                        });

                    }
                });

            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/lead/list.blade.php ENDPATH**/ ?>