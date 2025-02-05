@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Order details</h5>
                    <h6 class="m-0"><a href="#">Edit</a></h6>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="datatables-order-details table" id="datatable">
                        <thead class="table-light">
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="w-50">products</th>
                            <th class="w-25">price</th>
                            <th class="w-25">qty</th>
                            <th>total</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="d-flex justify-content-end align-items-center m-3 p-1">
                        <div class="order-calculations">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Subtotal:</span>
                                <h6 class="mb-0">$5000.25</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Discount:</span>
                                <h6 class="mb-0">$00.00</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Tax:</span>
                                <h6 class="mb-0">$100.00</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="w-px-100 mb-0">Total:</h6>
                                <h6 class="mb-0">$5100.25</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/payment/current-bill.js') }}"></script>
@endsection