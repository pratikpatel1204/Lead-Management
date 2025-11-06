
<?php $__env->startSection('title', config('app.name') . ' || Blogs'); ?>
<?php $__env->startSection('content'); ?>

    <!-- Start Page Header -->
    <section class="cs_page_header position-relative background-filled d-flex align-items-center justify-content-between"
        data-src="assets/img/page_header_1.jpeg">
        <div class="container position-relative z-index-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-white cs_fs_18 cs_mb_5">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('front.index')); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Blogs</li>
                </ol>
            </nav>
            <h1 class="cs_fs_48 cs_fs_lg_36 text-white m-0">Blog Posts</h1>
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

    <!-- Start Our Latest Project -->
    <!-- Start Blog Section -->
    <section class="cs_pt_140 cs_pt_lg_80 cs_pb_100 cs_pb_lg_80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php $__currentLoopData = $allBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cs_post cs_style_1 bg-white shadow-sm cs_mb_40">
                            <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>" class="cs_post_thumb d-block position-relative overflow-hidden">
                                <div class="cs_post_thumb-in cs_transition_5 background-filled h-100 w-100"
                                    data-src="<?php echo e(asset($blog->image)); ?>"></div>
                            </a>
                            <div
                                class="cs_pl_40 cs_pr_40 cs_pt_40 cs_pb_40 cs_pl_lg_25 cs_pr_lg_25 cs_pt_lg_25 cs_pb_lg_25">
                                <ul class="cs_post_meta d-flex flex-wrap cs_fs_12 p-0 cs_mb_20">
                                    <li>
                                        <span><i class="fa-solid fa-user"></i> By </span>
                                        <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->author_name); ?></a>
                                    </li>
                                    <li>
                                        <span><i class="fa-solid fa-calendar-days"></i></span>
                                        <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->created_at->format('F d, Y')); ?></a>
                                    </li>
                                </ul>
                                <h2 class="cs_post_title cs_lh_base cs_fs_26 cs_fs_lg_18 cs_mb_20">
                                    <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->title); ?></a></h2>
                                <div class="cs_post_subtitle cs_mb_30"><?php echo e($blog->short_description); ?></div>
                                <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"
                                    class="cs_post_btn d-inline-flex justify-content-between align-items-center cs_pl_25 cs_pr_25 cs_pb_10 cs_pt_10">
                                    <span class="cs_post_btn-text cs_mr_30">Read More</span>
                                    <div class="cs_post_btn-icon d-flex cs_transition_4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.9999 0.224976C6.52011 0.224976 1.63131 4.16368 0.485006 9.52707C-0.0876941 12.207 0.298106 15.0567 1.57581 17.4816C2.80551 19.8153 4.82151 21.7014 7.23351 22.7703C9.74241 23.8824 12.6227 24.0762 15.2597 23.3178C17.8037 22.5864 20.0594 20.9811 21.5951 18.8262C24.806 14.3211 24.3767 7.99288 20.5991 3.95608C18.3851 1.59028 15.2405 0.224976 11.9999 0.224976ZM17.6486 12.6291L14.4386 15.9165C13.6259 16.749 12.3413 15.4878 13.1507 14.6592L14.7704 13.0005H7.09461C6.54951 13.0005 6.09471 12.5454 6.09471 12.0006C6.09471 11.4558 6.54981 11.0007 7.09461 11.0007H14.732L13.0802 9.34918C12.2594 8.52838 13.532 7.25548 14.3528 8.07628L17.6411 11.3643C17.9897 11.7126 17.993 12.2766 17.6486 12.6291Z"
                                                fill="currentColor" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="col-lg-4">
                    <div class="cs_sidebar">
                        <div class="cs_sidebar_item widget_categories">
                            <h4 class="cs_sidebar_widget_title">Categories</h4>
                            <ul>
                                <?php $__currentLoopData = $blogCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="cat-item">
                                        <a href="<?php echo e(route('front.blog.category', $category->slug)); ?>"><?php echo e($category->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="cs_sidebar_item">
                            <h4 class="cs_sidebar_widget_title">Recent Posts</h4>
                            <ul class="cs_recent_posts">
                                <?php $__currentLoopData = $recentBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <div class="cs_recent_post">
                                            <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>" class="cs_recent_post-thumb">
                                                <div class="h-100 w-100 background-filled"
                                                    data-src="<?php echo e(asset($blog->image)); ?>"></div>
                                            </a>
                                            <div class="cs_recent_post-info">
                                                <div class="cs_recent_post-date"><i class="fa-regular fa-calendar-days"></i>
                                                    <?php echo e($blog->created_at->format('F d, Y')); ?></div>
                                                <h3 class="cs_recent_post-title">
                                                    <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->title); ?></a>
                                                </h3>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <?php echo e($allBlogs->links()); ?>

            </div>
        </div>
    </section>
    <!-- End Blog Section -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/front/blog.blade.php ENDPATH**/ ?>