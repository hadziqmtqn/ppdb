<div class="modal fade" id="modalCreateRegistrationSchedule" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah Jadwal Pendaftaran</h3>
                </div>
                <form onsubmit="return false" id="registrationScheduleForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select select2" name="educational_institution_id" id="select-educational-institution"></select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select select2" name="school_year_id" id="select-school-year"></select>
                            <label for="select-school-year">Tahun Ajaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="start_date" id="start_date" class="form-control bs-datepicker" placeholder="Tanggal Mulai" readonly>
                            <label for="start_date">Tanggal Mulai</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="end_date" class="form-control bs-datepicker" id="end_date" placeholder="Tanggal Berakhir" readonly>
                            <label for="end_date">Tanggal Berakhir</label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit-registration-schedule">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
