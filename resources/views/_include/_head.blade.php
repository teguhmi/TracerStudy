<head>
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>{{config('app.name')}} | {{config('app.title')}}</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
            rel="stylesheet" />

    @vite(['resources/assets/vendor/fonts/iconify/iconify.css'])

    <!-- BEGIN: Vendor CSS-->
    @vite(['resources/assets/vendor/libs/node-waves/node-waves.scss'])

    @vite(['resources/assets/vendor/libs/pickr/pickr-themes.scss'])

    <!-- Core CSS -->
    @vite(['resources/assets/vendor/scss/core.scss',
          'resources/assets/css/demo.css',
          'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss'])

    <!-- Vendor Styles -->
    @vite(['resources/assets/vendor/libs/typeahead-js/typeahead.scss',
          'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
          'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])

    {{--  @vite("resources/assets/vendor/libs/@algolia/autocomplete-js.js")--}}

    <!-- Page Styles -->

    <!-- app CSS -->
    @vite("resources/css/app.css")
    @vite("resources/assets/vendor/js/helpers.js")
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    @vite("resources/assets/vendor/js/template-customizer.js")
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    @vite("resources/assets/js/config.js")
</head>
