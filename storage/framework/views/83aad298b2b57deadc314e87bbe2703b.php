
<?php $__env->startSection('title', config('app.name') . ' || Blog Details'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Start Page Header -->
    <section class="cs_page_header position-relative background-filled d-flex align-items-center justify-content-between"
        data-src="assets/img/page_header_1.jpeg">
        <div class="container position-relative z-index-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-white cs_fs_18 cs_mb_5">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('front.index')); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Blog Details</li>
                </ol>
            </nav>
            <h1 class="cs_fs_48 cs_fs_lg_36 text-white m-0">Blog Details</h1>
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

    <!-- Start Blog Section -->
    <section class="cs_pt_140 cs_pt_lg_80 cs_pb_140 cs_pb_lg_80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cs_post cs_style_1 bg-white shadow-sm cs_mb_30">
                        <img src="<?php echo e(asset($blog->image)); ?>" alt="">
                        <div class="cs_pl_40 cs_pr_40 cs_pt_40 cs_pb_40 cs_pl_lg_25 cs_pr_lg_25 cs_pt_lg_25 cs_pb_lg_25">
                            <ul class="cs_post_meta d-flex flex-wrap cs_fs_12 p-0 cs_mb_20">
                                <li>
                                    <span><i class="fa-solid fa-user"></i> By </span>
                                    <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->author_name); ?></a>
                                </li>
                                <li>
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <a
                                        href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->created_at->format('F d, Y')); ?></a>
                                </li>
                            </ul>
                            <h2 class="cs_post_title cs_lh_base cs_fs_26 cs_fs_lg_18 cs_mb_20">
                                <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->title); ?></a>
                            </h2>
                            <div class="cs_post_subtitle"><?php echo $blog->description; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cs_sidebar cs_mt_lg_80">
                        <div class="cs_sidebar_item widget_categories">
                            <h4 class="cs_sidebar_widget_title">Categories</h4>
                            <ul>
                                <?php $__currentLoopData = $blogCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="cat-item">
                                        <a href="<?php echo e(route('front.blog.category', Str::slug($category->name))); ?>"><?php echo e($category->name); ?></a>
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
                                <li>
                                    <div class="cs_recent_post">
                                        <a href="#" class="cs_recent_post-thumb">
                                            <div class="h-100 w-100 background-filled"
                                                data-src="assets/img/recent-post-2.jpeg"></div>
                                        </a>
                                        <div class="cs_recent_post-info">
                                            <div class="cs_recent_post-date"><i class="fa-regular fa-calendar-days"></i>
                                                14 Mar, 2023</div>
                                            <h3 class="cs_recent_post-title">
                                                <a href="#">What services does your business provide?</a>
                                            </h3>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="cs_recent_post">
                                        <a href="#" class="cs_recent_post-thumb">
                                            <div class="h-100 w-100 background-filled"
                                                data-src="assets/img/recent-post-3.jpeg"></div>
                                        </a>
                                        <div class="cs_recent_post-info">
                                            <div class="cs_recent_post-date"><i class="fa-regular fa-calendar-days"></i>
                                                12 Mar, 2023</div>
                                            <h3 class="cs_recent_post-title">
                                                <a href="#">What services does your business provide?</a>
                                            </h3>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog Section -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/front/blog_details.blade.php ENDPATH**/ ?>