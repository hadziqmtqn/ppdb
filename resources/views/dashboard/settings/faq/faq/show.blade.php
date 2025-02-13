@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('faq.index') }}">FAQ</a> /</span>
        Detail {{ $title }}
    </h4>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.settings.faq.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="d-flex mb-3 gap-3">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-information-outline mdi-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">
                        <span class="align-middle">{{ $title }}</span>
                    </h5>
                    <small>Pertanyaan yang sering diajukan</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">{{ $title }}</h5>
                <form action="{{ route('faq.update', $faq->slug) }}" id="form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="faq_category_id" class="form-select select2" id="faq_category">
                                <option value=""></option>
                                @foreach($faqCategories as $faqCategory)
                                    <option value="{{ $faqCategory->id }}" {{ $faq->faq_category_id == $faqCategory->id ? 'selected' : '' }}>{{ $faqCategory->name }}</option>
                                @endforeach
                            </select>
                            <label for="faq_category">Kategori Pertanyaan</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="educational_institution_id" class="form-select select2" id="select-educational-institution" data-allow-clear="true">
                                <option value="{{ $faq->educational_institution_id }}" selected>{{ optional($faq->educationalInstitution)->name }}</option>
                            </select>
                            <label for="select-educational-institution">Lembaga</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Judul" value="{{ $faq->title }}">
                            <label for="title">Judul</label>
                        </div>
                        <div class="mb-3">
                            <label for="description">Deskripsi</label>
                            <div class="quill-editor">{{ old('description') }}</div>
                            <textarea name="description" id="description" class="d-none" placeholder="Deskripsi">{{ $faq->description }}</textarea>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/faq/faq/validation.js') }}"></script>
    <script src="{{ asset('materialize/js/quill-editor.js') }}"></script>
@endsection