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
                    <th>Nama Siswa</th>
                    <th>Admin Pengirim</th>
                    <th>Subjek</th>
                    <th>Status dibaca</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('dashboard.messages.conversation.modal-create')
@endsection

@section('scripts')
    <script src="{{ asset('js/message/conversation/datatable.js') }}"></script>
@endsection