<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah {{ $title }}</h3>
                </div>
                <form onsubmit="return false" id="formCreate" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="mb-3">
                            <div>Tambah Nama File Baru</div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="create_new" id="yes" value="YA">
                                <label class="form-check-label" for="yes">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="create_new" id="no" value="TIDAK" checked>
                                <label class="form-check-label" for="no">Tidak</label>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="media_file_id" id="select-media-file" class="form-select select2"></select>
                            <label for="select-media-file">Media File</label>
                        </div>
                        <div id="newMediaFile" style="display: none">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama File Baru">
                                <label for="name">Nama File Baru</label>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" id="select-educational-institution" class="form-select select2"></select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_path_id" id="select-registration-path" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-registration-path">Jalur Pendaftaran</label>
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
