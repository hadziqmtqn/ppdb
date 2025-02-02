@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    @foreach($stats as $label => $stat)
                        <div class="col-sm-6 col-lg-4">
                            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-2" id="{{ $stat['id'] }}">{{ $stat['total'] }}</h3>
                                    <p class="mb-0">{{ $label }}</p>
                                </div>
                                <div class="avatar me-sm-4">
                                <span class="avatar-initial rounded bg-label-secondary">
                                  <i class="mdi mdi-{{ $stat['icon'] }} mdi-24px"></i>
                                </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select name="school_year_id" id="select-school-year" class="form-select select2">
                            <option value="{{ $getSchoolYearActive['id'] }}" selected>{{ $getSchoolYearActive['year'] }}</option>
                        </select>
                        <label for="select-school-year">Tahun Ajaran</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select name="educational_institution_id" id="select-educational-institution" class="form-select select2" data-allow-clear="true"></select>
                        <label for="select-educational-institution">Lembaga</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select name="registration_category_id" id="select-registration-category" class="form-select select2" data-allow-clear="true"></select>
                        <label for="select-registration-category">Kategori</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-3 filter" data-bs-toggle="tooltip" title="Pastikan lembaga telah dipilih">
                        <select name="registration_path_id" id="select-registration-path" class="form-select select2" data-allow-clear="true"></select>
                        <label for="select-registration-path">Jalur Pendaftaran</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>No. Registrasi</th>
                    <th>Nama</th>
                    <th>Lembaga</th>
                    <th>Kategori Pendaftaran</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/educational-institution/select.js') }}" async></script>
    <script src="{{ asset('js/registration-category/select.js') }}" async></script>
    <script src="{{ asset('js/registration-path/select.js') }}" async></script>
    <script src="{{ asset('js/school-year/select.js') }}" async></script>
    <script src="{{ asset('js/student/datatable.js') }}" async></script>
    <script src="{{ asset('js/student/student-stats.js') }}"></script>
@endsection