<meta name="description" content="{{ $application['description'] }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

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
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/animate-css/animate.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/@form-validation/form-validation.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/spinkit/spinkit.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/pickr/pickr-themes.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/animate-on-scroll/animate-on-scroll.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/quill/katex.css') }}" />
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/libs/quill/editor.css') }}" />
<!-- Page CSS -->
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/css/pages/page-profile.css') }}" />

{{--plugins--}}
<link href="{{ url('https://unpkg.com/filepond@^4/dist/filepond.css') }}" rel="stylesheet" />
<link href="{{ url('https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ url('https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css') }}">

{{--custom--}}
<link rel="stylesheet" href="{{ url('https://hadziqmtqn.github.io/css/dashboard.css') }}">

<!-- Helpers -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/helpers.js') }}"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/vendor/js/template-customizer.js') }}"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ url('https://hadziqmtqn.github.io/materialize/assets/js/config.js') }}"></script>
