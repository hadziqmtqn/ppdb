@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.index') }}">Siswa</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('student.show', $user->username) }}">Detail Siswa</a> /</span>
        Keamanan Akun
    </h4>
    @include('dashboard.student.student.header')
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            @include('dashboard.student.student.sidebar')
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7">
            @include('dashboard.student.student.menu')

            <div class="card mb-4">
                <h5 class="card-header">Keamanan Akun</h5>
                <div class="card-body pt-1">
                    <form id="formChangePassword" onsubmit="return false" data-username="{{ $user->username }}">
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Baru" value="{{ $user->email }}">
                            <label for="email">Email Baru</label>
                        </div>
                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading mb-1">Memastikan bahwa persyaratan ini terpenuhi</h6>
                            <span>Minimum 8 karakter, huruf besar, huruf kecil & simbol</span>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="password" id="newPassword" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="newPassword">Kata Sandi Baru</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                                <small><i class="mdi mdi-information-outline text-danger me-1"></i>Kosongkan jika tidak akan mengubah kata sandi</small>
                            </div>
                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="password" name="password_confirmation" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <label for="confirmPassword">Konfirmasi Kata Sandi Baru</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                                <small><i class="mdi mdi-information-outline text-danger me-1"></i>Kosongkan jika tidak akan mengubah kata sandi</small>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary me-2" id="btn-submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/student/student-security/store.js') }}"></script>
@endsection