@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>

    <div class="row mt-4">
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            @include('dashboard.application.sidebar')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Customer</h5>
                    <div class="card shadow-none mb-4 border-0">
                        <div class="table-responsive border rounded">
                            <table class="table">
                                <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap w-50">Type</th>
                                    <th class="text-nowrap text-center w-25">Email</th>
                                    <th class="text-nowrap text-center w-25">App</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-nowrap text-heading">New customer sign up</td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck_cust_1" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck_cust_2" checked="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap text-heading">Customer account password reset</td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck_cust_4" checked="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck_cust_5" checked="">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-transparent">
                                    <td class="text-nowrap text-heading">Customer account invite</td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck_cust_7">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check mb-0 d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck_cust_8">
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection