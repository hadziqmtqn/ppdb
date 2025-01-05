@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('educational-institution.index') }}">{{ $title }}</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">Detail {{ $title }}</h5>
        <form action="{{ route('educational-institution.update', $educationalInstitution->slug) }}" method="post" id="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ $educationalInstitution->hasMedia('logo') ? $educationalInstitution->getFirstTemporaryUrl(\Carbon\Carbon::now()->addMinutes(5), 'logo') : asset('assets/sekolah.png') }}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded">
                </div>
            </div>
            <div class="card-body pt-2 mt-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_level_id" id="select-educational-level" class="form-select select2">
                                <option value="{{ $educationalInstitution->educational_level_id }}" selected>{{ optional($educationalInstitution->educationalLevel)->name }}</option>
                            </select>
                            <label for="select-educational-level">Level Pendidikan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="{{ $educationalInstitution->name }}">
                            <label for="name">Nama</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $educationalInstitution->email }}">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="url" class="form-control" name="website" id="website" placeholder="Website" value="{{ $educationalInstitution->website }}">
                            <label for="website">Website</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="province" id="select-province" class="form-select select2" data-allow-clear="true">
                                <option value="{{ $educationalInstitution->province }}" selected>{{ $educationalInstitution->province }}</option>
                            </select>
                            <label for="select-province">Provinsi</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="city" id="select-city" class="form-select select2" data-allow-clear="true">
                                <option value="{{ $educationalInstitution->city }}" selected>{{ $educationalInstitution->city }}</option>
                            </select>
                            <label for="select-city">Kota/Kabupaten</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="district" id="select-district" class="form-select select2" data-allow-clear="true">
                                <option value="{{ $educationalInstitution->district }}" selected>{{ $educationalInstitution->district }}</option>
                            </select>
                            <label for="select-district">Kecamatan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="village" id="select-village" class="form-select select2" data-allow-clear="true">
                                <option value="{{ $educationalInstitution->village }}" selected>{{ $educationalInstitution->village }}</option>
                            </select>
                            <label for="select-village">Desa/Kelurahan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="street" id="street" class="form-control" value="{{ $educationalInstitution->street }}" placeholder="Jalan">
                            <label for="street">Jalan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="number" name="postal_code" class="form-control" id="postal_code" value="{{ $educationalInstitution->postal_code }}" placeholder="Kode Pos">
                            <label for="postal_code">Kode Pos</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <textarea name="profile" class="form-control" id="profile" style="min-height: 100px" placeholder="Profil Singkat">{{ $educationalInstitution->profile }}</textarea>
                            <label for="profile">Profil</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="file" name="logo" class="form-control" id="logo" accept=".jpg,,jpeg,.png">
                            <label for="logo">Logo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">Status</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="active" value="1" @checked(($educationalInstitution->is_active == 1))>
                            <label class="form-check-label" for="active">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="not_active" value="0" @checked(($educationalInstitution->is_active == 0))>
                            <label class="form-check-label" for="not_active">Tidak Aktif</label>
                        </div>
                    </div>
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
    <script src="{{ asset('js/educational-level/select.js') }}"></script>
    <script src="{{ asset('js/idn-location/address.js') }}"></script>
    <script src="{{ asset('js/educational-institution/validation.js') }}"></script>
@endsection