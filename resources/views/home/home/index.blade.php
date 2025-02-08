@extends('home.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/front-page-landing.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/ui-carousel.css') }}" />
@endsection
@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        {{--<div id="carouselExampleDark" class="carousel carousel-dark slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('materialize/assets/img/backgrounds/6.jpg') }}" style="max-height: 700px; object-fit: cover" alt="First slide" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('materialize/assets/img/backgrounds/5.jpg') }}" style="max-height: 700px; object-fit: cover" alt="Second slide" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('materialize/assets/img/backgrounds/7.jpg') }}" style="max-height: 700px; object-fit: cover" alt="Third slide" />
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleDark" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleDark" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>--}}
        <section id="landingHero" class="section-py landing-hero position-relative">
            {{--<img src="{{ asset('materialize/assets/img/front-pages/backgrounds/hero-bg-light.png') }}" alt="hero background" class="position-absolute top-0 start-0 w-100 h-100 z-n1" data-speed="1" data-app-light-img="front-pages/backgrounds/hero-bg-light.png" data-app-dark-img="front-pages/backgrounds/hero-bg-dark.png" />--}}
            {{--<div class="container">
                <div class="hero-text-box text-center">
                    <h1 class="text-primary hero-title">All in one sass application for your business</h1>
                    <h2 class="h6 mb-4 pb-1 lh-lg">
                        No coding required to make customisations.<br />The live customiser has everything your marketing need.
                    </h2>
                    <a href="#" class="btn btn-primary">Get early access</a>
                </div>
                <div class="position-relative hero-animation-img">
                    <a href="#" target="_blank">
                        <div class="hero-dashboard-img text-center">
                            <img src="{{ asset('materialize/assets/img/front-pages/landing-page/hero-dashboard-light.png') }}" alt="hero dashboard" class="animation-img" data-speed="2" data-app-light-img="front-pages/landing-page/hero-dashboard-light.png" data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
                        </div>
                        <div class="position-absolute hero-elements-img">
                            <img src="{{ asset('materialize/assets/img/front-pages/landing-page/hero-elements-light.png') }}" alt="hero elements" class="animation-img" data-speed="4" data-app-light-img="front-pages/landing-page/hero-elements-light.png" data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
                        </div>
                    </a>
                </div>
            </div>--}}
            <img src="{{ asset('materialize/assets/img/front-pages/backgrounds/cta-bg.png') }}" class="position-absolute bottom-0 end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image" />
            <div class="container">
                <div class="row align-items-center gy-5 gy-lg-0">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h6 class="h2 text-primary fw-bold mb-1">Ready to Get Started?</h6>
                        <p class="fw-medium mb-4">Start your project with a 14-day free trial</p>
                        <a href="#" class="btn btn-primary">Get Started<i class="mdi mdi-arrow-right mdi-24px ms-3 scaleX-n1-rtl"></i></a>
                    </div>
                    <div class="col-lg-6 pt-lg-5">
                        <img src="{{ asset('materialize/assets/img/front-pages/landing-page/cta-dashboard.png') }}" alt="cta dashboard" class="img-fluid" />
                    </div>
                </div>
            </div>
        </section>

        <section id="landingFeatures" class="section-py landing-features">
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