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
                <h5 class="card-header">Data Tempat Tinggal</h5>
                <form id="form" onsubmit="return false" data-username="{{ $user->username }}">
                    <div class="card-body">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="school_name" id="school_name" class="form-control" placeholder="Nama Asal Sekolah" value="{{ optional($user->previousSchool)->school_name }}">
                            <label for="school_name">Nama Asal Sekolah</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="status" id="status" class="form-select select2">
                                <option value=""></option>
                                @foreach(['Swasta', 'Negeri'] as $status)
                                    <option value="{{ $status }}" {{ optional($user->previousSchool)->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            <label for="status">Status Sekolah</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="province" id="select-province" class="form-select select2">
                                <option value="{{ optional($user->previousSchool)->province }}" selected>{{ optional($user->previousSchool)->province }}</option>
                            </select>
                            <label for="province">Provinsi</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="city" id="select-city" class="form-select select2">
                                <option value="{{ optional($user->previousSchool)->city }}" selected>{{ optional($user->previousSchool)->city }}</option>
                            </select>
                            <label for="city">Kota/Kabupaten</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="district" id="select-district" class="form-select select2">
                                <option value="{{ optional($user->previousSchool)->district }}" selected>{{ optional($user->previousSchool)->district }}</option>
                            </select>
                            <label for="district">Kecamatan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="village" id="select-village" class="form-select select2">
                                <option value="{{ optional($user->previousSchool)->village }}" selected>{{ optional($user->previousSchool)->village }}</option>
                            </select>
                            <label for="village">Desa/Kelurahan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="street" id="street" class="form-control" placeholder="Jalan" value="{{ optional($user->previousSchool)->street }}">
                            <label for="street">Jalan</label>
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
@endsection