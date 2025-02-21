@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $subTitle }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $subTitle }}</h5>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Lembaga</th>
                    <th>Tahun Ajaran</th>
                    <th>Nama</th>
                    <th>Jenis Pembayaran</th>
                    <th>Status Registrasi</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @can('registration-fee-write')
        @include('dashboard.payment.registration-fee.modal-edit')
        @include('dashboard.payment.registration-fee.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/payment/registration-fee/datatable.js') }}"></script>
    <script src="{{ asset('js/payment/registration-fee/create.js') }}"></script>
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/school-year/select.js') }}"></script>
@endsection