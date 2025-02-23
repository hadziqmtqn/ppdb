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
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_group_id" id="select-educational-group" class="form-select select2"></select>
                            <label for="select-educational-group">Kelompok Pendidikan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="number" name="npsn" id="npsn" class="form-control" placeholder="NPSN">
                            <label for="npsn">NPSN</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="province" id="select-province" class="form-select select2"></select>
                            <label for="select-province">Provinsi</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="city" id="select-city" class="form-select select2"></select>
                            <label for="select-city">Kota/Kabupaten</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="district" id="select-district" class="form-select select2"></select>
                            <label for="select-district">Kecamatan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="village" id="select-village" class="form-select select2"></select>
                            <label for="select-village">Desa/Kelurahan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="street" id="street" class="form-control" placeholder="Jalan">
                            <label for="street">Jalan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="status" id="status" class="form-select select2">
                                <option value=""></option>
                                <option value="Swasta">Swasta</option>
                                <option value="Negeri">Negeri</option>
                            </select>
                            <label for="status">Status Sekolah</label>
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
