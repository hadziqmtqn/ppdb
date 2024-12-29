@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span> {{ $title }}</h4>
    <div class="card mb-3">
        <h5 class="card-header">{{ $title }}</h5>
        <form action="{{ route('application.store') }}" method="post" id="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama" value="{{ $application['name'] }}">
                            <label for="name">Nama</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" name="description" id="description" class="form-control" placeholder="Deskripsi" value="{{ $application['description'] }}">
                            <label for="description">Deskripsi</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="url" name="website" id="website" class="form-control" placeholder="Website" value="{{ $application['website'] }}">
                            <label for="website">Website</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="url" name="main_website" id="main_website" class="form-control" placeholder="Website Utama" value="{{ $application['mainWebsite'] }}">
                            <label for="main_website">Website Utama</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <select name="register_verification" id="registrer_verification" class="form-select select2">
                                <option value="0" {{ $application['registerVerification'] == 0 ? 'selected' : '' }}>Tidak</option>
                                <option value="1" {{ $application['registerVerification'] == 1 ? 'selected' : '' }}>Ya</option>
                            </select>
                            <label for="registrer_verification">Verifikasi Akun</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="file" name="logo" id="logo" class="form-control" accept=".jpg,jpeg,png">
                            <label for="logo">Logo</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/application/validation.js') }}"></script>
@endsection