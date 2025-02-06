@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
        <div class="mb-2 mb-sm-0">
            <h4 class="mb-1">Nama: {{ optional($payment->user)->name }}</h4>
            <p class="mb-0">Lembaga: {{ optional(optional(optional($payment->user)->student)->educationalInstitution)->name }} / {{ optional(optional($payment->user)->student)->registration_number }}</p>
        </div>
        <a href="{{ route('student.show', optional($payment->user)->username) }}" class="btn btn-outline-primary waves-effect">Detail</a>
    </div>
    <div class="bs-stepper mt-2">
        <div class="bs-stepper-content rounded-0">
            <div class="content fv-plugins-bootstrap5 fv-plugins-framework active dstepper-block">
                <div class="row">
                    <div class="col-xl-8 mb-3 mb-xl-0">
                        <ul class="list-group">
                            @foreach($payment->paymentTransactions as $paymentTransaction)
                                <li class="list-group-item">
                                    <div class="d-flex gap-3">
                                        <div class="flex-grow-1">
                                            <div class="row">
                                                <div class="col-md-8 pt-2">
                                                    <a href="javascript:void(0)" class="text-heading mt-1">
                                                        <h6>Google - Google Home - White</h6>
                                                    </a>
                                                    <div class="mb-1 d-flex flex-wrap">
                                                        <span class="me-1">Sold by:</span>
                                                        <a href="javascript:void(0)" class="me-1">Google</a>
                                                        <span class="badge bg-label-success rounded-pill">In Stock</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-md-end">
                                                        <div class="my-2 my-lg-4">
                                                            <span class="text-primary">$299/</span><span class="text-body">$359</span>
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
                        <div class="border rounded p-3">
                            <!-- Price Details -->
                            <h6>Price Details</h6>
                            <dl class="row mb-0">
                                <dt class="col-6 fw-normal">Order Total</dt>
                                <dd class="col-6 text-end">$1198.00</dd>

                                <dt class="col-6 fw-normal">Delivery Charges</dt>
                                <dd class="col-6 text-end">
                                    <s class="text-muted">$5.00</s> <span class="badge bg-label-success rounded-pill">Free</span>
                                </dd>
                            </dl>
                            <hr class="mx-n3 mt-1">
                            <dl class="row mb-0">
                                <dt class="col-6 h6 mb-0">Total</dt>
                                <dd class="col-6 h6 text-end mb-0">$1198.00</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection