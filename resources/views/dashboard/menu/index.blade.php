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
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nama">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="type" id="type" class="form-select select2">
                                <option value=""></option>
                                <option value="main_menu" {{ old('type') == 'main_menu' ? 'selected' : '' }}>Menu Utama</option>
                                <option value="sub_menu" {{ old('type') == 'sub_menu' ? 'selected' : '' }}>Sub Utama</option>
                            </select>
                            <label for="type">Tipe</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="visibility" id="select-permission" class="form-select select2" multiple></select>
                            <label for="select-permission">Hak Akses</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/menu/datatable.js') }}"></script>
    <script src="{{ asset('js/permission/select-permissions.js') }}"></script>
@endsection