<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} login</title>

    <meta name="description"
          content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description"
          content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon"
          sizes="192x192"
          type="image/png"
          href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon"
          sizes="180x180"
          href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Fonts and Styles -->
    @yield('css_before')
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
    <link rel="stylesheet" id="css-main" href="{{ mix('/css/oneui.css') }}">

    <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
<!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/amethyst.css') }}"> -->
@yield('css_after')


<!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
    <!-- END Stylesheets -->
</head>
<body>
<div id="page-container">
    <main id="main-container">

        <!-- Page Content -->
        <div class="bg-image"
             style="background-image: url({{ asset('media/photos/photo27@2x.jpg')}});">
            <div class="hero-static bg-white-95">
                <div class="content">
                    @yield('content');
                </div>
                <div class="content content-full font-size-sm text-muted text-center">
                    <strong>OneUI 4.0</strong> &copy; <span data-toggle="year-copy">2018</span>
                </div>
            </div>
        </div>
        <!-- END Page Content -->

    </main>
    <!-- END Main Container -->
</div>

<!-- OneUI Core JS -->
<script src="{{ mix('js/oneui.app.js') }}"></script>

<!-- Laravel Scaffolding JS -->
<script src="{{ mix('js/laravel.app.js') }}"></script>

<!--
OneUI JS

    Custom functionality including Blocks/Layout API as well as other vital and optional helpers
    webpack is putting everything together at assets/_es6/main/app.js
-->
<!-- Page JS Plugins -->
<script src="{{asset('js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
</body>
</html>
