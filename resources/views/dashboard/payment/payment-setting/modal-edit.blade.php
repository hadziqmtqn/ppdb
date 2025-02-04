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
                        <div class="mb-2">Metode Pembayaran</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_method" id="manual" value="MANUAL_PAYMENT">
                            <label class="form-check-label" for="manual">Manual Payment</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_method" id="gateway" value="PAYMENT_GATEWAY">
                            <label class="form-check-label" for="gateway">Payment Gateway</label>
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
