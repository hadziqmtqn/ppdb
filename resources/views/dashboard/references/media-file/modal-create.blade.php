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
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama File">
                            <label for="name">Nama File</label>
                        </div>
                        <div class="mb-3">
                            <div>Kategori</div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category" id="all" value="semua_unit">
                                <label class="form-check-label" for="all">Semua Unit</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category" id="specific" value="unit_tertentu">
                                <label class="form-check-label" for="specific">Unit Tertentu</label>
                            </div>
                        </div>
                        <div id="educational-institutions-wrapper" style="display: none;">
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="educational_institutions" id="educational-institutions" class="form-select select2" multiple>
                                    <option value=""></option>
                                    @foreach($educationalInstitutions as $educationalInstitution)
                                        <option value="{{ $educationalInstitution->id }}">{{ $educationalInstitution->name }}</option>
                                    @endforeach
                                </select>
                                <label for="educational-institutions">Lembaga</label>
                            </div>
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
