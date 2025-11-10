
<?php $__env->startSection('title', config('app.name') . ' || Create Field'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Field</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Fields</li>
                        <li class="breadcrumb-item active">Create Field</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-body">
                <form id="fieldForm" action="<?php echo e(route('admin.field.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Field Name"
                                required>
                            <span class="text-danger error-name"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Field Type <span class="text-danger">*</span></label>
                            <select name="type" id="fieldType" class="form-select" required>
                                <option value="">Select Type</option>

                                <!-- Basic Inputs -->
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="email">Email</option>
                                <option value="password">Password</option>

                                <!-- Numbers & Contact -->
                                <option value="number">Number</option>
                                <option value="mobile">Mobile Number</option>
                                <option value="tel">Telephone</option>

                                <!-- Dates & Time -->
                                <option value="date">Date</option>
                                <option value="datetime-local">Datetime Local</option>
                                <option value="month">Month</option>
                                <option value="time">Time</option>
                                <option value="week">Week</option>

                                <!-- Selection Inputs -->
                                <option value="select">Dropdown (Select)</option>
                                <option value="radio">Radio Button</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="multi_select">Multi Select</option>

                                <!-- File Inputs -->
                                <option value="file">File Upload</option>
                                <option value="image">Image Upload</option>

                                <!-- URL & Hidden -->
                                <option value="url">URL</option>
                                <option value="hidden">Hidden Field</option>

                                <!-- Special Inputs -->
                                <option value="color">Color Picker</option>
                                <option value="range">Range (Slider)</option>
                                <option value="switch">Toggle Switch</option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Validation</label>
                            <select name="validation" id="validation" class="form-select">
                                <option value="">Select Validation</option>
                                <option value="required">Required</option>
                                <option value="nullable">Nullable</option>
                                <option value="readonly">Readonly</option>
                            </select>
                        </div>                        
                        
                    </div>

                    <div class="text-end">
                        <a href="<?php echo e(route('admin.field.list')); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <span class="btn-text">Create Field</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/field/create.blade.php ENDPATH**/ ?>