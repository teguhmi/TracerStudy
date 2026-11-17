@include('_include._head')

<body>
<div class="login-background">
  <div class="min-vh-100 d-flex align-items-center justify-content-center p-4">
    <div class="card login-card border-0" style="width: 100%; max-width: 440px;">
      <div class="card-body p-4 p-md-5">

        {{-- LOGO --}}
        <div class="text-center mb-4">
          <img
            src="{{ asset('images/logo-ut.png') }}"
            class="img-fluid rounded-3"
            style="width: 56px; height: 56px; object-fit: contain;"
            alt="Logo UT">
        </div>

        {{-- WELCOME --}}
        <div class="text-center mb-4">
          <h3 class="mb-2 fw-bold">
            Selamat Datang 👋
          </h3>
          <p class="text-muted mb-0">
            Silakan pilih jenis login untuk melanjutkan
          </p>
        </div>

        {{-- PESAN ERROR UMUM (JIKA ADA) --}}
        @if ($errors->any())
          <div class="alert alert-danger py-2 px-3 mb-4" role="alert">
            <small>{{ $errors->first() }}</small>
          </div>
        @endif

        {{-- PILIHAN LOGIN --}}
        <div class="row g-2 mb-4">
          <div class="col-6">
            <button
              type="button"
              id="btn-alumni"
              class="btn btn-primary w-100">
              <i class="ri-graduation-cap-line me-1"></i>
              Alumni
            </button>
          </div>

          <div class="col-6">
            <button
              type="button"
              id="btn-staff"
              class="btn btn-outline-primary w-100">
              <i class="ri-user-line me-1"></i>
              Staff
            </button>
          </div>
        </div>

        <form id="login-form" method="POST" action="{{ route('auth-login-process') }}">
          @csrf

          <input
            type="hidden"
            name="login_type"
            id="login_type"
            value="{{ old('login_type', 'alumni') }}">

          {{-- ===========================
               LOGIN ALUMNI
          =========================== --}}
          <div id="form-alumni">

            {{-- NIM + TANGGAL LAHIR --}}
            <div class="row g-3 mb-2">
              <div class="col-md-6">
                <label for="nim" class="form-label fw-medium">
                  NIM
                </label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text">
                    <i class="ri-id-card-line"></i>
                  </span>
                  <input
                    type="text"
                    id="nim"
                    name="nim"
                    value="{{ old('nim') }}"
                    maxlength="9"
                    inputmode="numeric"
                    class="form-control"
                    placeholder="NIM">
                </div>
              </div>

              <div class="col-md-6">
                <label for="tanggal_lahir" class="form-label fw-medium">
                  Tanggal Lahir
                </label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text">
                    <i class="ri-calendar-line"></i>
                  </span>
                  <input
                    type="text"
                    id="tanggal_lahir"
                    name="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}"
                    class="form-control"
                    placeholder="dd/mm/yyyy"
                    pattern="^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/\d{4}$"
                    title="Gunakan format dd/mm/yyyy, contoh: 17/08/1998">
                </div>
              </div>
            </div>

            <div class="form-text mb-4">
              Gunakan tanggal lahir yang terdaftar (format: dd/mm/yyyy).
            </div>

            {{-- CAPTCHA --}}
            <div class="mb-4">
              <label for="captcha" class="form-label fw-medium">
                Verifikasi Keamanan
              </label>

              <div class="d-flex align-items-center gap-2 mb-2">
                <div id="captcha-img">
                  {!! captcha_img('flat') !!}
                </div>
                <button
                  type="button"
                  id="reload-captcha"
                  class="btn btn-sm btn-primary"
                  title="Muat ulang captcha">
                  <i class="ri-refresh-line"></i>
                </button>
              </div>

              <input
                type="text"
                id="captcha"
                name="captcha"
                class="form-control @error('captcha') is-invalid @enderror"
                placeholder="Masukkan kode captcha">

              @error('captcha')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>

          </div>

          {{-- ===========================
               LOGIN STAFF
          =========================== --}}
          <div id="form-staff" class="d-none">

            <div class="mb-4">
              <label for="email" class="form-label fw-medium">
                Email
              </label>
              <div class="input-group input-group-merge">
                <span class="input-group-text">
                  <i class="ri-mail-line"></i>
                </span>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value="{{ old('email') }}"
                  class="form-control"
                  autocomplete="username"
                  placeholder="Masukkan email">
              </div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-medium">
                Password
              </label>
              <div class="input-group input-group-merge form-password-toggle">
                <span class="input-group-text">
                  <i class="ri-lock-line"></i>
                </span>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="form-control"
                  autocomplete="current-password"
                  placeholder="Masukkan password">
                <span class="input-group-text cursor-pointer">
                  <i class="ri-eye-off-line"></i>
                </span>
              </div>
            </div>

            {{-- LOGIN SSO MICROSOFT --}}
            <div class="d-grid mb-3">
              <a href="{{ route('microsoft.login') }}" class="btn btn-outline-primary">
                <i class="ri-microsoft-line me-2"></i>
                Login dengan Microsoft 365
              </a>
            </div>

            <div class="text-center mb-3">
              <small class="text-muted">
                atau login menggunakan email dan password staff
              </small>
            </div>

          </div>

          {{-- SUBMIT --}}
          <div class="d-grid mt-4">
            <button
              type="submit"
              id="btn-submit"
              class="btn btn-primary btn-lg">
              <span id="submit-text">Masuk sebagai Alumni</span>
              <i class="ri-arrow-right-line ms-1"></i>
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

@include('_include._script')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const getEl = (id) => document.getElementById(id);

    function switchLogin(type) {
      const isAlumni = type === 'alumni';

      getEl('login_type').value = type;
      getEl('form-alumni').classList.toggle('d-none', !isAlumni);
      getEl('form-staff').classList.toggle('d-none', isAlumni);

      getEl('btn-alumni').className = `btn ${isAlumni ? 'btn-primary' : 'btn-outline-primary'} w-100`;
      getEl('btn-staff').className = `btn ${isAlumni ? 'btn-outline-primary' : 'btn-primary'} w-100`;

      getEl('nim').required = isAlumni;
      getEl('tanggal_lahir').required = isAlumni;
      getEl('captcha').required = isAlumni;

      getEl('email').required = !isAlumni;
      getEl('password').required = !isAlumni;

      getEl('submit-text').textContent = isAlumni ? 'Masuk sebagai Alumni' : 'Masuk sebagai Staff';
    }

    getEl('btn-alumni')?.addEventListener('click', () => switchLogin('alumni'));
    getEl('btn-staff')?.addEventListener('click', () => switchLogin('staff'));

    getEl('reload-captcha')?.addEventListener('click', function () {
      fetch('{{ route("reload.captcha") }}')
        .then((response) => response.json())
        .then((data) => {
          getEl('captcha-img').innerHTML = data.captcha;
        });
    });

    getEl('login-form')?.addEventListener('submit', function () {
      const btnSubmit = getEl('btn-submit');
      btnSubmit.disabled = true;
      getEl('submit-text').textContent = 'Memproses...';
    });

    switchLogin(getEl('login_type').value || 'alumni');
  });
</script>

<style>
  body {
    margin: 0;
  }

  .login-background {
    min-height: 100vh;
    background-image: linear-gradient(
      90deg,
      rgba(7, 38, 91, 0.40),
      rgba(7, 38, 91, 0.15)
    ),
    url('{{ asset('images/login-bg.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
  }

  .login-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 1.25rem;
    box-shadow: 0 1.5rem 4rem rgba(10, 30, 70, 0.27);
  }

  .login-card .form-control,
  .login-card .input-group-text {
    background-color: rgba(255, 255, 255, 0.85);
  }

  @media (max-width: 768px) {
    .login-background {
      background-position: 38% center;
    }
  }

  @media (max-width: 576px) {
    .login-background {
      background-attachment: scroll;
    }
    .login-card {
      border-radius: 1rem;
    }
  }
</style>
</body>
