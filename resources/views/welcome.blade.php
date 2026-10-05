<!DOCTYPE html>
<html lang="en"
      class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed"
      dir="ltr"
      data-skin="default"
      data-bs-theme="light"
      data-assets-path="../../assets/"
      data-template="vertical-menu-template">
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>
    <title>Demo: Collapsed menu - Layouts | Materialize - Bootstrap Dashboard PRO</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet"/>

    @vite(('resources/assets/vendor/fonts/iconify-icons.css'))

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css"/>

{{--    <script src="../../assets/vendor/libs/@algolia/autocomplete-js.js"></script>--}}

    <link rel="stylesheet" href="../../assets/vendor/libs/pickr/pickr-themes.css"/>

    <link rel="stylesheet" href="../../assets/vendor/css/core.css"/>
    <link rel="stylesheet" href="../../assets/css/demo.css"/>

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>

    <!-- endbuild -->

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js. -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../../assets/js/config.js"></script>
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">


        <aside id="layout-menu" class="layout-menu menu-vertical menu">
            <div class="app-brand demo">
                <a href="{{config('app.url')}}" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img style="width: 35px" height="40px"src="{{ asset('images/logo-ut.png') }}" alt="logo UT">
                </span>
              </span>
                    <span class="app-brand-text demo menu-text fw-semibold ms-2">{{config('app.name')}}</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                            fill-opacity="0.9"/>
                        <path
                            d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                            fill-opacity="0.4"/>
                    </svg>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboards -->
                <x-alumni-menu/>
            </ul>

        </aside>
        <!-- Component Sidebar Menu Vertikal -->
{{--        <div class="menu-mobile-toggler d-xl-none rounded-1">--}}
{{--            <a href="javascript:void(0);"--}}
{{--               class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">--}}
{{--                <i class="ri ri-menu-line icon-base"></i>--}}
{{--                <i class="ri ri-arrow-right-s-line icon-base"></i>--}}
{{--            </a>--}}
{{--        </div>--}}
        <div class="layout-page">
            <!-- Navbar -->

            <nav
                class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                        <i class="icon-base ri ri-menu-line icon-22px"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                            <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
                            </a>
                        </div>
                    </div>

                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                        <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                               data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-translate-2 icon-md"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="en"
                                       data-text-direction="ltr">
                                        <span>English</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="id"
                                       data-text-direction="ltr">
                                        <span>Indonesia</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <!--/ Language -->

                        <!-- Style Switcher -->
                        <li class="nav-item dropdown me-sm-2 me-xl-0">
                            <a
                                class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                id="nav-theme"
                                href="javascript:void(0);"
                                data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-sun-line icon-22px theme-icon-active"></i>
                                <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item align-items-center active"
                                        data-bs-theme-value="light"
                                        aria-pressed="false">
                                        <span><i class="icon-base ri ri-sun-line icon-22px me-3"
                                                 data-icon="sun-line"></i>Light</span>
                                    </button>
                                </li>
                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item align-items-center"
                                        data-bs-theme-value="dark"
                                        aria-pressed="true">
                        <span
                        ><i class="icon-base ri ri-moon-clear-line icon-22px me-3" data-icon="moon-clear-line"></i
                            >Dark</span
                        >
                                    </button>
                                </li>
                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item align-items-center"
                                        data-bs-theme-value="system"
                                        aria-pressed="false">
                        <span
                        ><i class="icon-base ri ri-computer-line icon-22px me-3" data-icon="computer-line"></i
                            >System</span
                        >
                                    </button>
                                </li>
                            </ul>
                        </li>
                        <!-- / Style Switcher-->

                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
                            <a
                                class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                                href="javascript:void(0);"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="outside"
                                aria-expanded="false">
                                <i class="icon-base ri ri-notification-2-line icon-22px"></i>
                                <span
                                    class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end py-0">
                                <li class="dropdown-menu-header border-bottom py-50">
                                    <div class="dropdown-header d-flex align-items-center py-2">
                                        <h6 class="mb-0 me-auto">Notification</h6>
                                        <div class="d-flex align-items-center h6 mb-0">
                                            <span
                                                class="badge rounded-pill bg-label-primary fs-xsmall me-2">8 New</span>
                                            <a
                                                href="javascript:void(0)"
                                                class="dropdown-notifications-all p-2"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Mark all as read"
                                            ><i class="icon-base ri ri-mail-open-line text-heading"></i
                                                ></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="../../images/1.png" alt="avatar"
                                                             class="rounded-circle"/>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="small mb-1">Congratulation Lettie 🎉</h6>
                                                    <small class="mb-1 d-block text-body">Won the monthly best seller
                                                        gold badge</small>
                                                    <small class="text-body-secondary">1h ago</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <a href="javascript:void(0)" class="dropdown-notifications-read"
                                                    ><span class="badge badge-dot"></span
                                                        ></a>
                                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                                    ><span class="icon-base ri ri-close-line"></span
                                                        ></a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="border-top">
                                    <div class="d-grid p-4">
                                        <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                            <small class="align-middle">View all notifications</small>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ Notification -->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                               data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="{{asset('images/1.png')}}" alt="avatar" class="rounded-circle"/>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                                <li>
                                    <a class="dropdown-item" href="pages-account-settings-account.html">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar avatar-online">
                                                    <img
                                                        src="{{asset('images/1.png')}}"
                                                        alt="alt"
                                                        class="w-px-40 h-auto rounded-circle"/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 small">John Doe</h6>
                                                <small class="text-body-secondary">Admin</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-profile-user.html">
                                        <i class="icon-base ri ri-user-3-line icon-22px me-3"></i
                                        ><span class="align-middle">My Profile</span>
                                    </a>
                                </li>

                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="pages-faq.html">
                                        <i class="icon-base ri ri-question-line icon-22px me-3"></i
                                        ><span class="align-middle">FAQ</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="d-grid px-4 pt-2 pb-1">
                                        <a class="btn btn-sm btn-danger d-flex" href="">
                                            <small class="align-middle">Logout</small>
                                            <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row g-6">
                        <!-- Gamification Card -->
                        <div class="col-md-12 col-xxl-8">
                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-md-6 order-2 order-md-1">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Congratulations <span
                                                    class="fw-bold">John!</span>
                                                🎉</h4>
                                            <p class="mb-0">You have done 68% 😎 more sales today.</p>
                                            <p>Check your new badge in your profile.</p>
                                            <a href="javascript:;" class="btn btn-primary">View Profile</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                                        <div class="card-body pb-0 px-0 pt-2">
                                            <img
                                                src="../../assets/img/illustrations/illustration-john-light.png"
                                                height="186"
                                                class="scaleX-n1-rtl"
                                                alt="View Profile"
                                                data-app-light-img="illustrations/illustration-john-light.png"
                                                data-app-dark-img="illustrations/illustration-john-dark.png"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Gamification Card -->
                @yield('content')
            </div>

            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                    <div
                        class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            &#169;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by
                            <a href="https://pixinvent.com" target="_blank" class="footer-link fw-medium">Pixinvent</a>
                        </div>
                        <div class="d-none d-lg-inline-block">
                            <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank"
                            >License</a
                            >

                            <a href="https://themeforest.net/user/pixinvent/portfolio" target="_blank"
                               class="footer-link me-4"
                            >More Themes</a
                            >
                            <a
                                href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/"
                                target="_blank"
                                class="footer-link me-4"
                            >Documentation</a
                            >

                            <a href="https://pixinvent.ticksy.com/" target="_blank"
                               class="footer-link d-none d-sm-inline-block"
                            >Support</a
                            >
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- / Footer -->

    <!-- Materialize JS CDN -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="../../assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="../../assets/vendor/libs/pickr/pickr.js"></script>

    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>

    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="../../assets/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Sidenav (Sidebar)
            M.Sidenav.init(document.querySelectorAll('.sidenav'));

            // Inisialisasi Collapsible (Submenu / Accordion)
            const collapsibleElems = document.querySelectorAll('.collapsible');
            M.Collapsible.init(collapsibleElems, {
                accordion: true // true = hanya 1 submenu yang terbuka dalam satu waktu
            });
        });
    </script>
</body>
</html>
