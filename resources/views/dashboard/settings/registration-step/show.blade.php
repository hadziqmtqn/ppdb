@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('registration-step.index') }}">{{ $title }}</a> /</span>
        {{ $title }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <form action="{{ route('registration-step.update', $registrationStep->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="number" name="serial_number" id="serial_number" class="form-control" value="{{ $registrationStep->serial_number }}" placeholder="No. Urut">
                    <label for="serial_number">No. Urut</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="title" id="title" class="form-control" value="{{ $registrationStep->title }}" placeholder="Judul">
                    <label for="title">Judul</label>
                </div>
                <label for="description">Deskripsi</label>
                <div class="mb-3 quill-editor">{!! $registrationStep->description !!}</div>
                <textarea name="description" id="description" class="d-none" placeholder="Deskripsi">{{ $registrationStep->description }}</textarea>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png">
                    <label for="image">Gambar</label>
                </div>
                <div class="mb-2">Status</div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="active" value="1" {{ $registrationStep->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Aktif</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="non_active" value="0" {{ !$registrationStep->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="non_active">Tidak Aktif</label>
                </div>
                @include('layouts.session')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary waves-light waves-effect">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('materialize/js/quill-editor.js') }}"></script>
@endsection