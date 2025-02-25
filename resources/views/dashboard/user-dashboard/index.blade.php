@extends('layouts.master')
@section('content')
    <div class="card bg-transparent shadow-none border-0 my-4">
        <div class="card-body row p-0 pb-3">
            <div class="col-12 col-md-8 card-separator">
                <h3 class="display-6">Selamat Datang, <span class="fw-semibold">{{ auth()->user()->name }}</span> 👋🏻</h3>
                <div class="col-12 col-lg-7">
                    <p>Berikut ini progres Anda registrasi siswa baru.</p>
                </div>
                {{-- <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                    <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                        <div class="avatar avatar-md">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="mdi mdi-laptop mdi-36px"></i>
                            </div>
                        </div>
                        <div class="content-right">
                            <p class="mb-0 fw-medium">Hours Spent</p>
                            <span class="text-primary mb-0 display-6">34h</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-md">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="mdi mdi-lightbulb-outline mdi-36px"></i>
                            </div>
                        </div>
                        <div class="content-right">
                            <p class="mb-0 fw-medium">Test Results</p>
                            <span class="text-info mb-0 display-6">82%</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-md">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="mdi mdi-check-decagram-outline mdi-36px"></i>
                            </div>
                        </div>
                        <div class="content-right">
                            <p class="mb-0 fw-medium">Course Completed</p>
                            <span class="text-warning mb-0 display-6">14</span>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="col-12 col-md-4 ps-md-3 ps-lg-5 pt-3 pt-md-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div>
                            <h5 class="mb-2">Time Spendings</h5>
                            <p class="mb-4">Weekly report</p>
                        </div>
                        <div class="time-spending-chart">
                            <h3 class="mb-2">231<span class="text-body">h</span> 14<span class="text-body">m</span></h3>
                            <span class="badge bg-label-success rounded-pill">+18.4%</span>
                        </div>
                    </div>
                    <div id="leadsReportChart"></div>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
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
                        Silahkan klik tombol dibawah ini untuk menuju halaman tagihan registrasi
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('current-bill.index', $user->username) }}" class="btn btn-secondary btn-sm"><i class="mdi mdi-credit-card-outline me-2"></i>Bayar Sekarang</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection