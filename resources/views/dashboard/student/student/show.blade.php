@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.index') }}">Siswa</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
        <div class="mb-2 mb-sm-0">
            <h4 class="mb-1">No. Registrasi: {{ optional($user->student)->registration_number }}</h4>
            <p class="mb-0">Tgl. Registrasi: {{ Carbon\Carbon::parse(optional($user->student)->created_at)->isoFormat('DD MMM Y') }}</p>
        </div>
        <a href="{{ route('student-registration.index', $user->username) }}" class="btn btn-outline-warning delete-customer waves-effect">Edit</a>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="customer-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 mt-4" src="{{ $photoUrl }}" height="120" width="120" alt="User avatar">
                            <div class="customer-info text-center mb-4">
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <span>{{ optional(optional($user->student)->educationalInstitution)->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar me-1">
                                <div class="avatar-initial rounded bg-label-primary">
                                    <i class="mdi mdi mdi-tag-outline mdi-20px"></i>
                                </div>
                            </div>
                            <div>
                                <span>Kategori</span>
                                <h5 class="mb-0">{{ optional(optional($user->student)->registrationCategory)->name }}</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar me-1">
                                <div class="avatar-initial rounded bg-label-primary">
                                    <i class="mdi mdi-sitemap-outline mdi-20px"></i>
                                </div>
                            </div>
                            <div>
                                <span>Jalur</span>
                                <h5 class="mb-0">{{ optional(optional($user->student)->registrationPath)->name }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="info-container">
                        <h5 class="border-bottom text-uppercase pb-3">DETAIL</h5>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <span class="h6 me-1">Email:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1">Status:</span>
                                <span class="badge {{ $user->is_active ? 'bg-label-success' : 'bg-label-danger' }} rounded-pill">{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1">Kontak:</span>
                                <span>{{ optional($user->student)->whatsapp_number }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-outline-warning me-3 waves-effect waves-light" data-bs-target="#editUser" data-bs-toggle="modal">Edit Status Akun</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 bg-gradient-primary">
                <div class="card-body">
                    <div class="row justify-content-between mb-3">
                        <div class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1 order-lg-0 order-xl-1 order-xxl-0">
                            <h4 class="card-title text-white text-nowrap">Upgrade to premium</h4>
                            <p class="card-text text-white">
                                Upgrade customer to premium membership to access pro features.
                            </p>
                        </div>
                        <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img src="{{ asset('materialize/assets/img/illustrations/rocket.png') }}" class="w-px-75 m-2" alt="3dRocket"></span>
                    </div>
                    <button class="btn btn-white text-primary w-100 fw-medium shadow-sm waves-effect waves-light" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">
                        Upgrade to premium
                    </button>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active waves-effect waves-light" href="{{ route('student.show', $user->username) }}"><i class="mdi mdi-account-outline mdi-20px me-1"></i>Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="#"><i class="mdi mdi-lock-open-outline mdi-20px me-1"></i>Keamanan</a>
                </li>
            </ul>

            <div class="row text-nowrap">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-icon mb-3">
                                <div class="avatar">
                                    <div class="avatar-initial rounded bg-label-primary">
                                        <i class="mdi mdi-account-network mdi-24px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <h4 class="card-title mb-3">Data Registrasi</h4>
                                @foreach($registrations as $key => $registration)
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="me-auto">
                                            <span class="text-heading fw-medium">{{ $key }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span>{{ $registration }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-icon mb-3">
                                <div class="avatar">
                                    <div class="avatar-initial rounded bg-label-success">
                                        <i class="mdi mdi-account-outline mdi-24px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <h4 class="card-title mb-3">Data Pribadi</h4>
                                @foreach($personalData as $key => $data)
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="me-auto">
                                            <span class="text-heading fw-medium">{{ $key }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span>{{ $data }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-icon mb-3">
                                <div class="avatar">
                                    <div class="avatar-initial rounded bg-label-warning">
                                        <i class="mdi mdi-account-multiple-outline mdi-24px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <h4 class="card-title mb-3">Data Keluarga</h4>
                                @foreach($families as $key => $familiy)
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="me-auto">
                                            <span class="text-heading fw-medium">{{ $key }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span>{{ $familiy }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-icon mb-3">
                                <div class="avatar">
                                    <div class="avatar-initial rounded bg-label-info">
                                        <i class="mdi mdi-home-heart mdi-24px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <h4 class="card-title mb-3">Tempat Tinggal</h4>
                                @foreach($residences as $key => $residence)
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="me-auto">
                                            <span class="text-heading fw-medium">{{ $key }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span>{{ $residence }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-icon mb-3">
                                <div class="avatar">
                                    <div class="avatar-initial rounded bg-label-danger">
                                        <i class="mdi mdi-office-building-outline mdi-24px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <h4 class="card-title mb-3">Asal Sekolah</h4>
                                @foreach($previousSchools as $key => $previousSchool)
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="me-auto">
                                            <span class="text-heading fw-medium">{{ $key }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span>{{ $previousSchool }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="card-icon mb-3">
                                <div class="avatar">
                                    <div class="avatar-initial rounded bg-label-success">
                                        <i class="mdi mdi-file-cloud-outline mdi-24px"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <h4 class="card-title">Berkas</h4>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <table class="table w-100 text-nowrap table-responsive">
                                <thead>
                                <tr>
                                    <th>Nama Berkas</th>
                                    <th style="text-align: end">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($mediaFiles as $mediaFile)
                                    <tr>
                                        <td>{{ $mediaFile['fileName'] }}</td>
                                        <td style="text-align: end">
                                            @if($mediaFile['fileUrl'])
                                                <a href="{{ $mediaFile['fileUrl'] }}" class="btn btn-xs btn-outline-dark" target="_blank"><i class="mdi mdi-file-link-outline me-1"></i>Lihat</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection