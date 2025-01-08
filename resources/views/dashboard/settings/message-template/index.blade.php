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
                    <th>Judul</th>
                    <th>Lembaga</th>
                    <th>Kategori</th>
                    <th>Penerima</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card mb-3">
        <h5 class="card-header">Penerima Pesan</h5>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatableMessageReceiver">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Pesan</th>
                    <th>Penerima</th>
                    <th>Kontak</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @can('message-template-write')
        @include('dashboard.settings.message-template.modal-create')
    @endcan
    @can('message-receiver-write')
        @include('dashboard.settings.message-receiver.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/message-template/datatable.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/message-template/select.js') }}"></script>
    <script src="{{ asset('js/message-template/validation.js') }}"></script>
    <script src="{{ asset('js/message-receiver/datatable.js') }}"></script>
    <script src="{{ asset('js/message-template/select-user.js') }}"></script>
    <script src="{{ asset('js/message-receiver/create.js') }}"></script>
@endsection