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
                    <!-- Navigation -->
                    <div class="col-lg-4 col-md-4 col-12 mb-md-0 mb-3">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-header">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link btn-white text-white waves-effect waves-light active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tab-home" aria-controls="navs-pills-tab-home" aria-selected="true">
                                            Home
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link btn-white text-white waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tab-profile" aria-controls="navs-pills-tab-profile" aria-selected="false" tabindex="-1">
                                            Profile
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
                                    <ul class="nav nav-align-left nav-pills flex-column e" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active btn-white text-white waves-effect waves-light" data-bs-toggle="tab" data-bs-target="#payment" aria-selected="true" role="tab">
                                                <i class="mdi mdi-credit-card-outline me-1"></i>
                                                <span class="align-middle">Payment</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn-white text-white waves-effect waves-light" data-bs-toggle="tab" data-bs-target="#delivery" aria-selected="false" tabindex="-1" role="tab">
                                                <i class="mdi mdi-cart-plus me-1"></i>
                                                <span class="align-middle">Delivery</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn-white text-white waves-effect waves-light" data-bs-toggle="tab" data-bs-target="#cancellation" aria-selected="false" tabindex="-1" role="tab">
                                                <i class="mdi mdi-reload me-1"></i>
                                                <span class="align-middle">Cancellation &amp; Return</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn-white text-white waves-effect waves-light" data-bs-toggle="tab" data-bs-target="#orders" aria-selected="false" tabindex="-1" role="tab">
                                                <i class="mdi mdi-wallet-giftcard me-1"></i>
                                                <span class="align-middle">My Orders</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link btn-white text-white waves-effect waves-light" data-bs-toggle="tab" data-bs-target="#product" aria-selected="false" tabindex="-1" role="tab">
                                                <i class="mdi mdi-cog-outline me-1"></i>
                                                <span class="align-middle">Product &amp; Services</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Navigation -->

                    <!-- FAQ's -->
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="payment" role="tabpanel">
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

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-2" aria-controls="accordionPayment-2">
                                                How do I pay for my order?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                We accept Visa®, MasterCard®, American Express®, and PayPal®. Our servers encrypt all
                                                information submitted to them, so you can be confident that your credit card information
                                                will be kept safe and secure.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-3" aria-controls="accordionPayment-3">
                                                What should I do if I'm having trouble placing an order?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                For any technical difficulties you are experiencing with our website, please contact us at
                                                our
                                                <a href="javascript:void(0);">support portal</a>, or you can call us toll-free at
                                                <span class="fw-medium">1-000-000-000</span>, or email us at
                                                <a href="javascript:void(0);">order@companymail.com</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-4" aria-controls="accordionPayment-4">
                                                Which license do I need for an end product that is only accessible to paying users?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-4" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                If you have paying users or you are developing any SaaS products then you need an Extended
                                                License. For each products, you need a license. You can get free lifetime updates as well.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-5" aria-controls="accordionPayment-5">
                                                Does my subscription automatically renew?
                                            </button>
                                        </h2>
                                        <div id="accordionPayment-5" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                No, This is not subscription based item.Pastry pudding cookie toffee bonbon jujubes
                                                jujubes powder topping. Jelly beans gummi bears sweet roll bonbon muffin liquorice. Wafer
                                                lollipop sesame snaps.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="delivery" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div class="avatar">
                          <span class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-cart-plus mdi-24px"></i>
                          </span>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">
                                            <span class="align-middle">Delivery</span>
                                        </h5>
                                        <small>Lorem ipsum, dolor sit amet.</small>
                                    </div>
                                </div>
                                <div id="accordionDelivery" class="accordion">
                                    <div class="accordion-item active">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionDelivery-1" aria-controls="accordionDelivery-1">
                                                How would you ship my order?
                                            </button>
                                        </h2>

                                        <div id="accordionDelivery-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                For large products, we deliver your product via a third party logistics company offering
                                                you the “room of choice” scheduled delivery service. For small products, we offer free
                                                parcel delivery.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionDelivery-2" aria-controls="accordionDelivery-2">
                                                What is the delivery cost of my order?
                                            </button>
                                        </h2>
                                        <div id="accordionDelivery-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                The cost of scheduled delivery is $69 or $99 per order, depending on the destination
                                                postal code. The parcel delivery is free.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionDelivery-4" aria-controls="accordionDelivery-4">
                                                What to do if my product arrives damaged?
                                            </button>
                                        </h2>
                                        <div id="accordionDelivery-4" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                We will promptly replace any product that is damaged in transit. Just contact our
                                                <a href="javascript:void(0);">support team</a>, to notify us of the situation within 48
                                                hours of product arrival.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cancellation" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div class="avatar">
                          <span class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-reload mdi-24px"></i>
                          </span>
                                    </div>
                                    <div>
                                        <h5 class="mb-0"><span class="align-middle">Cancellation &amp; Return</span></h5>
                                        <small>Lorem ipsum, dolor sit amet.</small>
                                    </div>
                                </div>
                                <div id="accordionCancellation" class="accordion">
                                    <div class="accordion-item active">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionCancellation-1" aria-controls="accordionCancellation-1">
                                                Can I cancel my order?
                                            </button>
                                        </h2>

                                        <div id="accordionCancellation-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <p>
                                                    Scheduled delivery orders can be cancelled 72 hours prior to your selected delivery date
                                                    for full refund.
                                                </p>
                                                <p class="mb-0">
                                                    Parcel delivery orders cannot be cancelled, however a free return label can be provided
                                                    upon request.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionCancellation-2" aria-controls="accordionCancellation-2">
                                                Can I return my product?
                                            </button>
                                        </h2>
                                        <div id="accordionCancellation-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                You can return your product within 15 days of delivery, by contacting our
                                                <a href="javascript:void(0);">support team</a>, All merchandise returned must be in the
                                                original packaging with all original items.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-controls="accordionCancellation-3" data-bs-target="#accordionCancellation-3">
                                                Where can I view status of return?
                                            </button>
                                        </h2>
                                        <div id="accordionCancellation-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <p>Locate the item from Your <a href="javascript:void(0);">Orders</a></p>
                                                <p class="mb-0">Select <span class="fw-medium">Return/Refund</span> status</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="orders" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div class="avatar">
                          <span class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-wallet-giftcard mdi-24px"></i>
                          </span>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">
                                            <span class="align-middle">My Orders</span>
                                        </h5>
                                        <small>Lorem ipsum, dolor sit amet.</small>
                                    </div>
                                </div>
                                <div id="accordionOrders" class="accordion">
                                    <div class="accordion-item active">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionOrders-1" aria-controls="accordionOrders-1">
                                                Has my order been successful?
                                            </button>
                                        </h2>

                                        <div id="accordionOrders-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <p>
                                                    All successful order transactions will receive an order confirmation email once the
                                                    order has been processed. If you have not received your order confirmation email within
                                                    24 hours, check your junk email or spam folder.
                                                </p>
                                                <p class="mb-0">
                                                    Alternatively, log in to your account to check your order summary. If you do not have a
                                                    account, you can contact our Customer Care Team on
                                                    <span class="fw-medium">1-000-000-000</span>.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionOrders-2" aria-controls="accordionOrders-2">
                                                My Promotion Code is not working, what can I do?
                                            </button>
                                        </h2>
                                        <div id="accordionOrders-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                If you are having issues with a promotion code, please contact us at
                                                <span class="fw-medium">1 000 000 000</span> for assistance.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionOrders-3" aria-controls="accordionOrders-3">
                                                How do I track my Orders?
                                            </button>
                                        </h2>
                                        <div id="accordionOrders-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <p>
                                                    If you have an account just sign into your account from
                                                    <a href="javascript:void(0);">here</a> and select
                                                    <span class="fw-medium">“My Orders”</span>.
                                                </p>
                                                <p class="mb-0">
                                                    If you have a a guest account track your order from
                                                    <a href="javascript:void(0);">here</a> using the order number and the email address.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="product" role="tabpanel">
                                <div class="d-flex mb-3 gap-3">
                                    <div class="avatar">
                          <span class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-cog-outline mdi-24px"></i>
                          </span>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">
                                            <span class="align-middle">Product &amp; Services</span>
                                        </h5>
                                        <small>Lorem ipsum, dolor sit amet.</small>
                                    </div>
                                </div>
                                <div id="accordionProduct" class="accordion">
                                    <div class="accordion-item active">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionProduct-1" aria-controls="accordionProduct-1">
                                                Will I be notified once my order has shipped?
                                            </button>
                                        </h2>

                                        <div id="accordionProduct-1" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                Yes, We will send you an email once your order has been shipped. This email will contain
                                                tracking and order information.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionProduct-2" aria-controls="accordionProduct-2">
                                                Where can I find warranty information?
                                            </button>
                                        </h2>
                                        <div id="accordionProduct-2" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                We are committed to quality products. For information on warranty period and warranty
                                                services, visit our Warranty section <a href="javascript:void(0);">here</a>.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionProduct-3" aria-controls="accordionProduct-3">
                                                How can I purchase additional warranty coverage?
                                            </button>
                                        </h2>
                                        <div id="accordionProduct-3" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                For the peace of your mind, we offer extended warranty plans that add additional year(s)
                                                of protection to the standard manufacturer’s warranty provided by us. To purchase or find
                                                out more about the extended warranty program, visit Extended Warranty section
                                                <a href="javascript:void(0);">here</a>.
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
@endsection