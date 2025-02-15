<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah {{ $title }}</h3>
                </div>
                <form onsubmit="return false" id="formCreate" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="col-12 fv-plugins-icon-container">
                        @if(auth()->user()->hasRole('user'))
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="send_to" value="admin">
                        @else
                            <input type="hidden" name="send_to" value="user">
                            <div class="form-floating form-floating mb-3">
                                <select name="educational_institution_id" id="select-educational-institution" class="form-select select2"></select>
                                <label for="select-educational-institution">Lembaga</label>
                            </div>
                            <div class="form-floating form-floating mb-3">
                                <select name="user_id" id="select-student" class="form-select select2"></select>
                                <label for="select-student">Siswa</label>
                            </div>
                        @endif
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subjek">
                            <label for="subject">Subjek</label>
                        </div>
                        <div class="mb-3">
                            <label for="description">Pesan</label>
                            <div class="quill-editor"></div>
                            <textarea name="message" id="description" class="d-none" placeholder="Pesan"></textarea>
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
