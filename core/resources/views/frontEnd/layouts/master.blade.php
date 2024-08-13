<!DOCTYPE html>
<html lang="{{ @Helper::currentLanguage()->code }}" dir="{{ @Helper::currentLanguage()->direction }}">

<head>
    <!-- ======= Meta & CSS ======= -->
    @stack('before-styles')
    @include('frontEnd.layouts.head')
    @include('frontEnd.layouts.colors')
    @yield('headInclude')
    @stack('after-styles')
</head>

<body class="dir-{{ @Helper::currentLanguage()->direction }} lang-{{ @Helper::currentLanguage()->code }}">
<!-- ======= Top Bar ======= -->
@include('frontEnd.layouts.topbar')

<!-- ======= Header ======= -->
@include('frontEnd.layouts.header')

<!-- ======= Main contents ======= -->
<main id="main" class="{{ (Helper::GeneralSiteSettings("style_header"))?"fixed-top-margin":"" }}">
@yield('content')
</main>
<!-- ======= Footer ======= -->
@include('frontEnd.layouts.footer')
@if(Helper::GeneralSiteSettings("style_preload"))
<div id="preloader"></div>
@endif
<!-- ======= JS Including ======= -->
@stack('before-scripts')
@include('frontEnd.layouts.foot')
@yield('footInclude')
@stack('after-scripts')
</body>
</html>
