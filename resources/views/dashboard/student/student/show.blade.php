@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.index') }}">Siswa</a> /</span>
        Detail {{ $title }}
    </h4>
    @include('dashboard.student.student.header')
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            @include('dashboard.student.student.sidebar')

            <div class="card mb-4 border-2 border-primary">
                <div class="card-body pb-0">
                    <div class="alert alert-outline-{{ $registrationValidation['color'] }} d-flex align-items-center" role="alert">
                        <i class="mdi mdi-{{ $registrationValidation['icon'] }} me-2"></i>
                        {{ $registrationValidation['text'] }}
                    </div>
                    @if(!auth()->user()->hasRole('user'))
                        <div class="d-grid w-100 mt-4 mb-3">
                            <button type="button" class="btn btn-secondary" data-bs-target="#validationModal" data-bs-toggle="modal">Ubah Status Validasi</button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4 bg-gradient-{{ $registrationStatus['color'] }}">
                <div class="card-body">
                    <div class="row justify-content-between mb-3">
                        <div class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1 order-lg-0 order-xl-1 order-xxl-0">
                            <h4 class="card-title text-white text-nowrap">{{ ucfirst(str_replace('_', ' ', $registrationStatus['status'])) }}</h4>
                            <p class="card-text text-white">{{ $registrationStatus['text'] }}</p>
                        </div>
                        <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img src="{{ asset('materialize/assets/img/illustrations/rocket.png') }}" class="w-px-75 m-2" alt="3dRocket"></span>
                    </div>
                    @if(!auth()->user()->hasRole('user'))
                        <button type="button" class="btn btn-white text-{{ $registrationStatus['color'] }} w-100 fw-medium shadow-sm waves-effect waves-light" data-bs-target="#acceptanceRegistrationModal" data-bs-toggle="modal">Ubah Status Registrasi</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7">
            @include('dashboard.student.student.menu')

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
                                <tr>
                                    <td>Biodata Pendaftaran</td>
                                    <td style="text-align: end">
                                        <a href="{{ route('student-report-pdf-user:username', $user->username) }}" class="btn btn-xs btn-outline-dark" target="_blank"><i class="mdi mdi-file-link-outline me-1"></i>Lihat</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if(optional(optional(optional($user->student)->educationalInstitution)->registrationSetting)->accepted_with_school_report)
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body pb-0">
                                <div class="card-icon mb-3">
                                    <div class="avatar">
                                        <div class="avatar-initial rounded bg-label-secondary">
                                            <i class="mdi mdi-file-outline mdi-24px"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-info">
                                    <h4 class="card-title">Nilai Raport</h4>
                                </div>
                            </div>
                            <div class="card-datatable">
                                <table class="table w-100 text-nowrap table-responsive">
                                    <tbody>
                                    @foreach($schoolReports['schoolReports'] as $schoolReport)
                                        <tr>
                                            <td class="table-light fw-bold">Semester {{ $schoolReport['semester'] }}</td>
                                            <td class="table-light fw-bold">{{ $schoolReport['totalScore'] }}</td>
                                        </tr>
                                        @foreach($schoolReport['detailSchoolReports'] as $detailSchoolReport)
                                            <tr>
                                                <td>{{ $detailSchoolReport['lessonName'] }}</td>
                                                <td>{{ $detailSchoolReport['score'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(!auth()->user()->hasRole('user'))
        @include('dashboard.student.student.modal-validation')
        @include('dashboard.student.student.modal-acceptance')
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('js/student/registration-validation.js') }}"></script>
    <script src="{{ asset('js/student/acceptance-registration.js') }}"></script>
    <script src="{{ asset('js/student/inactive.js') }}"></script>
@endsection
