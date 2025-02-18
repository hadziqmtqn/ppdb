<div class="modal fade" id="modalEdit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-0 pb-1">Update {{ $title }}</h3>
                    <p class="mb-2">Dengan memilih lembaga yang sama akan memperbarui data yang telah ada sebelumnya.</p>
                </div>
                <form onsubmit="return false" id="formEdit" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <input type="hidden" name="educational_institution_id" id="editEducationalInstitution">
                        <div class="mb-2">Registrasi diterima dengan Nilai Raport</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="accepted_with_school_report" id="editYes" value="1">
                            <label class="form-check-label" for="editYes">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="accepted_with_school_report" id="editNo" value="0">
                            <label class="form-check-label" for="editNo">Tidak</label>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-edit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
