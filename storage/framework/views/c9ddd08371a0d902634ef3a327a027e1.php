<?php $__env->startSection('title', config('app.name') . ' || Home'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Start Hero -->
    <section class="cs_hero_1-wrap position-relative cs_hero_slider bg-primary">
        <div class="cs_swiper_parallax_slider_wrap">
            <div class="cs_parallax_slider loading">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div
                                class="cs_hero cs_style_1 d-flex align-items-center justify-content-center background-filled position-relative overflow-hidden">
                                <figure class="cs_swiper_parallax_bg" data-src="<?php echo e(asset($banner->image)); ?>">
                                    <img src="<?php echo e(asset($banner->image)); ?>" alt="<?php echo e($banner->title); ?>" class="cs_entity_img">
                                    <div class="bg-primary opacity-75 position-absolute w-100 h-100 start-0 top-0"></div>
                                </figure>
                                <div class="container">
                                    <div class="cs_hero_text position-relative cs_zindex_5 d-inline-block">
                                        <h1 class="text-white cs_mb_16 cs_fs_60 cs_fs_lg_30"><?php echo e($banner->title); ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- If we need navigation buttons -->
                <div class="cs_slider_navigation d-flex cs_row_gap_15 flex-column position-absolute cs_zindex_4">
                    <div
                        class="cs_swiper_button_prev filter cs_height_45 cs_width_45 bg-white rounded-circle d-flex align-items-center justify-content-center bg-accent-hover cs_transition_4">
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
                        class="cs_swiper_button_next filter cs_height_45 cs_width_45 bg-white rounded-circle d-flex align-items-center justify-content-center bg-accent-hover cs_transition_4">
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
                <div class="cs_hero_shape_1 position-absolute bottom-0 d-flex align-items-end h-100 cs_zindex_1">
                    <svg width="434" height="759" viewBox="0 0 434 759" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M240 0H660L430 759H0L240 0Z" fill="url(#paint0_linear_81_287)" />
                        <defs>
                            <linearGradient id="paint0_linear_81_287" x1="145" y1="256.5" x2="484"
                                y2="738" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#D9D9D9" stop-opacity="0" offset="0" />
                                <stop offset="1" stop-color="#E9A132" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="cs_hero_shape_2 position-absolute start-0 cs_zindex_1">
                    <svg width="572" height="572" viewBox="0 0 572 572" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M572 -6.10352e-05L6.10352e-05 572L1.10293e-05 -1.10293e-05L572 -6.10352e-05Z"
                            fill="url(#paint0_linear_81_258)" fill-opacity="0.7" />
                        <defs>
                            <linearGradient id="paint0_linear_81_258" x1="388.254" y1="307.69" x2="-127.973"
                                y2="-227.83" gradientUnits="userSpaceOnUse">
                                <stop offset="0.0457759" stop-color="#18191D" stop-opacity="0" />
                                <stop offset="0.514455" stop-color="#FEC63F" stop-opacity="0.35" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <!-- Animated Text -->
    <div class="cs_moving_wrap background-filled text-uppercase text-white d-flex align-items-center"
        data-src="<?php echo e(asset('front/img/moving_text_shape.png')); ?>">
        <div class="cs_moving_text cs_fs_30 cs_fs_lg_26 d-flex align-items-center text-nowrap">
            <?php $__currentLoopData = $servicecategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicecat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span>* <?php echo e($servicecat->title); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <!-- End Animated Text -->

    <!-- Start Service Section -->
    <section class="background-filled cs_pt_133 cs_pt_lg_75 cs_pb_140 cs_pb_lg_80 cs_gray_bg"
        data-src="<?php echo e(asset('front/img/services_bg.jpeg')); ?>">
        <div class="container">
            <div
                class="cs_section_heading cs_style_1 d-flex align-items-center cs_mb_60 cs_mb_lg_40 cs_column_gap_15 cs_row_gap_15">
                <div class="cs_section_heading_in">
                    <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInLeft"
                        data-wow-duration="0.8s" data-wow-delay="0.2s">Our Service List</h3>
                    <h2 class="cs_fs_48 cs_fs_lg_36 m-0">We Provide The Solution <br>For Our Clients</h2>
                </div>
                <div class="cs_section_heading_right">
                    <p class="cs_section_text m-0">I have been a loyal customer of this auto parts company for years
                        and I cannot recommend them enough. Their extensive selection of high-quality parts and
                        accessories.</p>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-6">
                        <div
                            class="cs_service cs_style_1 cs_pt_25 cs_pl_25 cs_pr_25 cs_pb_15 bg-white cs_transition_4 shadow cs_mb-25">
                            <div class="cs_service_iconbox d-flex align-items-center cs_mb_20">
                                <h2 class="cs_lh_base cs_fs_20 cs_fs_lg_18 m-0">
                                    <a href="<?php echo e(route('front.service.details', $service->slug)); ?>"
                                        class="inline-block"><?php echo e($service->title); ?></a>
                                </h2>
                            </div>
                            <p class="cs_mb_24 two-line">
                                <?php echo e(\Illuminate\Support\Str::limit(strip_tags($service->description), 70)); ?>

                            </p>
                            <div class="cs_service_thumb position-relative cs_rounded_5">
                                <a href="<?php echo e(route('front.service.details', $service->slug)); ?>"
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
            <div
                class="cs_service_1-info  text-center cs_mt_40 d-flex justify-content-center align-items-center flex-wrap">
                <h4 class="fw-normal m-0">Digital agency services built specifically for your business</h4>
                <a href="<?php echo e(route('front.services')); ?>"
                    class="cs_btn cs_style_1 cs_fs_16  overflow-hidden cs_fs_16 cs_rounded_25 cs_pl_20 cs_pr_20 cs_pt_7 cs_pb_7 wow zoomIn"
                    data-wow-duration="0.8s" data-wow-delay="0.2s"><span>Find More Services</span></a>
            </div>
        </div>
    </section>
    <!-- End Service Section -->

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
                                <img src="<?php echo e(asset('front/img/experience_shape_1.png')); ?>" alt="Shape"
                                    class="moving_x">
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

    <!-- Start Why Choose Us -->
    <section class="position-relative cs_iconbox_2_wrap cs_pt_135 cs_pt_lg_75 cs_pb_100 cs_pb_lg_40 overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="position-relative cs_zindex_3">
                        <div
                            class="cs_section_heading cs_style_1 d-flex align-items-center cs_mb_60 cs_mb_lg_40 cs_column_gap_15 cs_row_gap_15">
                            <div class="cs_section_heading_in">
                                <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInLeft"
                                    data-wow-duration="0.8s" data-wow-delay="0.2s">Why Choose Us</h3>
                                <h2 class="cs_fs_48 cs_fs_lg_36 cs_mb_20 text-white"><?php echo e($choose_us->title); ?></h2>
                                <p class="text-white m-0"><?php echo e($choose_us->short_description); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="cs_iconbox cs_style_1 d-flex align-items-center cs_mb_40">
                                    <div class="cs_iconbox_icon d-flex align-items-center justify-content-center cs_height_70 cs_width_70 cs_rounded_10 flex-none cs_mr_20 bg-accent cs_transition_4 wow zoomIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M36.8436 1.9563H3.15638C1.41593 1.9563 0 3.37223 0 5.11268V27.3739C0 29.1144 1.41593 30.5303 3.15638 30.5303H14.5176V36.2336H10.2438C9.74407 36.2336 9.33882 36.6387 9.33882 37.1386C9.33882 37.6384 9.74407 38.0435 10.2438 38.0435H29.7561C30.2558 38.0435 30.6611 37.6384 30.6611 37.1386C30.6611 36.6387 30.2558 36.2336 29.7561 36.2336H25.4824V30.5303H36.8435C38.5839 30.5303 39.9999 29.1144 39.9999 27.3739V5.11268C40 3.37223 38.5841 1.9563 36.8436 1.9563ZM3.15638 3.76625H36.8436C37.5861 3.76625 38.19 4.37024 38.19 5.11268V24.8078H1.80995V5.11268C1.80995 4.37024 2.41394 3.76625 3.15638 3.76625ZM23.6725 36.2336H16.3275V30.5303H23.6725V36.2336ZM36.8436 28.7204H3.15638C2.41394 28.7204 1.80995 28.1164 1.80995 27.3739V26.6177H38.19V27.3739C38.19 28.1164 37.5861 28.7204 36.8436 28.7204Z"
                                                fill="white" />
                                            <path
                                                d="M13.944 19.3833H26.0566C26.5563 19.3833 26.9616 18.9782 26.9616 18.4784V10.0957C26.9616 9.59583 26.5563 9.19067 26.0566 9.19067H13.944C13.4443 9.19067 13.0391 9.59583 13.0391 10.0957V18.4784C13.0391 18.9781 13.4443 19.3833 13.944 19.3833ZM14.849 11.0006H25.1516V17.5734H14.849V11.0006Z"
                                                fill="white" />
                                            <path
                                                d="M28.738 11.0006H29.3716C29.8714 11.0006 30.2766 10.5955 30.2766 10.0957C30.2766 9.59583 29.8714 9.19067 29.3716 9.19067H28.738C28.2383 9.19067 27.833 9.59583 27.833 10.0957C27.833 10.5955 28.2382 11.0006 28.738 11.0006Z"
                                                fill="white" />
                                            <path
                                                d="M26.0563 8.31902C26.5561 8.31902 26.9613 7.91386 26.9613 7.41404V6.78047C26.9613 6.28065 26.5561 5.87549 26.0563 5.87549C25.5566 5.87549 25.1514 6.28065 25.1514 6.78047V7.41404C25.1514 7.91386 25.5565 8.31902 26.0563 8.31902Z"
                                                fill="white" />
                                            <path
                                                d="M28.738 19.3834H29.3716C29.8714 19.3834 30.2766 18.9783 30.2766 18.4785C30.2766 17.9786 29.8714 17.5735 29.3716 17.5735H28.738C28.2383 17.5735 27.833 17.9786 27.833 18.4785C27.833 18.9783 28.2382 19.3834 28.738 19.3834Z"
                                                fill="white" />
                                            <path
                                                d="M26.0563 20.2549C25.5566 20.2549 25.1514 20.66 25.1514 21.1599V21.7934C25.1514 22.2933 25.5566 22.6984 26.0563 22.6984C26.5561 22.6984 26.9613 22.2933 26.9613 21.7934V21.1599C26.9613 20.66 26.5561 20.2549 26.0563 20.2549Z"
                                                fill="white" />
                                            <path
                                                d="M10.6286 11.0006H11.2623C11.762 11.0006 12.1673 10.5955 12.1673 10.0957C12.1673 9.59583 11.762 9.19067 11.2623 9.19067H10.6286C10.1289 9.19067 9.72363 9.59583 9.72363 10.0957C9.72363 10.5955 10.1289 11.0006 10.6286 11.0006Z"
                                                fill="white" />
                                            <path
                                                d="M13.944 8.31902C14.4438 8.31902 14.849 7.91386 14.849 7.41404V6.78047C14.849 6.28065 14.4438 5.87549 13.944 5.87549C13.4443 5.87549 13.0391 6.28065 13.0391 6.78047V7.41404C13.0391 7.91386 13.4443 8.31902 13.944 8.31902Z"
                                                fill="white" />
                                            <path
                                                d="M10.6286 19.3834H11.2623C11.762 19.3834 12.1673 18.9783 12.1673 18.4785C12.1673 17.9786 11.762 17.5735 11.2623 17.5735H10.6286C10.1289 17.5735 9.72363 17.9786 9.72363 18.4785C9.72363 18.9783 10.1289 19.3834 10.6286 19.3834Z"
                                                fill="white" />
                                            <path
                                                d="M13.944 22.6984C14.4438 22.6984 14.849 22.2933 14.849 21.7934V21.1599C14.849 20.66 14.4438 20.2549 13.944 20.2549C13.4443 20.2549 13.0391 20.66 13.0391 21.1599V21.7934C13.0391 22.2933 13.4443 22.6984 13.944 22.6984Z"
                                                fill="white" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-white m-0 cs_fs_20 cs_fs_lg_18 cs_lh_base"><?php echo e($choose_us->list_one); ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="cs_iconbox cs_style_1 d-flex align-items-center cs_mb_40">
                                    <div class="cs_iconbox_icon d-flex align-items-center justify-content-center cs_height_70 cs_width_70 cs_rounded_10 flex-none cs_mr_20 bg-accent cs_transition_4 wow zoomIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_81_544)">
                                                <path
                                                    d="M39.1734 1.5156C39.1376 1.35251 39.0563 1.19738 38.9295 1.07058C38.8027 0.943877 38.6476 0.862423 38.4845 0.826673C34.4271 -0.135122 30.2842 -0.258028 26.4114 0.459857C26.4098 0.460129 26.4081 0.460491 26.4064 0.460762C25.9304 0.549185 25.458 0.650279 24.9907 0.764044C21.6828 1.56918 18.6142 3.01553 15.9643 5.00293C15.9218 5.02981 15.8816 5.06013 15.8443 5.09344C14.9868 5.74498 14.1735 6.45382 13.4113 7.21605C10.2697 10.3577 8.03857 14.3618 6.9593 18.7953C5.95632 22.9152 5.9413 27.4034 6.91196 31.808L0.2651 38.4549C-0.0883215 38.8083 -0.088412 39.3814 0.2651 39.7349C0.441766 39.9116 0.673458 40 0.90506 40C1.13666 40 1.36836 39.9116 1.54502 39.7349L8.19197 33.088C12.5967 34.0585 17.0848 34.0435 21.2047 33.0407C25.6382 31.9615 29.6424 29.7304 32.784 26.5887C34.9728 24.3999 36.7197 21.7924 37.9429 18.9127C37.9679 18.8656 37.989 18.816 38.0054 18.7643C38.5093 17.5562 38.9216 16.3009 39.236 15.0094C40.2755 10.7394 40.2538 6.0737 39.1734 1.5156ZM27.4801 2.1246C30.362 1.67244 33.397 1.70575 36.4652 2.25484L27.4801 11.2399V2.1246ZM14.6913 8.49597C14.9684 8.21875 15.2519 7.95022 15.5421 7.68957V10.3272C15.5421 10.8269 15.9473 11.2322 16.4472 11.2322C16.9471 11.2322 17.3522 10.8269 17.3522 10.3272V6.22991C19.8185 4.44805 22.6406 3.18451 25.6699 2.47712V13.0501L17.3522 21.3678V13.7198C17.3522 13.2201 16.9471 12.8148 16.4472 12.8148C15.9473 12.8148 15.5421 13.2201 15.5421 13.7198V23.1779L8.45018 30.2697C6.96744 21.9836 9.24581 13.9415 14.6913 8.49597ZM31.504 25.3087C26.0586 30.7542 18.0165 33.0326 9.73019 31.5497L21.886 19.3939H35.7228C34.6504 21.5779 33.2376 23.5752 31.504 25.3087ZM36.5174 17.5838H23.6962L37.7452 3.53485C38.6283 8.47008 38.1772 13.3187 36.5174 17.5838Z"
                                                    fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_81_544">
                                                    <rect width="40" height="40" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-white m-0 cs_fs_20 cs_fs_lg_18 cs_lh_base"><?php echo e($choose_us->list_two); ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="cs_iconbox cs_style_1 d-flex align-items-center cs_mb_40">
                                    <div class="cs_iconbox_icon d-flex align-items-center justify-content-center cs_height_70 cs_width_70 cs_rounded_10 flex-none cs_mr_20 bg-accent cs_transition_4 wow zoomIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M27.9115 4.33891V0.904977C27.9115 0.405249 27.5064 0 27.0065 0H1.52509C1.02528 0 0.620117 0.405249 0.620117 0.904977V35.7798C0.620117 36.2795 1.02528 36.6848 1.52509 36.6848H1.6393C2.05478 38.5783 3.74446 40 5.76084 40H22.7709C24.7873 40 26.4769 38.5783 26.8923 36.6848H27.0065C27.5064 36.6848 27.9115 36.2795 27.9115 35.7798V29.0186C34.3129 28.5536 39.3792 23.1967 39.3792 16.6788C39.3792 10.161 34.3129 4.80398 27.9115 4.33891ZM27.0065 27.2415C26.5067 27.2415 26.1016 27.6468 26.1016 28.1465V34.8749H12.3034C11.8036 34.8749 11.3984 35.2802 11.3984 35.7799C11.3984 36.2796 11.8036 36.6849 12.3034 36.6849H25.0041C24.6455 37.5665 23.7798 38.19 22.7709 38.19H5.76084C4.75179 38.19 3.88618 37.5665 3.52754 36.6848H8.80111C9.30093 36.6848 9.70609 36.2795 9.70609 35.7798C9.70609 35.2801 9.30093 34.8748 8.80111 34.8748H2.43007V1.80995H26.1016V5.21113C26.1016 5.71086 26.5067 6.11611 27.0065 6.11611C32.8308 6.11611 37.5693 10.8545 37.5693 16.6788C37.5693 22.5032 32.8309 27.2415 27.0065 27.2415Z"
                                                fill="white" />
                                            <path
                                                d="M27.0065 7.9812C26.5067 7.9812 26.1016 8.38645 26.1016 8.88618V24.4714C26.1016 24.9712 26.5067 25.3764 27.0065 25.3764C31.8024 25.3764 35.7041 21.4747 35.7041 16.6788C35.7041 11.883 31.8024 7.9812 27.0065 7.9812ZM27.9115 23.5073V9.85043C31.2833 10.2949 33.8941 13.1877 33.8941 16.6788C33.8941 20.17 31.2834 23.0628 27.9115 23.5073Z"
                                                fill="white" />
                                            <path
                                                d="M20.3347 25.6729C19.9431 25.6729 19.6096 25.9215 19.4836 26.2697C19.1355 26.3957 18.8867 26.7292 18.8867 27.1208C18.8867 27.6205 19.2919 28.0258 19.7917 28.0258H20.3347C20.8345 28.0258 21.2397 27.6205 21.2397 27.1208V26.5778C21.2397 26.078 20.8345 25.6729 20.3347 25.6729Z"
                                                fill="white" />
                                            <path
                                                d="M16.7933 26.2158H15.7653C15.2655 26.2158 14.8604 26.6211 14.8604 27.1208C14.8604 27.6205 15.2655 28.0258 15.7653 28.0258H16.7933C17.2931 28.0258 17.6983 27.6205 17.6983 27.1208C17.6983 26.6211 17.2931 26.2158 16.7933 26.2158Z"
                                                fill="white" />
                                            <path
                                                d="M12.7669 26.2158H11.739C11.2391 26.2158 10.834 26.6211 10.834 27.1208C10.834 27.6205 11.2391 28.0258 11.739 28.0258H12.7669C13.2667 28.0258 13.6719 27.6205 13.6719 27.1208C13.6719 26.6211 13.2667 26.2158 12.7669 26.2158Z"
                                                fill="white" />
                                            <path
                                                d="M9.0481 26.2694C8.92204 25.9213 8.58855 25.6726 8.19697 25.6726C7.69715 25.6726 7.29199 26.0779 7.29199 26.5776V27.1206C7.29199 27.6203 7.69715 28.0255 8.19697 28.0255H8.73996C9.23977 28.0255 9.64493 27.6203 9.64493 27.1206C9.64493 26.729 9.39615 26.3955 9.0481 26.2694Z"
                                                fill="white" />
                                            <path
                                                d="M8.19697 19.8089C8.69679 19.8089 9.10195 19.4037 9.10195 18.9039V17.781C9.10195 17.2812 8.69679 16.876 8.19697 16.876C7.69715 16.876 7.29199 17.2812 7.29199 17.781V18.9039C7.29199 19.4037 7.69715 19.8089 8.19697 19.8089Z"
                                                fill="white" />
                                            <path
                                                d="M8.19697 15.4105C8.69679 15.4105 9.10195 15.0052 9.10195 14.5055V13.3825C9.10195 12.8828 8.69679 12.4775 8.19697 12.4775C7.69715 12.4775 7.29199 12.8828 7.29199 13.3825V14.5055C7.29199 15.0053 7.69715 15.4105 8.19697 15.4105Z"
                                                fill="white" />
                                            <path
                                                d="M8.19697 24.2074C8.69679 24.2074 9.10195 23.8021 9.10195 23.3024V22.1794C9.10195 21.6797 8.69679 21.2744 8.19697 21.2744C7.69715 21.2744 7.29199 21.6797 7.29199 22.1794V23.3024C7.29199 23.8022 7.69715 24.2074 8.19697 24.2074Z"
                                                fill="white" />
                                            <path
                                                d="M8.73996 8.65918H8.19697C7.69715 8.65918 7.29199 9.06443 7.29199 9.56416V10.1071C7.29199 10.6069 7.69715 11.0121 8.19697 11.0121C8.58855 11.0121 8.92204 10.7634 9.0481 10.4153C9.39615 10.2892 9.64493 9.95574 9.64493 9.56416C9.64493 9.06434 9.23977 8.65918 8.73996 8.65918Z"
                                                fill="white" />
                                            <path
                                                d="M12.7669 8.65918H11.739C11.2391 8.65918 10.834 9.06443 10.834 9.56416C10.834 10.0639 11.2391 10.4691 11.739 10.4691H12.7669C13.2667 10.4691 13.6719 10.0639 13.6719 9.56416C13.6719 9.06443 13.2667 8.65918 12.7669 8.65918Z"
                                                fill="white" />
                                            <path
                                                d="M16.7933 8.65918H15.7653C15.2655 8.65918 14.8604 9.06443 14.8604 9.56416C14.8604 10.0639 15.2655 10.4691 15.7653 10.4691H16.7933C17.2931 10.4691 17.6983 10.0639 17.6983 9.56416C17.6983 9.06443 17.2931 8.65918 16.7933 8.65918Z"
                                                fill="white" />
                                            <path
                                                d="M20.3347 8.65918H19.7917C19.2919 8.65918 18.8867 9.06443 18.8867 9.56416C18.8867 9.95574 19.1355 10.2893 19.4836 10.4153C19.6096 10.7634 19.9431 11.0121 20.3347 11.0121C20.8345 11.0121 21.2397 10.6069 21.2397 10.1071V9.56416C21.2397 9.06434 20.8345 8.65918 20.3347 8.65918Z"
                                                fill="white" />
                                            <path
                                                d="M20.3347 16.876C19.8348 16.876 19.4297 17.2812 19.4297 17.781V18.9039C19.4297 19.4037 19.8348 19.8089 20.3347 19.8089C20.8345 19.8089 21.2396 19.4037 21.2396 18.9039V17.781C21.2396 17.2812 20.8345 16.876 20.3347 16.876Z"
                                                fill="white" />
                                            <path
                                                d="M20.3347 12.4775C19.8348 12.4775 19.4297 12.8828 19.4297 13.3825V14.5055C19.4297 15.0052 19.8348 15.4105 20.3347 15.4105C20.8345 15.4105 21.2396 15.0052 21.2396 14.5055V13.3825C21.2396 12.8827 20.8345 12.4775 20.3347 12.4775Z"
                                                fill="white" />
                                            <path
                                                d="M20.3347 21.2744C19.8348 21.2744 19.4297 21.6797 19.4297 22.1794V23.3024C19.4297 23.8021 19.8348 24.2074 20.3347 24.2074C20.8345 24.2074 21.2396 23.8021 21.2396 23.3024V22.1794C21.2396 21.6797 20.8345 21.2744 20.3347 21.2744Z"
                                                fill="white" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-white m-0 cs_fs_20 cs_fs_lg_18 cs_lh_base"><?php echo e($choose_us->list_three); ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="cs_iconbox cs_style_1 d-flex align-items-center cs_mb_40">
                                    <div class="cs_iconbox_icon d-flex align-items-center justify-content-center cs_height_70 cs_width_70 cs_rounded_10 flex-none cs_mr_20 bg-accent cs_transition_4 wow zoomIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <svg width="34" height="40" viewBox="0 0 34 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.2012 35.1591V36.3801C16.2012 36.8799 16.6064 37.2851 17.1061 37.2851C17.6059 37.2851 18.0111 36.8799 18.0111 36.3801V35.1591C18.0111 34.6593 17.6059 34.2542 17.1061 34.2542C16.6064 34.2542 16.2012 34.6593 16.2012 35.1591Z"
                                                fill="white" />
                                            <path
                                                d="M31.1066 4.58742H30.5865V3.17611C30.5865 1.4248 29.1617 0 27.4104 0H4.75042C2.99911 0 1.57431 1.4248 1.57431 3.17611V4.58751H1.10517C0.605444 4.58751 0.200195 4.99267 0.200195 5.49249C0.200195 5.99231 0.605444 6.39747 1.10517 6.39747H1.57431V7.80878C1.57431 9.56009 2.99911 10.9849 4.75042 10.9849H27.4105C29.1618 10.9849 30.5866 9.56009 30.5866 7.80878V6.39738H31.1067C31.5044 6.39738 31.9902 6.81819 31.9902 7.30932V11.7605C31.9902 12.3235 31.5037 12.9028 30.9492 13.0001L18.7389 15.1427C17.3157 15.3925 16.2008 16.72 16.2008 18.165V21.1112H13.6185C13.3526 21.1112 13.1 21.2281 12.9282 21.431C12.7562 21.6338 12.6821 21.9021 12.7257 22.1644L13.4967 26.8063V37.3982C13.4967 38.8329 14.6638 40 16.0985 40H18.1132C19.5479 40 20.715 38.8329 20.715 37.3982V26.8062L21.486 22.1643C21.5295 21.902 21.4555 21.6338 21.2835 21.431C21.1117 21.2281 20.8592 21.1111 20.5932 21.1111H18.011V18.1649C18.011 17.6019 18.4974 17.0226 19.052 16.9253L31.2622 14.7828C32.6854 14.533 33.8003 13.2055 33.8003 11.7605V7.30932C33.8 5.85937 32.5414 4.58742 31.1066 4.58742ZM28.7766 7.80878C28.7766 8.56208 28.1638 9.17493 27.4104 9.17493H4.75042C3.99712 9.17493 3.38427 8.56208 3.38427 7.80878V3.17611C3.38427 2.42281 3.99703 1.80995 4.75042 1.80995H27.4105C28.1638 1.80995 28.7767 2.42281 28.7767 3.17611V7.80878H28.7766ZM18.9171 26.5834C18.909 26.6325 18.9049 26.682 18.9049 26.7317V37.3982C18.9049 37.8348 18.5497 38.19 18.113 38.19H16.0983C15.6616 38.19 15.3064 37.8348 15.3064 37.3982V27.6367H16.19C16.6897 27.6367 17.0949 27.2315 17.0949 26.7317C17.0949 26.2319 16.6897 25.8267 16.19 25.8267H15.1686L14.6861 22.9212H19.5254L18.9171 26.5834Z"
                                                fill="white" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-white m-0 cs_fs_20 cs_fs_lg_18 cs_lh_base"><?php echo e($choose_us->list_four); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6"></div>
            </div>
        </div>
        <div class="cs_iconbox_left-img position-absolute bottom-0 start-0 h-100 background-filled"
            data-src="<?php echo e(asset('front/img/why_choose_us_left_img.jpeg')); ?>"></div>
        <div class="cs_iconbox_right-img position-absolute cs_zindex_1 bottom-0 end-0 background-filled"
            data-src="<?php echo e(asset($choose_us->image)); ?>"></div>
        <div class="cs_iconbox_logo position-absolute semi_rotate">
            <svg width="191" height="197" viewBox="0 0 191 197" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100.397 107.26C113.305 117.648 127.237 124.564 139.602 126.736C139.678 126.749 139.75 126.756 139.825 126.77L155.856 32.5327C156.421 29.2004 153.306 26.3917 150.454 27.6622L68.5886 64.126C72.5569 77.7763 84.1472 94.1815 100.397 107.26Z"
                    fill="#888888" fill-opacity="0.2" />
                <path
                    d="M134.283 136.497C121.573 133.528 107.766 126.385 95.0023 116.124C77.395 101.968 65.2019 84.7963 60.4863 69.405L19.093 87.8249C15.8591 89.2634 16.1251 94.3774 19.5029 95.6938L80.2458 119.392C83.8188 120.786 86.8631 123.528 88.8105 127.109L121.922 187.961C123.762 191.345 128.37 190.622 129.013 186.848L137.475 137.15C136.42 136.96 135.357 136.747 134.283 136.497Z"
                    fill="#888888" fill-opacity="0.2" />
                <path
                    d="M135.873 127.406C123.172 124.44 109.376 117.306 96.6244 107.06C66.6205 82.949 52.3161 50.0723 64.0597 32.2106C75.8041 14.3519 108.507 19.2476 138.51 43.3581C148.326 51.2452 156.884 60.5001 163.258 70.1219C164.637 72.2018 164.251 75.0376 162.4 76.4586C160.549 77.878 157.932 77.3443 156.556 75.2663C150.711 66.4452 142.82 57.9237 133.733 50.622C108.446 30.3012 79.6787 24.3911 70.9164 37.7191C62.1543 51.0456 76.1154 79.4713 101.404 99.7925C114.23 110.099 128.065 116.965 140.36 119.115C151.717 121.106 160.191 118.825 164.221 112.695C168.424 106.304 166.766 97.4981 164.635 91.2345C163.822 88.8441 164.914 86.2656 167.073 85.4735C169.232 84.6816 171.642 85.9765 172.455 88.3683C176.466 100.157 175.977 110.755 171.077 118.207C165.196 127.151 153.932 130.671 139.362 128.118C138.21 127.918 137.045 127.679 135.873 127.406Z"
                    fill="#888888" fill-opacity="0.2" />
            </svg>
        </div>
    </section>
    <!-- End Why Choose Us -->

    <!-- Start Testimonial Section -->
    <section class="background-filled cs_pt_140 cs_pt_lg_75 cs_pb_135 cs_pb_lg_75" data-src="">
        <div class="cs_testimonial_slider cs_gap_30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 cs_mb_lg_40">
                        <div class="cs_section_heading cs_style_1 d-flex align-items-center cs_mb_30">
                            <div class="cs_section_heading_in">
                                <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInLeft"
                                    data-wow-duration="0.8s" data-wow-delay="0.2s">Testimonial</h3>
                                <h2 class="cs_fs_48 cs_fs_lg_36 cs_mb_20">What They’re Saying?</h2>
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

    <!-- Start Team Section -->
    <section class="cs_pb_115 cs_pb_lg_55">
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

    <!-- Start Contact Section  -->
    <section class="background-filled overflow-hidden cs_pt_133 cs_pt_lg_75 cs_pb_140 cs_pb_lg_80"
        data-src="<?php echo e(asset('front/img/cta_bg.jpeg')); ?>">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="cs_section_heading cs_style_1 d-flex align-items-center cs_mb_40">
                        <div class="cs_section_heading_in">
                            <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInLeft"
                                data-wow-duration="0.8s" data-wow-delay="0.2s">Contact With Us</h3>
                            <h2 class="cs_fs_48 cs_fs_lg_36 cs_mb_20 text-white">Let’s Work Together?</h2>
                            <p class="text-white m-0">Providing legal advice, contract drafting, compliance assistance,
                                intellectual property protection, and other legal support for businesses.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center cs_mb_30">
                        <div
                            class="d-flex align-items-center justify-content-center cs_height_90 cs_width_90 cs_height_lg_80 cs_width_lg-80 cs_rounded_10 flex-none cs_mr_20 bg-accent">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M31.6128 24.7786C30.7939 23.9259 29.8062 23.47 28.7593 23.47C27.7209 23.47 26.7247 23.9175 25.8721 24.7701L23.2043 27.4295C22.9848 27.3113 22.7653 27.2015 22.5543 27.0918C22.2503 26.9398 21.9633 26.7963 21.7185 26.6443C19.2196 25.0572 16.9486 22.9888 14.7705 20.3126C13.7152 18.9787 13.006 17.8559 12.4911 16.7162C13.1833 16.083 13.8249 15.4245 14.4497 14.7914C14.6861 14.555 14.9224 14.3102 15.1588 14.0738C16.9317 12.3009 16.9317 10.0046 15.1588 8.23172L12.8541 5.92698C12.5924 5.66527 12.3222 5.39512 12.0689 5.12497C11.5624 4.60155 11.0305 4.06124 10.4818 3.5547C9.6629 2.74425 8.6836 2.31369 7.65364 2.31369C6.62368 2.31369 5.62749 2.74425 4.78327 3.5547C4.77482 3.56315 4.77482 3.56315 4.76638 3.57159L1.89601 6.46729C0.815398 7.5479 0.199112 8.86489 0.0640356 10.3929C-0.138579 12.8581 0.587457 15.1544 1.14465 16.6571C2.5123 20.3464 4.55533 23.7655 7.60299 27.4295C11.3007 31.8448 15.7498 35.3314 20.832 37.7881C22.7738 38.7083 25.3655 39.7974 28.2612 39.9831C28.4385 39.9916 28.6242 40 28.7931 40C30.7433 40 32.3811 39.2993 33.6643 37.9063C33.6727 37.8894 33.6896 37.881 33.6981 37.8641C34.1371 37.3322 34.6436 36.851 35.1755 36.3361C35.5385 35.9899 35.9099 35.6269 36.2729 35.247C37.1087 34.3774 37.5477 33.3644 37.5477 32.326C37.5477 31.2791 37.1003 30.2745 36.2476 29.4303L31.6128 24.7786ZM34.6351 33.6683C34.6267 33.6683 34.6267 33.6767 34.6351 33.6683C34.3059 34.0229 33.9682 34.3437 33.6052 34.6983C33.0564 35.2217 32.4993 35.7704 31.9758 36.3867C31.1232 37.2985 30.1185 37.729 28.8015 37.729C28.6749 37.729 28.5398 37.729 28.4132 37.7206C25.9058 37.5602 23.5758 36.5809 21.8282 35.7451C17.0499 33.4319 12.8541 30.1479 9.36742 25.9858C6.48861 22.5161 4.56377 19.308 3.28898 15.8635C2.50385 13.7614 2.21682 12.1236 2.34345 10.5787C2.42787 9.59093 2.80777 8.77203 3.50848 8.07132L6.3873 5.19251C6.80097 4.80416 7.23997 4.5931 7.67052 4.5931C8.20239 4.5931 8.63294 4.91391 8.9031 5.18406C8.91154 5.19251 8.91998 5.20095 8.92842 5.20939C9.4434 5.6906 9.93305 6.18869 10.448 6.72056C10.7097 6.99071 10.9799 7.26086 11.25 7.53946L13.5548 9.8442C14.4497 10.7391 14.4497 11.5664 13.5548 12.4613C13.31 12.7061 13.0736 12.951 12.8288 13.1873C12.1196 13.9134 11.4442 14.5888 10.7097 15.2473C10.6929 15.2641 10.676 15.2726 10.6675 15.2895C9.9415 16.0155 10.0766 16.7247 10.2285 17.2059C10.237 17.2312 10.2454 17.2565 10.2539 17.2818C10.8533 18.7339 11.6975 20.1016 12.9807 21.7309L12.9892 21.7394C15.3192 24.6097 17.7759 26.8469 20.4859 28.5607C20.832 28.7802 21.1866 28.9575 21.5243 29.1264C21.8282 29.2783 22.1153 29.4218 22.3601 29.5738C22.3938 29.5907 22.4276 29.616 22.4614 29.6329C22.7484 29.7764 23.0186 29.8439 23.2972 29.8439C23.9979 29.8439 24.4369 29.4049 24.5804 29.2614L27.4677 26.3742C27.7547 26.0871 28.2106 25.741 28.7424 25.741C29.2659 25.741 29.6964 26.0702 29.9581 26.3573C29.9666 26.3657 29.9666 26.3657 29.975 26.3742L34.6267 31.0259C35.4963 31.887 35.4963 32.7734 34.6351 33.6683Z"
                                    fill="white" />
                                <path
                                    d="M21.6168 9.51496C23.8287 9.88642 25.838 10.9333 27.442 12.5373C29.046 14.1413 30.0844 16.1506 30.4643 18.3625C30.5572 18.9197 31.0384 19.308 31.5872 19.308C31.6547 19.308 31.7138 19.2996 31.7813 19.2911C32.4061 19.1898 32.8197 18.5989 32.7184 17.9741C32.2625 15.2979 30.9962 12.8581 29.0629 10.9248C27.1296 8.99154 24.6898 7.7252 22.0136 7.26932C21.3889 7.16801 20.8064 7.58168 20.6966 8.19797C20.5869 8.81425 20.9921 9.41365 21.6168 9.51496Z"
                                    fill="white" />
                                <path
                                    d="M39.9542 17.6449C39.2028 13.238 37.126 9.22793 33.9349 6.03675C30.7437 2.84557 26.7336 0.768768 22.3267 0.017406C21.7104 -0.0923436 21.1279 0.32977 21.0182 0.946056C20.9169 1.57078 21.3305 2.1533 21.9553 2.26305C25.8894 2.92999 29.4773 4.79573 32.3308 7.64078C35.1843 10.4943 37.0416 14.0822 37.7086 18.0163C37.8014 18.5735 38.2826 18.9619 38.8314 18.9619C38.8989 18.9619 38.958 18.9534 39.0256 18.945C39.6418 18.8521 40.0639 18.2612 39.9542 17.6449Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-accent cs_mb_7">Have Any Question?</p>
                            <h2 class="text-white m-0 fw-medium cs_fs_22 cs_fs_lg_18 cs_lh_base"><?php echo e($contact->phone); ?>

                            </h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center cs_mb_30">
                        <div
                            class="d-flex align-items-center justify-content-center cs_height_90 cs_width_90 cs_height_lg_80 cs_width_lg-80 cs_rounded_10 flex-none cs_mr_20 bg-accent">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M34.1388 5H5.86125C4.63868 5.00132 3.46656 5.48758 2.60207 6.35207C1.73758 7.21656 1.25132 8.38868 1.25 9.61125V30.3888C1.25132 31.6113 1.73758 32.7834 2.60207 33.6479C3.46656 34.5124 4.63868 34.9987 5.86125 35H34.1388C35.3613 34.9987 36.5334 34.5124 37.3979 33.6479C38.2624 32.7834 38.7487 31.6113 38.75 30.3888V9.61125C38.7487 8.38868 38.2624 7.21656 37.3979 6.35207C36.5334 5.48758 35.3613 5.00132 34.1388 5ZM5.86125 7.5H34.1388C34.6985 7.50066 35.2351 7.72331 35.6309 8.1191C36.0267 8.51489 36.2493 9.05151 36.25 9.61125V10.5675L20 21.0138L3.75 10.5675V9.61125C3.75066 9.05151 3.97331 8.51489 4.3691 8.1191C4.76489 7.72331 5.30151 7.50066 5.86125 7.5ZM34.1388 32.5H5.86125C5.30151 32.4993 4.76489 32.2767 4.3691 31.8809C3.97331 31.4851 3.75066 30.9485 3.75 30.3888V13.54L19.3237 23.5512C19.5254 23.681 19.7602 23.75 20 23.75C20.2398 23.75 20.4746 23.681 20.6763 23.5512L36.25 13.54V30.3888C36.2493 30.9485 36.0267 31.4851 35.6309 31.8809C35.2351 32.2767 34.6985 32.4993 34.1388 32.5Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-accent cs_mb_7">Send Email</p>
                            <h2 class="text-white m-0 fw-medium cs_fs_22 cs_fs_lg_18 cs_lh_base"><?php echo e($contact->email); ?>

                            </h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div
                            class="d-flex align-items-center justify-content-center cs_height_90 cs_width_90 cs_height_lg_80 cs_width_lg-80 cs_rounded_10 flex-none cs_mr_20 bg-accent">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.0002 0C12.0123 0 5.51367 6.49859 5.51367 14.4864C5.51367 24.3995 18.4777 38.9526 19.0296 39.5673C19.548 40.1447 20.4532 40.1437 20.9707 39.5673C21.5227 38.9526 34.4866 24.3995 34.4866 14.4864C34.4865 6.49859 27.988 0 20.0002 0ZM20.0002 36.6976C15.6371 31.5149 8.12242 21.29 8.12242 14.4866C8.12242 7.93703 13.4507 2.60875 20.0002 2.60875C26.5496 2.60875 31.8779 7.93703 31.8779 14.4865C31.8778 21.2902 24.3643 31.5133 20.0002 36.6976Z"
                                    fill="white" />
                                <path
                                    d="M20.0004 7.19797C15.9814 7.19797 12.7119 10.4676 12.7119 14.4865C12.7119 18.5054 15.9815 21.775 20.0004 21.775C24.0192 21.775 27.2887 18.5054 27.2887 14.4865C27.2887 10.4676 24.0192 7.19797 20.0004 7.19797ZM20.0004 19.1662C17.4199 19.1662 15.3207 17.067 15.3207 14.4865C15.3207 11.906 17.42 9.80672 20.0004 9.80672C22.5807 9.80672 24.68 11.906 24.68 14.4865C24.68 17.067 22.5807 19.1662 20.0004 19.1662Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-accent cs_mb_7">Address</p>
                            <h2 class="text-white m-0 fw-medium cs_fs_22 cs_fs_lg_18 cs_lh_base"><?php echo e($contact->address); ?>

                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 offset-xl-1 cs_mt_lg_55">
                    <div class="cs_contact_wrap position-relative">
                        <form id="contactForm" method="POST" class="bg-white cs_pt_64 cs_pl_80 cs_pr_80 cs_pb_80 cs_pl_lg_30 cs_pr_lg_30 position-relative cs_rounded_20">
                            <?php echo csrf_field(); ?>
                            <div class="cs_section_heading cs_style_1 d-flex align-items-center text-center cs_mb_30">
                                <div class="cs_section_heading_in">
                                    <h2 class="cs_fs_48 cs_fs_lg_36 m-0">Contact Us</h2>
                                </div>
                            </div>

                            <input name="name" id="name"
                                class="form-control cs_fs_14 cs_rounded_5 border-0 cs_mb_15 bg-gray" type="text"
                                placeholder="Your Name">

                            <input name="email" id="email"
                                class="form-control cs_fs_14 cs_rounded_5 border-0 cs_mb_15 bg-gray" type="email"
                                placeholder="Your Email">

                            <textarea name="message" id="message" class="form-control cs_fs_14 cs_rounded_5 border-0 cs_mb_30 bg-gray"
                                placeholder="Message here ..." cols="30" rows="4"></textarea>

                            <button type="submit"
                                class="cs_btn cs_style_1 cs_fs_16 cs_rounded_5 cs_pl_30 cs_pr_30 cs_pt_10 cs_pb_10 overflow-hidden">
                                <span>Submit Now</span>
                            </button>
                        </form>

                        <div class="cs_contact_image d-none d-xl-block wow fadeInRight" data-wow-duration="0.8s"
                            data-wow-delay="0.4s"><img src="<?php echo e(asset('front/img/contact_img_1.png')); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section  -->
    <!-- Start Blog Section -->
    <section class="cs_pt_115 cs_pt_lg_75 cs_pb_110 cs_pb_lg_50">
        <div class="container">
            <div class="cs_section_heading cs_style_1 d-flex align-items-center text-center cs_mb_60 cs_mb_lg_40">
                <div class="cs_section_heading_in">
                    <h3 class="cs_fs_20 cs_fs_lg_18 text-accent fw-normal cs_lh_base cs_mb_10 wow fadeInUp"
                        data-wow-duration="0.8s" data-wow-delay="0.2s">Find The Blogs</h3>
                    <h2 class="cs_fs_48 cs_fs_lg_36 m-0">Find Out Latest News <br>and Articles</h2>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4">
                        <div class="cs_post cs_style_1 bg-white shadow-sm cs_mb_30">
                            <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"
                                class="cs_post_thumb d-block position-relative overflow-hidden">
                                <div class="cs_post_thumb-in cs_transition_5 background-filled h-100 w-100"
                                    data-src="<?php echo e(asset($blog->image)); ?>"></div>
                            </a>
                            <div class="cs_post_in">
                                <div class="cs_post_info cs_pl_33 cs_pr_33 cs_pt_40 cs_pb_40">
                                    <ul class="cs_post_meta d-flex flex-wrap cs_fs_12 p-0 cs_mb_16">
                                        <li>
                                            <span><i class="fa-solid fa-user"></i> By </span>
                                            <a
                                                href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->author_name); ?></a>
                                        </li>
                                        <li>
                                            <span><i class="fa-solid fa-calendar-days"></i></span>
                                            <a
                                                href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->created_at->format('F d, Y')); ?></a>
                                        </li>
                                    </ul>
                                    <h2 class="cs_post_title cs_lh_base cs_fs_20 cs_fs_lg_18 cs_mb_10">
                                        <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"><?php echo e($blog->title); ?></a>
                                    </h2>
                                    <div class="cs_post_subtitle"><?php echo Str::limit($blog->short_description, 100); ?></div>
                                </div>
                                <a href="<?php echo e(route('front.blog.details', $blog->slug)); ?>"
                                    class="cs_post_btn d-flex justify-content-between align-items-center cs_pl_40 cs_pr_40 cs_pb_10 cs_pt_10">
                                    <span class="cs_post_btn-text">Read More</span>
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
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <!-- End Blog Section -->
    <script>
    $(document).ready(function () {
        $('#contactForm').on('submit', function (e) {
            e.preventDefault();
    
            let formData = $(this).serialize();
    
            $.ajax({
                url: "<?php echo e(route('front.contact.submit')); ?>",
                method: "POST",
                data: formData,
                beforeSend: function () {
                    $('button[type="submit"]').prop('disabled', true);
                },
                success: function (response) {
                    $('button[type="submit"]').prop('disabled', false);
    
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $('#contactForm')[0].reset();
                    }
                },
                error: function (xhr) {
                    $('button[type="submit"]').prop('disabled', false);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\Lead-Management\resources\views/front/index.blade.php ENDPATH**/ ?>