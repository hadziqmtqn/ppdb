@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">{{ $title }}</h5>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table text-nowrap" id="datatable">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th class="w-50">Nama</th>
                            <th class="w-50">Jenis Tagihan</th>
                            <th>Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($currentBills as $currentBill)
                            <tr>
                                <td>
                                    <input type="checkbox" name="registration_fee_id[]" class="form-check-input" id="registrationFee-{{ $currentBill->id }}" value="{{ $currentBill->amount }}">
                                </td>
                                <td>{{ $currentBill->name }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $currentBill->type_of_payment)) }}</td>
                                <td>Rp. {{ number_format($currentBill->amount,0,',','.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end align-items-center m-3 p-1">
                        <div class="order-calculations">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Subtotal:</span>
                                <h6 class="mb-0">Rp. {{ number_format($currentBills->sum('amount'),0,',','.') }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="w-px-100 mb-0">Total:</h6>
                                <h6 class="mb-0">Rp. {{ number_format($currentBills->sum('amount'),0,',','.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection