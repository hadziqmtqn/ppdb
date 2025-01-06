@extends('home.layouts.master')
@section('content')
    <section class="section-py first-section-pt">
        <div class="container">
            <h2 class="text-center mb-2">{{ $title }}</h2>
            <p class="text-center px-sm-5">
                <span>Informasi Pendaftaran Calon Siswa Baru Tahun Ajaran {{ $getSchoolYearActive['year'] }}.</span>
            </p>
            <div class="row gy-4">
                @foreach($educationalInstitutions as $key => $educationalInstitution)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card border-1 shadow-none">
                            <div class="card-header pb-2">
                                <div class="d-flex align-items-start">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar me-3">
                                            <img src="{{ url($educationalInstitution['logo']) }}" alt="Logo" class="rounded-circle">
                                        </div>
                                        <div class="me-2">
                                            <h5 class="mb-1">
                                                <a href="javascript:void(0)" class="text-heading">{{ $educationalInstitution['name'] }}</a>
                                            </h5>
                                            <div class="client-info text-body">
                                                <span class="fw-medium">Email: </span><span>{{ $educationalInstitution['email'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge rounded-pill {{ $educationalInstitution['colorLevel'] }}">{{ $educationalInstitution['educationalLevel'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="bg-lighter px-2 py-1 rounded-2 me-auto mb-3" data-bs-toggle="tooltip" title="Kuota Pendaftaran">
                                        <p class="mb-1"><span class="fw-medium text-heading">{{ $educationalInstitution['remainingQuota'] }}</span> <span>/ {{ $educationalInstitution['quota'] }}</span></p>
                                        <span class="text-body">Kuota</span>
                                    </div>
                                    <div class="text-end mb-3" data-bs-toggle="tooltip" title="Jadwal Pendaftaran">
                                        <p class="mb-1">
                                            <span class="text-heading fw-medium">Mulai: </span> <span>{{ $educationalInstitution['startDateSchedule'] }}</span>
                                        </p>
                                        <p class="mb-1">
                                            <span class="text-heading fw-medium">Sampai: </span> <span>{{ $educationalInstitution['endDateSchedule'] }}</span>
                                        </p>
                                    </div>
                                </div>
                                @if($educationalInstitution['profile'])
                                    <p class="mb-0">{{ Str::limit($educationalInstitution['profile']) }} <span class="fst-italic text-primary cursor-pointer" data-bs-toggle="modal" data-bs-target="#modal{{ $key }}">Selengkapnya</span></p>
                                    <div class="modal fade" id="modal{{ $key }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalLabel2">Profil {{ $educationalInstitution['name'] }}</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $educationalInstitution['profile'] }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body border-top">
                                <div class="d-flex align-items-center mb-3">
                                    <p class="mb-1"><span class="text-heading fw-medium">Persentase Kuota</span></p>
                                    <span class="badge {{ $educationalInstitution['remainingDays'] == 'Belum dibuka' ? 'bg-label-secondary' : ($educationalInstitution['remainingDays'] == 'Telah ditutup' ? 'bg-label-danger' : 'bg-label-success') }} ms-auto rounded-pill">{{ $educationalInstitution['remainingDays'] }}</span>
                                </div>
                                <div class="progress mb-3 rounded rounded" style="height: 8px">
                                    <div class="progress-bar rounded" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-primary waves-light waves-effect w-100" data-id="{{ $educationalInstitution['id'] }}" data-education-name="{{ $educationalInstitution['name'] }}" data-major="{{ $educationalInstitution['hasMajors'] }}" data-bs-toggle="modal" data-bs-target="#modalRegister">Daftar Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @include('home.register.modal-create')
@endsection

@section('scripts')
    <script src="{{ asset('js/register/select-institution.js') }}"></script>
    <script src="{{ asset('js/register/form-reset.js') }}"></script>
    <script src="{{ asset('js/registration-category/select.js') }}"></script>
    <script src="{{ asset('js/registration-path/select.js') }}"></script>
    <script src="{{ asset('js/class-level/select.js') }}"></script>
    <script src="{{ asset('js/major/select.js') }}"></script>
@endsection