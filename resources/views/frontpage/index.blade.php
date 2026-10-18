<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Alumni Universitas Terbuka</title>

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
    }
  </script>

  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    body {
      background:#f8fafc;
    }

    .hero-bg{
      background:
        linear-gradient(
          135deg,
          #002B5C,
          #005BAC
        );
    }

    .service-card{
      transition:.3s;
    }

    .service-card:hover{
      transform:translateY(-8px);
    }
  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 bg-white shadow z-50">

  <div class="max-w-7xl mx-auto px-4">

    <div class="h-20 flex items-center justify-between">

      <a href="#"
         class="flex items-center gap-3">

        <img src="{{asset('images/logo-ut.png')}}"
             alt="UT"
             class="h-12">

        <div>
          <h1 class="font-bold text-ut-navy">
            Portal Alumni UT
          </h1>

          <small class="text-slate-500">
            Universitas Terbuka
          </small>
        </div>

      </a>

      <div class="hidden lg:flex items-center gap-8">

        <a href="#layanan">Layanan</a>
        <a href="#tracer">Tracer Study</a>
        <a href="#karier">Karier</a>
        <a href="#berita">Berita</a>

      </div>

      @if(session('alumni_authenticated'))

          <a href="{{ route('auth-logout') }}"
             class="bg-ut-yellow px-5 py-3 rounded-xl font-semibold">
            Logout
          </a>

      @else

        <a href="{{ route('login-alumni') }}"
           class="bg-ut-yellow px-5 py-3 rounded-xl font-semibold">
          Login Alumni
        </a>

      @endif

    </div>

  </div>

</nav>

<!-- HERO -->
<section class="hero-bg pt-36 pb-24 text-white">

  <div class="max-w-7xl mx-auto px-4">

    <div class="grid lg:grid-cols-2 gap-12 items-center">

      <div>

                <span class="bg-white/10 px-4 py-2 rounded-full text-sm">
                    UNIVERSITAS TERBUKA
                </span>

        <h1 class="text-5xl lg:text-6xl font-extrabold mt-6">
          Terhubung Kembali
          Dengan Almamater
        </h1>

        <p class="mt-6 text-lg text-blue-100">
          Portal Alumni Universitas Terbuka untuk
          tracer study, pembaruan data alumni,
          pengembangan karier, dan jejaring alumni.
        </p>

        <div class="mt-8 flex gap-4 flex-wrap">

          <a href="{{route('tracer.index')}}"
             class="bg-ut-yellow text-ut-navy px-8 py-4 rounded-xl font-bold">
            Isi Tracer Study
          </a>

{{--          <a href="{{route('tracer.index')}}"--}}
{{--             class="border border-white px-8 py-4 rounded-xl">--}}
{{--            Isi Tracer Study--}}
{{--          </a>--}}

        </div>

      </div>

      <div>

        <img src="{{asset('images/frontpage-banner.png')}}"
             alt="Alumni UT"
             class="rounded-3xl shadow-2xl">

      </div>

    </div>

  </div>

</section>

<!-- LAYANAN -->
<section id="layanan" class="py-20 bg-gradient-to-b from-white to-slate-50">
  <div class="max-w-7xl mx-auto px-4">

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

      <!-- Profil Alumni -->
      <a href="https://myut-alumni.ut.ac.id"
         target="_blank"
         class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">

        <div
          class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mb-5">
          <i class="fas fa-user text-3xl text-ut-blue"></i>
        </div>

        <h3 class="font-bold text-xl mb-2">
          Profil Alumni
        </h3>

        <p class="text-slate-500 text-sm">
          Kelola profil, data diri, riwayat pendidikan, dan informasi alumni.
        </p>

        <div class="mt-4 text-ut-blue font-semibold">
          Kunjungi →
        </div>
      </a>

      <!-- Tracer Study -->
      <a href="{{ route('tracer.index') }}"
         class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">

        <div
          class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center mb-5">
          <i class="fas fa-chart-line text-3xl text-ut-yellow"></i>
        </div>

        <h3 class="font-bold text-xl mb-2">
          Tracer Study
        </h3>

        <p class="text-slate-500 text-sm">
          Berpartisipasi dalam tracer study untuk meningkatkan kualitas lulusan UT.
        </p>

        <div class="mt-4 text-ut-yellow font-semibold">
          Isi Sekarang →
        </div>
      </a>

      <!-- Pusat Karier -->
      <a href="https://pusatkarier.ut.ac.id"
         target="_blank"
         class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">

        <div
          class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center mb-5">
          <i class="fas fa-briefcase text-3xl text-green-600"></i>
        </div>

        <h3 class="font-bold text-xl mb-2">
          Pusat Karier
        </h3>

        <p class="text-slate-500 text-sm">
          Temukan informasi lowongan kerja, magang, dan pengembangan karier.
        </p>

        <div class="mt-4 text-green-600 font-semibold">
          Jelajahi →
        </div>
      </a>

      <!-- Komunitas -->
      <div
        class="bg-white rounded-3xl p-8 shadow-lg border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

        <div
          class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mb-5">
          <i class="fas fa-users text-3xl text-purple-600"></i>
        </div>

        <h3 class="font-bold text-xl mb-2">
          Komunitas Alumni
        </h3>

        <p class="text-slate-500 text-sm">
          Terhubung dengan alumni UT dari seluruh Indonesia dan dunia.
        </p>
      </div>

      <!-- Legalisir -->
      <a href="https://aksi.ut.ac.id"
         target="_blank"
         class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-slate-100">

        <div
          class="w-16 h-16 rounded-2xl bg-orange-100 flex items-center justify-center mb-5">
          <i class="fas fa-certificate text-3xl text-orange-600"></i>
        </div>

        <h3 class="font-bold text-xl mb-2">
          Surat Keterangan & Legalisir
        </h3>

        <p class="text-slate-500 text-sm">
          Pengajuan surat keterangan, legalisir ijazah, dan layanan akademik.
        </p>

        <div class="mt-4 text-orange-600 font-semibold">
          Ajukan →
        </div>
      </a>

      <!-- Dana Abadi -->
      <a href="https://www.instagram.com/reel/DZrGfJRJqTC/?xtok=ZGxiYncwM3o0YW9r"
         class="group bg-gradient-to-br from-red-500 to-pink-500 text-white rounded-3xl p-8 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">

        <div
          class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center mb-5">
          <i class="fas fa-heart text-3xl"></i>
        </div>

        <h3 class="font-bold text-xl mb-2">
          Dana Abadi Alumni
        </h3>

        <p class="text-white/90 text-sm">
          Bersama alumni membangun masa depan Universitas Terbuka melalui Dana Abadi.
        </p>

        <div class="mt-4 font-semibold">
          Lihat Program →
        </div>
      </a>

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
                   target="_blank"
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
               target="_blank"
               class="hover:text-yellow-300 transition">
              Profil Alumni
            </a>
          </li>

          <li>
            <a href="https://pusatkarier.ut.ac.id"
               target="_blank"
               class="hover:text-yellow-300 transition">
              Pusat Karier
            </a>
          </li>

          <li>
            <a href="https://aksi.ut.ac.id"
               target="_blank"
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

          <a href="https://wa.me/6285110556158"
             target="_blank"
             class="flex items-center gap-3 p-4 rounded-xl bg-green-500 hover:bg-green-600 transition">

            <i class="fab fa-whatsapp text-2xl"></i>

            <div>
              <div class="text-sm opacity-80">
                WhatsApp
              </div>
              <div class="font-bold">
                0851-1055-6158
              </div>
            </div>

          </a>

          <div class="flex items-center gap-3">
            <i class="fas fa-envelope text-yellow-300"></i>
            <span>alumni@ut.ac.id</span>
          </div>

          <div class="flex items-center gap-3">
            <i class="fas fa-phone"></i>
            <span>HALO UT 1500024</span>
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

          <a href="https://www.instagram.com/ut.alumnikarier"
             target="_blank"
             class="w-12 h-12 rounded-xl bg-pink-600 flex items-center justify-center hover:scale-110 transition">
            <i class="fab fa-instagram"></i>
          </a>

          <a href="https://www.facebook.com/UnivTerbuka"
             target="_blank"
             class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center hover:scale-erbuka"
             target="_blank"
             class="w-12 h-12 rounded-xl bg-sky-700 flex items-center justify-center hover:scale-110 transition">
            <i class="fab fa-linkedin-in"></i>
          </a>

          <a href="https://www.youtube.com/@universitasterbukatv"
             target="_blank"
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
