@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.settings.faq.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="d-flex mb-3 gap-3">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-information-variant-circle-outline mdi-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">
                        <span class="align-middle">{{ $title }}</span>
                    </h5>
                    <small>Kategori Pertanyaan yang sering diajukan</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">{{ $title }}</h5>
                <form action="{{ route('faq-category.store') }}" method="POST">
                    @csrf
                    <div class="card-datatable table-responsive">
                        <table class="table table-striped text-nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                @foreach($educationalInstitutions as $educationalInstitution)
                                    <th>{{ $educationalInstitution->name }}</th>
                                @endforeach
                                <th>Opsi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($faqCategories as $faqCategory)
                                <tr>
                                    <td class="text-nowrap">
                                        <input type="hidden" name="slugs[{{ $faqCategory['slug'] }}]" value="{{ $faqCategory['slug'] }}">
                                        <input type="text" name="name[{{ $faqCategory['slug'] }}]" id="faq_category_{{ $faqCategory['slug'] }}" class="form-control" aria-label="Faq Category" value="{{ $faqCategory['name'] }}">
                                    </td>
                                    @foreach($educationalInstitutions as $educationalInstitution)
                                        <td>
                                            <div class="form-check mb-0 d-flex justify-content-center">
                                                <input class="form-check-input" name="qualification[{{ $faqCategory['slug'] }}][]" type="checkbox" value="{{ $educationalInstitution->id }}" id="defaultCheck{{ $faqCategory['slug'] }}{{ $educationalInstitution->id }}" {{ in_array($educationalInstitution->id, $faqCategory['qualification']) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    @endforeach
                                    <td>
                                        @if($faqCategory['faqsCount'] == 0)
                                            <button type="button" class="btn btn-sm btn-danger btn-icon" onclick="deleteFaqCategory('{{ $faqCategory['slug'] }}')" data-bs-toggle="tooltip" title="Hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="{{ $educationalInstitutions->count() + 2 }}" class="fw-bold">Tambah Baru</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="new_faq_category_name" id="new_faq_category_name" class="form-control" aria-label="Faq Category" value="{{ old('new_faq_category_name') }}">
                                </td>
                                @foreach($educationalInstitutions as $educationalInstitution)
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" name="new_qualification[]" type="checkbox" value="{{ $educationalInstitution->id }}" id="new_qualification">
                                        </div>
                                    </td>
                                @endforeach
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('layouts.session')
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/faq/faq-category/delete.js') }}"></script>
@endsection