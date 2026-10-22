<!DOCTYPE html>
<html lang="en"
      class="layout-navbar-fixed layout-menu-fixed layout-compact"
      dir="ltr"
      data-skin="default"
      data-bs-theme="light"
      data-assets-path="../../assets/"
      data-template="horizontal-menu-template-no-customizer">

@include('_include._head')
@yield('head')
@stack('head')
<body>
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
  <div class="layout-container">
      <!-- Navbar -->
      @include('_include._nav')
      <!-- / Navbar -->

      <!-- Content wrapper -->
    <div class="layout-page">
      <!-- Content wrapper -->
      <div class="content-wrapper">
        @yield('content')
      </div>

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
