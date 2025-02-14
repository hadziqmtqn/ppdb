@extends('home.layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/front-page-landing.css') }}" />
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
                    <span class="text-uppercase">Cara Daftar</span>
                </h6>
                <h3 class="text-center mb-0 pb-5">{{ count($registrationSteps) }} Langkah mudah pendaftaran <span class="fw-bold text-primary">Siswa Baru</span> di website ini</h3>
            </div>
        </section>

        @foreach($registrationSteps as $registrationStep)
            <section class="section-py bg-body position-relative" style="padding-bottom: {{ $loop->last ? '10rem' : '3rem' }};">
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
                                    <div>{!! $registrationStep['description'] !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach

        <section class="section-py position-relative bg-label-primary" style="padding-top: 10rem; padding-bottom: 10rem">
            <div class="container">
                <div class="text-center text-center">
                    <h3 class="badge rounded-pill rounded-start-bottom bg-secondary" style="font-size: 14pt">MULAI SEKARANG</h3>
                    <h2 class="text-primary mb-1">Ayo daftar sekarang juga!</h2>
                    <p class="text-body mb-1">Kamu bisa mengikuti prosedur yang telah dijelaskan langkah dibawah ini.</p>
                    <a href="{{ route('registration.index') }}" class="btn btn-primary mt-4 waves-effect waves-light">Daftar Sekarang<i class="mdi mdi-arrow-right mdi-24px ms-3 scaleX-n1-rtl"></i></a>
                </div>
            </div>
        </section>

        <section class="section-py position-relative">
            <div class="container">
                <div class="faq-header d-flex flex-column justify-content-center align-items-center pt-5 position-relative overflow-hidden rounded-3">
                    <h3 class="text-center text-primary mb-2">Halo, bagaimana kami bisa membantu?</h3>
                    <p class="text-body text-center mb-0 px-3">atau pilih kategori untuk dengan cepat menemukan bantuan yang Anda butuhkan</p>
                    <div class="my-3 input-group input-group-lg input-group-merge px-5" style="max-width: 40rem">
                        <span class="input-group-text" id="search"><i class="mdi mdi-magnify mdi-20px"></i></span>
                        <input type="search" class="form-control" placeholder="Ajukan pertanyaan...." aria-label="Search" id="faq_search" aria-describedby="search">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                            @foreach($educationalInstitutions as $educationalInstitution)
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link {{ $loop->first ? 'active' : '' }} waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="" data-educational-institution="{{ $educationalInstitution->id }}" aria-controls="navs-pills-justified-home" aria-selected="true">
                                        <i class="tf-icons mdi mdi-home-outline me-1"></i> {{ $educationalInstitution->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Navigation -->
                    <div class="col-lg-4 col-md-4 col-12 mb-md-0 mb-3">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-column mb-2 mb-md-0" id="faqCategories">
                                    <ul class="nav nav-align-left nav-pills flex-column e" role="tablist"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Navigation -->

                    <!-- FAQ's -->
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="faq-category-{id}" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-label-primary rounded">
                                            <i class="mdi mdi-credit-card-outline mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">
                                            <span class="align-middle">Payment</span>
                                        </h5>
                                        <small>Get help with payment</small>
                                    </div>
                                </div>
                                <div id="accordionPayment" class="accordion">
                                    <div class="accordion-item active">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionPayment-1" aria-controls="accordionPayment-1">
                                                When is payment taken for my order?
                                            </button>
                                        </h2>

                                        <div id="accordionPayment-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                Payment is taken during the checkout process when you pay for your order. The order number
                                                that appears on the confirmation screen indicates payment has been successfully processed.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /FAQ's -->
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

    {{--faq--}}
    <script src="{{ asset('js/home/faqs.js') }}"></script>
@endsection