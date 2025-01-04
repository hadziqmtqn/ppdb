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
                    <th>Lembaga</th>
                    <th>Kategori Pendaftaran</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @can('class-level-write')
        @include('dashboard.references.class-level.modal-edit')
        @include('dashboard.references.class-level.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/class-level/datatable.js') }}"></script>
    <script src="{{ asset('js/class-level/create.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/registration-category/select.js') }}"></script>
@endsection