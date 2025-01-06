<div class="modal fade" id="modalRegister" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Registrasi Akun Baru</h3>
                </div>
                <form onsubmit="return false" id="formCreate" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <input type="hidden" name="educational_institution_id" id="select-educational-institution">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_category_id" class="form-select select2" id="select-registration-category"></select>
                            <label for="select-registration-category">Kategori Pendaftaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_path_id" class="form-select select2" id="select-registration-path"></select>
                            <label for="select-registration-path">Jalur Pendaftaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="class_level_id" class="form-select select2" id="select-class-level"></select>
                            <label for="select-class-level">Kelas</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            <label for="name">Nama</label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
