@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @can('registration-path-write')
        @include('dashboard.references.registration-path.modal-edit')
        @include('dashboard.references.registration-path.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/registration-path/datatable.js') }}"></script>
    <script src="{{ asset('js/registration-path/create.js') }}"></script>
@endsection