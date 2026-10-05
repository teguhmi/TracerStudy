@extends('_include._template')

@section('title', 'Pemeriksaan Data Alumni')

@section('content')

  <div class="container-xxl flex-grow-1 container-p-y">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="row mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body">

            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">

              <div>
                <h4 class="mb-1">
                  <i class="ti ti-user-check me-2"></i>
                  Pemeriksaan Data Alumni
                </h4>

                <p class="text-muted mb-0">
                  Silakan periksa kesesuaian data Anda.
                  Jika terdapat data yang tidak sesuai, isi data perbaikan pada kolom yang tersedia.
                </p>
              </div>

              <div class="text-md-end">
                                <span class="badge bg-label-primary">
                                    NIM: {{ $dpAlumni->nim ?? '-' }}
                                </span>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>


    {{-- ========================================================= --}}
    {{-- INFORMASI KELULUSAN --}}
    {{-- ========================================================= --}}
    <div class="row mb-4">
      <div class="col-12">

        <div class="card">

          <div class="card-header border-bottom">
            <h5 class="card-title mb-0">
              <i class="ti ti-school me-2"></i>
              Informasi Kelulusan
            </h5>
          </div>

          <div class="card-body pt-4">

            <div class="row g-4">

              <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                  Masa Yudisium
                </small>

                <strong>
                  {{ $dpAlumni->masa_yudisium ?? '-' }}
                </strong>
              </div>

              <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                  Nomor SK Rektor
                </small>

                <strong>
                  {{ $dpAlumni->skRektor->nomor_sk_rektor ?? '-' }}
                </strong>
              </div>

              <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                  Tanggal SK
                </small>

                <strong>
                  {{ $dpAlumni->skRektor->tanggal_sk ?? '-' }}
                </strong>
              </div>

              <div class="col-md-3">
                <small class="text-muted d-block mb-1">
                  Nomor Ijazah
                </small>

                <strong>
                  {{ $dpAlumni->nomor_ijazah ?? '-' }}
                </strong>
              </div>

            </div>

          </div>
        </div>

      </div>
    </div>


    {{-- ========================================================= --}}
    {{-- FORM VALIDASI --}}
    {{-- ========================================================= --}}
{{--    {{ route('validasidp.store') }}--}}

    @csrf

    <input
      type="hidden"
      name="nim"
      value="{{ $encryptedNim }}"
    >


    {{-- ===================================================== --}}
    {{-- PERBANDINGAN DATA --}}
    {{-- ===================================================== --}}
    <div class="row g-4">

      {{-- ================================================= --}}
      {{-- DATA SAAT INI --}}
      {{-- ================================================= --}}
      <div class="col-lg-6">

        <div class="card h-100">

          <div class="card-header border-bottom">

            <div class="d-flex align-items-center justify-content-between">

              <div>
                <h5 class="card-title mb-1">
                  <i class="ti ti-database me-2"></i>
                  Data Saat Ini
                </h5>

                <small class="text-muted">
                  Data yang tersimpan pada sistem
                </small>
              </div>

              <span class="badge bg-label-info">
                                    Data SRS
                                </span>

            </div>

          </div>


          <div class="card-body pt-4">

            {{-- NIM --}}
            <div class="mb-4">
              <label class="form-label">
                NIM
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->nim ?? '-' }}"
                readonly
              >
            </div>


            {{-- NAMA --}}
            <div class="mb-4">
              <label class="form-label">
                Nama Lengkap
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->nama_mahasiswa ?? $dpAlumni->nama ?? '-' }}"
                readonly
              >
            </div>


            {{-- TEMPAT LAHIR --}}
            <div class="mb-4">
              <label class="form-label">
                Tempat Lahir
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->tempat_lahir ?? '-' }}"
                readonly
              >
            </div>


            {{-- TANGGAL LAHIR --}}
            <div class="mb-4">
              <label class="form-label">
                Tanggal Lahir
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->tanggal_lahir ?? '-' }}"
                readonly
              >
            </div>


            {{-- NIK --}}
            <div class="mb-4">
              <label class="form-label">
                NIK
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->nik ?? '-' }}"
                readonly
              >
            </div>


            {{-- EMAIL --}}
            <div class="mb-4">
              <label class="form-label">
                Email
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->email ?? '-' }}"
                readonly
              >
            </div>


            {{-- NOMOR HP --}}
            <div class="mb-0">
              <label class="form-label">
                Nomor HP
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->no_hp ?? '-' }}"
                readonly
              >
            </div>

          </div>

        </div>

      </div>


      {{-- ================================================= --}}
      {{-- DATA PERBAIKAN --}}
      {{-- ================================================= --}}
      <div class="col-lg-6">

        <div class="card h-100">

          <div class="card-header border-bottom">

            <div class="d-flex align-items-center justify-content-between">

              <div>
                <h5 class="card-title mb-1">
                  <i class="ti ti-edit me-2"></i>
                  Data Perbaikan
                </h5>

                <small class="text-muted">
                  Isi hanya data yang perlu diperbaiki
                </small>
              </div>

              <span class="badge bg-label-warning">
                                    Perbaikan
                                </span>

            </div>

          </div>


          <div class="card-body pt-4">

            {{-- NIM --}}
            <div class="mb-4">

              <label class="form-label">
                NIM
              </label>

              <input
                type="text"
                class="form-control"
                value="{{ $dpAlumni->nim ?? '-' }}"
                readonly
              >

{{--              <small class="text-muted">--}}
{{--                NIM tidak dapat diubah.--}}
{{--              </small>--}}

            </div>


            {{-- NAMA --}}
            <div class="mb-4">

              <label
                for="nama"
                class="form-label"
              >
                Nama Lengkap
              </label>

              <input
                type="text"
                id="nama"
                name="nama"
                class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama') }}"
                placeholder="{{ $dpAlumni->nama_mahasiswa ?? $dpAlumni->nama ?? 'Masukkan nama lengkap' }}"
              >

              @error('nama')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>


            {{-- TEMPAT LAHIR --}}
            <div class="mb-4">

              <label
                for="tempat_lahir"
                class="form-label"
              >
                Tempat Lahir
              </label>

              <input
                type="text"
                id="tempat_lahir"
                name="tempat_lahir"
                class="form-control @error('tempat_lahir') is-invalid @enderror"
                value="{{ old('tempat_lahir') }}"
                placeholder="{{ $dpAlumni->tempat_lahir ?? 'Masukkan tempat lahir' }}"
              >

              @error('tempat_lahir')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>


            {{-- TANGGAL LAHIR --}}
            <div class="mb-4">

              <label
                for="tanggal_lahir"
                class="form-label"
              >
                Tanggal Lahir
              </label>
                <input
                        type="date"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir', $dpAlumni->tanggal_lahir ? \Carbon\Carbon::createFromFormat('d/m/Y', $dpAlumni->tanggal_lahir)->format('Y-m-d'): '') }}"
                >
                @error('tanggal_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- NIK --}}
            <div class="mb-4">

              <label
                for="nik"
                class="form-label"
              >
                NIK
              </label>

              <input
                type="text"
                id="nik"
                name="nik"
                class="form-control @error('nik') is-invalid @enderror"
                value="{{ old('nik') }}"
                maxlength="16"
                inputmode="numeric"
                placeholder="{{ $dpAlumni->nik ?? 'Masukkan NIK' }}"
              >

              @error('nik')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>


            {{-- EMAIL --}}
            <div class="mb-4">

              <label
                for="email"
                class="form-label"
              >
                Email
              </label>

              <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="{{ $dpAlumni->email ?? 'Masukkan email' }}"
              >

              @error('email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>


            {{-- NOMOR HP --}}
            <div class="mb-0">

              <label
                for="no_hp"
                class="form-label"
              >
                Nomor HP
              </label>

              <input
                type="text"
                id="no_hp"
                name="no_hp"
                class="form-control @error('no_hp') is-invalid @enderror"
                value="{{ old('no_hp') }}"
                inputmode="numeric"
                placeholder="{{ $dpAlumni->no_hp ?? 'Masukkan nomor HP' }}"
              >

              @error('no_hp')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>

          </div>

        </div>

      </div>

    </div>


    {{-- ===================================================== --}}
    {{-- KONFIRMASI --}}
    {{-- ===================================================== --}}
    <div class="row mt-4">

      <div class="col-12">

        <div class="card">

          <div class="card-header border-bottom">

            <h5 class="card-title mb-0">
              <i class="ti ti-circle-check me-2"></i>
              Konfirmasi Data
            </h5>

          </div>


          <div class="card-body pt-4">

            <p class="mb-3">
              Setelah membandingkan data di atas, silakan tentukan
              apakah data Anda sudah sesuai.
            </p>


            <div class="row g-3">

              {{-- DATA SESUAI --}}
              <div class="col-md-6">

                <label
                  class="border rounded p-3 d-flex align-items-start gap-3 w-100 cursor-pointer"
                  for="statusSesuai"
                >

                  <input
                    class="form-check-input mt-1"
                    type="radio"
                    name="status_data"
                    id="statusSesuai"
                    value="sesuai"
                    {{ old('status_data') === 'sesuai' ? 'checked' : '' }}
                  >

                  <div>

                    <strong class="text-success d-block mb-1">
                      <i class="ti ti-circle-check me-1"></i>
                      Data Sudah Sesuai
                    </strong>

                    <small class="text-muted">
                      Semua data yang tercantum sudah benar
                      dan tidak memerlukan perubahan.
                    </small>

                  </div>

                </label>

              </div>


              {{-- DATA TIDAK SESUAI --}}
              <div class="col-md-6">

                <label
                  class="border rounded p-3 d-flex align-items-start gap-3 w-100 cursor-pointer"
                  for="statusPerbaikan"
                >

                  <input
                    class="form-check-input mt-1"
                    type="radio"
                    name="status_data"
                    id="statusPerbaikan"
                    value="perbaikan"
                    {{ old('status_data') === 'perbaikan' ? 'checked' : '' }}
                  >

                  <div>

                    <strong class="text-warning d-block mb-1">
                      <i class="ti ti-alert-circle me-1"></i>
                      Ada Data yang Perlu Diperbaiki
                    </strong>

                    <small class="text-muted">
                      Terdapat data yang tidak sesuai.
                      Data perbaikan telah diisi pada form di atas.
                    </small>

                  </div>

                </label>

              </div>

            </div>


            @error('status_data')
            <div class="text-danger small mt-2">
              {{ $message }}
            </div>
            @enderror


            {{-- PERNYATAAN --}}
            <div class="alert alert-warning mt-4 mb-0">

              <div class="form-check">

                <input
                  class="form-check-input"
                  type="checkbox"
                  name="konfirmasi"
                  value="1"
                  id="konfirmasi"
                  required
                >

                <label
                  class="form-check-label"
                  for="konfirmasi"
                >
                  Saya menyatakan bahwa data yang saya periksa
                  dan/atau data perbaikan yang saya masukkan
                  adalah benar.
                </label>

              </div>

            </div>

          </div>


          <div class="card-footer border-top">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">

              <a href="{{ url()->previous() }}" class="btn btn-label-secondary">
              <i class="ti ti-arrow-left me-1"></i>
              Kembali
              </a>

              <button type="submit"
                      id="btnSimpan"
                      class="btn btn-primary">
                <i class="ti ti-device-floppy me-1"></i>
                Simpan & Konfirmasi Data
              </button>

            </div>

          </div>

        </div>

      </div>

    </div>

    </form>

  </div>

@endsection




@section('script')

  <script>
    $(document).ready(function () {

      // ================================================================
      // MATERIALIZE SELECT
      // ================================================================

      $('select').formSelect();


      // ================================================================
      // TAMPILKAN / SEMBUNYIKAN FORM PERBAIKAN
      // ================================================================

      function toggleFormPerbaikan() {

        const status = $('input[name="status_data"]:checked').val();

        if (status === 'perbaikan') {

          $('#form-perbaikan').slideDown(200);

        } else {

          $('#form-perbaikan').slideUp(200);

        }
      }


      $('input[name="status_data"]').on('change', function () {

        toggleFormPerbaikan();

      });


      // Jalankan ketika halaman pertama kali dibuka
      // Berguna ketika kembali dari validation error.
      toggleFormPerbaikan();


      // ================================================================
      // NIK HANYA ANGKA
      // ================================================================

      $('#nik').on('input', function () {

        this.value = this.value.replace(/\D/g, '');

      });


      // ================================================================
      // NOMOR HP HANYA ANGKA
      // ================================================================

      $('#nomor_hp').on('input', function () {

        this.value = this.value.replace(/\D/g, '');

      });


      // ================================================================
      // NOMOR WHATSAPP HANYA ANGKA
      // ================================================================

      $('#nomor_wa').on('input', function () {

        this.value = this.value.replace(/\D/g, '');

      });


      // ================================================================
      // VALIDASI SEBELUM SUBMIT
      // ================================================================

      $('#form-validasi-data').on('submit', function (e) {

        const status = $('input[name="status_data"]:checked').val();


        // Status belum dipilih
        if (!status) {

          e.preventDefault();

          M.toast({
            html: 'Silakan pilih apakah data sudah sesuai atau perlu diperbaiki.'
          });

          return false;
        }


        // ============================================================
        // JIKA MEMILIH PERBAIKAN
        // ============================================================

        if (status === 'perbaikan') {

          const nama = $('#nama').val().trim();

          const tempatLahir = $('#tempat_lahir')
            .val()
            .trim();

          const tanggalLahir = $('#tanggal_lahir')
            .val()
            .trim();

          const jenisKelamin = $('#jenis_kelamin').val();

          const nik = $('#nik').val().trim();

          const nomorHp = $('#nomor_hp')
            .val()
            .trim();

          const nomorWa = $('#nomor_wa')
            .val()
            .trim();


          // Minimal satu data perbaikan harus diisi
          if (
            !nama &&
            !tempatLahir &&
            !tanggalLahir &&
            !jenisKelamin &&
            !nik &&
            !nomorHp &&
            !nomorWa
          ) {

            e.preventDefault();

            M.toast({
              html: 'Silakan isi minimal satu data yang ingin diperbaiki.'
            });

            return false;
          }


          // ========================================================
          // VALIDASI NIK
          // hanya ketika NIK diisi
          // ========================================================

          if (nik && nik.length !== 16) {

            e.preventDefault();

            M.toast({
              html: 'NIK harus terdiri dari 16 digit.'
            });

            $('#nik').focus();

            return false;
          }

        }

      });

    });
  </script>

@endsection
