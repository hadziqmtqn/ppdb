@extends('layouts.master')
@section('content')
    <div class="card bg-transparent shadow-none border-0 my-4">
        <div class="card-body row p-0 pb-3">
            <div class="col-12 col-md-8 card-separator">
                <h3 class="display-6">Selamat Datang, <span class="fw-semibold">{{ auth()->user()->name }}</span> 👋🏻</h3>
                <div class="col-12 col-lg-7">
                    <p>Berikut ini progres Anda registrasi siswa baru.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="list-group">
                    <div class="list-group-item active fw-bold">Data Registrasi</div>
                    @foreach ($mainProgress as $label => $progress)
                        <a href="{{ $progress['url'] }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="mdi {{ $progress['icon'] }} me-2"></i>{{ $label }}
                            </div>
                            <span class="badge bg-{{ $progress['isCompleted'] ? 'primary' : 'warning' }}">{{ $progress['isCompleted'] ? 'Lengkap' : 'Belum Lengkap' }}</span>
                        </a>
                    @endforeach
                    @if (optional(optional(optional($user->student)->educationalInstitution)->registrationSetting)->accepted_with_school_report)
                        <a href="{{ route('school-report.index', $user->username) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="mdi mdi-menu me-2"></i>Nilai Rapor
                            </div>
                            <span class="badge bg-{{ $schoolReportProgress ? 'primary' : 'warning' }}">{{ $schoolReportProgress ? 'Lengkap' : 'Belum Lengkap' }}</span>
                        </a>
                    @endif
                </div>
            </div>

            @if($activeRegistrationFee)
                <div class="card">
                    <h5 class="card-header">Biaya Registrasi</h5>
                    <div class="card-body">
                        <div class="alert alert-{{ $paymentRegistrationExists ? 'primary' : 'danger' }} alert-dismissible" role="alert">
                            @if($paymentRegistrationExists)
                                Terima kasih, tagihan registrasi siswa baru telah dilunasi.
                            @else
                                Mohon maaf, tagihan registrasi siswa baru belum dilunasi.
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        {{ !$paymentRegistrationExists ? 'Silahkan klik tombol dibawah ini untuk menuju halaman tagihan registrasi' : null }}
                    </div>
                    @if(!$paymentRegistrationExists)
                        <div class="card-footer">
                            <a href="{{ route('current-bill.index', $user->username) }}" class="btn btn-secondary btn-sm"><i class="mdi mdi-credit-card-outline me-2"></i>Bayar Sekarang</a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card mb-4 bg-gradient-{{ $registrationStatus['color'] }}">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1 order-lg-0 order-xl-1 order-xxl-0">
                            <h4 class="card-title text-white text-nowrap">{{ ucfirst(str_replace('_', ' ', $registrationStatus['status'])) }}</h4>
                            <p class="card-text text-white">{{ $registrationStatus['text'] }}</p>
                        </div>
                        <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img src="{{ url('https://hadziqmtqn.github.io/materialize/assets/img/illustrations/rocket.png') }}" class="w-px-75 m-2" alt="3dRocket"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection