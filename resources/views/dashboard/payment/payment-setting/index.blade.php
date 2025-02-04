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
                        <span class="align-middle">Pengaturan Pembayaran</span>
                    </h5>
                    <small>Metode pembayaran pendaftaran siswa</small>
                </div>
            </div>

            <div class="card mb-3">
                <h5 class="card-header">{{ $title }}</h5>
                <form action="{{ route('payment-setting.update', $paymentSetting->slug) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="payment_method" id="payment_method" class="form-select select2">
                                <option value=""></option>
                                @foreach(['MANUAL_PAYMENT', 'PAYMENT_GATEWAY'] as $method)
                                    <option value="{{ $method }}" {{ $paymentSetting->payment_method == $method ? 'selected' : '' }}>{{ str_replace('_', ' ', $method) }}</option>
                                @endforeach
                            </select>
                            <label for="payment_method">Metode Pembayaran</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-light waves-effect">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection