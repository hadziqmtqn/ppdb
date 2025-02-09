@extends('home.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/front-page-landing.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/ui-carousel.css') }}" />
@endsection
@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section id="landingHero" class="section-py landing-hero position-relative pt-0 pb-0">
            <div class="container">
                <div class="row align-items-center gy-5 gy-lg-0">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h6 class="h1 text-primary fw-bold mb-1">{{ $application['name'] }}</h6>
                        <h4 class="fw-medium mb-4">{{ $application['description'] }}</h4>
                        <a href="{{ route('registration.index') }}" class="btn btn-primary">Daftar Sekarang<i class="mdi mdi-arrow-right mdi-24px ms-3 scaleX-n1-rtl"></i></a>
                    </div>
                    <div class="col-lg-6 pt-lg-5">
                        <img src="{{ url($application['frontHeaderAssets']) }}" alt="cta dashboard" class="img-fluid" />
                    </div>
                </div>
            </div>
            {{--<div id="carouselAssets" class="carousel carousel-dark slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if(count($application['carouselAssets']) > 0)
                        @foreach($application['carouselAssets'] as $carouselAsset)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ url($carouselAsset['fileUrl']) }}" style="max-height: 500px; object-fit: cover" alt="First slide" />
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('assets/slide-1.png') }}" style="max-height: 500px; object-fit: cover" alt="First slide" />
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('assets/slide-2.png') }}" style="max-height: 500px; object-fit: cover" alt="Second slide" />
                        </div>
                    @endif
                </div>
                <a class="carousel-control-prev" href="#carouselAssets" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselAssets" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>--}}
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