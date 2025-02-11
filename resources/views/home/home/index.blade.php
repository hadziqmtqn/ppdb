@extends('home.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/front-page-pricing.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/ui-carousel.css') }}" />
    <style>
        #header {
            position: relative;
            background-image: url('{{ asset('assets/jane.jpg') }}');
            background-attachment: fixed;
            background-position: bottom;
            /*background-color: #0a6aa1;*/
            object-fit: cover;
        }

        /*#header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(33, 120, 188, 0.48); !* Adjust the rgba value for the desired color and transparency *!
            z-index: 1;
        }*/

        /*.text-white * {
            color: white !important;
        }*/
    </style>
@endsection
@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
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

        <section id="header" class="section-py border border-0 landing-cta p-lg-0 pb-0 position-relative">
            {{--<img src="{{ asset('assets/jane.jpg') }}" class="position-absolute bottom-0 end-0 scaleX-n1-rtl w-100 z-n1" alt="cta image">--}}
            <div class="container" style="padding-top: 2rem">
                <div class="row align-items-center gy-5 gy-lg-0" style="padding-bottom: 15rem; padding-top: 10rem">
                    <div class="col-lg-12 text-center text-lg-center">
                        <h6 class="h1 text-white fw-bold mb-1">Penerimaan Peserta Didik Baru</h6>
                        <h4 class="fw-medium mb-2 text-white">
                            Jenjang
                            @foreach($educationalLevels as $educationalLevel)
                                {{ $educationalLevel->name . ($loop->last ? '' : ',') }}
                            @endforeach
                        </h4>
                        <h5 class="fw-medium mb-2 text-white">Tahun Ajaran {{ $getSchoolYearActive['year'] }}</h5>
                        <p class="mb-4 text-white">Situs ini dipersiapkan sebagai pusat informasi dan pengolahan seleksi data siswa peserta Tahun Pelajaran secara online dan realtime.</p>
                        <a href="{{ route('registration.index') }}" class="btn btn-primary">Daftar Sekarang<i class="mdi mdi-arrow-right mdi-24px ms-3 scaleX-n1-rtl"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="section-py landing-features" style="padding-top: 10rem; padding-bottom: 10rem">
            <div class="container">
                <h6 class="text-center fw-semibold d-flex justify-content-center align-items-center mb-4">
                    <img src="{{ asset('materialize/assets/img/front-pages/icons/section-tilte-icon.png') }}" alt="section title icon" class="me-2" />
                    <span class="text-uppercase">Kuota Pendaftaran</span>
                </h6>
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
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="card-body">
                                                            <div class="card-info">
                                                                <h5 class="text-nowrap pt-2"><span data-bs-toggle="tooltip" title="{{ $data['description'] }}">{{ $data['label'] }}</span></h5>
                                                            </div>
                                                            <div class="d-flex align-items-end">
                                                                <h4 class="mb-0 me-2">{{ $data['value'] }}</h4>
                                                                <small class="text-success">Siswa</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 text-end d-flex align-items-end">
                                                        <div class="card-body pb-0 pt-3">
                                                            <img src="{{ $data['asset'] }}" alt="Ratings" class="img-fluid" width="80">
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

        <section class="pricing-free-trial bg-label-primary">
            <div class="container">
                <div class="position-relative">
                    <div class="d-flex justify-content-between flex-column-reverse flex-lg-row align-items-center py-5">
                        <div class="text-center text-lg-start">
                            <h3 class="text-primary mb-1">Still not convinced? Start with a 14-day FREE trial!</h3>
                            <p class="text-body mb-1">You will get full access to with all the features for 14 days.</p>
                            <a href="#" class="btn btn-primary mt-4 waves-effect waves-light">Start 14-day free trial</a>
                        </div>
                        <!-- image -->
                        <div class="text-center">
                            <img src="{{ asset('materialize/assets/img/illustrations/pricing-illustration.png') }}" alt="Pricing Illustration Image" class="img-fluid mb-3 mb-lg-0">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-py bg-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 text-center">
                        <h4 class="display-6">Still need help?</h4>
                        <p>
                            Our specialists are always happy to help.<br>Contact us during standard business hours or email us 24/7
                            and we'll get back to you.
                        </p>
                        <div class="d-flex justify-content-center flex-wrap gap-3">
                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light">Visit our community</a>
                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light">Contact us</a>
                        </div>
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