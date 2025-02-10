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