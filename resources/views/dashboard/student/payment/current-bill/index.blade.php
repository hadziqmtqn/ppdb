@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
        <div class="mb-2 mb-sm-0">
            <a href="{{ route('student.show', $user->username) }}" class="h4 mb-1 text-primary" target="_blank">Nama: {{ $user->name }}</a>
            <p class="mb-0">Lembaga: {{ optional(optional($user->student)->educationalInstitution)->name }} / {{ optional($user->student)->registration_number }}</p>
        </div>
    </div>
    <div class="bs-stepper mt-2">
        <div class="bs-stepper-content rounded-0">
            <form id="registration-fee-form" onsubmit="return false">
                <div class="content fv-plugins-bootstrap5 fv-plugins-framework active dstepper-block">
                    <div class="row">
                        <!-- Cart left -->
                        <div class="col-xl-8 mb-3 mb-xl-0">
                            <div class="alert alert-success mb-4" role="alert">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-check-circle-outline mdi-24px"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">Keterangan</div>
                                        <ul class="list-unstyled mb-0">
                                            <li>- Jenis tagihan <strong>sekali bayar</strong> dibayar secara kontan</li>
                                            <li>- Jenis tagihan <strong>kredit</strong> pembayaran dapat dicicil</li>
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <h5>Tagihan Anda saat ini ({{ $numberOfBill }} Item)</h5>
                            <ul class="list-group mb-3">
                                @foreach($registrationFees as $registrationFee)
                                    <li class="list-group-item p-4">
                                        <div class="d-flex gap-3">
                                            <div class="flex-grow-1">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h6 class="me-3">
                                                            <span class="text-heading">{{ $registrationFee->name }}</span>
                                                        </h6>
                                                        <div class="mb-1 d-flex flex-wrap">
                                                            <span class="badge {{ $registrationFee->type_of_payment == 'sekali_bayar' ? 'bg-label-success' : 'bg-label-warning' }} rounded-pill">{{ ucfirst(str_replace('_',' ', $registrationFee->type_of_payment)) }}</span>
                                                        </div>
                                                        @if($registrationFee->type_of_payment == 'kredit')
                                                            <input type="number" class="form-control form-control-sm w-px-150 mt-4 input-amount-of-bill" name="paid_amount[{{ $registrationFee->id }}]" id="paidAmount-{{ $registrationFee->id }}" value="{{ $registrationFee->amount }}" min="{{ $registrationFee->amount / 2 }}" max="{{ $registrationFee->amount }}" style="display: none;">
                                                        @else
                                                            <input type="hidden" name="paid_amount[{{ $registrationFee->id }}]" id="paidAmount-{{ $registrationFee->id }}" value="{{ $registrationFee->amount }}">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-md-end">
                                                            <div class="my-2 mt-md-4 mb-md-5">
                                                                <span class="text-body">Rp. {{ number_format($registrationFee->amount,0,',','.') }}</span>
                                                            </div>
                                                            <div class="d-block">
                                                                <input type="checkbox" name="registration_fee_id[{{ $registrationFee->id }}]" value="{{ $registrationFee->id }}" data-amount="{{ $registrationFee->amount }}" class="btn-check" id="checkBill-{{ $registrationFee->id }}">
                                                                <label class="btn btn-sm btn-outline-primary waves-effect waves-light" for="checkBill-{{ $registrationFee->id }}">Pilih Tagihan</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div id="error-message"></div>
                        </div>

                        <!-- Cart right -->
                        <div class="col-xl-4">
                            <div class="border rounded p-3 mb-3">
                                <h6>Metode Pembayaran</h6>
                                <input type="hidden" name="pay_method" value="{{ $paymentSetting->payment_method }}" id="paymentMethod">
                                @if($paymentSetting->payment_method == 'MANUAL_PAYMENT')
                                    <div class="form-floating form-floating-outline mb-3">
                                        <select name="bank_account_id" id="select-bank-account" class="form-select select2" data-educational-institution="{{ optional($user->student)->educational_institution_id }}"></select>
                                        <label for="select-bank-account">Rekening Bank</label>
                                    </div>

                                    <div class="bg-lighter rounded p-3">
                                        <h6>Rincian Bank Tujuan</h6>
                                        <div class="mb-3">
                                            <h6 class="mb-1 text-primary">Bank tujuan</h6>
                                            <div id="destinationBank">-</div>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="mb-1 text-primary">No. Rekening</h6>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="me-2 fw-medium" id="accountNumber">-</span>
                                                <span class="clipboard-btn text-light cursor-pointer" data-clipboard-action="copy" data-clipboard-target="#accountNumber"><i class="mdi mdi-content-copy" data-bs-toggle="tooltip" title="Salin"></i></span>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-primary">Atas nama</h6>
                                            <div id="accountName">-</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-secondary">{{ str_replace('_', ' ', $paymentSetting->payment_method) }}</span>
                                @endif

                                <hr class="mx-n3">
                                <h6 class="mb-4">Rincian</h6>
                                <dl class="row mb-0">
                                    <dt class="col-6 fw-normal text-heading">Total Tagihan</dt>
                                    <dd class="col-6 text-end" id="totalBilling">Rp. {{ number_format($totalBilling, 0,',','.') }}</dd>

                                    <dt class="col-6 fw-normal text-heading">DP</dt>
                                    <dd class="col-6 text-end" id="dp">Rp. 0</dd>

                                    <dt class="col-6 fw-normal text-heading">Sisa Tagihan</dt>
                                    <dd class="col-6 text-end" id="restBill">Rp. 0</dd>
                                </dl>
                                <hr class="mx-n3 my-3">
                                <dl class="row mb-0 h6">
                                    <dt class="col-6 mb-0">Total akan dibayar</dt>
                                    <dd class="col-6 text-end mb-0" id="totalWillBePaid">Rp. 0</dd>
                                </dl>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary waves-effect waves-light" id="pay-now" data-username="{{ $user->username }}">Buat Tagihan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/payment/current-bill.js') }}"></script>
    <script src="{{ asset('js/payment/bank-account/select.js') }}"></script>
    <script src="{{ asset('materialize/assets/js/extended-ui-misc-clipboardjs.js') }}"></script>
    <script src="{{ asset('js/student/payment/payment.js') }}"></script>
@endsection