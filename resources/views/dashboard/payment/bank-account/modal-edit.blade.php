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
                        <input type="hidden" name="educational_institution_id" id="editEducationalInstitution">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="payment_channel_id" id="editPaymentChannel" class="form-select select2">
                                <option value=""></option>
                                @foreach($paymentChannels as $paymentChannel)
                                    <option value="{{ $paymentChannel->id }}">{{ $paymentChannel->name }}</option>
                                @endforeach
                            </select>
                            <label for="editPaymentChannel">Saluran Pembayaran</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="account_number" id="editAccountNumber" class="form-control" placeholder="Nomor Rekening">
                            <label for="editAccountNumber">Nomor Rekening</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="account_name" id="editAccountName" class="form-control" placeholder="Nama Pemilik">
                            <label for="editAccountName">Nama Pemilik</label>
                        </div>
                        <div class="mb-2">Status</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="active" value="1">
                            <label class="form-check-label" for="active">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="not_active" value="0">
                            <label class="form-check-label" for="not_active">Tidak Aktif</label>
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
