<!DOCTYPE html>
<html lang="en"
      class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed"
      dir="ltr"
      data-skin="default"
      data-bs-theme="light"
      data-assets-path="../../assets/"
      data-template="vertical-menu-template">

@include('_include._head')
@yield('head')
@stack('head')
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('_include._aside')
        <div class="layout-page">
            <!-- Navbar -->
            @include('_include._nav')
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- / Content wrapper -->
            @include('_include._footer')
        </div>
    </div>
    <!-- / Footer -->
@include('_include._script')
@yield('script')
@stack('scripts')
</body>
</html>
