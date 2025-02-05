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
                            <select name="payment_channel_id" id="paymentChannel" class="form-select select2">
                                <option value=""></option>
                                @foreach($paymentChannels as $paymentChannel)
                                    <option value="{{ $paymentChannel->id }}">{{ $paymentChannel->name }}</option>
                                @endforeach
                            </select>
                            <label for="paymentChannel">Saluran Pembayaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="account_number" id="accountNumber" class="form-control" placeholder="Nomor Rekening">
                            <label for="accountNumber">Nomor Rekening</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="account_name" id="accountName" class="form-control" placeholder="Nama Pemilik">
                            <label for="accountName">Nama Pemilik</label>
                        </div>
                        <div class="mb-2">Status</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="createActive" value="1">
                            <label class="form-check-label" for="createActive">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="createNotActive" value="0">
                            <label class="form-check-label" for="createNotActive">Tidak Aktif</label>
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
