@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.index') }}">Siswa</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header-banner">
                    <img src="{{ asset('materialize/assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ asset('materialize/assets/img/avatars/1.png') }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ $user->name }}</h4>
                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item">
                                        <i class="mdi mdi-invert-colors me-1 mdi-20px"></i><span class="fw-medium">{{ optional(optional($user->student)->registrationPath)->name }}</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="mdi mdi-map-marker-outline me-1 mdi-20px"></i><span class="fw-medium">Vatican City</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="mdi mdi-calendar-blank-outline me-1 mdi-20px"></i><span class="fw-medium"> Terdaftar {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('DD MMM Y') }}</span>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('student-registration.index', $user->username) }}" class="btn btn-warning waves-effect waves-light">
                                <i class="mdi mdi-account-edit-outline me-1"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection