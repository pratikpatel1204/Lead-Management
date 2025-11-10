<?php $__env->startSection('title', config('app.name') . ' || Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Dashboard</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Superadmin</li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="input-icon mb-2 position-relative">
                    <span class="input-icon-addon">
                        <i class="ti ti-calendar text-gray-9"></i>
                    </span>
                    <input type="text" class="form-control date-range bookingrange"
                        placeholder="dd/mm/yyyy - dd/mm/yyyy">
                </div>
                <div class="ms-2 head-icons">
                    <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Welcome Wrap -->
        <div class="welcome-wrap mb-4">
            <div class=" d-flex align-items-center justify-content-between flex-wrap">
                <div class="mb-3">
                    <h2 class="mb-1 text-white">Welcome Back, Adrian</h2>
                    <p class="text-light">14 New Companies Subscribed Today !!!</p>
                </div>
                <div class="d-flex align-items-center flex-wrap mb-1">
                    <a href="javascript:void(0);" class="btn btn-dark btn-md me-2 mb-2">Companies</a>
                    <a href="javascript:void(0);" class="btn btn-light btn-md mb-2">All
                        Packages</a>
                </div>
            </div>
            <div class="welcome-bg">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-02.svg')); ?>" alt="img" class="welcome-bg-01">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-03.svg')); ?>" alt="img" class="welcome-bg-02">
                <img src="<?php echo e(asset('admin/img/bg/welcome-bg-01.svg')); ?>" alt="img" class="welcome-bg-03">
            </div>
        </div>
        <!-- /Welcome Wrap -->

        <div class="row">

            <!-- Total Companies -->
            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="ti ti-building fs-16"></i>
                            </span>
                            <span class="badge bg-success fw-normal mb-3">
                                +19.01%
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="mb-1">5468</h2>
                                <p class="fs-13">Total Companies</p>
                            </div>
                            <div class="company-bar1">5,10,7,5,10,7,5</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Total Companies -->

            <!-- Active Companies -->
            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="ti ti-carousel-vertical fs-16"></i>
                            </span>
                            <span class="badge bg-danger fw-normal mb-3">
                                -12%
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="mb-1">4598</h2>
                                <p class="fs-13">Active Companies</p>
                            </div>
                            <div class="company-bar2">5,3,7,6,3,10,5</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Active Companies -->

            <!-- Total Subscribers -->
            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="ti ti-chalkboard-off fs-16"></i>
                            </span>
                            <span class="badge bg-success fw-normal mb-3">
                                +6%
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="mb-1">3698</h2>
                                <p class="fs-13">Total Subscribers</p>
                            </div>
                            <div class="company-bar3">8,10,10,8,8,10,8</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Total Subscribers -->

            <!-- Total Earnings -->
            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="ti ti-businessplan fs-16"></i>
                            </span>
                            <span class="badge bg-danger fw-normal mb-3">
                                -16%
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="mb-1">$89,878,58</h2>
                                <p class="fs-13">Total Earnings</p>
                            </div>
                            <div class="company-bar4">5,10,7,5,10,7,5</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Total Earnings -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>