@php
    $contact = \App\Models\ContactSetting::first();
@endphp
<!-- Start Footer -->
<footer class="cs_footer background-filled text-white" data-src="{{ asset('front/img/footer_bg.jpeg') }}">
    <div class="container">
        <div
            class="cs_footer_top d-flex justify-content-between align-items-start align-items-md-center cs_pt_46 cs_pb_46 cs_column_gap_15 cs_row_gap_15 flex-md-row  flex-column">
            <div class="cs_footer_contact_info">
                <h3 class="text-accent fw-normal cs_mb_4 cs_fs_16 cs_lh_lg">Have Any Question?</h3>
                <h2 class="text-white fw-medium m-0 cs_fs_22">{{ $contact->phone }}</h2>
            </div>
            <div class="cs_footer_logo wow zoomIn text-center" data-wow-duration="0.8s" data-wow-delay="0.2s">
                <img src="{{ asset('front/img/logo.png') }}" alt="Logo">
            </div>
            <div class="cs_footer_contact_info">
                <h3 class="text-accent fw-normal cs_mb_4 cs_fs_16 cs_lh_lg">Send Email</h3>
                <h2 class="text-white fw-medium m-0 cs_fs_22">{{ $contact->email }}</h2>
            </div>
        </div>
        <div class="cs_footer_main cs_pt_30 cs_pb_30">
            <div class="row">
                <div class="col-lg-4">
                    <div class="cs_footer_item cs_pt_20 cs_pb_20">
                        <div class="cs_text_widget">
                            <p>I've been using [business name] for the past year and I'm so glad I did. Their products
                                and services are top-notch and their customer service is amazing. I would highly
                                recommend them to anyone</p>
                        </div>
                        <div class="cs_social_btns d-flex flex-wrap cs_column_gap_15 cs_row_gap_15 cs_transition_5">
                            <a href="{{ $contact->facebook }}"
                                class="d-flex align-items-center justify-content-center cs_height_35 cs_width_35 text-white rounded-circle"><i
                                    class="fa-brands fa-facebook-f"></i></a>
                            <a href="{{ $contact->twitter }}"
                                class="d-flex align-items-center justify-content-center cs_height_35 cs_width_35 text-white rounded-circle"><i
                                    class="fa-brands fa-twitter"></i></a>
                            <a href="{{ $contact->linkedin }}"
                                class="d-flex align-items-center justify-content-center cs_height_35 cs_width_35 text-white rounded-circle"><i
                                    class="fa-brands fa-linkedin-in"></i></a>
                            <a href="{{ $contact->instagram }}"
                                class="d-flex align-items-center justify-content-center cs_height_35 cs_width_35 text-white rounded-circle"><i
                                    class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="cs_footer_item cs_pt_20 cs_pb_20">
                        <h2 class="cs_widget_title text-white cs_fs_22 cs_mb_22">Explore</h2>
                        <ul class="cs_menu_widget text-uppercase">
                            <li><a href="{{ route('front.about') }}">About</a></li>
                            <li><a href="{{ route('front.services') }}">Services</a></li>
                            <li><a href="{{ route('front.our.team') }}">Team</a></li>
                            <li><a href="{{ route('front.blog') }}">Blog</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="{{ route('front.contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="cs_footer_item cs_pt_20 cs_pb_20">
                        <div class="cs_newsletter cs_style_1">
                            <h2 class="cs_newsletter_title text-white cs_fs_22 cs_mb_9">Newsletter</h2>
                            <p class="cs_newsletter_subtitle cs_mb_26"> At vero eos et accusamus et iusto odio as part
                                dignissimos ducimus qui blandit. </p>
                            <form id="newsletterForm" method="POST" class="cs_newsletter_form position-relative">
                                @csrf
                                <input type="email" name="email"
                                    class="cs_newsletter_input text-white cs_fs_14 cs_rounded_5 border-0 w-100 cs_pt_10"
                                    placeholder="Enter your email">
                                <button type="submit"
                                    class="cs_newsletter_btn cs_fs_14 cs_rounded_5 cs_transition_4 bg-accent position-absolute text-uppercase">
                                    <span>Go</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cs_copyright text-center cs_fs_124 cs_lh_lg cs_pt_36 cs_pb_36">
        <div class="container">
            <p class="m-0">Copyright © 2023 <a href="index-2.html">bizmax</a>. All rights reserved.</p>
        </div>
    </div>
</footer>
<script>
    $('#newsletterForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        form.find('button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: "{{ route('front.newsletter.submit') }}",
            method: 'POST',
            data: formData,
            success: function(res) {
                toastr.success(res.message);
                form[0].reset();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        toastr.error(errors[key][0]);
                    });
                } else {
                    toastr.error('Something went wrong, please try again.');
                }
            },
            complete: function() {
                form.find('button[type="submit"]').prop('disabled', false);
            }
        });
    });
</script>
<!-- End Footer -->
