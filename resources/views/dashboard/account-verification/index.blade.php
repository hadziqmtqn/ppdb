<!doctype html>

<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="/materialize/assets/"
    data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }} | {{ $application['name'] }}</title>

    <meta name="description" content="{{ $application['description'] }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $application['logo'] }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/fonts/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('materialize/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('materialize/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('materialize/assets/js/config.js') }}"></script>
</head>

<body>
<!-- Content -->

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card p-2">
                <div class="card-body mt-2">
                    <h4 class="mb-2">Verifikasi akun Anda 👨‍🎓</h4>
                    <p class="text-start mb-2">
                        Tautan aktivasi akun yang dikirimkan ke {{ $application['notificationMethod'] }} Anda: <span class="text-primary">{{ $application['notificationMethod'] == 'email' ? $myAccount['email'] : $myAccount['whatsapp'] }}</span> Silakan ikuti tautan di dalamnya untuk melanjutkan.
                    </p>
                    <hr>
                    <p class="text-center mb-0">
                        Tidak menerima tautan verifikasi Akun?
                        <a href="javascript:void(0);"> Kirim Ulang </a>
                    </p>
                </div>
            </div>
            <img alt="mask" src="{{ asset('materialize/assets/img/illustrations/auth-basic-login-mask-light.png') }}" class="authentication-image d-none d-lg-block" data-app-light-img="illustrations/auth-basic-login-mask-light.png" data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
        </div>
    </div>
</div>

<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('materialize/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('materialize/assets/vendor/js/menu.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ asset('materialize/assets/js/main.js') }}"></script>

<!-- Page JS -->
</body>
</html>
