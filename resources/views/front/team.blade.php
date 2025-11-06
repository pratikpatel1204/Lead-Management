@extends('front.layout.main-layout')
@section('title', config('app.name') . ' || Our Team')
@section('content')
    <!-- Start Page Header -->
    <section class="cs_page_header position-relative background-filled d-flex align-items-center justify-content-between"
        data-src="assets/img/page_header_1.jpeg">
        <div class="container position-relative z-index-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-white cs_fs_18 cs_mb_5">
                    <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Team</li>
                </ol>
            </nav>
            <h1 class="cs_fs_48 cs_fs_lg_36 text-white m-0">Team</h1>
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
    <section class="cs_pt_140 cs_pt_lg_80 cs_pb_140 cs_pb_lg_80">
        <div class="container">
            <div class="row">
                @foreach ($teams as $team)
                    <div class="col-lg-4">
                        <div class="cs_team cs_style_1 text-center cs_mb_25 overflow-hidden cs_rounded_50">
                            <div class="cs_team_member position-relative cs_rounded_50">
                                <img class="w-100 cs_rounded_50" src="{{ asset($team->image) }}" alt="{{ $team->name }}">
                                <div
                                    class="cs_social_btns d-flex flex-wrap cs_column_gap_15 cs_row_gap_15 cs_transition_5 cs_fs_20 cs_fs_lg_18 position-absolute">
                                </div>
                            </div>
                            <div class="cs_team_info cs_pt_127 cs_pl_15 cs_pr_15 cs_pb_25 cs_transition_4">
                                <h2 class="text-white m-0 cs_fs_26 cs_mb_3">{{ $team->name }}</h2>
                                <p class="text-white m-0">{{ $team->designation }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Our Latest Project -->
@endsection
