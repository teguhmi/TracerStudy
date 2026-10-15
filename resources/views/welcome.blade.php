@extends('layouts/contentLayoutMaster')

@section('title', 'Portal Alumni Universitas Terbuka')

@section('content')

  <style>
    :root{
      --ut-primary:#0047BA;
      --ut-secondary:#1E88E5;
      --ut-light:#EAF3FF;
    }

    .hero-section{
      position:relative;
      overflow:hidden;
      background:linear-gradient(
        135deg,
        rgba(0,71,186,.08),
        rgba(30,136,229,.15)
      );
      padding:100px 0 80px;
      border-radius:24px;
    }

    .hero-section::before{
      content:'';
      position:absolute;
      width:700px;
      height:700px;
      border-radius:50%;
      background:rgba(0,71,186,.06);
      right:-250px;
      top:-250px;
    }

    .hero-section::after{
      content:'';
      position:absolute;
      width:400px;
      height:400px;
      border-radius:50%;
      background:rgba(30,136,229,.07);
      left:-100px;
      bottom:-180px;
    }

    .hero-title{
      color:var(--ut-primary);
      font-weight:800;
      font-size:3rem;
      line-height:1.2;
    }

    .hero-subtitle{
      font-size:1.15rem;
      color:#6c757d;
    }

    .section-title{
      font-size:2rem;
      font-weight:700;
      color:var(--ut-primary);
    }

    .feature-card{
      border:none;
      border-radius:20px;
      transition:.3s;
    }

    .feature-card:hover{
      transform:translateY(-8px);
    }

    .feature-icon{
      width:70px;
      height:70px;
      border-radius:18px;
      display:flex;
      align-items:center;
      justify-content:center;
      margin:auto;
      background:var(--ut-light);
      color:var(--ut-primary);
      font-size:32px;
    }

    .stats-card{
      border:none;
      border-radius:20px;
      text-align:center;
    }

    .stats-number{
      color:var(--ut-primary);
      font-weight:700;
      font-size:2rem;
    }

    .blue-section{
      background:var(--ut-primary);
      color:white;
      border-radius:28px;
    }

    .news-card{
      border:none;
      border-radius:18px;
      overflow:hidden;
    }

    .footer-ut{
      background:var(--ut-primary);
      color:white;
      border-radius:24px 24px 0 0;
    }

    @media(max-width:768px){

      .hero-title{
        font-size:2rem;
        text-align:center;
      }

      .hero-subtitle{
        text-align:center;
      }

      .hero-buttons{
        text-align:center;
      }

      .section-title{
        font-size:1.5rem;
      }
    }
  </style>

  {{-- HERO --}}
  <section class="hero-section mb-5">

    <div class="container position-relative">

      <div class="row align-items-center">

        <div class="col-lg-6">

                <span class="badge bg-label-primary mb-3">
                    Universitas Terbuka
                </span>

          <h1 class="hero-title mb-3">
            Portal Alumni
            Universitas Terbuka
          </h1>

          <p class="hero-subtitle mb-4">
            Menghubungkan alumni Universitas Terbuka dalam
            jaringan profesional, tracer study, pengembangan
            karier, survei alumni, dan program dana abadi.
          </p>

          <div class="hero-buttons">

            <a href=""
               class="btn btn-primary btn-lg me-2">
              Login Alumni
            </a>

            <a href="#tracer"
               class="btn btn-outline-primary btn-lg">
              Tracer Study
            </a>

          </div>

        </div>

        <div class="col-lg-6 text-center">

          <img
            src="{{ asset('assets/img/illustrations/girl-doing-yoga-light.png') }}"
            class="img-fluid"
            style="max-height:500px;">

        </div>

      </div>

    </div>

  </section>

  {{-- STATISTIK --}}
  <div class="row mb-5">

    <div class="col-md-3 mb-3">
      <div class="card shadow-sm stats-card">
        <div class="card-body">
          <div class="stats-number">2.1 Juta+</div>
          <div>Total Alumni</div>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card shadow-sm stats-card">
        <div class="card-body">
          <div class="stats-number">39</div>
          <div>UT Daerah</div>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card shadow-sm stats-card">
        <div class="card-body">
          <div class="stats-number">4</div>
          <div>Fakultas</div>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card shadow-sm stats-card">
        <div class="card-body">
          <div class="stats-number">100+</div>
          <div>Mitra Karier</div>
        </div>
      </div>
    </div>

  </div>

  {{-- LAYANAN --}}
  <div class="text-center mb-4">
    <h2 class="section-title">
      Layanan Alumni
    </h2>
  </div>

  <div class="row mb-5">

    <div class="col-lg-3 col-md-6 mb-4">

      <div class="card feature-card shadow-sm h-100">
        <div class="card-body text-center">

          <div class="feature-icon">
            <i class="ti ti-user"></i>
          </div>

          <h5 class="mt-3">
            Data Alumni
          </h5>

          <p>
            Pemutakhiran dan validasi data alumni.
          </p>

        </div>
      </div>

    </div>

    <div class="col-lg-3 col-md-6 mb-4">

      <div class="card feature-card shadow-sm h-100">
        <div class="card-body text-center">

          <div class="feature-icon">
            </p>

          </div>
        </div>

      </div>

      <div class="col-lg-3 col-md-6 mb-4">

        <div class="card feature-card shadow-sm h-100">
          <div class="card-body text-center">

            <div class="feature-icon">
              <i class="ti ti-building-community"></i>
            </div>

            <h5 class="mt-3">
              Survey Fakultas
            </h5>

            <p>
              Evaluasi kualitas lulusan dan umpan balik.
            </p>

          </div>
        </div>

      </div>

      <div class="col-lg-3 col-md-6 mb-4">

        <div class="card feature-card shadow-sm h-100">
          <div class="card-body text-center">

            <div class="feature-icon">
              <i class="ti ti-heart-handshake"></i>
            </div>

            <h5 class="mt-3">
              Dana Abadi
            </h5>

            <p>
              Program kontribusi dan beasiswa alumni.
            </p>

          </div>
        </div>

      </div>

    </div>

    {{-- TRACER --}}
    <section id="tracer" class="card shadow-sm border-0 mb-5">

      <div class="card-body p-5">

        <div class="row align-items-center">

          <div class="col-lg-7">

            <h2 class="section-title mb-3">
              Tracer Study Alumni
            </h2>

            <p>
              Tracer Study merupakan kegiatan pelacakan alumni
              untuk memperoleh informasi tentang masa tunggu kerja,
              kesesuaian pekerjaan, kompetensi lulusan dan
              evaluasi kurikulum Universitas Terbuka.
            </p>

            #
            Isi Tracer Study
            </a>

          </div>

          <div class="col-lg-5 text-center">

            <i class="ti ti-chart-pie-2"
               style="font-size:180px;color:#0047BA;">
            </i>

          </div>

        </div>

      </div>

    </section>

    {{-- SURVEY --}}
    <div class="blue-section p-5 mb-5">

      <div class="row align-items-center">

        <div class="col-md-8">

          <h2 class="mb-3 text-white">
            Survey Fakultas
          </h2>

          <p>
            Survey dilakukan untuk memperoleh masukan
            dari alumni dan pengguna lulusan mengenai
            kompetensi, kualitas layanan akademik,
            dan kebutuhan dunia kerja.
          </p>

        </div>

        <div class="col-md-4 text-center">

          <i class="ti ti-clipboard-text"
             style="font-size:150px;">
          </i>

        </div>

      </div>

    </div>

    {{-- DANA ABADI --}}
    <div class="card border-0 shadow-sm mb-5">

      <div class="card-body p-5">

        <div class="row align-items-center">

          <div class="col-lg-8">

            <h2 class="section-title">
              Dana Abadi Alumni
            </h2>

            <p>
              Dana Abadi Alumni merupakan bentuk kepedulian alumni
              dalam mendukung pengembangan Universitas Terbuka,
              bantuan pendidikan, kegiatan akademik,
              dan penguatan layanan kemahasiswaan.
            </p>

            #
            Donasi Sekarang
            </a>

          </div>

          <div class="col-lg-4 text-center">

            <i class="ti ti-coins"
               style="font-size:160px;color:#28a745;">
            </i>

          </div>

        </div>

      </div>

    </div>

    {{-- BERITA --}}
    <div class="text-center mb-4">
      <h2 class="section-title">
        Berita & Informasi
      </h2>
    </div>

    <div class="row mb-5">

      @for($i=1;$i<=3;$i++)
        <div class="col-lg-4 mb-4">

          <div class="card news-card shadow-sm">

            https://picsum.photos/600/300?random={{ $i }}

            <div class="card-body">

              <h5>
                Kegiatan Alumni Universitas Terbuka
              </h5>

              <p class="text-muted">
                Informasi terbaru mengenai kegiatan
                alumni dan pengembangan karier.
              </p>

            </div>

          </div>

        </div>
      @endfor

    </div>

    {{-- FOOTER --}}
    <footer class="footer-ut">

      <div class="container py-5">

        <div class="row">

          <div class="col-lg-6 mb-4">

            <h3>
              Unit Pemberdayaan Alumni,
              Sentra Karier dan Penempatan Kerja
            </h3>

            <p class="mb-0">
              Jl. Cabe Raya, Pondok Cabe,
              Pamulang, Tangerang Selatan,
              Banten, Indonesia.
            </p>

          </div>

          <div class="col-lg-3 mb-4">

            <h5>Kontak</h5>

            <p class="mb-1">
              Hallo UT 1500024
            </p>

            <p class="mb-1">
              alumni@ecampus.ut.ac.id
            </p>

            <p>
              0851-1055-6158
            </p>

          </div>

          <div class="col-lg-3">

            <h5>Media Sosial</h5>

            <div class="d-flex gap-3 fs-3">

              <i class="ti ti-brand-facebook"></i>
              <i class="ti ti-brand-instagram"></i>
              <i class="ti ti-brand-youtube"></i>
              <i class="ti ti-brand-linkedin"></i>

            </div>

          </div>

        </div>

        <hr class="bg-white">

        <div class="text-center">
          © {{ date('Y') }} Universitas Terbuka
        </div>

      </div>

    </footer>

@endsection
