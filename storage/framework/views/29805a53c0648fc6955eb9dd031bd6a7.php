
<?php $__env->startSection('title', config('app.name') . ' || Employee List'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Employee List</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active" aria-current="page">Employee List</li>
                    </ol>
                </nav>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Employee')): ?>
                <a href="<?php echo e(route('admin.create.employee')); ?>" class="btn btn-primary mt-2 mt-md-0">
                    + Add Employee
                </a>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Employee List</h4>
                    </div>
                    <div class="card-body">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="empTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Mobile Number</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th width="120">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($emp->employee_id ?? ''); ?></td>
                                            <td><?php echo e($emp->name); ?></td>
                                            <td><?php echo e($emp->email); ?></td>
                                            <td><?php echo e($emp->show_password); ?></td>
                                            <td><?php echo e($emp->mobile); ?></td>
                                            <td>                                               
                                                <span class="badge bg-success"><?php echo e($emp->role ?? ''); ?></span>                                                
                                            </td>
                                            <td>
                                                <?php if(!$emp->hasRole('super admin')): ?>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status-toggle" type="checkbox"
                                                            role="switch" data-id="<?php echo e($emp->id); ?>"
                                                            <?php echo e($emp->status == 1 ? 'checked' : ''); ?>>
                                                        <label class="form-check-label status-text">
                                                            <?php echo e($emp->status == 1 ? 'Active' : 'Inactive'); ?>

                                                        </label>
                                                    </div>
                                                <?php else: ?>
                                                    <?php if($emp->status == 1): ?>
                                                        <span class="badge bg-primary">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary serializeBtn" data-id="<?php echo e($emp->id); ?>">
                                                    <i class="ti ti-arrows-exchange"></i>
                                                </a>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Employee')): ?>
                                                    <?php if(!$emp->hasRole('super admin')): ?>
                                                        <a href="<?php echo e(route('admin.employee.edit', $emp->id)); ?>" class="btn btn-sm btn-info">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Employee')): ?>
                                                    <?php if(!$emp->hasRole('super admin')): ?>
                                                        <button class="btn btn-sm btn-danger deleteEmployeeBtn" data-id="<?php echo e($emp->id); ?>">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>

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
    </div>
    <!-- Field Order Modal -->
    <div class="modal fade" id="serializeModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Field Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="sortcrateform">
                    <div class="modal-body">
                        <label class="form-label">Field Order (Check & Drag to Sort)</label>                
                        <div id="serializeData" style="max-height:300px; overflow-y:auto;">                            
                        </div>
                        <input type="hidden" name="field_order" id="fieldOrder">
                    </div>
                
                    <div class="modal-footer">                        
                        <button type="submit" class="btn btn-primary" id="saveFieldOrder">
                            <span class="btn-text">Save Order</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>                
            </div>
        </div>
    </div> 
    <script>
        $(document).on('click', '.serializeBtn', function () {
            let empId = $(this).data('id');
        
            $('#serializeModal').modal('show');          
            $('#serializeData').html('');
            $('#serializeData').html('<div class="text-center py-5"><div class="spinner-border"></div></div>');
        
            $.ajax({
                url: "<?php echo e(route('admin.get.lead.serialize')); ?>",
                type: "GET",
                data: { id: empId },
                success: function (response) {
                    if (response.success) {
                        $('#serializeData').html(response.html);
                    }
                },
                error: function () {
                    $('#serializeData').html('<div class="alert alert-danger">Failed to load data</div>');
                }
            });
        });
    </script>            
    <script>       
        $(document).on('change', '.status-toggle', function() {

            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;
            var label = $(this).closest('.form-check').find('.status-text');

            $.ajax({
                url: "<?php echo e(route('admin.employee.update.status')); ?>",
                method: "POST",
                data: {
                    id: id,
                    status: status,
                    _token: "<?php echo e(csrf_token()); ?>"
                },
                success: function(response) {

                    if (response.success) {
                        // Update label text
                        label.text(status == 1 ? 'Active' : 'Inactive');

                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error("Server error occurred!");
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            let table = $('#empTable').DataTable();

            $(document).on('click', '.deleteEmployeeBtn', function() {
                let id = $(this).data('id');
                let url = "<?php echo e(url('admin/employee-delete')); ?>/" + id;
                let row = $(this).closest('tr'); // Get table row

                Swal.fire({
                    title: "Are you sure?",
                    text: "This employee will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>"
                            },
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire("Deleted!", res.message, "success");

                                    // ✅ Remove row without reloading page
                                    table.row(row).remove().draw(false);
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },
                            error: function(xhr) {
                                let message = "Something went wrong!";

                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                Swal.fire("Error", message, "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        /* ===============================
           LOAD HTML VIA AJAX
        ================================ */
        $(document).on('click', '.serializeBtn', function () {
        
            let empId = $(this).data('id');
        
            $('#serializeModal').modal('show');
        
            $('#serializeData').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                </div>
            `);
        
            $.ajax({
                url: "<?php echo e(route('admin.get.lead.serialize')); ?>",
                type: "GET",
                data: { id: empId },
                success: function (response) {
        
                    if (response.success) {
                        $('#serializeData').html(response.html);
        
                        initSortable();   // 🔥 VERY IMPORTANT
                        serializeFields();
                    }
                },
                error: function () {
                    $('#serializeData').html(
                        '<div class="alert alert-danger">Failed to load data</div>'
                    );
                }
            });
        });
        
        /* ===============================
           SORTABLE INIT
        ================================ */
        function initSortable() {
        
            let $sortable = $("#sortableFields");
        
            if (!$sortable.length) return;
        
            if ($sortable.hasClass("ui-sortable")) {
                $sortable.sortable("destroy");
            }
        
            $sortable.sortable({
                handle: ".drag-handle",
                placeholder: "ui-state-highlight",
                update: function () {
                    serializeFields();
                }
            });
        
            $sortable.disableSelection();
        }
        
        /* ===============================
           SERIALIZE CHECKED FIELDS
        ================================ */
        function serializeFields() {
        
            let order = [];
        
            $("#sortableFields li").each(function () {
        
                let checkbox = $(this).find('.field-checkbox');
        
                if (checkbox.is(':checked')) {
                    order.push($(this).data("key"));
                }
            });
        
            $("#fieldOrder").val(order.join(','));
        }
        
        /* ===============================
           CHECKBOX CHANGE
        ================================ */
        $(document).on('change', '.field-checkbox', function () {
            serializeFields();
        });
        
        /* ===============================
           SAVE ORDER
        ================================ */
        $(document).on('submit', '#sortcrateform', function (e) {
        
            e.preventDefault();
        
            let $btn = $('#saveFieldOrder');
        
            serializeFields();
        
            $btn.prop('disabled', true);
            $btn.find('.btn-text').addClass('d-none');
            $btn.find('.btn-loader').removeClass('d-none');
        
            $.ajax({
                url: "<?php echo e(route('admin.lead.field.order.save')); ?>",
                type: "POST",
                data: $(this).serialize() + '&_token=<?php echo e(csrf_token()); ?>',
                success: function (res) {        
                    toastr.success(res.message ?? 'Order saved successfully');
                    $('#serializeModal').modal('hide');
                },
                error: function () {
                    toastr.error('Failed to save order');
                },
                complete: function () {
        
                    $btn.prop('disabled', false);
                    $btn.find('.btn-text').removeClass('d-none');
                    $btn.find('.btn-loader').addClass('d-none');
                }
            });
        });
    </script>
        
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/employees/list.blade.php ENDPATH**/ ?>