@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $subTitle }}</h4>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.settings.registration-setting.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="d-flex mb-3 gap-3">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-account-check-outline mdi-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">
                        <span class="align-middle">{{ $subTitle }}</span>
                    </h5>
                    <small>{{ $subTitle }} Selanjutnya</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">{{ $subTitle }}</h5>
                <div class="card-datatable">
                    <table class="table table-striped text-nowrap" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Level Pendidikan Selanjutnya</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('educational-group-write')
        @include('dashboard.settings.registration-setting.educational-group.modal-create')
        @include('dashboard.settings.registration-setting.educational-group.modal-edit')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/educational-group/datatable.js') }}"></script>
    <script src="{{ asset('js/educational-group/create.js') }}"></script>
    <script src="{{ asset('js/educational-level/select.js') }}"></script>
@endsection