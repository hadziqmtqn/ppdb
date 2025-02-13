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
                <div class="card-datatable">
                    <table class="table table-striped text-nowrap" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Lembaga</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('faq-write')
        @include('dashboard.settings.faq.faq.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/faq/faq/datatable.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
@endsection