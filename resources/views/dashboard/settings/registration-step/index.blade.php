@extends('layouts.master')

@section('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/quill/editor.css') }}" />
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>No. Urut</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @can('registration-step-write')
        @include('dashboard.settings.registration-step.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/registration-step/datatable.js') }}"></script>
    <!-- Vendors JS -->
    <script src="{{ asset('materialize/assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('materialize/assets/vendor/libs/quill/quill.js') }}"></script>

    {{--page js--}}
    <script src="{{ asset('materialize/js/quill-editor.js') }}"></script>
@endsection