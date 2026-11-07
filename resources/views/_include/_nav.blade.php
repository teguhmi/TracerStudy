<!-- Navbar -->

<nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
  <div class="container-xxl">
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
      <a href="{{route('home')}}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <span class="text-primary">
                      <img
                        src="{{ asset('images/logo-ut.png') }}"
                        alt="Logo UT"
                        height="18" width="32"
                        class="img-fluid"
                      >
                  </span>
                </span>
        <span class="app-brand-text demo menu-text fw-semibold ms-1">{{config('app.name')}}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
        <i class="icon-base ri ri-close-line icon-sm"></i>
      </a>
    </div>

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base ri ri-menu-line icon-22px"></i>
      </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
      <ul class="navbar-nav flex-row align-items-center ms-md-auto">
        <!-- Search -->
        <li class="nav-item navbar-search-wrapper me-sm-2 me-xl-0">
          <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
            <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
          </a>
        </li>
        <!-- /Search -->

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
                  <span class="badge rounded-pill bg-label-primary fs-xsmall me-2">8 New</span>
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
                        <img src="../../assets/img/avatars/1.png" alt="avatar" class="rounded-circle" />
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="small mb-1">Congratulation Lettie 🎉</h6>
                      <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
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
          <a class="nav-link dropdown-toggle hide-arrow"
             href="javascript:void(0);"
             data-bs-toggle="dropdown">

            <div class="avatar avatar-online">
              <img src="{{ asset('assets/img/avatars/1.png') }}"
                   alt="Avatar"
                   class="rounded-circle">
            </div>
          </a>

          <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">

            <li>
              <div class="dropdown-item">
                <div class="d-flex align-items-center">
                  <div class="flex-grow-1">
                    <h6 class="mb-0 small">
                      {{ session('nama_mahasiswa', 'Guest') }}
                    </h6>

                    <small class="text-body-secondary">
                      {{ session('nim', '-') }}
                    </small>
                  </div>

                </div>
              </div>
            </li>

            <li>
              <div class="dropdown-divider"></div>
            </li>

            <li>
              <div class="px-3 py-2">
                <form action="{{ route('auth-logout') }}"
                      method="POST">
                  @csrf

                  <button type="submit"
                          class="btn btn-danger btn-sm w-100">
                    Logout
                  </button>
                </form>
              </div>
            </li>

          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </div>
</nav>

<!-- / Navbar -->
