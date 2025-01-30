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
                            <select name="province" id="select-province" class="form-select select2">
                                <option value="{{ optional($user->residence)->province }}" selected>{{ optional($user->residence)->province }}</option>
                            </select>
                            <label for="province">Provinsi</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="city" id="select-city" class="form-select select2">
                                <option value="{{ optional($user->residence)->city }}" selected>{{ optional($user->residence)->city }}</option>
                            </select>
                            <label for="city">Kota/Kabupaten</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="district" id="select-district" class="form-select select2">
                                <option value="{{ optional($user->residence)->district }}" selected>{{ optional($user->residence)->district }}</option>
                            </select>
                            <label for="district">Kecamatan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="village" id="select-village" class="form-select select2">
                                <option value="{{ optional($user->residence)->village }}" selected>{{ optional($user->residence)->village }}</option>
                            </select>
                            <label for="village">Desa/Kelurahan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="street" id="street" class="form-control" placeholder="Jalan" value="{{ optional($user->residence)->street }}">
                            <label for="street">Jalan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="postal_code" id="postal_code" class="form-control number-only" placeholder="Kode Pos" value="{{ optional($user->residence)->postal_code }}" minlength="5" maxlength="5">
                            <label for="postal_code">Kode Pos</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="distance_to_school_id" id="distance_to_school_id" class="form-select select2">
                                <option value=""></option>
                                @foreach($distanceToSchools as $distanceToSchool)
                                    <option value="{{ $distanceToSchool->id }}" {{ optional($user->residence)->distance_to_school_id == $distanceToSchool->id ? 'selected' : '' }}>{{ $distanceToSchool->name }}</option>
                                @endforeach
                            </select>
                            <label for="distance_to_school_id">Jarak Tempat Tinggal ke Sekolah</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="transportation_id" id="transportation_id" class="form-select select2">
                                <option value=""></option>
                                @foreach($transportations as $transportation)
                                    <option value="{{ $transportation->id }}" {{ optional($user->residence)->transportation_id == $transportation->id ? 'selected' : '' }}>{{ $transportation->name }}</option>
                                @endforeach
                            </select>
                            <label for="transportation_id">Transportasi ke Sekolah</label>
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
    <script src="{{ asset('js/student/place-of-recidence/store.js') }}"></script>
    <script src="{{ asset('js/idn-location/address.js') }}"></script>
@endsection