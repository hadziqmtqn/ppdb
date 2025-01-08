<div class="modal fade" id="modalCreateMessageReceiver" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah Penerima Pesan</h3>
                </div>
                <form onsubmit="return false" id="formCreateMessageReceiver" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" id="select-educational-institution" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="message_template_id" id="select-message-template" class="form-select select2" data-allow-clear="true" data-education-id="1"></select>
                            <label for="select-message-template">Templat Pesan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="user_id" id="select-message-user" class="form-select select2" data-allow-clear="true" data-education-id="1"></select>
                            <label for="select-message-user">Penerima</label>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="btn-submit-message-receiver">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
