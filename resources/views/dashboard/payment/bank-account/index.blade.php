@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.payment.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="d-flex mb-3 gap-3">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded">
                        <i class="mdi mdi-credit-card-outline mdi-24px"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0">
                        <span class="align-middle">Rekening Bank</span>
                    </h5>
                    <small>Metode pembayaran pendaftaran siswa</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">Rekening Bank</h5>
                <div class="card-datatable">
                    <table class="table table-striped text-nowrap" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Lembaga</th>
                            <th>Saluran Pembayaran</th>
                            <th>No. Rekening</th>
                            <th>Pemilik</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('bank-account-write')
        @include('dashboard.payment.bank-account.modal-edit')
        @include('dashboard.payment.bank-account.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/payment/bank-account/datatable.js') }}"></script>
    <script src="{{ asset('js/payment/bank-account/create.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
@endsection