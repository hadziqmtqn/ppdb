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
                <h5 class="card-header">Data Pribadi</h5>
                <form id="form" onsubmit="return false" data-username="{{ $user->username }}">
                    <div class="card-body">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="place_of_birth" id="place_of_birth" class="form-control" placeholder="Tempat Lahir">
                            <label for="place_of_birth">Tempat Lahir</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control bs-datepicker-max-today" placeholder="Tanggal Lahir" readonly>
                            <label for="date_of_birth">Tanggal Lahir</label>
                        </div>
                        <div class="mb-2">Jenis Kelamin</div>
                        <div class="form-check form-check-inline mb-3">
                            <input name="gender" class="form-check-input" type="radio" value="Laki-laki" id="gender-male">
                            <label class="form-check-label" for="gender-male">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline mb-3">
                            <input name="gender" class="form-check-input" type="radio" value="Perempuan" id="gender-famale">
                            <label class="form-check-label" for="gender-famale">Perempuan</label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="number" name="child_to" class="form-control" id="child_to" placeholder="Anak Ke">
                                    <label for="child_to">Anak Ke</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="number" name="number_of_brothers" class="form-control" id="number_of_brothers" placeholder="Dari Jumlah Saudara Kandung">
                                    <label for="number_of_brothers">Dari Jumlah Saudara Kandung</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="family_relationship" id="family_relationship" class="form-select select2">
                                <option value=""></option>
                                @foreach(['Anak Kandung', 'Anak Angkat', 'Anak Tiri', 'Anak Sambung', 'Anak Asuh'] as $familyRelationship)
                                    <option value="{{ $familyRelationship }}">{{ $familyRelationship }}</option>
                                @endforeach
                            </select>
                            <label for="family_relationship">Hubungan Keluarga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="religion" id="religion" class="form-select select2">
                                <option value=""></option>
                                @foreach(['Islam','Protestan','Katolik','Buddha','Hindu','Khonghucu'] as $religion)
                                    <option value="{{ $religion }}">{{ $religion }}</option>
                                @endforeach
                            </select>
                            <label for="religion">Agama</label>
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

@endsection