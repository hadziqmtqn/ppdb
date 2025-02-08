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
                                <button type="button" class="btn btn-outline-{{ $payment->status == 'PENDING' ? 'warning' : ($payment->status == 'PAID' ? 'success' : 'danger') }}" style="cursor: default" id="paymentStatus">{{ str_replace('_', ' ', $payment->status) }}</button>
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
                        <ul class="list-group mb-3">
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

                        @if($payment->payment_method == 'MANUAL_PAYMENT' && $payment->hasMedia('proof_of_payment'))
                            <div class="list-group">
                                <a href="{{ url($payment->getFirstTemporaryUrl(\Carbon\Carbon::now()->addMinutes(10), 'proof_of_payment')) }}" target="_blank" class="list-group-item d-flex justify-content-between">
                                    <span class="text-primary"><span class="mdi mdi-file-document-outline me-1"></span>Lihat bukti pembayaran</span>
                                    <i class="mdi mdi-chevron-right lh-sm scaleX-n1-rtl"></i>
                                </a>
                            </div>
                        @endif
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
                                    @if(($payment->status == 'PENDING'))
                                        <h6>Harap lakukan pembayaran sebelum</h6>
                                        <div class="text-center fs-big text-danger">{{ Carbon\Carbon::parse($payment->expires_at)->isoFormat('llll') }}</div>
                                    @else
                                        <h6 class="text-center mb-0">Terima kasih tagihan telah berhasil dibayar</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{--TODO manual payment--}}
                        @if($payment->payment_method == 'MANUAL_PAYMENT')
                            {{--TODO for user--}}
                            @if(auth()->user()->hasRole('user'))
                                <form action="{{ route('payment-transaction.confirm', $payment->slug) }}" id="formPaymentConfirm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="alert alert-warning" role="alert">
                                        <ul class="ps-3 mb-0">
                                            <li>File yang diizinkan berupa gambar (jpg/jpeg/png) atau pdf</li>
                                            <li>File berukuran maksimal 2MB</li>
                                        </ul>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="file" name="file" id="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        <label for="file">Upload bukti pembayaran</label>
                                    </div>
                                    @include('layouts.session')
                                    <button type="submit" class="btn btn-primary w-100" id="btn-bill-confirm" {{ $payment->status == 'PAID' ? 'disabled' : '' }}>Konfirmasi Pembayaran</button>
                                </form>
                            @else
                                {{--TODO untuk admin--}}
                                <form onsubmit="return false" id="paymentValidationForm" data-slug="{{ $payment->slug }}">
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="row select-valid-option">
                                        @foreach(['PAID','CANCEL'] as $paymentStatus)
                                            <div class="col-lg-6 col-md-12">
                                                <div class="list-group mb-2">
                                                    <label class="list-group-item cursor-pointer">
                                                        <span class="form-check mb-0"><input class="form-check-input me-1" type="radio" id="{{ $paymentStatus }}" name="status" value="{{ $paymentStatus }}" {{ $payment->status == $paymentStatus ? 'checked' : '' }}>{{ $paymentStatus }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="btn-submit-validation" class="btn btn-primary waves-light waves-effect w-100">Validasi Pembayaran</button>
                                </form>
                            @endif
                        @else
                            {{--TODO payment gateway--}}
                            @if($payment->status == 'PENDING')
                                <a href="{{ url($payment->checkout_link) }}" class="btn btn-primary w-100" target="_blank" id="checkoutLink">Bayar Sekarang</a>
                            @else
                                <button type="button" class="btn btn-primary w-100" disabled id="checkoutLink">Bayar Sekarang</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/payment/check-payment.js') }}"></script>
    <script src="{{ asset('js/student/payment/validation.js') }}"></script>
@endsection