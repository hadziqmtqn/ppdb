@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('school-year.index') }}">{{ $title }}</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">Detail {{ $title }}</h5>
        <form action="{{ route('school-year.update', $schoolYear->slug) }}" method="post" id="form">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="first_year" id="first_year" class="form-control bs-datepicker-year" value="{{ $schoolYear->first_year }}" placeholder="Tahun Awal" readonly>
                    <label for="first_year">Tahun Awal</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="last_year" class="form-control bs-datepicker-year" id="last_year" value="{{ $schoolYear->last_year }}" placeholder="Tahun Akhir" readonly>
                    <label for="last_year">Tahun Akhir</label>
                </div>
                <div class="mb-3">
                    <div class="mb-1">Status</div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="active" value="1" @checked($schoolYear->is_active == 1)>
                        <label class="form-check-label" for="active">Aktif</label>
                    </div>
                    @if(!$schoolYear->is_active)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="not_active" value="0" @checked($schoolYear->is_active == 0)>
                            <label class="form-check-label" for="not_active">Tidak Aktif</label>
                        </div>
                    @endif
                </div>
                @include('layouts.session')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/school-year/validation.js') }}"></script>
@endsection