@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('menu.index') }}">Menu</a> /</span>
        {{ $title }}
    </h4>
    <div class="card mb-3">
        <h5 class="card-header">Tambah {{ $title }}</h5>
        <form action="{{ route('menu.update', $menu->slug) }}" id="form" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="{{ $menu->name }}">
                    <label for="name">Nama</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="type" id="type" class="form-select select2">
                        <option value=""></option>
                        <option value="main_menu" {{ $menu->type == 'main_menu' ? 'selected' : '' }}>Main Menu</option>
                        <option value="sub_menu" {{ $menu->type == 'sub_menu' ? 'selected' : '' }}>Sub Utama</option>
                    </select>
                    <label for="type">Tipe</label>
                </div>
                <div id="mainMenuVisibility" class="d-none">
                    <div class="form-floating form-floating-outline mb-3">
                        <select name="main_menu" id="select-main-menu" class="form-select select2">
                            <option value="{{ $menu->main_menu }}" selected>{{ $menu->main_menu }}</option>
                        </select>
                        <label for="select-main-menu">Menu Utama</label>
                    </div>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <select name="visibility[]" id="select-permission" class="form-select select2" multiple>
                        <option value=""></option>
                        @foreach ($allPermissions as $permission)
                            <option value="{{ $permission }}" {{ in_array($permission, json_decode($menu->visibility ?? '[]')) ? 'selected' : '' }}>
                                {{ $permission }}
                            </option>
                        @endforeach
                    </select>
                    <label for="select-permission">Hak Akses</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="url" id="url" placeholder="Contoh: /dashboard" class="form-control" value="{{ $menu->url }}">
                    <label for="url">Link/URL</label>
                </div>
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" name="icon" id="icon" placeholder="Ikon" class="form-control" value="{{ $menu->icon }}">
                    <label for="icon">Ikon</label>
                </div>
                @include('layouts.session')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/menu/validation.js') }}"></script>
    <script src="{{ asset('js/permission/select-permissions.js') }}"></script>
    <script src="{{ asset('js/menu/select-main-menu.js') }}"></script>
@endsection