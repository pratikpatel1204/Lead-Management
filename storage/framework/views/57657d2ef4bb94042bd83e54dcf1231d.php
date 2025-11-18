
<?php $__env->startSection('title', config('app.name') . ' || Dropdown List'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Dropdown List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Field Master</li>
                        <li class="breadcrumb-item active">Dropdown List</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    <a href="<?php echo e(route('admin.create.dropdown')); ?>" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Create Dropdown
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Table -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle" id="DropdownTable">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Field Name</th>
                            <th>Dropdown Options</th>
                            <th width="120" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="field-<?php echo e($field->id); ?>">
                                <td><?php echo e($key + 1); ?></td>
                                <td><?php echo e($field->name); ?></td>
                                <td>
                                    <?php if(isset($dropdowns[$field->id]) && count($dropdowns[$field->id]) > 0): ?>
                                        <ul class="mb-0">
                                            <?php $__currentLoopData = $dropdowns[$field->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dropdown): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($dropdown->label); ?> (<?php echo e($dropdown->value); ?>)</li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php else: ?>
                                        <span class="text-muted">No dropdown options</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.dropdown.edit', $field->id)); ?>"
                                        class="btn btn-sm btn-info me-1">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger deleteDropdownBtn" data-id="<?php echo e($field->id); ?>">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                         
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /Table -->

    </div>

    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
            let table = $('#DropdownTable').DataTable();
        });
        $(document).on('click', '.deleteDropdownBtn', function() {
            let id = $(this).data('id');
            let url = "<?php echo e(url('admin/dropdown-delete')); ?>/" + id;

            Swal.fire({
                title: "Are you sure?",
                text: "This field's dropdown will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>"
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire("Deleted!", res.message, "success");
                                $("#field-" + id).remove();
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/field/dropdown_list.blade.php ENDPATH**/ ?>