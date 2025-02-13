@extends('home.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/front-page-pricing.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/ui-carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section id="header" class="section-py border border-0 landing-cta p-lg-0 pb-0 position-relative">
            <img src="{{ $application['frontHeaderAssets'] }}" class="position-absolute bottom-0 end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image" style="object-fit: cover">
            <div class="container" style="padding-top: 5rem; position: relative; z-index: 2">
                <div class="row align-items-center gy-5 gy-lg-0" style="padding-bottom: 15rem; padding-top: 10rem">
                    <div class="col-lg-12 text-center text-lg-center">
                        <h6 class="h2 text-white fw-bold mb-1">{{ $application['name'] }}</h6>
                        <h4 class="h1 fw-bold fw-medium mb-2 text-white">{{ $application['foundation'] }}</h4>
                        <h5 class="h2 fw-bold fw-medium mb-2 text-white">Tahun Ajaran {{ $getSchoolYearActive['year'] }}</h5>
                        <p class="mb-4 text-white">{!! $application['description'] !!}</p>
                        <a href="{{ route('registration.index') }}" class="btn btn-warning text-dark">Daftar Sekarang<i class="mdi mdi-arrow-right mdi-24px ms-3 scaleX-n1-rtl"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="section-py landing-features" style="padding-top: 10rem; padding-bottom: 5rem">
            <div class="container">
                <h6 class="text-center fw-semibold d-flex justify-content-center align-items-center mb-4">
                    <img src="{{ asset('materialize/assets/img/front-pages/icons/section-tilte-icon.png') }}" alt="section title icon" class="me-2" />
                    <span class="text-uppercase">Kuota Pendaftaran</span>
                </h6>
                <h3 class="text-center mb-3 mb-md-5">{{ $application['name'] }} <span class="fw-bold text-primary">TA. {{ $getSchoolYearActive['year'] }}</span></h3>
                <div class="nav-align-top mb-4 pt-lg-4">
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

        <section class="section-py position-relative" style="padding-top: 5rem; padding-bottom: 3rem">
            <div class="container" style="padding-bottom: 6rem; padding-top: 2rem">
                <h6 class="text-center fw-semibold d-flex justify-content-center align-items-center mb-4">
                    <img src="{{ asset('materialize/assets/img/front-pages/icons/section-tilte-icon.png') }}" alt="section title icon" class="me-2">
                    <span class="text-uppercase">Jadwal Pendaftaran</span>
                </h6>
                <h3 class="text-center mb-3 mb-md-5">{{ $application['name'] }} <span class="fw-bold text-primary">TA. {{ $getSchoolYearActive['year'] }}</span></h3>
                <div class="row align-items-center gy-5 gy-lg-0">
                    <div class="col-lg-6 text-center text-lg-start">
                        <div class="card shadow-none border-2 border-primary">
                            <div class="card-body">
                                @foreach($schedules as $schedule)
                                    <h4 class="mb-2 pb-1">{{ $schedule['name'] }}</h4>
                                    <p>Agenda {{ $application['name'] }}</p>
                                    <div class="row mb-3 g-3">
                                        <div class="col-6">
                                            <div class="d-flex">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-primary"><i class="mdi mdi-calendar-month-outline mdi-24px"></i></span>
                                                </div>
                                                <div>
                                                    <small>Dari Tgl.</small>
                                                    <h6 class="mb-0 text-nowrap {{ $schedule['hasEnded'] ? 'text-danger' : '' }}">{{ $schedule['hasEnded'] ? 'Telah berakhir' : $schedule['startDate'] }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-primary"><i class="mdi mdi-clock-time-four-outline mdi-24px"></i></span>
                                                </div>
                                                <div>
                                                    <small>Sampai Tgl.</small>
                                                    <h6 class="mb-0 text-nowrap {{ $schedule['hasEnded'] ? 'text-danger' : '' }}">{{ $schedule['hasEnded'] ? 'Telah berakhir' : $schedule['endDate'] }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-lg-4 text-center">
                        <img src="{{ asset('assets/g10.svg') }}" alt="cta dashboard" class="img-fluid" />
                    </div>
                </div>
            </div>
        </section>

        <section class="section-py bg-body pb-0 position-relative" style="padding-top: 7rem">
            <div class="container">
                <h6 class="text-center fw-semibold d-flex justify-content-center align-items-center mb-4">
                    <img src="{{ asset('materialize/assets/img/front-pages/icons/section-tilte-icon.png') }}" alt="section title icon" class="me-2">
                    <span class="text-uppercase">Prosedur Pendaftaran</span>
                </h6>
                <h3 class="text-center mb-0 pb-5">{{ count($registrationSteps) }} Langkah mudah pendaftaran <span class="fw-bold text-primary">Siswa Baru</span> di website ini</h3>
            </div>
        </section>

        @foreach($registrationSteps as $registrationStep)
            <section class="section-py bg-body position-relative" style="padding-bottom: 3rem">
                <div class="container">
                    <div class="row align-items-center gy-5 gy-lg-0">
                        {{--setiap data genap tambah class order-md-0 order-lg-1--}}
                        <div class="col-lg-6 text-center {{ $registrationStep['classPosition'] ? $registrationStep['classPosition']['imageClass'] : '' }}">
                            <img src="{{ $registrationStep['image'] }}" alt="cta dashboard" class="img-fluid w-75" />
                        </div>
                        {{--setiap data genap tambah class order-md-1 order-lg-0--}}
                        <div class="col-lg-6 pt-lg-4 ps-4 pe-4 ps-lg-5 pe-lg-5 {{ $registrationStep['classPosition'] ? $registrationStep['classPosition']['contentClass'] : '' }}">
                            <div class="d-flex gap-3">
                                <div class="avatar">
                                    <div class="avatar-initial bg-label-warning rounded-circle" style="padding: 40px">
                                        <i class="mdi mdi-numeric-{{ $registrationStep['serialNumber'] }} mdi-48px"></i>
                                    </div>
                                </div>
                                <div class="card-info pt-4 ps-4 ps-lg-1" style="z-index: 1">
                                    <h2 class="mb-0 fw-bold">{{ $registrationStep['title'] }}</h2>
                                    <p>{!! $registrationStep['description'] !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

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

        <section class="section-py">
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
    <script src="{{ asset('materialize/assets/js/extended-ui-timeline.js') }}"></script>
@endsection