@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('lesson-mapping.index') }}">Pembagian Mata Pelajaran</a> /</span>
        {{ $subTitle }}
    </h4>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.settings.registration-setting.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="d-flex mb-3 gap-3">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-note-plus-outline mdi-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">
                        <span class="align-middle">{{ $subTitle }}</span>
                    </h5>
                    <small>Referensi {{ $subTitle }} Pada Nilai Rapor</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">{{ $subTitle }}</h5>
                <form onsubmit="return false" id="formEdit" data-slug="{{ $lessonMapping->slug }}">
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="lesson_id" id="lesson" class="form-select select2">
                                <option value=""></option>
                                @foreach($lessons as $lesson)
                                    <option value="{{ $lesson->id }}" {{ $lessonMapping->lesson_id == $lesson->id ? 'selected' : '' }}>{{ $lesson->name }}</option>
                                @endforeach
                            </select>
                            <label for="lesson">Mata Pelajaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" class="form-select select2" id="select-educational-institution">
                                <option value="{{ $lessonMapping->educational_institution_id }}" selected>{{ optional($lessonMapping->educationalInstitution)->name }}</option>
                            </select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="previous_educational_group[]" class="form-select select2" multiple id="select-educational-group">
                                @foreach($educationalGroups as $educationalGroup)
                                    <option value="{{ $educationalGroup->id }}" selected>{{ $educationalGroup->name }}</option>
                                @endforeach
                            </select>
                            <label for="select-educational-group">Jenjang/Level Kelompok Pendidikan Sebelumnya</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/lesson-mapping/update.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/educational-group/select.js') }}"></script>
@endsection