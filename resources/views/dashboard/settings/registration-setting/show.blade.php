@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('registration-setting.index') }}">{{ $title }}</a> /</span>
        {{ $title }}
    </h4>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.settings.registration-setting.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="d-flex mb-3 gap-3">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-account-check-outline mdi-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">
                        <span class="align-middle">{{ $title }}</span>
                    </h5>
                    <small>Pengaturan Registrasi Murid Baru</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">Pembagian Mata Pelajaran</h5>
                <form onsubmit="return false" id="formEdit" data-slug="{{ $registrationSetting->slug }}">
                    <div class="card-body">
                        <input type="hidden" name="educational_institution_id" id="editEducationalInstitution" value="{{ $registrationSetting->educational_institution_id }}">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="" id="educational" value="{{ optional($registrationSetting->educationalInstitution)->name }}" class="form-control" disabled>
                            <label for="educational">Lembaga</label>
                        </div>
                        <div class="mb-3">
                            <div class="mb-2">Registrasi diterima dengan Nilai Raport</div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="accepted_with_school_report" id="yes" value="1" {{ $registrationSetting->accepted_with_school_report == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="yes">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="accepted_with_school_report" id="no" value="0" {{ $registrationSetting->accepted_with_school_report == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="no">Tidak</label>
                            </div>
                        </div>
                        <div id="inputSemester" class="{{ $registrationSetting->accepted_with_school_report ? 'd-block' : 'd-none' }}">
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="school_report_semester[]" id="edit_school_report_semester" class="form-select select2" multiple>
                                    @foreach(range(1,6) as $range)
                                        <option value="{{ $range }}" {{ in_array($range, $schoolReportSemester) ? 'selected' : '' }}>Semester {{ $range }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_school_report_semester">Rapor Semster</label>
                            </div>
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
    <script src="{{ asset('js/registration-setting/update.js') }}"></script>
    <script src="{{ asset('js/registration-setting/input-semester.js') }}"></script>
@endsection