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
                    <th>Nama</th>
                    <th>Detail Media</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @can('media-file-write')
        @include('dashboard.references.media-file.modal-create')
        @include('dashboard.references.media-file.modal-edit')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/media-file/datatable.js') }}"></script>
    <script src="{{ asset('js/media-file/create.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/registration-path/select.js') }}"></script>
    <script src="{{ asset('js/media-file/select.js') }}"></script>
    <script src="{{ asset('js/media-file/new-media-file.js') }}"></script>
@endsection