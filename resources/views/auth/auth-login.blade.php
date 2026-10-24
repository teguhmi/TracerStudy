@include('_include._head')

<body>

<div class="login-background">

  <div class="min-vh-100 d-flex align-items-center justify-content-center p-4">

    <div
      class="card login-card border-0"
      style="width: 100%; max-width: 440px;">

      <div class="card-body p-4 p-md-5">

        {{-- LOGO --}}
        <div class="text-center mb-5">

          <div
            class="d-inline-flex align-items-center justify-content-center
                               bg-primary text-white rounded-3 mb-3"
            style="width: 100%; height: 100%; object-fit: contain;">


          </div>
          {{-- LOGO --}}
          <div class="text-center mb-4">
            <img
              src="{{ asset('images/logo-ut.png') }}"
              class="img-fluid rounded-3"
              style="width: 56px; height: 56px; object-fit: contain;"
             alt="">
          </div>
        </div>

        {{-- WELCOME --}}
        <div class="text-center mb-5">

          <h3 class="mb-2 fw-bold">
            Selamat Datang 👋
          </h3>

          <p class="text-muted mb-0">
            Silakan pilih jenis login untuk melanjutkan
          </p>

        </div>


        {{-- PILIHAN LOGIN --}}
        <div class="row g-2 mb-5">

          <div class="col-6">

            <button
              type="button"
              id="btn-alumni"
              class="btn btn-primary w-100"
              onclick="switchLogin('alumni')">

              <i class="ri-graduation-cap-line me-1"></i>

              Alumni

            </button>

          </div>


          <div class="col-6">

            <button
              type="button"
              id="btn-staff"
              class="btn btn-outline-primary w-100"
              onclick="switchLogin('staff')">

              <i class="ri-user-line me-1"></i>

              Staff

            </button>

          </div>

        </div>


        <form method="POST" action="{{ route('auth-login-process') }}">
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
            <div class="row mb-6">

              <div class="col-md-6">
                <label
                  for="nim"
                  class="form-label fw-medium">
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
                <label
                  for="tanggal_lahir"
                  class="form-label fw-medium">
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
                    pattern="^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$">
                </div>
              </div>

            </div>

            <div class="form-text mb-4">
              Gunakan tanggal lahir yang terdaftar.
            </div>

            {{-- CAPTCHA --}}
            <div class="mb-4">

              <label class="form-label fw-medium">
                Verifikasi Keamanan
              </label>

              <div class="row g-2 mb-2">

                <div class="col-9">

                  <div class="captcha-container mb-2">

                    <div id="captcha-img">
                      {!! captcha_img('flat') !!}
                    </div>

                    <button
                      type="button"
                      id="reload-captcha"
                      class="btn btn-sm btn-primary captcha-reload">
                      <i class="ri-refresh-line"></i>
                    </button>

                  </div>


                </div>

{{--                <div class="col-3">--}}

{{--                  <button--}}
{{--                    type="button"--}}
{{--                    id="reload-captcha"--}}
{{--                    class="btn btn-primary w-100 h-100">--}}

{{--                    <i class="ri-refresh-line"></i>--}}

{{--                  </button>--}}

                </div>

              </div>

              <input
                type="text"
                name="captcha"
                class="form-control @error('captcha') is-invalid @enderror"
                placeholder="Masukkan kode captcha">

              @error('captcha')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>


          {{-- ===========================
               LOGIN STAFF
          =========================== --}}
          <div
            id="form-staff"
            class="d-none">

            <div class="mb-4">

              <label
                for="email"
                class="form-label fw-medium">
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

            <div class="mb-2">

              <label
                for="password"
                class="form-label fw-medium">
                Password     <div class="input-group input-group-merge form-password-toggle">

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

            <div class="text-end mt-2 mb-4">
              #
              Lupa Password?
              </a>
            </div>

          </div>

          {{-- SUBMIT --}}
          <div class="d-grid mt-4">

            <button
              type="submit"
              class="btn btn-primary btn-lg">

            <span id="submit-text">
                Masuk sebagai Alumni
            </span>

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
  document.getElementById('reload-captcha').addEventListener('click', function() {

    fetch('{{ route("reload.captcha") }}')
      .then(response => response.json())
      .then(data => {
        document.getElementById('captcha-img').innerHTML = data.captcha;
      });

  });
</script>

<script>
  function switchLogin(type) {

    const loginType = document.getElementById('login_type');

    const formAlumni = document.getElementById('form-alumni');
    const formStaff = document.getElementById('form-staff');

    const btnAlumni = document.getElementById('btn-alumni');
    const btnStaff = document.getElementById('btn-staff');

    const nim = document.getElementById('nim');
    const tanggalLahir = document.getElementById('tanggal_lahir');

    const email = document.getElementById('email');
    const password = document.getElementById('password');

    const submitText = document.getElementById('submit-text');

    loginType.value = type;


    if (type === 'alumni') {

      formAlumni.classList.remove('d-none');
      formStaff.classList.add('d-none');

      btnAlumni.classList.remove('btn-outline-primary');
      btnAlumni.classList.add('btn-primary');

      btnStaff.classList.remove('btn-primary');
      btnStaff.classList.add('btn-outline-primary');

      nim.required = true;
      tanggalLahir.required = true;

      email.required = false;
      password.required = false;

      submitText.textContent = 'Masuk sebagai Alumni';


    } else {

      formAlumni.classList.add('d-none');
      formStaff.classList.remove('d-none');

      btnAlumni.classList.remove('btn-primary');
      btnAlumni.classList.add('btn-outline-primary');

      btnStaff.classList.remove('btn-outline-primary');
      btnStaff.classList.add('btn-primary');

      nim.required = false;
      tanggalLahir.required = false;

      email.required = true;
      password.required = true;

      submitText.textContent = 'Masuk sebagai Staff';

      loginInfo.textContent =
        'Gunakan email dan password akun staff.';
    }
  }


  document.addEventListener('DOMContentLoaded', function () {

    const loginType = document.getElementById('login_type');

    switchLogin(loginType.value || 'alumni');

  });
</script>


<style>

  body {
    margin: 0;
  }


  /* ==============================
     BACKGROUND
  =============================== */

  .login-background {

    min-height: 100vh;

    background-image:
      linear-gradient(
        90deg,
        rgba(7, 38, 91, 0.40),
        rgba(7, 38, 91, 0.15)
      ),
      url('/images/login-bg.png');

    background-size: cover;

    background-position: center;

    background-repeat: no-repeat;

    background-attachment: fixed;
  }


  /* ==============================
     LOGIN CARD
  =============================== */

  .login-card {

    background:
      rgba(255, 255, 255, 0.95);

    backdrop-filter: blur(12px);

    -webkit-backdrop-filter: blur(12px);

    border-radius: 1.25rem;

    box-shadow:
      0 1.5rem 4rem
      rgba(10, 30, 70, 0.27);
  }


  /* ==============================
     FORM
  =============================== */

  .login-card .form-control,
  .login-card .input-group-text {

    background-color:
      rgba(255, 255, 255, 0.85);
  }


  /* ==============================
     RESPONSIVE
  =============================== */

  @media (max-width: 768px) {

    .login-background {

      background-position:
        38% center;
    }

  }


  @media (max-width: 576px) {

    .login-background {

      background-attachment:
        scroll;
    }

    .login-card {

      border-radius:
        1rem;
    }

  }

</style>

</body>
