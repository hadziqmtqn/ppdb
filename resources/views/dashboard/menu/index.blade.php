@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-datatable">
                    <table class="table table-striped text-nowrap" id="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Menu Utama</th>
                            <th>Hak Akses</th>
                            <th>Url</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <h5 class="card-header">Tambah {{ $title }}</h5>
                <form action="{{ route('menu.store') }}" id="form" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="number" class="form-control" name="serial_number" id="serial_number" placeholder="No. Urut" value="{{ old('serial_number') }}">
                            <label for="serial_number">No. Urut</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="{{ old('name') }}">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="type" id="type" class="form-select select2">
                                <option value=""></option>
                                <option value="main_menu" {{ old('type') == 'main_menu' ? 'selected' : '' }}>Main Menu</option>
                                <option value="sub_menu" {{ old('type') == 'sub_menu' ? 'selected' : '' }}>Sub Utama</option>
                            </select>
                            <label for="type">Tipe</label>
                        </div>
                        <div id="mainMenuVisibility" class="d-none">
                            <div class="form-floating form-floating-outline mb-3">
                                <select name="main_menu" id="select-main-menu" class="form-select select2"></select>
                                <label for="select-main-menu">Menu Utama</label>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="visibility[]" id="select-permission" class="form-select select2" multiple></select>
                            <label for="select-permission">Hak Akses</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="url" id="url" placeholder="Contoh: /dashboard" class="form-control" value="{{ old('url') }}">
                            <label for="url">Link/URL</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="icon" id="icon" placeholder="Ikon" class="form-control" value="{{ old('icon') }}">
                            <label for="icon">Ikon</label>
                            <small class="fst-italic">Ikon diambil dari situs <a href="{{ url('https://pictogrammers.com/library/mdi/') }}" target="_blank">Material Design Icon</a>. Anda hanya mengambil nama ikon seperti <strong>ab-testing</strong></small>
                        </div>
                        @include('layouts.session')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/menu/datatable.js') }}"></script>
    <script src="{{ asset('js/permission/select-permissions.js') }}"></script>
    <script src="{{ asset('js/menu/select-main-menu.js') }}"></script>
    <script src="{{ asset('js/menu/validation.js') }}"></script>
@endsection