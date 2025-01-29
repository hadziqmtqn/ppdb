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
                        <div>Apakah Punya Wali?</div>
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input name="have_a_guardian" class="form-check-input" type="radio" value="1" {{ optional($user->family)->have_a_guardian === 1 ? 'checked' : '' }} id="yes">
                                <label class="form-check-label" for="yes">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="have_a_guardian" class="form-check-input" type="radio" value="0" {{ optional($user->family)->have_a_guardian === 0 ? 'checked' : '' }} id="no">
                                <label class="form-check-label" for="no">Tidak</label>
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
@endsection