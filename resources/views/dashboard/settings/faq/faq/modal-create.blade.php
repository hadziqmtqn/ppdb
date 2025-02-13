<div class="modal fade" id="modalCreate" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1">Create {{ $title }}</h3>
                </div>
                <form action="{{ route('faq.store') }}" id="form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
                    @csrf
                    <div class="col-12 fv-plugins-icon-container">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="faq_category_id" class="form-select select2" id="faq_category">
                                <option value=""></option>
                                @foreach($faqCategories as $faqCategory)
                                    <option value="{{ $faqCategory->id }}" {{ old('faq_category_id') == $faqCategory->id ? 'selected' : '' }}>{{ $faqCategory->name }}</option>
                                @endforeach
                            </select>
                            <label for="faq_category">Kategori Pertanyaan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" class="form-select select2" id="select-educational-institution" data-allow-clear="true"></select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Judul" value="{{ old('title') }}">
                            <label for="title">Judul</label>
                        </div>
                        <div class="mb-3">
                            <label for="description">Deskripsi</label>
                            <div class="quill-editor">{{ old('description') }}</div>
                            <textarea name="description" id="description" class="d-none" placeholder="Deskripsi">{{ old('description') }}</textarea>
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
