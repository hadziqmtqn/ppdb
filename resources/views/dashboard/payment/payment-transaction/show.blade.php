@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
        <div class="mb-2 mb-sm-0">
            <a href="{{ route('student.show', optional($payment->user)->username) }}" class="h4 mb-1 text-primary" target="_blank">Nama: {{ optional($payment->user)->name }}</a>
            <p class="mb-0">Lembaga: {{ optional(optional(optional($payment->user)->student)->educationalInstitution)->name }} / {{ optional(optional($payment->user)->student)->registration_number }}</p>
        </div>
    </div>
    <div class="bs-stepper mt-2">
        <div class="bs-stepper-content rounded-0">
            <div class="content fv-plugins-bootstrap5 fv-plugins-framework active dstepper-block">
                <div class="row">
                    <div class="col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column mb-3">
                            <div class="mb-xl-0 pb-3">
                                <button type="button" class="btn btn-outline-{{ $payment->status == 'PENDING' ? 'warning' : ($payment->status == 'PAID' ? 'success' : 'danger') }}" style="cursor: default" id="paymentStatus">{{ $payment->status }}</button>
                            </div>
                            <div>
                                <h4 class="fw-medium" id="paymentSlug" data-slug="{{ $payment->slug }}">#{{ $payment->code }}</h4>
                                <div class="mb-1">
                                    <span>Tgl. dibuat:</span>
                                    <span>{{ \Carbon\Carbon::parse($payment->created_at)->isoFormat('DD MMM Y') }}</span>
                                </div>
                                <div>
                                    <span>Tgl. Jatuh Tempo:</span>
                                    <span>{{ Carbon\Carbon::parse($payment->expires_at)->isoFormat('DD MMM Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <ul class="list-group list-group-horizontal-md">
                                    <li class="list-group-item flex-fill">
                                        <h6 class="d-flex align-items-center gap-2">
                                            <i class="mdi mdi-credit-card-outline"></i> Tagihan Kepada
                                        </h6>
                                        <address class="text-body">
                                            {{ optional($payment->user)->name }} <br>
                                            {{ optional(optional(optional($payment->user)->student)->educationalInstitution)->name }},<br>
                                            <br>
                                            <span class="fw-medium">{{ optional(optional($payment->user)->student)->whatsapp_number }}</span>
                                        </address>
                                    </li>
                                    <li class="list-group-item flex-fill">
                                        <h6 class="d-flex align-items-center gap-2">
                                            <i class="mdi mdi-cash-marker"></i> Metode Pembayaran
                                        </h6>
                                        <span class="fw-medium text-body" id="paymenyMethod">{{ str_replace('_', ' ', $payment->payment_method) }}</span>
                                        <div class="text-body mb-0 mt-3">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td class="pe-3 fw-medium">Bank:</td>
                                                    <td id="paymentChannel">{{ $payment->payment_method == 'MANUAL_PAYMENT' ? optional(optional($payment->bankAccount)->paymentChannel)->code : $payment->payment_channel }}</td>
                                                </tr>
                                                @if($payment->payment_method == 'MANUAL_PAYMENT')
                                                    <tr>
                                                        <td class="pe-3 fw-medium">No. Rek:</td>
                                                        <td>{{ optional($payment->bankAccount)->account_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-3 fw-medium">A/N:</td>
                                                        <td>{{ optional($payment->bankAccount)->account_name }}</td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <ul class="list-group">
                            @foreach($payment->paymentTransactions as $paymentTransaction)
                                <li class="list-group-item">
                                    <div class="d-flex gap-3">
                                        <div class="flex-grow-1">
                                            <div class="row">
                                                <div class="col-md-8 pt-2">
                                                    <a href="javascript:void(0)" class="text-heading mt-1">
                                                        <h6>{{ optional($paymentTransaction->registrationFee)->name }}</h6>
                                                    </a>
                                                    <div class="mb-1 d-flex flex-wrap">
                                                        <span class="badge {{ optional($paymentTransaction->registrationFee)->type_of_payment == 'sekali_bayar' ? 'bg-label-success' : 'bg-label-warning' }} rounded-pill">{{ ucfirst(str_replace('_',' ', optional($paymentTransaction->registrationFee)->type_of_payment)) }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-md-end">
                                                        <div class="my-2 my-lg-4">
                                                            <span class="text-body">Rp. {{ number_format($paymentTransaction->paid_amount,0,',','.') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Confirmation total -->
                    <div class="col-xl-4">
                        <div class="border rounded p-3 mb-3">
                            <dl class="row mb-3">
                                <dt class="col-6 h6 mb-0">Total tagihan</dt>
                                <dd class="col-6 h6 text-end mb-0">Rp. {{ number_format($payment->amount,0,',','.') }}</dd>
                            </dl>
                            <hr class="mx-n3 mt-1">
                            <div id="countdownContainer">
                                <div class="bg-lighter rounded p-3">
                                    <h6>Harap lakukan pembayaran sebelum</h6>
                                    <div class="text-center fs-big text-danger">{{ Carbon\Carbon::parse($payment->expires_at)->isoFormat('llll') }}</div>
                                </div>
                            </div>
                        </div>
                        @if($payment->payment_method == 'MANUAL_PAYMENT')
                            <form action="#" id="formPaymentConfirm">
                                <button type="submit" class="btn btn-primary w-100" id="btn-bill-confirm">Konfirmasi Pembayaran</button>
                            </form>
                        @else
                            <a href="{{ url($payment->checkout_link) }}" class="btn btn-primary w-100" target="_blank" id="checkoutLink">Bayar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/payment/check-payment.js') }}"></script>
@endsection