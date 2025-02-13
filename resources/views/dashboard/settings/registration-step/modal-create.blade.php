<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah {{ $title }}</h3>
                </div>
                <form action="{{ route('registration-step.store') }}" id="form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="number" name="serial_number" id="serial_number" class="form-control" value="{{ old('serial_number') }}" placeholder="No. Urut">
                            <label for="serial_number">No. Urut</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Judul">
                            <label for="title">Judul</label>
                        </div>
                        <label for="description">Deskripsi</label>
                        <div class="mb-3 quill-editor"></div>
                        <textarea name="description" id="description" class="d-none" placeholder="Deskripsi">{{ old('description') }}</textarea>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png">
                            <label for="image">Gambar</label>
                        </div>
                        @include('layouts.session')
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
