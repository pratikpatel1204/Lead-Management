
<?php $__env->startSection('title', config('app.name') . ' || Blogs'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Start Page Header -->
    <section class="cs_page_header position-relative background-filled d-flex align-items-center justify-content-between"
        data-src="assets/img/page_header_1.jpeg">
        <div class="container position-relative z-index-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-white cs_fs_18 cs_mb_5">
                    <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
                    <li class="breadcrumb-item active">Service Details</li>
                </ol>
            </nav>
            <h1 class="cs_fs_48 cs_fs_lg_36 text-white m-0"><?php echo e($service->category->title ?? 'N/A'); ?></h1>
        </div>
        <div class="position-absolute end-0 bottom-0">
            <svg width="660" height="497" viewBox="0 0 660 497" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M240 0H660L430 497H0L240 0Z" fill="url(#paint0_linear_81_9510)" />
                <defs>
                    <linearGradient id="paint0_linear_81_9510" x1="330" y1="78.2497" x2="375.052" y2="780.743"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="white" stop-opacity="0" offset="none" />
                        <stop offset="0.9999" stop-color="#D9D9D9" stop-opacity="0.35" />
                        <stop offset="1" stop-color="#222121" stop-opacity="0" />
                        <stop offset="1" stop-color="#222121" stop-opacity="0" />
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </section>
    <!-- End Page Header -->

    <!-- Start Service Details Section -->
    <section class="cs_pt_140 cs_pt_lg_80 cs_pb_115 cs_pb_lg_55">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 cs_mb_lg_60">
                    <div class="cs_service_list cs_mb_40">
                        <h2 class="cs_fs_20 text-white text-uppercase bg-accent cs_pl_30 cs_pr_30 cs_pt_23 cs_pb_23 m-0">All
                            Services</h2>
                        <ul class="m-0 cs_pl_30 cs_pr_30 cs_pt_30 cs_pb_30">
                            <?php $__currentLoopData = $serviceCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('front.service.category', $category->slug)); ?>"
                                        class="<?php echo e($service->category && $service->category->id === $category->id ? 'active' : ''); ?>">
                                        <?php echo e($category->title); ?>

                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7">
                    <img src="<?php echo e(asset($service->image)); ?>" alt="Thumb" class="cs_mb_40">
                    <h2 class="cs_fs_26 cs_mb_20"><?php echo e($service->title); ?></h2>
                    <p class="cs_mb_40"><?php echo $service->description; ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Service Details Section -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/front/service_details.blade.php ENDPATH**/ ?>