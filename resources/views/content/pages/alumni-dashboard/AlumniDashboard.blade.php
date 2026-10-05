@extends('_include._template')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

    <style>
        #cropperContainer {
            position: relative;
            width: 100%;
            height: 500px;
            background: #181818;
            overflow: hidden;
            border-radius: 0.5rem;
        }

        #imageCropperIjazah {
            display: block;
            max-width: 100%;
        }

        #cropperContainer
            /*.cropper-container */
        {
            width: 100% !important;
            height: 100% !important;
        }

        #previewFotoIjazah {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 767px) {
            #cropperContainer {
                height: 400px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="content-wrapper">

        <div class="container-fluid flex-grow-1 container-p-y">

            {{-- ====================================================== --}}
            {{-- PROFILE HEADER --}}
            {{-- ====================================================== --}}

            <div class="row">
                <div class="col-12">

                    <div class="card mb-6 overflow-hidden">

                        {{-- Banner --}}
                        <div class="user-profile-header-banner">
                            <img src="{{asset('assets/img/pages/profile-banner.png')}}" alt="Banner image" class="rounded-top" />
                        </div>

                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-5">

                            {{-- Avatar --}}
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                <img
                                        src="{{ $fotoIjazah ?? asset('assets/img/avatars/1.png') }}"
                                        alt="user image"
                                        class="d-block ms-0 ms-sm-5 rounded-4 user-profile-img"
                                        style="width: 105px; height: 140px; object-fit: cover;"
                                />
                            </div>

                            <div class="flex-grow-1 mt-4 mt-sm-12">

                                <div class="d-flex align-items-md-end
                                        align-items-sm-start
                                        align-items-center
                                        justify-content-md-between
                                        justify-content-start
                                        mx-5
                                        flex-md-row
                                        flex-column
                                        gap-6">

                                    <div class="user-profile-info">

                                        <h4 class="mb-2">
                                            {{ $dpAlumni->nama_mahasiswa ?? '-' }}
                                        </h4>

                                        <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">

                                            <li class="list-inline-item">
                                                <i class="icon-base ri ri-building-line me-2 icon-24px"></i>
                                                <span class="fw-medium">
                                                {{ $dpAlumni->nama_fakultas ?? '-' }}
                                            </span>
                                            </li>

                                            <li class="list-inline-item">
                                                <i class="icon-base ri ri-graduation-cap-line me-2 icon-24px"></i>

                                                <span class="fw-medium">
                                                {{ $dpAlumni->nama_program_studi ?? '-' }}
                                            </span>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="icon-base ri ri-calendar-check-line me-2 icon-24px"></i>

                                                <span class="fw-medium">
                                                Masa Yudisium {{ $dpAlumni->masa_yudisium ?? '-' }}
                                            </span>
                                            </li>

                                        </ul>

                                    </div>

                                    <span class="badge bg-label-success fs-6">
                                    <i class="icon-base ri ri-graduation-cap-line me-1"></i>
                                    Alumni
                                </span>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- ====================================================== --}}
            {{-- NAVIGATION --}}
            {{-- ====================================================== --}}

            <div class="row">
                <div class="col-md-12">

                    <div class="nav-align-top">

                        <ul class="nav nav-pills flex-column flex-sm-row mb-6 row-gap-2">

                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0);"><i class="icon-base ri ri-user-3-line icon-sm me-2"></i>Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-base ri ri-team-line icon-sm me-2"></i>Surat Keterangan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-base ri ri-computer-line icon-sm me-2"></i>Legalisir</a>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>

            {{-- ====================================================== --}}
            {{-- PROFILE CONTENT --}}
            {{-- ====================================================== --}}

            <div class="row">

                {{-- LEFT COLUMN --}}
                <div class="col-xl-4 col-lg-5 col-md-5">

                    {{-- DATA PRIBADI --}}
                    <div class="card mb-6">

                        <div class="card-body">

                            <small class="card-text text-uppercase text-body-secondary">
                                Data Pribadi
                            </small>

                            <ul class="list-unstyled my-3 py-1">

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-id-card-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    NIM:
                                </span>

                                    <span>
                                    {{ $dpAlumni->nim ?? '-' }}
                                </span>
                                </li>

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-user-3-line icon-24px"></i>
                                    <span class="fw-medium mx-2">Nama:</span>
                                    <span>{{ $dpAlumni->nama_mahasiswa ?? '-' }}</span>
                                </li>

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-cake-2-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    TTL:
                                </span>

                                    <span>
                                    {{ $dpAlumni->tempat_tanggal_lahir }}
                                </span>
                                </li>

                            </ul>

                            <hr>

                            <small class="card-text text-uppercase text-body-secondary">
                                Akademik
                            </small>

                            <ul class="list-unstyled my-3 py-1">

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-building-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Fakultas:
                                </span>

                                    <span>
                                    {{ $dpAlumni->nama_fakultas ?? '-' }}

                                        @if (!empty($dpAlumni->singkatan_fakultas))
                                            ({{ $dpAlumni->singkatan_fakultas }})
                                        @endif
                                </span>
                                </li>

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-book-open-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Program Studi:
                                </span>

                                    <span>
                                    {{ $dpAlumni->nama_singkat_ps ?? '-' }}
                                </span>
                                </li>

                                <li class="d-flex align-items-start">
                                    <i class="icon-base ri ri-graduation-cap-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Jenjang:
                                </span>

                                    <span>
                                    {{ $dpAlumni->nama_jenjang ?? '-' }}
                                </span>
                                </li>

                            </ul>

                            <hr>

                            <small class="card-text text-uppercase text-body-secondary">
                                Kontak
                            </small>

                            <ul class="list-unstyled my-3 py-1">

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-phone-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Telepon:
                                </span>

                                    <span>
                                    {{ $dpAlumni->hp ?? '-' }}
                                </span>
                                </li>

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-whatsapp-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    WhatsApp:
                                </span>

                                    <span>
                                    {{ $dpAlumni->wa ?? '-' }}
                                </span>
                                </li>

                                <li class="d-flex align-items-start">
                                    <i class="icon-base ri ri-mail-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Email:
                                </span>

                                    <span class="text-break">
                                    {{ $dpAlumni->email ?? '-' }}
                                </span>
                                </li>

                            </ul>

                        </div>

                    </div>

                    {{-- KELULUSAN --}}
                    <div class="card mb-6">

                        <div class="card-body">

                            <small class="card-text text-uppercase text-body-secondary">
                                Kelulusan
                            </small>

                            <ul class="list-unstyled mb-0 mt-3 pt-1">

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-calendar-check-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Masa Yudisium:
                                </span>

                                    <span>
                                    {{ $dpAlumni->masa_yudisium ?? '-' }}
                                </span>
                                </li>

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-file-text-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Nomor SK:
                                </span>

                                    <span>
                                    {{ $dpAlumni->nomor_sk_rektor ?? '-' }}
                                </span>
                                </li>

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-calendar-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Tanggal SK:
                                </span>

                                    <span>
                                {{ $dpAlumni->skRektor?->tanggal_sk_format ?? '-' }}
                                </span>
                                </li>

                                <li class="d-flex align-items-start mb-4">
                                    <i class="icon-base ri ri-award-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    Nomor Ijazah:
                                </span>

                                    <span>
                                    {{ $dpAlumni->nomor_ijazah ?? '-' }}
                                </span>
                                </li>

                                @if (!empty($dpAlumni->nomor_ijazah_akta))

                                    <li class="d-flex align-items-start mb-4">
                                        <i class="icon-base ri ri-file-certificate-line icon-24px"></i>

                                        <span class="fw-medium mx-2">
                                        Nomor Ijazah Akta:
                                    </span>

                                        <span>
                                        {{ $dpAlumni->nomor_ijazah_akta }}
                                    </span>
                                    </li>

                                @endif

                                <li class="d-flex align-items-start">
                                    <i class="icon-base ri ri-star-line icon-24px"></i>

                                    <span class="fw-medium mx-2">
                                    IPK:
                                </span>

                                    <span class="fw-medium">
                                    {{ $dpAlumni->ipk ?? '-' }}
                                </span>
                                </li>

                            </ul>

                        </div>
                    </div>

                </div>

                {{-- ================================================== --}}
                {{-- RIGHT COLUMN --}}
                {{-- ================================================== --}}

                <div class="col-xl-8 col-lg-7 col-md-7">

                    {{-- PEMBERKASAN --}}
                    <div class="card card-action mb-6">

                        <div class="card-header align-items-center">

                            <h5 class="card-action-title mb-0">
                                <i class="icon-base ri ri-folder-check-line icon-24px text-body me-2"></i>
                                Pemberkasan
                            </h5>

                        </div>

                        <div class="card-body pt-5">

                            <ul class="timeline card-timeline mb-0">

                                {{-- SK REKTOR --}}
                                <li class="timeline-item timeline-item-transparent">

                                    <span class="timeline-point timeline-point-primary"></span>

                                    <div class="timeline-event">

                                        <div class="timeline-header mb-2">
                                            <h6 class="mb-0">
                                                SK Rektor
                                            </h6>
                                            <small class="text-body-secondary">
                                                {{ $dpAlumni->skRektor?->tanggal_sk_format ?? '-' }}
                                            </small>
                                        </div>

                                        <p class="mb-0">
                                            Nomor:
                                            <span class="fw-medium">
                                            {{ $dpAlumni->nomor_sk_rektor ?? '-' }}
                                        </span>
                                        </p>

                                    </div>

                                </li>

                                {{-- Surat Pernyataan --}}
                                <li class="timeline-item timeline-item-transparent">

                                    <span class="timeline-point timeline-point-danger"></span>

                                    <div class="timeline-event">
                                        <div class="timeline-header mb-2">
                                            <h6 class="mb-0">Surat Pernyataan</h6>
                                        </div>

                                        <p class="mb-3">
                                            Unggah dan periksa Surat Pernyataan sebagai bagian dari proses kelulusan.
                                        </p>

                                        @if (($data->flag_surat ?? 0) == 1)

                                            {{-- Sudah mengisi/upload surat --}}
                                            <button
                                                    type="button"
                                                    class="btn btn-sm btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalLihatSuratPernyataan">
                                                <i class="ri-file-pdf-2-line me-1"></i>
                                                Lihat Surat Pernyataan
                                            </button>

                                        @else

                                            {{-- Belum mengisi/upload surat --}}
                                            <a href="{{ route('alumni-validasi.index') }}"
                                               type="button" class="btn btn-warning waves-effect waves-light"></i>
                                                Isi Surat Pernyataan

                                            </a>

                                        @endif
                                    </div>

                                </li>

                                {{-- Ijazah --}}
                                <li class="timeline-item timeline-item-transparent">

                                    <span class="timeline-point timeline-point-success"></span>

                                    <div class="timeline-event">

                                        <div class="timeline-header mb-2">
                                            <h6 class="mb-0">Ijazah</h6>
                                        </div>

                                        <p class="mb-3">Nomor:
                                            <span class="fw-medium">{{ $dpAlumni->nomor_ijazah ?? '-' }}</span>
                                        </p>

                                        {{-- Foto Ijazah --}}
                                        <div class="d-flex align-items-center gap-3 flex-wrap">

                                            <div
                                                    class="border rounded-3 overflow-hidden bg-label-secondary d-flex align-items-center justify-content-center"
                                                    style="width: 90px; height: 120px;"
                                            >
                                                <img
                                                        id="previewFotoIjazah"
                                                        src=""
                                                        alt="Foto Ijazah"
                                                        class="d-none w-100 h-100"
                                                        style="object-fit: cover;"
                                                >

                                                <i
                                                        id="placeholderFotoIjazah"
                                                        class="ri ri-user-3-line"
                                                        style="font-size: 38px;"
                                                ></i>
                                            </div>

                                            <div>

                                                <button
                                                        type="button"
                                                        class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalFotoIjazah"
                                                >
                                                    <i class="ri ri-camera-line me-1"></i>
                                                    Unggah Foto
                                                </button>

                                                <div class="text-body-secondary mt-2">
                                                    <small>
                                                        Foto untuk ijazah dengan rasio 3:4
                                                    </small>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </li>

                                {{-- STATUS DATA --}}
                                <li class="timeline-item timeline-item-transparent">

                                    <span class="timeline-point timeline-point-info"></span>

                                    <div class="timeline-event">

                                        <div class="timeline-header mb-2">

                                            <h6 class="mb-0">
                                                Data Alumni
                                            </h6>

                                        </div>

                                        <span class="badge bg-label-success">
                                        <i class="icon-base ri ri-checkbox-circle-line me-1"></i>
                                        Data Tersedia
                                    </span>

                                    </div>

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    {{-- ====================================================== --}}
    {{-- MODAL UPLOAD FOTO IJAZAH --}}
    {{-- ====================================================== --}}

    <div
            class="modal fade"
            id="modalFotoIjazah"
            tabindex="-1"
            aria-labelledby="modalFotoIjazahLabel"
            aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title" id="modalFotoIjazahLabel">
                            <i class="ri ri-camera-line me-1"></i>
                            Foto Ijazah
                        </h5>

                        <small class="text-body-secondary">
                            Pilih dan sesuaikan posisi foto dengan ukuran 3:4
                        </small>
                    </div>

                    <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                    ></button>

                </div>

                <div class="modal-body">

                    {{-- Pilih Foto --}}
                    <div id="areaPilihFoto" class="text-center py-4">

                        <div class="mb-3">

                            <div
                                    class="bg-label-primary rounded-circle d-inline-flex
                                   align-items-center justify-content-center"
                                    style="width: 70px; height: 70px;"
                            >
                                <i
                                        class="ri ri-image-add-line text-primary"
                                        style="font-size: 32px;"
                                ></i>
                            </div>

                        </div>

                        <h6 class="mb-1">
                            Pilih Foto
                        </h6>

                        <p class="text-body-secondary mb-4">
                            Gunakan foto yang jelas dan memiliki resolusi yang baik.
                        </p>

                        <input
                                type="file"
                                id="inputFotoIjazah"
                                accept="image/jpeg,image/png"
                                class="d-none">

                        <button type="button"
                                id="btnPilihFotoIjazah"
                                class="btn btn-primary">
                            <i class="ri ri-folder-image-line me-1"></i>
                            Pilih Foto
                        </button>

                        <div class="mt-3">
                            <small class="text-body-secondary">
                                Format JPG/PNG, maksimal 5 MB
                            </small>
                        </div>

                    </div>

                    {{-- Area Crop --}}
                    <div id="areaCropFoto" class="d-none">

                        <div class="alert alert-info d-flex align-items-start" role="alert">
                            <i class="ri ri-information-line me-2 mt-1"></i>

                            <div>
                                Geser atau perbesar foto hingga posisi sesuai.
                                Area pemotongan dikunci pada rasio
                                <strong>3:4</strong>.
                            </div>
                        </div>

                        <div id="cropperContainer">
                            <img id="imageCropperIjazah" src="" alt="Preview foto">
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-body-secondary">
                                Hasil foto menggunakan rasio
                                <strong>3:4</strong>
                                dengan ukuran
                                <strong>600 × 800 pixel</strong>.
                            </small>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                    <button
                            type="button"
                            class="btn btn-label-secondary"
                            data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                            type="button"
                            id="btnGantiFoto"
                            class="btn btn-label-primary d-none"
                    >
                        <i class="ri ri-image-edit-line me-1"></i>
                        Ganti Foto
                    </button>

                    <button
                            type="button"
                            id="btnGunakanFoto"
                            class="btn btn-primary d-none"
                    >
                        <i class="ri ri-crop-line me-1"></i>
                        Gunakan Foto
                    </button>

                </div>

            </div>

        </div>
    </div>


    {{-- Hasil cropping --}}
    <input
            type="hidden"
            name="foto_ijazah"
            id="fotoIjazahCropped"
    >
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {

        // =========================================================
        // ELEMENT
        // =========================================================

        const modalElement = document.getElementById('modalFotoIjazah');

        const inputFoto = document.getElementById('inputFotoIjazah');

        const btnPilihFoto = document.getElementById('btnPilihFotoIjazah');
        const btnGantiFoto = document.getElementById('btnGantiFoto');
        const btnGunakanFoto = document.getElementById('btnGunakanFoto');

        const areaPilihFoto = document.getElementById('areaPilihFoto');
        const areaCropFoto = document.getElementById('areaCropFoto');

        const imageCropper = document.getElementById('imageCropperIjazah');

        const previewFoto = document.getElementById('previewFotoIjazah');
        const placeholderFoto = document.getElementById('placeholderFotoIjazah');

        let cropper = null;


        // =========================================================
        // CEK ELEMENT
        // =========================================================

        if (!modalElement) {
          console.error('#modalFotoIjazah tidak ditemukan.');
          return;
        }

        if (!inputFoto) {
          console.error('#inputFotoIjazah tidak ditemukan.');
          return;
        }

        if (!btnPilihFoto) {
          console.error('#btnPilihFotoIjazah tidak ditemukan.');
          return;
        }

        if (!imageCropper) {
          console.error('#imageCropperIjazah tidak ditemukan.');
          return;
        }

        if (!btnGunakanFoto) {
          console.error('#btnGunakanFoto tidak ditemukan.');
          return;
        }

        if (typeof Cropper === 'undefined') {
          console.error('Library CropperJS tidak ditemukan.');
          return;
        }


        // =========================================================
        // PILIH FOTO
        // =========================================================

        btnPilihFoto.addEventListener('click', function() {

          inputFoto.click();

        });
        // =========================================================
        // FOTO DIPILIH
        // =========================================================

        inputFoto.addEventListener('change', function(event) {

          const file = event.target.files[0];

          // if (!file) {
          //   return;
          // }


          // -----------------------------------------------------
          // VALIDASI TYPE
          // -----------------------------------------------------

          const allowedTypes = [
            'image/jpeg',
            'image/png'
          ];

          if (!allowedTypes.includes(file.type)) {

            alert('Foto harus berformat JPG atau PNG.');

            inputFoto.value = '';

            return;
          }


          // -----------------------------------------------------
          // VALIDASI SIZE
          // -----------------------------------------------------

          const maxSize = 5 * 1024 * 1024;

          if (file.size > maxSize) {

            alert('Ukuran foto maksimal 5 MB.');

            inputFoto.value = '';

            return;
          }


          // -----------------------------------------------------
          // FILE READER
          // -----------------------------------------------------

          const reader = new FileReader();


          reader.onload = function(e) {

            if (cropper) {

              cropper.destroy();

              cropper = null;
            }


            // -------------------------------------------------
            // TAMPILKAN AREA CROPPER
            // -------------------------------------------------

            areaPilihFoto.classList.add('d-none');

            areaCropFoto.classList.remove('d-none');

            btnGantiFoto.classList.remove('d-none');

            btnGunakanFoto.classList.remove('d-none');


            // -------------------------------------------------
            // IMAGE LOAD
            // -------------------------------------------------

            imageCropper.onload = function() {

              if (cropper) {

                cropper.destroy();

                cropper = null;
              }


              // ---------------------------------------------
              // CROPPER
              // ---------------------------------------------

              cropper = new Cropper(imageCropper, {

                aspectRatio: 3 / 4,

                viewMode: 1,

                dragMode: 'move',

                autoCropArea: 0.85,

                responsive: true,

                restore: false,

                guides: true,

                center: true,

                highlight: false,

                background: false,

                movable: true,

                zoomable: true,

                zoomOnWheel: true,

                cropBoxMovable: true,

                cropBoxResizable: false,

                toggleDragModeOnDblclick: false,

                ready: function() {

                  console.log(
                    'CropperJS berhasil dibuat.'
                  );

                }

              });

            };


            // -------------------------------------------------
            // SET FOTO
            // -------------------------------------------------

            imageCropper.src = e.target.result;

          };


          reader.onerror = function() {

            alert('Foto gagal dibaca.');

          };


          reader.readAsDataURL(file);

        });


        // =========================================================
        // GANTI FOTO
        // =========================================================

        btnGantiFoto.addEventListener('click', function() {

          if (cropper) {

            cropper.destroy();

            cropper = null;
          }

          imageCropper.removeAttribute('src');

          inputFoto.value = '';

          areaCropFoto.classList.add('d-none');

          areaPilihFoto.classList.remove('d-none');

          btnGunakanFoto.classList.add('d-none');

          btnGantiFoto.classList.add('d-none');


          // Langsung buka file picker
          setTimeout(function() {

            inputFoto.click();

          }, 100);

        });


        // =========================================================
        // GUNAKAN FOTO
        // =========================================================

        btnGunakanFoto.addEventListener('click', function() {

          if (!cropper) {

            alert('Silakan pilih dan crop foto terlebih dahulu.');

            return;
          }


          // -----------------------------------------------------
          // HASIL CROP
          // -----------------------------------------------------

          const canvas = cropper.getCroppedCanvas({

            width: 600,

            height: 800,

            imageSmoothingEnabled: true,

            imageSmoothingQuality: 'high'

          });


          if (!canvas) {

            alert('Gagal memproses foto.');

            return;
          }


          // -----------------------------------------------------
          // CONVERT KE JPEG
          // -----------------------------------------------------

          canvas.toBlob(
            async function(blob) {

              if (!blob) {

                alert('Gagal membuat file JPG.');

                return;
              }


              // =============================================
              // FILE JPG
              // =============================================

              const file = new File(
                [blob],

                'foto-ijazah.jpg',

                {
                  type: 'image/jpeg',
                  lastModified: Date.now()
                }
              );


              console.log(
                'File hasil Crop:',
                file
              );


              // =============================================
              // FORMDATA
              // =============================================

              const formData = new FormData();

              formData.append(
                'foto_ijazah',
                file
              );


              // =============================================
              // CSRF
              // =============================================

              const csrfElement = document.querySelector(
                'meta[name="csrf-token"]'
              );


              if (!csrfElement) {

                alert('CSRF token tidak ditemukan.');

                return;
              }


              const csrfToken = csrfElement.getAttribute(
                'content'
              );


              // =============================================
              // LOADING BUTTON
              // =============================================

              const oldButtonHtml = btnGunakanFoto.innerHTML;

              btnGunakanFoto.disabled = true;

              btnGunakanFoto.innerHTML = `
                    <span
                        class="spinner-border spinner-border-sm me-1"
                        role="status"
                        aria-hidden="true">
                    </span>

                    Menyimpan...
                `;


              try {

                // =========================================
                // FETCH
                // =========================================

                const response = await fetch(
                  "{{ route('alumni.foto-ijazah') }}",

                  {

                    method: 'POST',

                    headers: {

                      'X-CSRF-TOKEN': csrfToken,

                      'Accept': 'application/json'

                    },

                    body: formData

                  }
                );


                // =========================================
                // JANGAN LANGSUNG response.json()
                // =========================================

                const responseText = await response.text();


                console.log(
                  'HTTP Status:',
                  response.status
                );

                console.log(
                  'Response Laravel:',
                  responseText
                );


                // =========================================
                // RESPONSE KOSONG
                // =========================================

                // if (!responseText.trim()) {
                //
                //   throw new Error(
                //     'Server memberikan response kosong. HTTP '
                //     + response.status
                //   );
                //
                // }

                if (!responseText.trim()) {
                  console.error(`Server memberikan response kosong. HTTP ${response.status}`);
                  return;
                }

                // =========================================
                // PARSE JSON
                // =========================================

                let data;


                // try {
                //
                //   data = JSON.parse(responseText);
                //
                // } catch (parseError) {
                //
                //   console.error(
                //     'Response bukan JSON:',
                //     responseText
                //   );
                //
                //   throw new Error(
                //     'Response server bukan JSON. HTTP '
                //     + response.status
                //   );
                //
                // }

                try {
                  data = JSON.parse(responseText);
                } catch (parseError) {
                  console.error('Response bukan JSON:', responseText);
                  console.error('Parse error:', parseError);

                  console.error(
                    `Response server bukan JSON. HTTP ${response.status}`
                  );

                  return;
                }
                // =========================================
                // RESPONSE ERROR
                // =========================================

                if (!response.ok) {

                  let message =
                    data.message ||
                    'Foto gagal disimpan.';

// =========================================================
// UPLOAD BERHASIL
// =========================================================

                  console.log('Upload foto berhasil:', data);

// =========================================================
// TAMPILKAN FOTO YANG SUDAH TERSIMPAN
// =========================================================

                  if (previewFoto && data.url) {

                    const fotoUrl =
                      data.url +
                      '?t=' +
                      Date.now();

                    previewFoto.onload = function() {

                      console.log(
                        'Foto berhasil dimuat:',
                        fotoUrl
                      );

                    };

                    previewFoto.onerror = function() {

                      console.error(
                        'Foto gagal dimuat:',
                        fotoUrl
                      );

                    };

                    // Load foto langsung dari storage
                    previewFoto.src = fotoUrl;
                  }


                  // =========================================================
                  // TUTUP MODAL
                  // =========================================================

                  const modal = bootstrap.Modal.getOrCreateInstance(
                    modalElement
                  );

                  modal.hide();


// =========================================================
// NOTIFIKASI
// =========================================================

                  alert(
                    data.message ||
                    'Foto berhasil disimpan.'
                  );

                  // Laravel validation
                  if (data.errors) {

                    const errors = Object
                      .values(data.errors)
                      .flat();
                    if (errors.length > 0) {
                      message = errors[0];
                    }

                  }
                  // throw new Error(message);
                  console.error(message);
                  return;
                }


                // =========================================
                // BERHASIL
                // =========================================

                console.log(
                  'Upload berhasil:',
                  data
                );


                // =========================================
                // UPDATE PREVIEW
                // =========================================

                if (previewFoto) {

                  /*
                   * Menggunakan URL dari server.
                   *
                   * Timestamp ditambahkan agar browser
                   * tidak menampilkan cache foto lama.
                   */

                  previewFoto.src =
                    data.url +
                    '?t=' +
                    Date.now();


                  previewFoto.classList.remove(
                    'd-none'
                  );

                }


                // =========================================
                // HILANGKAN PLACEHOLDER
                // =========================================

                if (placeholderFoto) {

                  placeholderFoto.classList.add(
                    'd-none'
                  );

                }


                // =========================================
                // TUTUP MODAL
                // =========================================

                const modal =
                  bootstrap.Modal.getOrCreateInstance(
                    modalElement
                  );


                modal.hide();


                // =========================================
                // NOTIFIKASI
                // =========================================

                alert(
                  data.message ||
                  'Foto berhasil disimpan.'
                );


              } catch (error) {


                // =========================================
                // ERROR
                // =========================================

                console.error(
                  'Upload foto gagal:',
                  error
                );


                alert(
                  error.message ||
                  'Terjadi kesalahan saat menyimpan foto.'
                );


              } finally {


                // =========================================
                // RESET BUTTON
                // =========================================

                btnGunakanFoto.disabled = false;

                btnGunakanFoto.innerHTML =
                  oldButtonHtml;

              }

            },

            'image/jpeg',

            0.90
          );

        });


        // =========================================================
        // RESET MODAL
        // =========================================================

        modalElement.addEventListener(
          'hidden.bs.modal',
          function() {

            if (cropper) {

              cropper.destroy();

              cropper = null;

            }


            imageCropper.removeAttribute('src');

            inputFoto.value = '';


            areaCropFoto.classList.add('d-none');

            areaPilihFoto.classList.remove('d-none');


            btnGunakanFoto.classList.add('d-none');

            btnGantiFoto.classList.add('d-none');

          }
        );

      });
    </script>
@endsection
