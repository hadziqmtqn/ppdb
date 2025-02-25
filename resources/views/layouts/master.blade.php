<!doctype html>

<html
    lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ url('https://hadziqmtqn.github.io/materialize/assets/') }}"
    data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ !isset($subTitle) ? $title : $subTitle }} | {{ $application['name'] }}</title>

    <meta name="description" content="{{ $application['description'] }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $application['logo'] }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.head')
    @yield('styles')
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
        <!-- Navbar -->

        @include('layouts.navbar')

        <!-- / Navbar -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Menu -->
                @include('layouts.menu')
                <!-- / Menu -->

                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
                <!--/ Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div class="footer-container py-3 text-center">
                            <div class="mb-2 mb-md-0">
                                © {{ now()->year }}, made with <span class="text-danger"><i class="tf-icons mdi mdi-heart"></i></span> by
                                <a href="{{ $application['website'] }}" target="_blank" class="footer-link fw-medium">Tim Dev {{ $application['name'] }}</a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
        @include('layouts.flash')
    </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<!--/ Layout wrapper -->

<!-- Core JS -->
@include('layouts.script')
@yield('scripts')

<!-- Page JS -->
</body>
</html>
