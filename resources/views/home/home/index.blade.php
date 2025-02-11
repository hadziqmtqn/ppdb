@extends('home.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/front-page-landing.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/ui-carousel.css') }}" />
@endsection
@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section id="header" class="section-py bg-body landing-hero position-relative pt-0 pb-0">
            <div class="container" style="padding-bottom: 6rem; padding-top: 2rem">
                <div class="row align-items-center gy-5 gy-lg-0">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h6 class="h1 text-primary fw-bold mb-1">{{ $application['name'] }}</h6>
                        <h4 class="fw-medium mb-2">{{ $application['description'] }}</h4>
                        <h4 class="fw-medium mb-4">
                            Jenjang
                            @foreach($educationalLevels as $educationalLevel)
                                {{ $educationalLevel->name . ($loop->last ? '' : ',') }}
                            @endforeach
                            TA. {{ $getSchoolYearActive['year'] }}
                        </h4>
                        <a href="{{ route('registration.index') }}" class="btn btn-primary">Daftar Sekarang<i class="mdi mdi-arrow-right mdi-24px ms-3 scaleX-n1-rtl"></i></a>
                    </div>
                    <div class="col-lg-6 pt-lg-5">
                        <img src="{{ url($application['frontHeaderAssets']) }}" alt="cta dashboard" class="img-fluid" />
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="section-py landing-features" style="padding-top: 10rem">
            <div class="container">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        @foreach($quotas as $key => $quota)
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link {{ $loop->first ? 'active' : '' }} waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-{{ $key }}" aria-controls="navs-pills-justified-{{ $key }}" aria-selected="true">
                                    <i class="tf-icons mdi mdi-office-building-outline me-1"></i> {{ $quota['name'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content p-0 shadow-none">
                        @foreach($quotas as $key => $quota)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="navs-pills-justified-{{ $key }}" role="tabpanel">
                                <div class="row gy-4">
                                    @foreach($quota['data'] as $data)
                                        <div class="col-lg-4 col-sm-6">
                                            {{--<div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                                        <div class="avatar me-3">
                                                            <div class="avatar-initial bg-label-{{ $data['color'] }} rounded">
                                                                <i class="mdi mdi-{{ $data['icon'] }} mdi-24px"> </i>
                                                            </div>
                                                        </div>
                                                        <div class="card-info">
                                                            <div class="d-flex align-items-center">
                                                                <h4 class="mb-0">{{ $data['value'] }}</h4>
                                                            </div>
                                                            <small>{{ $data['label'] }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>--}}
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="card-body">
                                                            <div class="card-info">
                                                                <h5 class="text-nowrap pt-2">Ratings</h5>

                                                            </div>
                                                            <div class="d-flex align-items-end">
                                                                <h4 class="mb-0 me-2">8.14k</h4>
                                                                <small class="text-success">+15.6%</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 text-end d-flex align-items-end">
                                                        <div class="card-body pb-0 pt-3">
                                                            <img src="{{ asset('materialize/assets/img/illustrations/card-ratings-illustration.png') }}" alt="Ratings" class="img-fluid" width="80">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="section-py landing-features" style="padding-top: 10rem">
            <div class="container">
                <h6 class="text-center fw-semibold d-flex justify-content-center align-items-center mb-4">
                    <img src="{{ asset('materialize/assets/img/front-pages/icons/section-tilte-icon.png') }}" alt="section title icon" class="me-2" />
                    <span class="text-uppercase">Useful features</span>
                </h6>
                <h3 class="text-center mb-2"><span class="fw-bold">Everything you need</span> to start your next project</h3>
                <p class="text-center fw-medium mb-3 mb-md-5 pb-3">
                    Not just a set of tools, the package includes ready-to-deploy conceptual application.
                </p>
                <div class="features-icon-wrapper row gx-0 gy-4 g-sm-5">
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="features-icon mb-3">
                            <img src="{{ asset('materialize/assets/img/front-pages/icons/laptop-charging.png') }}" alt="laptop charging" />
                        </div>
                        <h5 class="mb-2">Quality Code</h5>
                        <p class="features-icon-description">
                            Code structure that all developers will easily understand and fall in love with.
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="features-icon mb-3">
                            <img src="{{ asset('materialize/assets/img/front-pages/icons/transition-up.png') }}" alt="transition up" />
                        </div>
                        <h5 class="mb-2">Continuous Updates</h5>
                        <p class="features-icon-description">
                            Free updates for the next 12 months, including new demos and features.
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="features-icon mb-3">
                            <img src="{{ asset('materialize/assets/img/front-pages/icons/transition-up.png') }}" alt="transition up" />
                        </div>
                        <h5 class="mb-2">Continuous Updates</h5>
                        <p class="features-icon-description">
                            Free updates for the next 12 months, including new demos and features.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('materialize/assets/js/front-main.js') }}"></script>
    <script src="{{ asset('materialize/assets/js/front-page-landing.js') }}"></script>
    <script src="{{ asset('materialize/assets/js/ui-carousel.js') }}"></script>
@endsection