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
                <h5 class="card-header">Pendaftaran</h5>
                <form id="form" onsubmit="return false">
                    <div class="card-body">
                        <input type="hidden" value="{{ optional($user->student)->educational_institution_id }}" id="select-educational-institution">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="educationalInstitution" value="{{ optional(optional($user->student)->educationalInstitution)->name }}" readonly>
                            <label for="educationalInstitution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="registrationNumber" value="{{ optional($user->student)->registration_number }}" readonly>
                            <label for="registrationNumber">No. Pendaftaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_category_id" class="form-select select2" id="select-registration-category">
                                <option value="{{ optional($user->student)->registration_category_id }}" selected>{{ optional(optional($user->student)->registrationCategory)->name }}</option>
                            </select>
                            <label for="select-registration-category">Kategori Pendaftaran</label>
                        </div>
                        @if(optional(optional($user->student)->educationalInstitution)->registrationPaths->isNotEmpty())
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="registration_path_id" class="form-select select2" id="select-registration-path">
                                    <option value="{{ optional($user->student)->registration_path_id }}" selected>{{ optional(optional($user->student)->registrationPath)->name }}</option>
                                </select>
                                <label for="select-registration-path">Jalur Pendaftaran</label>
                            </div>
                        @endif
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="class_level_id" class="form-select select2" id="select-class-level">
                                <option value="{{ optional($user->student)->class_level_id }}" selected>{{ optional(optional($user->student)->classLevel)->name }}</option>
                            </select>
                            <label for="select-class-level">Kelas</label>
                        </div>
                        @if(optional(optional($user->student)->educationalInstitution)->majors->isNotEmpty())
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="major_id" class="form-select select2" id="select-major">
                                    <option value="{{ optional($user->student)->major_id }}" selected>{{ optional(optional($user->student)->major)->name }}</option>
                                </select>
                                <label for="select-major">Jurusan</label>
                            </div>
                        @endif
                        @if(optional(optional(optional($user->student)->educationalInstitution)->educationalLevel)->code != 'SD')
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="number" class="form-control" name="nisn" id="nisn" placeholder="Nomor Induk Siswa Nasional" value="{{ optional($user->student)->nisn }}">
                                <label for="nisn">NISN</label>
                            </div>
                        @endif
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control uppercase-input" name="name" id="name" value="{{ $user->name }}" placeholder="Nama Lengkap">
                            <label for="name">Nama Lengkap</label>
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
    <script src="{{ asset('js/registration-category/select.js') }}"></script>
    <script src="{{ asset('js/registration-path/select.js') }}"></script>
    <script src="{{ asset('js/class-level/select.js') }}"></script>
    <script src="{{ asset('js/major/select.js') }}"></script>
    <script>
        const inputField = document.querySelector('.uppercase-input');

        // Tambahkan event listener untuk mengubah input ke huruf besar
        inputField.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
        });
    </script>
@endsection