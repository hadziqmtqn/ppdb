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

                            <h5>My Shopping Bag (2 Items)</h5>
                            <ul class="list-group mb-3">
                                <li class="list-group-item p-4">
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0">
                                            <img src="#" alt="google home" class="w-px-100">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h6 class="me-3">
                                                        <a href="javascript:void(0)" class="text-heading">Google - Google Home - White</a>
                                                    </h6>
                                                    <div class="mb-1 d-flex flex-wrap">
                                                        <span class="me-1">Sold by:</span>
                                                        <a href="javascript:void(0)" class="me-1">Google</a>
                                                        <span class="badge bg-label-success rounded-pill">In Stock</span>
                                                    </div>

                                                    <input type="number" class="form-control form-control-sm w-px-100 mt-4" value="1" min="1" max="5">
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-md-end">
                                                        <button type="button" class="btn-close btn-pinned" aria-label="Close"></button>
                                                        <div class="my-2 mt-md-4 mb-md-5">
                                                            <span class="text-primary">$299/</span><span class="text-body">$359</span>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary mt-3 waves-effect">
                                                            Move to wishlist
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item p-4">
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0">
                                            <img src="#" alt="google home" class="w-px-100">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h6 class="me-3">
                                                        <a href="javascript:void(0)" class="text-heading">Apple iPhone 11 (64GB, Black)</a>
                                                    </h6>
                                                    <div class="mb-1 d-flex flex-wrap">
                                                        <span class="me-1">Sold by:</span>
                                                        <a href="javascript:void(0)" class="me-1">Apple</a>
                                                        <span class="badge bg-label-success rounded-pill">In Stock</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm w-px-100 mt-4" value="1" min="1" max="5">
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-md-end">
                                                        <button type="button" class="btn-close btn-pinned" aria-label="Close"></button>
                                                        <div class="my-2 mt-md-4 mb-md-5">
                                                            <span class="text-primary">$899/</span><span class="text-body">$999</span>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary mt-3 waves-effect">
                                                            Move to wishlist
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
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
                                <button class="btn btn-primary btn-next waves-effect waves-light">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Tagihan Saat ini ({{ $currentBills->count() }} Item)</h5>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table text-nowrap" id="currentBillTable">
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
        <div class="col-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-4">Detail Siswa</h6>
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <div class="avatar me-2 pe-1">
                            <img src="{{ url('https://ui-avatars.com/api/?name='. $user->name .'&color=7F9CF5&background=EBF4FF') }}" alt="Avatar" class="rounded-circle">
                        </div>
                        <div class="d-flex flex-column">
                            <a href="{{ route('student.show', $user->username) }}">
                                <h6 class="mb-1">{{ $user->name }}</h6>
                            </a>
                            <small>No. Reg: {{ optional($user->student)->registration_number }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Data Registrasi</h6>
                    </div>
                    <p class="mb-1">Lembaga: {{ optional(optional($user->student)->educationalInstitution)->name }}</p>
                    <p class="mb-0">TA: {{ optional(optional($user->student)->schoolYear)->first_year . '/' . optional(optional($user->student)->schoolYear)->last_year }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection