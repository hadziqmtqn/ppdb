<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah {{ $title }}</h3>
                </div>
                <form action="{{ route('school-year.store') }}" id="form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
                    @csrf
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="first_year" id="first_year" class="form-control bs-datepicker-year" value="{{ old('first_year') }}" placeholder="Tahun Awal" readonly>
                            <label for="first_year">Tahun Awal</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="last_year" class="form-control bs-datepicker-year" id="last_year" value="{{ old('last_year') }}" placeholder="Tahun Akhir" readonly>
                            <label for="last_year">Tahun Akhir</label>
                        </div>
                        <div class="mb-3">
                            <div class="mb-1">Status</div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="active" value="1">
                                <label class="form-check-label" for="active">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_active" id="not_active" value="0">
                                <label class="form-check-label" for="not_active">Tidak Aktif</label>
                            </div>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
