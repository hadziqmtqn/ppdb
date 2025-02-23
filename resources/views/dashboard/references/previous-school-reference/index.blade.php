@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <div class="card-datatable">
            <table class="table table-striped text-nowrap" id="datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Kelompok Pendidikan</th>
                    <th>NPSN</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Provinsi</th>
                    <th>Kota/Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Desa/Kelurahan</th>
                    <th>Jalan</th>
                    <th>Opsi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @can('previous-school-reference-write')
        @include('dashboard.references.previous-school-reference.modal-create')
    @endcan
@endsection

@section('scripts')
    <script src="{{ asset('js/previous-school-reference/datatable.js') }}"></script>
    <script src="{{ asset('js/previous-school-reference/create.js') }}"></script>

    <script src="{{ asset('js/educational-group/single-select.js') }}"></script>
    <script src="{{ asset('js/idn-location/address.js') }}"></script>
@endsection