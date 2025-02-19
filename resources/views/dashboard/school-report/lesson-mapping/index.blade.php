@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.settings.registration-setting.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="d-flex mb-3 gap-3">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-note-plus-outline mdi-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">
                        <span class="align-middle">Pembagian Mata Pelajaran</span>
                    </h5>
                    <small>Referensi Pembagian Mata Pelajaran Pada Nilai Rapor</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">Pembagian Mata Pelajaran</h5>
                <div class="card-datatable">
                    <table class="table table-striped text-nowrap" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mata Pelajaran</th>
                            <th>Lembaga</th>
                            <th>Untuk Jenjang/Level Sebelumnya</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('lesson-mapping-write')
        @include('dashboard.school-report.lesson-mapping.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/lesson-mapping/datatable.js') }}"></script>
    <script src="{{ asset('js/lesson-mapping/create.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/educational-group/select.js') }}"></script>
@endsection