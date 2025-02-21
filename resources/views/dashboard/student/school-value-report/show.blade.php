@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('school-report') }}">Nilai Rapor</a> /</span>
        {{ $subTitle }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $subTitle }}</h5>
        <div class="card-body">
        </div>
    </div>
@endsection