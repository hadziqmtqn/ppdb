@extends('home.auth.master')
@section('content')
    <!-- /Left Section -->
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-5 pb-2">
        <img src="{{ asset('materialize/assets/img/illustrations/auth-login-illustration-light.png') }}" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="illustrations/auth-login-illustration-light.png" data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
        <img src="{{ asset('materialize/assets/img/illustrations/auth-cover-login-mask-light.png') }}" class="authentication-image" alt="mask" data-app-light-img="illustrations/auth-cover-login-mask-light.png" data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
    </div>
    <!-- /Left Section -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
        <div class="w-px-400 mx-auto pt-5 pt-lg-0">
            <h4 class="mb-2">Selamat datang di {{ $application['name'] }}! 👋</h4>
            <p class="mb-4">Silahkan masuk ke akun Anda</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="form-floating form-floating-outline mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Anda" autofocus />
                    <label for="email">Email</label>
                </div>
                <div class="mb-3">
                    <div class="form-password-toggle">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                <label for="password">Kata Sandi</label>
                            </div>
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me" />
                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                    <a href="#" class="float-end mb-1">
                        <span>Forgot Password?</span>
                    </a>
                </div>
                @include('layouts.session')
                <button type="submit" class="btn btn-primary d-grid w-100">Sign in</button>
            </form>

            <p class="text-center mt-2">
                <span>Belum punya akun?</span>
                <a href="{{ route('registration.index') }}">
                    <span>Buat akun baru</span>
                </a>
            </p>

            <div class="divider my-4">
                <div class="divider-text">or</div>
            </div>

            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('oauth.redirect-to-provider', 'google') }}" class="btn btn-icon btn-lg rounded-pill btn-text-google-plus">
                    <i class="tf-icons mdi mdi-24px mdi-google"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Login -->
@endsection

@section('scripts')
    <script src="{{ asset('js/auth/login-validation.js') }}"></script>
@endsection