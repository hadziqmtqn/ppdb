@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.index') }}">Siswa</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="row">
        <div class="col-md-4">
            @include('dashboard.student.menu')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/registration-category/select.js') }}"></script>
@endsection