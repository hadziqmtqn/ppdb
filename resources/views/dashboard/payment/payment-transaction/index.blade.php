@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Siswa</th>
                    <th>Lembaga</th>
                    <th>No. Tagihan</th>
                    <th>Total</th>
                    <th>Tgl. Transaksi</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/educational-institution/select.js') }}"></script>
    <script src="{{ asset('js/payment/payment-transaction/datatable.js') }}"></script>
@endsection