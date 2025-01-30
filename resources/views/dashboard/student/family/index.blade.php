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
                            <input type="text" name="national_identification_number" id="national_identification_number" class="form-control number-only" placeholder="Nomor Induk Kependudukan" value="{{ optional($user->family)->national_identification_number }}" minlength="16" maxlength="16">
                            <label for="national_identification_number">Nomor Induk Kependudukan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="family_card_number" id="family_card_number" class="form-control number-only" placeholder="Nomor Kartu Keluarga" value="{{ optional($user->family)->family_card_number }}" maxlength="16">
                            <label for="family_card_number">Nomor Kartu Keluarga</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Data Ayah Kandung</div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Nama Ayah Kandung" value="{{ optional($user->family)->father_name }}" minlength="3">
                            <label for="father_name">Nama Ayah Kandung</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="father_education_id" id="father_education_id" class="form-select select2" data-allow-clear="true">
                                <option value=""></option>
                                @foreach($educations as $education)
                                    <option value="{{ $education->id }}" {{ optional($user->family)->father_education_id == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
                                @endforeach
                            </select>
                            <label for="father_education_id">Pendidikan Ayah Kandung</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="father_profession_id" id="father_profession_id" class="form-select select2" data-allow-clear="true">
                                <option value=""></option>
                                @foreach($professions as $profession)
                                    <option value="{{ $profession->id }}" {{ optional($user->family)->father_profession_id == $profession->id ? 'selected' : '' }}>{{ $profession->name }}</option>
                                @endforeach
                            </select>
                            <label for="father_profession_id">Pekerjaan Ayah Kandung</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="father_income_id" id="father_income_id" class="form-select select2" data-allow-clear="true">
                                <option value=""></option>
                                @foreach($incomes as $income)
                                    <option value="{{ $income->id }}" {{ optional($user->family)->father_income_id == $income->id ? 'selected' : '' }}>{{ $income->nominal }}</option>
                                @endforeach
                            </select>
                            <label for="father_income_id">Pengasilan Ayah Kandung</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Data Ibu Kandung</div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="mother_name" id="mother_name" class="form-control" placeholder="Nama Ibu Kandung" value="{{ optional($user->family)->mother_name }}" minlength="3">
                            <label for="mother_name">Nama Ibu Kandung</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="mother_education_id" id="mother_education_id" class="form-select select2" data-allow-clear="true">
                                <option value=""></option>
                                @foreach($educations as $education)
                                    <option value="{{ $education->id }}" {{ optional($user->family)->mother_education_id == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
                                @endforeach
                            </select>
                            <label for="mother_education_id">Pendidikan Ibu Kandung</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="mother_profession_id" id="mother_profession_id" class="form-select select2" data-allow-clear="true">
                                <option value=""></option>
                                @foreach($professions as $profession)
                                    <option value="{{ $profession->id }}" {{ optional($user->family)->mother_profession_id == $profession->id ? 'selected' : '' }}>{{ $profession->name }}</option>
                                @endforeach
                            </select>
                            <label for="mother_profession_id">Pekerjaan Ibu Kandung</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="mother_income_id" id="mother_income_id" class="form-select select2" data-allow-clear="true">
                                <option value=""></option>
                                @foreach($incomes as $income)
                                    <option value="{{ $income->id }}" {{ optional($user->family)->mother_income_id == $income->id ? 'selected' : '' }}>{{ $income->nominal }}</option>
                                @endforeach
                            </select>
                            <label for="mother_income_id">Pengasilan Ibu Kandung</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Data Wali</div>
                        </div>
                        <div>Apakah Punya Wali?</div>
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input name="have_a_guardian" class="form-check-input" type="radio" value="1" {{ optional($user->family)->have_a_guardian == 1 ? 'checked' : '' }} id="yes">
                                <label class="form-check-label" for="yes">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="have_a_guardian" class="form-check-input" type="radio" value="0" {{ optional($user->family)->have_a_guardian == 0 ? 'checked' : '' }} id="no">
                                <label class="form-check-label" for="no">Tidak</label>
                            </div>
                        </div>
                        <div id="inputGuardian" class="{{ optional($user->family)->have_a_guardian ? 'd-block' : 'd-none' }}">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" name="guardian_name" id="guardian_name" class="form-control" placeholder="Nama Wali" value="{{ optional($user->family)->guardian_name }}" minlength="3">
                                <label for="guardian_name">Nama Wali</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="guardian_education_id" id="guardian_education_id" class="form-select select2" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach($educations as $education)
                                        <option value="{{ $education->id }}" {{ optional($user->family)->guardian_education_id == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
                                    @endforeach
                                </select>
                                <label for="guardian_education_id">Pendidikan Wali</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="guardian_profession_id" id="guardian_profession_id" class="form-select select2" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach($professions as $profession)
                                        <option value="{{ $profession->id }}" {{ optional($user->family)->guardian_profession_id == $profession->id ? 'selected' : '' }}>{{ $profession->name }}</option>
                                    @endforeach
                                </select>
                                <label for="guardian_profession_id">Pekerjaan Wali</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="guardian_income_id" id="guardian_income_id" class="form-select select2" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach($incomes as $income)
                                        <option value="{{ $income->id }}" {{ optional($user->family)->guardian_income_id == $income->id ? 'selected' : '' }}>{{ $income->nominal }}</option>
                                    @endforeach
                                </select>
                                <label for="guardian_income_id">Pengasilan Wali</label>
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
    <script src="{{ asset('js/student/family/store.js') }}"></script>
    <script src="{{ asset('js/student/family/input-guardian.js') }}"></script>
@endsection