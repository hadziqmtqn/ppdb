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
                            <select name="educational_institution_id" id="select-educational-institution" class="form-select select2"></select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="school_year_id" id="select-school-year" class="form-select select2">
                                <option value="{{ $getSchoolYearActive['id'] }}" selected>{{ $getSchoolYearActive['year'] }}</option>
                            </select>
                            <label for="select-school-year">Tahun Ajaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="type_of_payment" class="form-select select2" id="typeOfPayment">
                                <option value=""></option>
                                <option value="sekali_bayar">Sekali Bayar</option>
                                <option value="kredit">Kredit</option>
                            </select>
                            <label for="typeOfPayment">Jenis Pembayaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="registration_status" class="form-select select2" id="registrationStatus">
                                <option value=""></option>
                                <option value="siswa_belum_diterima">Siswa Belum Diterima</option>
                                <option value="siswa_diterima">Siswa Diterima</option>
                            </select>
                            <label for="registrationStatus">Status Registrasi</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="amount" class="form-control numeral-mask" id="amount" placeholder="Jumlah">
                            <label for="amount">Jumlah</label>
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
