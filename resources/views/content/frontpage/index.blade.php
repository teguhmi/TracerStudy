<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Alumni Universitas Terbuka</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo-ut-1.jpg') }}">
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ut: {
              navy: '#002B5C',
              blue: '#005BAC',
              yellow: '#FDB813'
            }
          }
        }
      }
    };
  </script>

  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    body {
      background: #f8fafc;
    }

    .hero-bg {
      background: linear-gradient(
        135deg,
        #002B5C,
        #005BAC
      );
    }

    .service-card {
      transition: .3s;
    }

    .service-card:hover {
      transform: translateY(-8px);
    }
  </style>
</head>

<body>

<!-- Navbar -->
<header
  id="navbar"
  class="fixed top-4 left-0 right-0 z-50 transition-all duration-300"
>
  <div class="max-w-7xl mx-auto px-4">

    <nav
      id="navbarContainer"
      class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-lg border border-slate-200 transition-all duration-300"
    >
      <div class="flex items-center justify-between px-5 lg:px-8 h-20">

        <!-- Logo -->
        <div class="flex items-center gap-3">

          <img
            src="{{ asset('images/logo-ut.png') }}"
            class="w-12 h-12 object-contain"
            alt="UT"
          >

          <div>
            <h1 class="font-bold text-xl text-slate-800">
              Portal Alumni UT
            </h1>

            <p class="text-sm text-slate-500">
              Universitas Terbuka
            </p>
          </div>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center gap-10">

          <a href="#layanan"
             class="font-medium text-slate-700 hover:text-blue-700 transition">
            Layanan
          </a>

          <a href="#tracer"
             class="font-medium text-slate-700 hover:text-blue-700 transition">
            Tracer Study
          </a>

          <a href="#karier"
             class="font-medium text-slate-700 hover:text-blue-700 transition">
            Karier
          </a>

          <a href="#berita"
             class="font-medium text-slate-700 hover:text-blue-700 transition">
            Berita
          </a>

        </div>

        <!-- Right Menu -->
        <div class="flex items-center gap-3">

          @if(session('alumni_authenticated'))
            <form action="{{ route('auth-logout') }}" method="POST" class="hidden lg:inline">
              @csrf
              <button
                type="submit"
                class="inline-flex items-center px-6 py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 transition">
                Logout
              </button>
            </form>
          @else
            <a
              href="{{ route('login-alumni') }}"
              class="hidden lg:inline-flex items-center px-6 py-3 rounded-xl bg-amber-400 text-slate-900 font-semibold hover:bg-amber-500 transition">
              Login
            </a>
          @endif
          <!-- Hamburger -->
          <button
            id="mobileBtn"
            class="lg:hidden w-11 h-11 flex items-center justify-center rounded-xl hover:bg-slate-100"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-7 h-7"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>

        </div>

      </div>

      <!-- Mobile Menu -->
      <div
        id="mobileMenu"
        class="hidden lg:hidden border-t border-slate-100"
      >
        <div class="flex flex-col p-5 space-y-4">

          <a href="#layanan"
             class="font-medium text-slate-700">
            Layanan
          </a>

          <a href="#tracer"
             class="font-medium text-slate-700">
            Tracer Study
          </a>

          <a href="#karier"
             class="font-medium text-slate-700">
            Karier
          </a>

          <a href="#berita"
             class="font-medium text-slate-700">
            Berita
          </a>

          <a
            href=""
            class="bg-amber-400 text-center py-3 rounded-xl font-semibold"
          >
            Login Alumni
          </a>

        </div>
      </div>

    </nav>

  </div>
</header>

<!-- HERO -->
@if($hero)

  <section class="hero-bg pt-36 pb-24 text-white">
    <div class="max-w-7xl mx-auto px-4">

      <div class="grid lg:grid-cols-2 gap-12 items-center">

        <div>

          @if($hero->badge)
            <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                        {{ $hero->badge }}
                    </span>
          @endif

          <h1 class="text-5xl lg:text-6xl font-extrabold mt-6">
            {!! nl2br(e($hero->title)) !!}
          </h1>

          <p class="mt-4 text-2xl font-semibold text-ut-yellow italic">
            {{ $hero->subtitle }}
          </p>

          <p class="mt-6 text-lg text-blue-100">
            {{ $hero->description }}
          </p>

          @if($hero->button_url)
            <div class="mt-8">
              <a href="{{ $hero->button_url }}"
                 class="bg-ut-yellow text-ut-navy px-8 py-4 rounded-xl font-bold">
                {{ $hero->button_text }}
              </a>
            </div>
          @endif

        </div>

        <div>

          <img src="{{ asset($hero->image) }}"
               alt="{{ $hero->title }}"
               class="rounded-3xl shadow-2xl">

        </div>

      </div>

    </div>
  </section>

@endif

<!-- LAYANAN -->
<section id="layanan" class="py-20 bg-gradient-to-b from-white to-slate-50">
  <div class="max-w-7xl mx-auto px-2">

    <div class="text-center mb-14">
            <span
              class="inline-block px-4 py-1 rounded-full bg-blue-100 text-ut-blue font-semibold text-sm">
                Portal Alumni UT
            </span>

      <h2 class="text-4xl md:text-5xl font-bold mt-4 text-slate-900">
        Layanan Alumni
      </h2>

      <p class="text-slate-500 mt-4 max-w-2xl mx-auto">
        Akses berbagai layanan dan informasi alumni Universitas Terbuka
        dalam satu portal yang terintegrasi.
      </p>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

      @foreach($layanans as $layanan)

        <a href="{{ $layanan->url }}"
           @if($layanan->is_external)
             target="_blank" rel="noopener noreferrer"
           @endif
           class="{{$layanan->class}}">

          <div class="w-16 h-16 rounded-2xl bg-{{ $layanan->warna }}-100 flex items-center justify-center mb-5">
            <i class="fas {{ $layanan->icon }} text-3xl text-{{ $layanan->warna }}-600"></i>
          </div>

          <h3 class="font-bold text-xl mb-2">
            {{ $layanan->nama }}
          </h3>

          @if($layanan->slug === 'dana-abadi-alumni')
            <p class="{{$layanan->text}}">
              {{ $layanan->deskripsi }}
            </p>
            <div class="mt-4 font-semibold">
              Lihat Program →
            </div>
          @else
            <p class="text-slate-500 text-sm">
              {{ $layanan->deskripsi }}
            </p>
            <div class="mt-4 font-semibold text-{{ $layanan->warna }}-600">
              Kunjungi →
            </div>
          @endif

        </a>

      @endforeach

    </div>

  </div>
</section>


<!-- TRACER -->
<section id="tracer" class="py-24">

  {{--  <div class="max-w-7xl mx-auto px-4">--}}

  {{--    <section id="tracer" class="py-20">--}}
  <div class="max-w-7xl mx-auto px-4">

    <div class="bg-gradient-to-r from-ut-navy to-ut-blue rounded-3xl overflow-hidden shadow-2xl">

      <div class="grid lg:grid-cols-2 items-center">

        <!-- Content -->
        <div class="p-8 lg:p-12 text-white">

                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 text-sm font-semibold">
                        📊 Tracer Study Alumni
                    </span>

          <h2 class="mt-5 text-3xl lg:text-5xl font-extrabold leading-tight">
            Suara Alumni,
            Masa Depan UT
          </h2>

          <p class="mt-5 text-blue-100 leading-relaxed text-lg">
            Partisipasi Alumni membantu Universitas Terbuka
            meningkatkan kualitas layanan, kurikulum,
            dan relevansi lulusan dengan dunia kerja.
          </p>

          <div class="mt-8 flex flex-wrap gap-4">

            <a href="{{route('tracer.index')}}"
               target="_blank" rel="noopener noreferrer"
               class="px-8 py-4 bg-ut-yellow text-ut-navy rounded-xl font-bold hover:scale-105 transition">
              Isi Tracer Study
            </a>

            <div class="flex items-center text-sm text-blue-100">
              🎓 Untuk seluruh Alumni UT
            </div>

          </div>

        </div>

        <!-- Image -->
        <div class="h-full">
          <img src="{{ asset('images/tracer1.png') }}"
               alt="Tracer Study Alumni UT"
               class="w-full h-full object-cover">
        </div>

      </div>

    </div>

  </div>
</section>

<!-- BERITA -->
<section id="berita" class="py-20 bg-white">

  <div class="max-w-7xl mx-auto px-4">

    <h2 class="text-4xl font-bold text-center mb-12">
      Berita Alumni
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

      <article class="shadow rounded-3xl overflow-hidden">
        <img src="berita1.jpg" alt="">
        <div class="p-6">
          <h3 class="font-bold text-lg">
            Gathering Alumni Nasional UT
          </h3>
        </div>
      </article>

      <article class="shadow rounded-3xl overflow-hidden">
        <img src="berita2.jpg" alt="">
        <div class="p-6">
          <h3 class="font-bold text-lg">
            Peluang Karier Alumni
          </h3>
        </div>
      </article>

      <article class="shadow rounded-3xl overflow-hidden">
        <img src="berita3.jpg" alt="">
        <div class="p-6">
          <h3 class="font-bold text-lg">
            Alumni Berprestasi UT
          </h3>
        </div>
      </article>

    </div>

  </div>

</section>

<!-- CTA -->
<section class="py-20">

  <div class="max-w-4xl mx-auto px-4">

    <div class="bg-ut-navy text-white rounded-3xl text-center p-12">

      <h2 class="text-4xl font-bold">
        Sudah Memperbarui Data Alumni?
      </h2>

      <p class="mt-4">
        Pastikan data Anda selalu terbaru.
      </p>

      <a href="https://myut-alumni.ut.ac.id"
         class="inline-block mt-8 bg-ut-yellow text-ut-navy px-8 py-4 rounded-xl font-bold">
        Login Alumni
      </a>

    </div>

  </div>

</section>

<!-- FOOTER -->
<footer class="relative overflow-hidden bg-gradient-to-r from-[#001B5E] via-[#003B8E] to-[#0057B8] text-white">

  <!-- Glow Background -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-0 left-0 w-72 h-72 bg-yellow-400 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
  </div>

  <div class="relative max-w-7xl mx-auto px-6 py-16">

    <div class="grid lg:grid-cols-4 gap-12">

      <!-- Brand -->
      <div>
        <div class="flex items-center gap-3 mb-4">
          <img src="{{ asset('images/logo-ut.png') }}"
               class="h-14"
               alt="Universitas Terbuka">
          <div>
            <h3 class="font-bold text-2xl">
              Portal Alumni UT
            </h3>
          </div>
        </div>

        <p class="text-white/80 leading-relaxed">
          Unit Pemberdayaan Alumni, Sentra Karier dan Penempatan Kerja
          Universitas Terbuka.
        </p>

        <div
          class="mt-5 inline-flex items-center gap-2 bg-yellow-400 text-slate-900 px-4 py-2 rounded-full font-semibold">
          <i class="fas fa-graduation-cap"></i>
          Untuk Alumni, Oleh Alumni
        </div>
      </div>

      <!-- Layanan -->
      <div>
        <h4 class="font-bold text-xl mb-5">
          Layanan Alumni
        </h4>

        <ul class="space-y-3 text-white/80">

          <li>
            <a href="{{ route('tracer.index') }}"
               class="hover:text-yellow-300 transition">
              Tracer Study
            </a>
          </li>

          <li>
            <a href="https://myut-alumni.ut.ac.id"
               target="_blank" rel="noopener noreferrer"
               class="hover:text-yellow-300 transition">
              Profil Alumni
            </a>
          </li>

          <li>
            <a href="https://pusatkarier.ut.ac.id"
               target="_blank" rel="noopener noreferrer"
               class="hover:text-yellow-300 transition">
              Pusat Karier
            </a>
          </li>

          <li>
            <a href="https://aksi.ut.ac.id"
               target="_blank" rel="noopener noreferrer"
               class="hover:text-yellow-300 transition">
              Surat Keterangan & Legalisir
            </a>
          </li>

        </ul>
      </div>

      <!-- Kontak -->
      <div>
        <h4 class="font-bold text-xl mb-5">
          Hubungi Kami
        </h4>

        <div class="space-y-4">

          <a href="https://wa.me/{{$setting->whatsapp}}"
             target="_blank" rel="noopener noreferrer"
             class="flex items-center gap-3 p-4 rounded-xl bg-green-500 hover:bg-green-600 transition">

            <i class="fab fa-whatsapp text-2xl"></i>

            <div>
              <div class="text-sm opacity-80">
                WhatsApp
              </div>
              <div class="font-bold">
                {{$setting->whatsapp}}
              </div>
            </div>

          </a>

          <div class="flex items-center gap-3">
            <i class="fas fa-envelope text-yellow-300"></i>
            <span>{{$setting->email}}</span>
          </div>

          <div class="flex items-center gap-3">
            <i class="fas fa-phone"></i>
            <span>HALO UT {{$setting->telepon}}</span>
          </div>

        </div>
      </div>

      <!-- Social -->
      <div>
        <h4 class="font-bold text-xl mb-5">
          Ikuti Kami
        </h4>

        <p class="text-white/80 mb-5">
          Dapatkan informasi alumni, karier, kegiatan, dan peluang terbaru.
        </p>

        <div class="flex flex-wrap gap-3">

          <a href="{{$setting->instagram}}"
             target="_blank" rel="noopener noreferrer"
             class="w-12 h-12 rounded-xl bg-pink-600 flex items-center justify-center hover:scale-110 transition">
            <i class="fab fa-instagram"></i>
          </a>

          <a href="{{$setting->facebook}}"
             target="_blank" rel="noopener noreferrer"
             class="w-12 h-12 rounded-xl bg-sky-700 flex items-center justify-center hover:scale-110 transition">
            <i class="fab fa-linkedin-in"></i>
          </a>

          <a href="{{$setting->youtube}}"
             target="_blank" rel="noopener noreferrer"
             class="w-12 h-12 rounded-xl bg-red-600 flex items-center justify-center hover:scale-110 transition">
            <i class="fab fa-youtube"></i>
          </a>

        </div>

        <div class="mt-5 text-yellow-300 font-semibold">
          @ut.alumnikarier
        </div>

      </div>

    </div>

    <div class="border-t border-white/20 mt-12 pt-8 text-center text-white/70">
      © {{ date('Y') }} Universitas Terbuka • Unit Pemberdayaan Alumni, Sentra Karier dan Penempatan Kerja
    </div>

  </div>

</footer>

</body>
