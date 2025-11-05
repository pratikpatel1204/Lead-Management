
<?php $__env->startSection('title', config('app.name') . ' || Category List'); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">Category List</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Categories</li>
                    <li class="breadcrumb-item active" aria-current="page">Category List</li>
                </ol>
            </nav>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Services Categories')): ?>
        <a href="<?php echo e(route('admin.create.services.categories')); ?>" class="btn btn-primary mt-2 mt-md-0">
            + Add Category
        </a>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Categories</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="categoryTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Short Description</th>
                                    <th>Status</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>

                                    <td>
                                        <?php if($category->image): ?>
                                            <img src="<?php echo e(asset($category->image)); ?>" width="60" height="40" style="object-fit:cover;border-radius:5px;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('default/no-img.jpg')); ?>" width="60" height="40" style="object-fit:cover;border-radius:5px;">
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo e($category->title); ?></td>

                                    <td><?php echo e(Str::limit($category->short_description, 40)); ?></td>

                                    <td>
                                        <?php if($category->status == 'Active'): ?>
                                            <span class="badge bg-primary">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Services Categories Edit')): ?>                                            
                                        <a href="<?php echo e(route('admin.services.categories.edit', $category->id)); ?>" class="btn btn-sm btn-info">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Services Categories Delete')): ?>                                            
                                        <button class="btn btn-sm btn-danger deleteCategoryBtn" data-id="<?php echo e($category->id); ?>">
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
    let table = $('#categoryTable').DataTable();

    $(document).on('click', '.deleteCategoryBtn', function() {
        let id = $(this).data('id');
        let url = "<?php echo e(url('admin/services-categories-delete')); ?>/" + id;
        let row = $(this).closest('tr');

        Swal.fire({
            title: "Are you sure?",
            text: "This category and all related services will be permanently deleted!",
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
                        if (res.success) {
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

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/service/list_categories.blade.php ENDPATH**/ ?>