<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-0 pb-1">Tambah Mata Pelajaran</h3>
                </div>
                <form onsubmit="return false" id="formCreate" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="code" id="code" class="form-control" placeholder="Kode">
                            <label for="code">Kode</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="type" class="form-select select2" id="type">
                                <option value=""></option>
                                <option value="umum">Umum</option>
                                <option value="keagamaan">Keagamaan</option>
                            </select>
                            <label for="type">Tipe</label>
                        </div>
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
