<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide"
      dir="ltr"
      data-theme="theme-default"
      data-assets-path="{{ url('https://hadziqmtqn.github.io/materialize/assets/') }}"
      data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }} | {{ $application['name'] }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $application['logo'] }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/fonts/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/toastr/toastr.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/@form-validation/form-validation.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/config.js') }}"></script>
</head>

<body>
<!-- Content -->

<div class="authentication-wrapper authentication-cover">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="auth-cover-brand d-flex align-items-center gap-2">
        <span class="app-brand-logo demo">
            <img src="{{ $application['logo'] }}" alt="logo" style="width: 40px">
        </span>
        <span class="app-brand-text demo text-heading fw-bold">{{ $application['name'] }}</span>
    </a>
    <!-- /Logo -->
    <div class="authentication-inner row m-0">
        @yield('content')
    </div>
    @include('layouts.flash')
</div>

<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/menu.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/@form-validation/popular.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/toastr/toastr.js') }}"></script>

<!-- Main JS -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/main.js') }}"></script>

<!-- Page JS -->
@yield('scripts')
<script src="{{ url('https://hadziqmtqn.github.io/materialize/js/toastr/flash.js') }}"></script>
<script src="{{ url('https://hadziqmtqn.github.io/materialize/js/toastr/global-flash.js') }}"></script>
</body>
</html>
