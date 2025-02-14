<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-wide" dir="ltr" data-theme="theme-default" data-assets-path="/materialize/assets/" data-template="front-pages">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }} | {{ $application['name'] }}</title>

    <meta name="description" content="{{ $application['description'] }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $application['logo'] }}" />

    @include('home.layouts.head')
    @yield('styles')
</head>

<body>
<script src="{{ asset('materialize/assets/vendor/js/dropdown-hover.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/js/mega-dropdown.js') }}"></script>

<!-- Navbar: Start -->
@include('home.layouts.navbar')
<!-- Navbar: End -->

<!-- Sections:Start -->

@yield('content')

<!-- /Modal -->

<!-- / Sections:End -->

<!-- Footer: Start -->
<footer class="landing-footer">
    <div class="footer-top position-relative overflow-hidden">
        <img src="{{ asset('materialize/assets/img/front-pages/backgrounds/footer-bg.png') }}" alt="footer bg" class="footer-bg banner-bg-img" />
        <div class="container position-relative">
            <div class="row gx-0 gy-4 g-md-5">
                <div class="col-lg-5">
                    <a href="{{ route('home') }}" class="app-brand-link mb-4">
                        <span class="app-brand-logo demo me-2">
                            <img src="{{ $application['logo'] }}" alt="logo" style="width: 40px">
                        </span>
                        <span class="app-brand-text demo footer-link fw-bold">{{ $application['name'] }}</span>
                    </a>
                    <p class="footer-text footer-logo-description mb-4">{{ $application['description'] }}</p>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-4">Menu</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <a href="{{ route('home') }}" class="footer-link">Home</a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ url('/#quotas') }}" class="footer-link" onclick="navigateToSection(event, '#quotas')">Kuota Pendaftaran</a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ url('/#registrationSchedule') }}" class="footer-link" onclick="navigateToSection(event, '#registrationSchedule')">Jadwal Pendaftaran</a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ url('/#registrationStep') }}" class="footer-link" onclick="navigateToSection(event, '#registrationStep')">Cara Daftar</a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ url('/#faqContainer') }}" class="footer-link" onclick="navigateToSection(event, '#faqContainer')">FAQ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-3">
        <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
            <div class="mb-2 mb-md-0">
                <span class="footer-text">© {{ date('Y') }}, Made with <i class="tf-icons mdi mdi-heart text-danger"></i> by</span>
                <a href="{{ $application['website'] }}" target="_blank" class="footer-link fw-medium footer-theme-link">{{ $application['name'] }}</a>
            </div>
            <div>
                <a href="https://github.com/pixinvent" class="footer-link me-2" target="_blank"><i class="mdi mdi-github"></i></a>
                <a href="https://www.facebook.com/pixinvents/" class="footer-link me-2" target="_blank"><i class="mdi mdi-facebook"></i></a>
                <a href="https://twitter.com/pixinvents" class="footer-link me-2" target="_blank"><i class="mdi mdi-twitter"></i></a>
                <a href="https://www.instagram.com/pixinvents/" class="footer-link" target="_blank"><i class="mdi mdi-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>
<!-- Footer: End -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

@include('layouts.script')
<script src="{{ asset('js/home/navigation.js') }}"></script>
@yield('scripts')
</body>
</html>
