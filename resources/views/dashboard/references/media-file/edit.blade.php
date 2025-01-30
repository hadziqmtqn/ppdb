@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <form onsubmit="return false" id="formEdit" data-slug="{{ $mediaFile->slug }}">
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama File" value="{{ $mediaFile->name }}">
                    <label for="name">Nama File</label>
                </div>
                <div class="mb-3">
                    <div>Kategori</div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="category" id="all" value="semua_unit" {{ $mediaFile->category == 'semua_unit' ? 'checked' : '' }}>
                        <label class="form-check-label" for="all">Semua Unit</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="category" id="specific" value="unit_tertentu" {{ $mediaFile->category == 'unit_tertentu' ? 'checked' : '' }}>
                        <label class="form-check-label" for="specific">Unit Tertentu</label>
                    </div>
                </div>
                <div id="educational-institutions-wrapper" style="display: {{ $mediaFile->category == 'semua_unit' ? 'd-none' : 'd-block' }};">
                    <div class="form-floating form-floating-outline mb-3">
                        <select name="educational_institutions" id="educational-institutions" class="form-select select2" multiple>
                            <option value=""></option>
                            @foreach($educationalInstitutions as $educationalInstitution)
                                <option value="{{ $educationalInstitution->id }}" {{ $educationalInstitutionsSelected ? in_array($educationalInstitution->id, $educationalInstitutionsSelected) ? 'selected' : '' : '' }}>{{ $educationalInstitution->name }}</option>
                            @endforeach
                        </select>
                        <label for="educational-institutions">Lembaga</label>
                    </div>
                </div>
                <div class="mb-2">Status</div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="active" value="1" {{ $mediaFile->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Aktif</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="non_active" value="0" {{ !$mediaFile->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="non_active">Tidak Aktif</label>
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
    <script src="{{ asset('js/media-file/select-educational-institutions.js') }}"></script>
    <script src="{{ asset('js/media-file/edit.js') }}"></script>
@endsection