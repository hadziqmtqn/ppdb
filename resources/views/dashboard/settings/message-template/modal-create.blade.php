<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Tambah {{ $title }}</h3>
                </div>
                <form action="{{ route('message-template.store') }}" id="form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
                    @csrf
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Judul">
                            <label for="title">Judul</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" id="select-educational-institution" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="category" id="category" class="form-select select2">
                                <option value=""></option>
                                @foreach($messageCategories as $messageCategory)
                                    <option value="{{ $messageCategory }}" {{ old('category') == $messageCategory ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $messageCategory)) }}</option>
                                @endforeach
                            </select>
                            <label for="category">Kategori</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="recipient" id="recipient" class="form-select select2">
                                <option value=""></option>
                                @foreach($recipients as $recipient)
                                    <option value="{{ $recipient->name }}" {{ old('recipient') == $recipient->name ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $recipient->name)) }}</option>
                                @endforeach
                                <option value="all" {{ old('recipient') == 'all' ? 'selected' : '' }}>Semua</option>
                            </select>
                            <label for="recipient">Penerima</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <textarea name="message" id="message" style="height: 200px" class="form-control" placeholder="Pesan">{{ old('message') }}</textarea>
                            <label for="message">Pesan</label>
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
