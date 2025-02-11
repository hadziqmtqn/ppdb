<!doctype html>

<html lang="en" class="light-style layout-wide" dir="ltr" data-theme="theme-default" data-assets-path="/materialize/assets/" data-template="front-pages">
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
                    <a href="#" class="app-brand-link mb-4">
                    <span class="app-brand-logo demo me-2">
                        <img src="{{ $application['logo'] }}" alt="logo" style="width: 40px">
                    </span>
                        <span class="app-brand-text demo footer-link fw-bold">{{ $application['name'] }}</span>
                    </a>
                    <p class="footer-text footer-logo-description mb-4">
                        Most Powerful & Comprehensive 🤩 React NextJS Admin Template with Elegant Material Design & Unique
                        Layouts.
                    </p>
                    <form>
                        <div class="d-flex mt-2 gap-3">
                            <div class="form-floating form-floating-outline w-px-250">
                                <input type="text" class="form-control bg-transparent text-white" id="newsletter-1" placeholder="Your email" />
                                <label for="newsletter-1">Subscribe to newsletter</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-4">Demos</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <a href="../vertical-menu-template/" target="_blank" class="footer-link">Vertical Layout</a>
                        </li>
                        <li class="mb-3">
                            <a href="../horizontal-menu-template/" target="_blank" class="footer-link">Horizontal Layout</a>
                        </li>
                        <li class="mb-3">
                            <a href="../vertical-menu-template-bordered/" target="_blank" class="footer-link">Bordered Layout</a>
                        </li>
                        <li class="mb-3">
                            <a href="../vertical-menu-template-semi-dark/" target="_blank" class="footer-link">Semi Dark Layout</a>
                        </li>
                        <li>
                            <a href="../vertical-menu-template-dark/" target="_blank" class="footer-link">Dark Layout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-4">Pages</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><a href="#" class="footer-link">Pricing</a></li>
                        <li class="mb-3"><a href="#" class="footer-link">Payment<span class="badge rounded-pill bg-primary ms-2">New</span></a></li>
                        <li class="mb-3"><a href="#" class="footer-link">Checkout</a></li>
                        <li class="mb-3"><a href="#" class="footer-link">Help Center</a></li>
                        <li><a href="#" target="_blank" class="footer-link">Login/Register</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h6 class="footer-title mb-4">Download our app</h6>
                    <a href="javascript:void(0);" class="d-block footer-link mb-3 pb-2"><img src="{{ asset('materialize/assets/img/front-pages/landing-page/apple-icon.png') }}" alt="apple icon"/></a>
                    <a href="javascript:void(0);" class="d-block footer-link"><img src="{{ asset('materialize/assets/img/front-pages/landing-page/google-play-icon.png') }}" alt="google play icon"/></a>
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
@yield('scripts')
</body>
</html>
