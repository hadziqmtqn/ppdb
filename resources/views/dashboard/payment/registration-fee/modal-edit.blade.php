<div class="modal fade" id="modalEdit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Update {{ $title }}</h3>
                </div>
                <form id="formEdit" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" name="name" id="editName" placeholder="Nama">
                            <label for="editName">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="type_of_payment" class="form-select select2" id="editTypeOfPayment">
                                <option value="sekali_bayar">Sekali Bayar</option>
                                <option value="kredit">Kredit</option>
                            </select>
                            <label for="editTypeOfPayment">Jenis Pembayaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_status" class="form-select select2" id="editRegistrationStatus">
                                <option value="siswa_belum_diterima">Siswa Belum Diterima</option>
                                <option value="siswa_diterima">Siswa Diterima</option>
                            </select>
                            <label for="editRegistrationStatus">Status Registrasi</label>
                        </div>
                        <div class="input-group input-group-merge mb-3">
                            <span class="input-group-text">Rp</span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="amount" class="form-control numeral-mask" id="editAmount" placeholder="Jumlah">
                                <label for="editAmount">Jumlah</label>
                            </div>
                            <span class="input-group-text">.00</span>
                        </div>
                        <div class="mb-2">Status</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="active" value="1">
                            <label class="form-check-label" for="active">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="non_active" value="0">
                            <label class="form-check-label" for="non_active">Tidak Aktif</label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-edit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
