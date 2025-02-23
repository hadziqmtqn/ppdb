@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('previous-school-reference.index') }}">{{ $title }}</a> /</span>
        {{ $subTitle }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $subTitle }}</h5>
        <form onsubmit="return false" id="formEdit" data-slug="{{ $previousSchoolReference->slug }}">
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <select name="educational_group_id" id="select-educational-group" class="form-select select2">
                        <option value="{{ $previousSchoolReference->educational_group_id }}" selected>{{ optional($previousSchoolReference->educationalGroup)->name }}</option>
                    </select>
                    <label for="select-educational-group">Kelompok Pendidikan</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama" value="{{ $previousSchoolReference->name }}">
                    <label for="name">Nama</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="number" name="npsn" id="npsn" class="form-control" placeholder="NPSN" value="{{ $previousSchoolReference->npsn }}">
                    <label for="npsn">NPSN</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="province" id="select-province" class="form-select select2">
                        <option value="{{ $previousSchoolReference->province }}" selected>{{ $previousSchoolReference->province }}</option>
                    </select>
                    <label for="select-province">Provinsi</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="city" id="select-city" class="form-select select2">
                        <option value="{{ $previousSchoolReference->city }}" selected>{{ $previousSchoolReference->city }}</option>
                    </select>
                    <label for="select-city">Kota/Kabupaten</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="district" id="select-district" class="form-select select2">
                        <option value="{{ $previousSchoolReference->district }}" selected>{{ $previousSchoolReference->district }}</option>
                    </select>
                    <label for="select-district">Kecamatan</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="village" id="select-village" class="form-select select2">
                        <option value="{{ $previousSchoolReference->village }}" selected>{{ $previousSchoolReference->village }}</option>
                    </select>
                    <label for="select-village">Desa/Kelurahan</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="street" id="street" class="form-control" placeholder="Jalan" value="{{ $previousSchoolReference->street }}">
                    <label for="street">Jalan</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="status" id="status" class="form-select select2">
                        <option value=""></option>
                        <option value="Swasta" @selected($previousSchoolReference->status == 'Swasta')>Swasta</option>
                        <option value="Negeri" @selected($previousSchoolReference->status == 'Negeri')>Negeri</option>
                    </select>
                    <label for="status">Status Sekolah</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary waves-light waves-effect" id="btn-submit">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/previous-school-reference/edit.js') }}"></script>

    <script src="{{ asset('js/educational-group/single-select.js') }}"></script>
    <script src="{{ asset('js/idn-location/address.js') }}"></script>
@endsection