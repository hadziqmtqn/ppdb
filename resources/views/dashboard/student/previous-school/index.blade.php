@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.index') }}">Siswa</a> /</span>
        Pendaftaran
    </h4>
    <div class="row">
        <div class="col-md-4">
            @include('dashboard.student.menu')
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <h5 class="card-header">Data Asal Sekolah</h5>
                <form id="form" onsubmit="return false" data-username="{{ $user->username }}">
                    <div class="card-body">
                        <input type="hidden" name="" id="select-educational-institution-0" value="{{ $user->student->educational_institution_id }}">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_group_id" id="select-educational-group" class="form-select select2">
                                <option value="{{ optional(optional($user->previousSchool)->previousSchoolReference)->educational_group_id }}" selected>{{ optional(optional(optional($user->previousSchool)->previousSchoolReference)->educationalGroup)->name }}</option>
                            </select>
                            <label for="select-educational-group">Kelompok Pendidikan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="province" id="select-province" class="form-select select2">
                                <option value="{{ optional(optional($user->previousSchool)->previousSchoolReference)->province }}" selected>{{ optional(optional($user->previousSchool)->previousSchoolReference)->province }}</option>
                            </select>
                            <label for="province">Provinsi</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="city" id="select-city" class="form-select select2">
                                <option value="{{ optional(optional($user->previousSchool)->previousSchoolReference)->city }}" selected>{{ optional(optional($user->previousSchool)->previousSchoolReference)->city }}</option>
                            </select>
                            <label for="city">Kota/Kabupaten</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="district" id="select-district" class="form-select select2">
                                <option value="{{ optional(optional($user->previousSchool)->previousSchoolReference)->district }}" selected>{{ optional(optional($user->previousSchool)->previousSchoolReference)->district }}</option>
                            </select>
                            <label for="district">Kecamatan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="village" id="select-village" class="form-select select2">
                                <option value="{{ optional(optional($user->previousSchool)->previousSchoolReference)->village }}" selected>{{ optional(optional($user->previousSchool)->previousSchoolReference)->village }}</option>
                            </select>
                            <label for="village">Desa/Kelurahan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="previous_school_reference_id" id="select-previous-school-reference" class="form-select select2" data-allow-clear="true">
                                <option value="{{ optional($user->previousSchool)->previous_school_reference_id }}" selected>{{ optional(optional($user->previousSchool)->previousSchoolReference)->name }} ({{ optional(optional($user->previousSchool)->previousSchoolReference)->status }})</option>
                            </select>
                            <label for="select-previous-school-reference">Asal Sekolah</label>
                        </div>
                        <div class="form-check form-check-primary mb-3">
                            <input class="form-check-input" type="checkbox" name="create_new" value="0" id="createNew">
                            <label class="form-check-label" for="createNew">Tambah Baru</label>
                        </div>
                        <div id="inputNewSchool" class="d-none">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" name="school_name" id="school_name" class="form-control" placeholder="Nama Asal Sekolah">
                                <label for="school_name">Nama Asal Sekolah</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="status" id="status" class="form-select select2">
                                    <option value=""></option>
                                    @foreach(['Swasta', 'Negeri'] as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                <label for="status">Status Sekolah</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" name="street" id="street" class="form-control" placeholder="Nama Jalan">
                                <label for="street">Jalan</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="btn-submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/previous-school/store.js') }}"></script>
    <script src="{{ asset('js/idn-location/address.js') }}"></script>
    <script src="{{ asset('js/educational-group/select.js') }}"></script>

    <script src="{{ asset('js/previous-school-reference/select.js') }}"></script>
    <script src="{{ asset('js/student/previous-school/new-school.js') }}"></script>
@endsection