
<?php $__env->startSection('title', config('app.name') . ' || About Us'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Start Page Header -->
    <section class="cs_page_header position-relative background-filled d-flex align-items-center justify-content-between"
        data-src="assets/img/page_header_1.jpeg">
        <div class="container position-relative z-index-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-white cs_fs_18 cs_mb_5">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('front.index')); ?>">Home</a></li>
                    <li class="breadcrumb-item active">About</li>
                </ol>
            </nav>
            <h1 class="cs_fs_48 cs_fs_lg_36 text-white m-0">About Us</h1>
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

    <!-- Start About Section -->
    <section class="cs_pt_135 cs_pt_lg_75 cs_pb_140 cs_pb_lg_80 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 cs_mb_lg_55">
                    <div class="cs_experience cs_style_1 position-relative">
                        <div class="cs_experience_thumb">
                            <img src="<?php echo e(asset($abouts->main_image)); ?>" alt="Thumb"
                                class="position-relative cs_zindex_3 cs_rounded_15">
                            <div class="cs_experience_shape">
                                <img src="<?php echo e(asset('front/img/experience_shape_1.png')); ?>" alt="Shape" class="moving_x">
                            </div>
                        </div>
                        <div class="cs_experience_box background-filled text-center bg-white cs_rounded_10 position-absolute bottom-0 end-0 cs_zindex_3 d-flex flex-column justify-content-center align-items-center"
                            data-src="<?php echo e(asset($abouts->second_image)); ?>">
                            <img src="<?php echo e(asset('front/img/experience_icon.svg')); ?>" alt="Icon" class="cs_mb_5">
                            <h3 class="text-white cs_fs_60 cs_fs_lg_46 fw-bold lh_1 mb-0 d-flex justify-content-between">
                                <span data-count-to="40" class="odometer"></span>
                                <span class="fw-light">+</span>
                            </h3>
                            <h2 class="cs_fs_18 fw-normal text-white m-0">Work Experience</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cs_about cs_style_1">
                        <div class="cs_section_heading cs_style_1 d-flex align-items-center cs_mb_15">
                            <div class="cs_section_heading_in">
                                <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInLeft"
                                    data-wow-duration="0.8s" data-wow-delay="0.2s">About Us</h3>
                                <h2 class="cs_fs_48 cs_fs_lg_36 cs_mb_20"><?php echo $abouts->title; ?></h2>
                                <p class="m-0"><?php echo $abouts->description; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <!-- Start Service Section -->
    <section class="bg-primary cs_pt_140 cs_pt_lg_80 cs_pb_140 cs_pb_lg_80">
        <div class="container">
            <div class="row">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-6">
                        <div
                            class="cs_service cs_style_1 cs_pt_25 cs_pl_25 cs_pr_25 cs_pb_15 bg-white cs_transition_4 shadow cs_mb-25">
                            <div class="cs_service_iconbox d-flex align-items-center cs_mb_20">
                                <h2 class="cs_lh_base cs_fs_20 cs_fs_lg_18 m-0">
                                    <a href="#" class="inline-block"><?php echo e($service->title); ?></a>
                                </h2>
                            </div>
                            <p class="cs_mb_24 two-line">
                                <?php echo e(\Illuminate\Support\Str::limit(strip_tags($service->description), 70)); ?>

                            </p>
                            <div class="cs_service_thumb position-relative cs_rounded_5">
                                <a href="services-details.html"
                                    class="cs_service_btn d-flex align-items-center justify-content-center rounded-circle position-absolute text-white">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.8491 11.347C20.855 11.3381 20.8602 11.3289 20.8656 11.3198C20.8706 11.3114 20.8759 11.3032 20.8805 11.2946C20.8855 11.2853 20.8897 11.2757 20.8942 11.2663C20.8984 11.2573 20.9029 11.2484 20.9067 11.2392C20.9105 11.23 20.9136 11.2206 20.9169 11.2113C20.9205 11.2014 20.9243 11.1916 20.9274 11.1814C20.9302 11.1721 20.9322 11.1626 20.9346 11.1532C20.9372 11.1429 20.9401 11.1327 20.9422 11.1222C20.9444 11.1113 20.9456 11.1003 20.9472 11.0894C20.9485 11.0801 20.9503 11.0711 20.9512 11.0617C20.9532 11.0415 20.9543 11.0213 20.9543 11.001C20.9543 11.0007 20.9543 11.0004 20.9543 11.0001C20.9543 10.9998 20.9543 10.9994 20.9543 10.9991C20.9542 10.9789 20.9532 10.9586 20.9512 10.9384C20.9503 10.929 20.9485 10.92 20.9472 10.9108C20.9456 10.8998 20.9444 10.8888 20.9422 10.8779C20.9401 10.8674 20.9372 10.8572 20.9346 10.8469C20.9322 10.8375 20.9302 10.828 20.9274 10.8187C20.9243 10.8086 20.9205 10.7988 20.9169 10.7889C20.9136 10.7795 20.9105 10.7701 20.9067 10.7609C20.9029 10.7517 20.8984 10.7428 20.8941 10.7338C20.8897 10.7244 20.8855 10.7148 20.8805 10.7055C20.8759 10.6969 20.8706 10.6887 20.8656 10.6803C20.8602 10.6712 20.855 10.662 20.8491 10.6531C20.8428 10.6438 20.8359 10.635 20.8292 10.6261C20.8237 10.6187 20.8186 10.6112 20.8127 10.604C20.7996 10.588 20.7858 10.5727 20.7713 10.5581L15.026 4.81285C14.7819 4.56877 14.3862 4.56877 14.1421 4.81285C13.898 5.05692 13.898 5.45264 14.1421 5.69672L18.8204 10.375L0.88388 10.375C0.53871 10.375 0.258878 10.6548 0.258878 11C0.258878 11.3452 0.53871 11.625 0.88388 11.625L18.8204 11.625L14.1421 16.3033C13.8981 16.5474 13.8981 16.9431 14.1421 17.1872C14.3862 17.4312 14.7819 17.4313 15.026 17.1872L20.7713 11.442C20.7858 11.4274 20.7996 11.4121 20.8127 11.3962C20.8186 11.389 20.8237 11.3814 20.8292 11.374C20.8359 11.3651 20.8428 11.3563 20.8491 11.347Z"
                                            fill="currentColor" />
                                    </svg>
                                </a>
                                <div class="cs_service_thumb-in position-relative-in background-filled h-100"
                                    data-src="<?php echo e(asset($service->image)); ?>"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="cs_service_1-info  text-center cs_mt_40 d-flex justify-content-center align-items-center flex-wrap">
                <h4 class="fw-normal m-0 text-white"><span class="text-accent">Digital agency</span> services built
                    specifically for your business</h4>
                <a href="service.html"
                    class="cs_btn cs_style_1 cs_fs_16  overflow-hidden cs_fs_16 cs_rounded_25 cs_pl_20 cs_pr_20 cs_pt_7 cs_pb_7 wow zoomIn"
                    data-wow-duration="0.8s" data-wow-delay="0.2s"><span>Find More Services</span></a>
            </div>
        </div>
    </section>
    <!-- End Service Section -->

    <!-- Start Team Section -->
    <section class="cs_pt_133 cs_pt_lg_75">
        <div class="container">
            <div class="cs_section_heading cs_style_1 d-flex align-items-center text-center cs_mb_60 cs_mb_lg_40">
                <div class="cs_section_heading_in">
                    <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInUp"
                        data-wow-duration="0.8s" data-wow-delay="0.2s">Meet Our Team Member</h3>
                    <h2 class="cs_fs_48 cs_fs_lg_36 m-0">Meet the professional team <br>behind the success</h2>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4">
                        <div class="cs_team cs_style_1 text-center cs_mb_25 overflow-hidden cs_rounded_50">
                            <div class="cs_team_member position-relative cs_rounded_50">
                                <img class="w-100 cs_rounded_50" src="<?php echo e(asset($team->image)); ?>"
                                    alt="<?php echo e($team->name); ?>">
                                <div
                                    class="cs_social_btns d-flex flex-wrap cs_column_gap_15 cs_row_gap_15 cs_transition_5 cs_fs_20 cs_fs_lg_18 position-absolute">
                                </div>
                            </div>
                            <div class="cs_team_info cs_pt_127 cs_pl_15 cs_pr_15 cs_pb_25 cs_transition_4">
                                <h2 class="text-white m-0 cs_fs_26 cs_mb_3"><?php echo e($team->name); ?></h2>
                                <p class="text-white m-0"><?php echo e($team->designation); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <!-- End Team Section -->

    <!-- Start Testimonial Section -->
    <section class="background-filled cs_pt_110 cs_pt_lg_55 cs_pb_140 cs_pb_lg_80"
        data-src="assets/img/testimonial_bg.jpeg">
        <div class="cs_testimonial_slider cs_gap_30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 cs_mb_lg_40">
                        <div class="cs_section_heading cs_style_1 d-flex align-items-center cs_mb_30">
                            <div class="cs_section_heading_in">
                                <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInLeft"
                                    data-wow-duration="0.8s" data-wow-delay="0.2s">Testimonial</h3>
                                <h2 class="cs_fs_48 cs_fs_lg_36 cs_mb_20">What Theyâ€™re Saying?</h2>
                                <p class="m-0">Providing legal advice, contract drafting, compliance assistance,
                                    intellectual property protection, and other legal support for businesses.</p>
                            </div>
                        </div>
                        <div class="d-flex cs_column_gap_15">
                            <div
                                class="cs_slider_prev filter cs_height_45 cs_width_45 bg-white rounded-circle d-flex align-items-center justify-content-center bg-accent-hover cs_transition_4">
                                <svg width="20" height="8" viewBox="0 0 20 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.461063 4.4077H19.538C19.7649 4.4077 19.9482 4.22437 19.9482 3.99745C19.9482 3.77052 19.7649 3.58719 19.538 3.58719H1.45209L3.94183 1.09745C4.10209 0.937189 4.10209 0.676933 3.94183 0.516677C3.78158 0.35642 3.52132 0.35642 3.36106 0.516677L0.170038 3.7077C0.0520878 3.82565 0.0174732 4.00129 0.0815754 4.15514C0.145678 4.3077 0.295677 4.4077 0.461063 4.4077Z"
                                        fill="black" />
                                    <path
                                        d="M3.65549 7.60253C3.76062 7.60253 3.86575 7.56278 3.94524 7.48202C4.10549 7.32176 4.10549 7.0615 3.94524 6.90125L0.750365 3.70637C0.590108 3.54612 0.329853 3.54612 0.169597 3.70637C0.00934029 3.86663 0.00934029 4.12689 0.169597 4.28714L3.36447 7.48202C3.44524 7.56278 3.55036 7.60253 3.65549 7.60253Z"
                                        fill="black" />
                                </svg>
                            </div>
                            <div
                                class="cs_slider_next filter cs_height_45 cs_width_45 bg-white rounded-circle d-flex align-items-center justify-content-center bg-accent-hover cs_transition_4">
                                <svg width="20" height="8" viewBox="0 0 20 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.5389 4.4077H0.462014C0.235091 4.4077 0.0517578 4.22437 0.0517578 3.99745C0.0517578 3.77052 0.235091 3.58719 0.462014 3.58719H18.5479L16.0582 1.09745C15.8979 0.937189 15.8979 0.676933 16.0582 0.516677C16.2184 0.35642 16.4787 0.35642 16.6389 0.516677L19.83 3.7077C19.9479 3.82565 19.9825 4.00129 19.9184 4.15514C19.8543 4.3077 19.7043 4.4077 19.5389 4.4077Z"
                                        fill="#18191D" />
                                    <path
                                        d="M16.3445 7.60253C16.2394 7.60253 16.1342 7.56278 16.0548 7.48202C15.8945 7.32176 15.8945 7.0615 16.0548 6.90125L19.2496 3.70637C19.4099 3.54612 19.6701 3.54612 19.8304 3.70637C19.9907 3.86663 19.9907 4.12689 19.8304 4.28714L16.6355 7.48202C16.5548 7.56278 16.4496 7.60253 16.3445 7.60253Z"
                                        fill="#18191D" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="cs_slider_activate">                            
                            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="cs_slide">
                                    <div class="cs_testimonial cs_style_1 cs_pt_20">
                                        <div
                                            class="cs_testimonial_in bg-white shadow-sm cs_pl_30 cs_pr_30 cs_pb_27 cs_pt_1 cs_rounded_10">
                                            <div class="cs_testimonial_img cs_mb_15">
                                                <img src="<?php echo e(asset($testimonial->image)); ?>" alt="Avatar"
                                                    class="cs_height_75 cs_width_75 rounded-circle">
                                            </div>
                                            <div class="cs_rating text-accent cs_mb_15"
                                                data-rating="<?php echo e($testimonial->star); ?>">
                                                <div class="cs_rating_percentage"></div>
                                            </div>
                                            <p class="cs_mb_14"><?php echo $testimonial->message; ?></p>
                                            <h3 class="cs_fs_18 cs_mb_2 cs_lh_base"><?php echo e($testimonial->name); ?></h3>
                                            <p class="m-0 cs_fs_14 cs_lh_base"><?php echo e($testimonial->designation); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonial Section -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/front/about_us.blade.php ENDPATH**/ ?>