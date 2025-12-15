<?php $__env->startSection('title', config('app.name') . ' || ' . $name . ' Data List'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1"><?php echo e($name); ?> - Data List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($name); ?> - Data List</li>
                    </ol>
                </nav>
            </div>
            <a href="<?php echo e(route('admin.data.create', $name)); ?>" class="btn btn-primary mt-2 mt-md-0">
                <i class="ti ti-plus"></i> <?php echo e($name); ?> Data
            </a>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e($name); ?> - Data List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="datalistTable">
                            <thead>
                                <tr class="bg-light">
                                    <?php if(isset($templates) && count($templates) > 0): ?>
                                        <?php
                                            $firstGroup = $templates->first();
                                        ?>
                                        <?php $__currentLoopData = $firstGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e($item->field_name); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupId => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e($rec->field_value ?? '-'); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="text-center">
                                            <a href="<?php echo e(route('admin.data.edit', ['name' => $item->template_name, 'groupid' => $groupId])); ?>"
                                                class="btn btn-info btn-sm text-white me-1">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm deleteDataBtn"
                                                data-group="<?php echo e($groupId); ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="50" class="text-center">No data found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Script -->
    <script>
        $(document).ready(function() {
            let table = $('#datalistTable').DataTable();
            $(document).on('click', '.deleteDataBtn', function() {

                let groupId = $(this).data('group');
                let templateName = $(this).data('name');
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
                            url: "<?php echo e(route('admin.data.delete')); ?>",
                            type: "POST",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                                group_id: groupId,
                                template_name: templateName
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

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/form_data/list.blade.php ENDPATH**/ ?>