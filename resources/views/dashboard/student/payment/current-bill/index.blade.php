@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
        <div class="mb-2 mb-sm-0">
            <h4 class="mb-1">Nama: {{ $user->name }}</h4>
            <p class="mb-0">Lembaga: {{ optional(optional($user->student)->educationalInstitution)->name }} / {{ optional($user->student)->registration_number }}</p>
        </div>
        <a href="{{ route('student.show', $user->username) }}" class="btn btn-outline-primary waves-effect">Detail</a>
    </div>
    <div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example mt-2">

        <div class="bs-stepper-content rounded-0">
            <form id="wizard-checkout-form" onsubmit="return false">
                <!-- Cart -->
                <div id="checkout-cart" class="content fv-plugins-bootstrap5 fv-plugins-framework active dstepper-block">
                    <div class="row">
                        <!-- Cart left -->
                        <div class="col-xl-8 mb-3 mb-xl-0">
                            <!-- Offer alert -->
                            <div class="alert alert-success mb-4" role="alert">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-check-circle-outline mdi-24px"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">Available Offers</div>
                                        <ul class="list-unstyled mb-0">
                                            <li>- 10% Instant Discount on Bank of America Corp Bank Debit and Credit cards</li>
                                            <li>- 25% Cashback Voucher of up to $60 on first ever PayPal transaction. TCA</li>
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <h5>Tagihan Anda saat ini ({{ $currentBills->count() }} Item)</h5>
                            <ul class="list-group mb-3">
                                @foreach($currentBills as $currentBill)
                                    <li class="list-group-item p-4">
                                        <div class="d-flex gap-3">
                                            <div class="flex-grow-1">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h6 class="me-3">
                                                            <span class="text-heading">{{ $currentBill->name }}</span>
                                                        </h6>
                                                        <div class="mb-1 d-flex flex-wrap">
                                                            <span class="badge {{ $currentBill->type_of_payment == 'sekali_bayar' ? 'bg-label-success' : 'bg-label-warning' }} rounded-pill">{{ ucfirst(str_replace('_',' ', $currentBill->type_of_payment)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-md-end">
                                                            <div class="my-2 mt-md-4 mb-md-2">
                                                                <span class="text-body">Rp. {{ number_format($currentBill->amount,0,',','.') }}</span>
                                                            </div>
                                                            <div class="d-block">
                                                                <input type="checkbox" name="registration_fee_id[]" value="{{ $currentBill->amount }}" class="btn-check" id="checkBill-{{ $currentBill->id }}">
                                                                <label class="btn btn-sm btn-outline-primary waves-effect waves-light" for="checkBill-{{ $currentBill->id }}">Pilih Tagihan</label>
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

                        <!-- Cart right -->
                        <div class="col-xl-4">
                            <div class="border rounded p-3 mb-3">
                                <!-- Offer -->
                                <h6>Offer</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-8 col-xxl-8 col-xl-12">
                                        <input type="text" class="form-control" placeholder="Enter Promo Code" aria-label="Enter Promo Code">
                                    </div>
                                    <div class="col-4 col-xxl-4 col-xl-12">
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-outline-primary waves-effect">Apply</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gift wrap -->
                                <div class="bg-lighter rounded p-3">
                                    <h6>Buying gift for a loved one?</h6>
                                    <p>Gift wrap and personalized message on card, Only for $2.</p>
                                    <a href="javascript:void(0)" class="fw-medium">Add a gift wrap</a>
                                </div>
                                <hr class="mx-n3">

                                <!-- Price Details -->
                                <h6 class="mb-4">Price Details</h6>
                                <dl class="row mb-0">
                                    <dt class="col-6 fw-normal text-heading">Bag Total</dt>
                                    <dd class="col-6 text-end">$1198.00</dd>

                                    <dt class="col-6 fw-normal text-heading">Coupon Discount</dt>
                                    <dd class="col-6 text-primary text-end fw-medium">Apply Coupon</dd>

                                    <dt class="col-6 fw-normal text-heading">Order Total</dt>
                                    <dd class="col-6 text-end">$1198.00</dd>

                                    <dt class="col-6 fw-normal text-heading">Delivery Charges</dt>
                                    <dd class="col-6 text-end">
                                        <s class="text-muted">$5.00</s>
                                        <span class="badge bg-label-success rounded-pill">Free</span>
                                    </dd>
                                </dl>
                                <hr class="mx-n3 my-3">
                                <dl class="row mb-0 h6">
                                    <dt class="col-6 mb-0">Total</dt>
                                    <dd class="col-6 text-end mb-0">$1198.00</dd>
                                </dl>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary btn-next waves-effect waves-light" id="pay-now">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

@endsection