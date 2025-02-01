@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('media-file.index') }}">{{ $title }}</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <form onsubmit="return false" id="formEdit" data-slug="{{ $detailMediaFile->slug }}">
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama File" value="{{ optional($detailMediaFile->mediaFile)->name }}">
                    <label for="name">Nama File</label>
                </div>
                <div class="mb-2">Status</div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="active" value="1" {{ optional($detailMediaFile->mediaFile)->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Aktif</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="non_active" value="0" {{ !optional($detailMediaFile->mediaFile)->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="non_active">Tidak Aktif</label>
                </div>
                <div class="divider">
                    <div class="divider-text divider-primary">Detail File</div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" id="select-educational-institution" class="form-select select2">
                                <option value="{{ $detailMediaFile->educational_institution_id }}" selected>{{ optional($detailMediaFile->educationalInstitution)->name }}</option>
                            </select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_path_id" id="select-registration-path" class="form-select select2" data-allow-clear="true">
                                <option value="{{ $detailMediaFile->registration_path_id }}" selected>{{ optional($detailMediaFile->registrationPath)->name }}</option>
                            </select>
                            <label for="select-registration-path">Jalur Pendaftaran</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit">Submit</button>
                <a href="{{ route('media-file.index') }}" class="btn btn-outline-secondary me-sm-3 me-1 waves-effect waves-light">Batal</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/registration-path/select.js') }}"></script>
    <script src="{{ asset('js/media-file/edit.js') }}"></script>
@endsection