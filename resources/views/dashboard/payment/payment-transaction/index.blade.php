@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        @if(!auth()->user()->hasRole('user'))
            <div class="card-body border-bottom border-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3 filter">
                            <select name="educational_institution_id" id="select-educational-institution" class="form-select select2" data-allow-clear="true"></select>
                            <label for="select-educational-institution">Lembaga Pendidikan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3 filter">
                            <select name="" id="select-status" class="form-select select2" data-allow-clear="true" multiple>
                                @foreach(['PENDING', 'PAID', 'EXPIRED', 'PROSES_VALIDASI', 'CANCEL'] as $status)
                                    <option value="{{ $status }}">{{ str_replace('_', ' ', $status) }}</option>
                                @endforeach
                            </select>
                            <label for="select-status">Status</label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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