
<?php $__env->startSection('title', config('app.name') . ' || Team List'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Team Members</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Team</li>
                        <li class="breadcrumb-item active">Team List</li>
                    </ol>
                </nav>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Team')): ?>
                <a href="<?php echo e(route('admin.create.team')); ?>" class="btn btn-primary mt-2 mt-md-0">
                    + Add Team Member
                </a>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Team Members</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="teamTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th width="130">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>

                                            <td>
                                                <?php if($team->image): ?>
                                                    <img src="<?php echo e(asset($team->image)); ?>" width="60" height="60"
                                                        style="object-fit:cover;border-radius:50%;">
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('default/no-img.jpg')); ?>" width="60"
                                                        height="60" style="object-fit:cover;border-radius:50%;">
                                                <?php endif; ?>
                                            </td>

                                            <td><?php echo e($team->name); ?></td>
                                            <td><?php echo e($team->designation); ?></td>

                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Team Edit')): ?>
                                                    <a href="<?php echo e(route('admin.team.edit', $team->id)); ?>"
                                                        class="btn btn-sm btn-info">Edit</a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Team Delete')): ?>
                                                    <button class="btn btn-sm btn-danger deleteTeamBtn"
                                                        data-id="<?php echo e($team->id); ?>">
                                                        Delete
                                                    </button>
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

    <script>
        $(document).ready(function() {

            let table = $('#teamTable').DataTable();

            $(document).on('click', '.deleteTeamBtn', function() {
                let id = $(this).data('id');
                let url = "<?php echo e(url('admin/team-delete')); ?>/" + id;
                let row = $(this).closest('tr');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This team member will be permanently deleted!",
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
                                    table.row(row).remove().draw(false);
                                } else {
                                    Swal.fire("Error", res.message, "error");
                                }
                            },
                            error: function(xhr) {
                                Swal.fire("Error", "Something went wrong!", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/team/list.blade.php ENDPATH**/ ?>