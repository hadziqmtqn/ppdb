@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('conversation.index') }}">Kirim Pesan</a> /</span>
        Detail {{ $title }}
    </h4>

    <div class="card card- mb-4">
        <div class="card-header">
            <h5 class="card-title m-0">{{ $conversation->subject }}</h5>
        </div>
        <div class="card-body" style="padding-left: 2.5rem">
            <ul class="timeline mb-0">
                <li class="timeline-item ps-4 border-left-dashed">
                    <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                        <img src="{{ asset('materialize/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="timeline-event ps-1 pt-0">
                        <div class="card shadow-none bg-transparent border border-opacity-25 mb-3">
                            <h5 class="card-header border-bottom">Quote</h5>
                            <div class="card-body">
                                <p class="card-text">Some quick example text to build on the card title and make up.</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="timeline-item ps-4 border-transparent">
                    <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                        <img src="{{ asset('materialize/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="timeline-event ps-1">
                        <div class="timeline-header">
                            <small class="text-primary text-uppercase fw-medium">Receiver</small>
                        </div>
                        <h6 class="mb-2">Barry Schowalter</h6>
                        <p class="mb-0">939 Orange, California(CA), 92118</p>
                    </div>
                </li>
            </ul>
            {{--<ul class="timeline pb-0 mb-0">
                <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header">
                            <h6 class="mb-0">Order was placed (Order ID: #32543)</h6>
                            <span class="text-muted">Tuesday 11:29 AM</span>
                        </div>
                        <p class="mt-2">Your order has been placed successfully</p>
                    </div>
                </li>
                <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header">
                            <h6 class="mb-0">Pick-up</h6>
                            <span class="text-muted">Wednesday 11:29 AM</span>
                        </div>
                        <p class="mt-2">Pick-up scheduled with courier</p>
                    </div>
                </li>
                <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header">
                            <h6 class="mb-0">Dispatched</h6>
                            <span class="text-muted">Thursday 11:29 AM</span>
                        </div>
                        <p class="mt-2">Item has been picked up by courier</p>
                    </div>
                </li>
                <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header">
                            <h6 class="mb-0">Package arrived</h6>
                            <span class="text-muted">Saturday 15:20 AM</span>
                        </div>
                        <p class="mt-2">Package arrived at an Amazon facility, NY</p>
                    </div>
                </li>
                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header">
                            <h6 class="mb-0">Dispatched for delivery</h6>
                            <span class="text-muted">Today 14:12 PM</span>
                        </div>
                        <p class="mt-2">Package has left an Amazon facility, NY</p>
                    </div>
                </li>
                <li class="timeline-item timeline-item-transparent border-transparent pb-0">
                    <span class="timeline-point timeline-point-secondary"></span>
                    <div class="timeline-event pb-0">
                        <div class="timeline-header">
                            <h6 class="mb-0">Delivery</h6>
                        </div>
                        <p class="mt-2 mb-0">Package will be delivered by tomorrow</p>
                    </div>
                </li>
            </ul>--}}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('materialize/js/quill-message-editor.js') }}"></script>
@endsection