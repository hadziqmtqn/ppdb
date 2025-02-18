<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Create {{ $title }}</h3>
                </div>
                <form onsubmit="return false" id="formCreate" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" class="form-select select2" id="select-educational-institution"></select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="mb-2">Registrasi diterima dengan Nilai Raport</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="accepted_with_school_raport" id="yes" value="1">
                            <label class="form-check-label" for="yes">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="accepted_with_school_raport" id="no" value="0">
                            <label class="form-check-label" for="no">Tidak</label>
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
