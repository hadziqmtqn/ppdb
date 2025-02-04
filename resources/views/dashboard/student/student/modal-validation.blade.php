<div class="modal fade" id="validationModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Validasi Pendaftaran</h3>
                </div>
                <form id="formValidation" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false" data-username="{{ $user->username }}">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="alert alert-outline-warning d-flex align-items-center" role="alert">
                            <i class="mdi mdi-alert-outline me-2"></i>
                            Sebelum mengubah status validasi pendaftaran, pastikan biodata siswa dan berkas pendukungnya telah diperiksa dengan teliti.
                        </div>
                        <div class="row select-valid-option">
                            @foreach(['belum_divalidasi', 'valid', 'tidak_valid'] as $statusValidation)
                                <div class="col-lg-4 col-md-12">
                                    <div class="list-group mb-2">
                                        <label class="list-group-item cursor-pointer">
                                            <span class="form-check mb-0"><input class="form-check-input me-1" type="radio" id="{{ $statusValidation }}" name="registration_validation" value="{{ $statusValidation }}" {{ optional($user->student)->registration_validation == $statusValidation ? 'checked' : '' }}>{{ ucfirst(str_replace('_', ' ', $statusValidation)) }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit-validation">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
