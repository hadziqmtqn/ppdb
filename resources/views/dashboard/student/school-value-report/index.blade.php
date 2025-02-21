@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select class="form-select select2" id="select-school-year">
                            <option value="{{ $getSchoolYearActive['id'] }}">{{ $getSchoolYearActive['year'] }}</option>
                        </select>
                        <label for="select-school-year">Tahun Ajaran</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select class="form-select select2" id="select-educational-institution" data-allow-clear="true"></select>
                        <label for="select-educational-institution">Lembaga</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-3 filter">
                        <select class="form-select select2" id="select-educational-group" data-allow-clear="true"></select>
                        <label for="select-educational-group">Kelompok Pendidikan</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Lembaga</th>
                    <th>Asal Sekolah</th>
                    <th>Total Skor</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/school-value-report/datatable.js') }}"></script>

    <script src="{{ asset('js/school-year/select.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/educational-group/select.js') }}"></script>
    <script src="{{ asset('js/student/school-value-report/report-excel.js') }}"></script>
@endsection