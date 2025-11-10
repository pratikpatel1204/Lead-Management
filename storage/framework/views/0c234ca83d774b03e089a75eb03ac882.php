
<?php $__env->startSection('title', config('app.name') . ' || Banner List'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Banner List</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Banner</li>
                    <li class="breadcrumb-item active" aria-current="page">Banner List</li>
                </ol>
            </nav>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Banner')): ?>
        <a href="<?php echo e(route('admin.banner.create')); ?>" class="btn btn-primary mt-2 mt-md-0">
            + Add Banner
        </a>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Banner List</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="bannerTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Banner Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>

                                    <td>
                                        <?php if($banner->image): ?>
                                            <img src="<?php echo e(asset($banner->image)); ?>" width="60" height="40" style="object-fit:cover;border-radius:5px;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('default/no-img.jpg')); ?>" width="60" height="40" style="object-fit:cover;border-radius:5px;">
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo e($banner->title); ?></td>

                                    <td>
                                        <?php if($banner->status == 'Active'): ?>
                                            <span class="badge bg-primary">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="<?php echo e(route('admin.banner.edit', $banner->id)); ?>" class="btn btn-sm btn-info">Edit</a>

                                        <button class="btn btn-sm btn-danger deleteBannerBtn" data-id="<?php echo e($banner->id); ?>">
                                            Delete
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
</div>

<script>
$(document).ready(function() {
    let table = $('#bannerTable').DataTable();

    $(document).on('click', '.deleteBannerBtn', function() {
        let id = $(this).data('id');
        let url = "<?php echo e(url('admin/banners-delete')); ?>/" + id;
        let row = $(this).closest('tr');

        Swal.fire({
            title: "Are you sure?",
            text: "This banner will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "<?php echo e(csrf_token()); ?>" },
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

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/banner/list.blade.php ENDPATH**/ ?>