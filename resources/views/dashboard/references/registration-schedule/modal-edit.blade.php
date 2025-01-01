<div class="modal fade" id="modalEditRegistrationSchedule" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Edit Jadwal Pendaftaran</h3>
                </div>
                <form onsubmit="return false" id="registrationScheduleFormEdit" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <dl class="row mb-2">
                            <dt class="col-4">Lembaga</dt>
                            <dd class="col-8" id="educationalInstitution"></dd>
                            <dt class="col-4">Tahun Ajaran</dt>
                            <dd class="col-8" id="schoolYear"></dd>
                        </dl>
                        <hr>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="date" name="start_date" id="editStartDate" class="form-control" placeholder="Tanggal Mulai">
                            <label for="editStartDate">Tanggal Mulai</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="date" name="end_date" class="form-control" id="editEndDate" placeholder="Tanggal Berakhir">
                            <label for="editEndDate">Tanggal Berakhir</label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-edit-registration-schedule">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
