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

      <a href="{{route('login')}}"
         class="bg-ut-yellow px-5 py-3 rounded-xl font-semibold">
        Login Alumni
      </a>

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

          <a href="{{route('login')}}"
             class="bg-ut-yellow text-ut-navy px-8 py-4 rounded-xl font-bold">
            Login Alumni
          </a>

          <a href="https://sila.ut.acid"
             class="border border-white px-8 py-4 rounded-xl">
            Isi Tracer Study
          </a>

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
<section id="layanan" class="py-20 bg-white">

  <div class="max-w-7xl mx-auto px-4">

    <div class="text-center mb-12">

      <h2 class="text-4xl font-bold">
        Layanan Alumni
      </h2>

      <p class="text-slate-500 mt-3">
        Seluruh layanan alumni dalam satu portal
      </p>

    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

      <div class="service-card bg-white shadow rounded-3xl p-8">
        <i class="fas fa-user text-4xl text-ut-blue"></i>
        <h3 class="font-bold mt-4">
          Profil Alumni
        </h3>
      </div>

      <div class="service-card bg-white shadow rounded-3xl p-8">
        <i class="fas fa-chart-line text-4xl text-ut-blue"></i>
        <h3 class="font-bold mt-4">
          Tracer Study
        </h3>
      </div>

      <div class="service-card bg-white shadow rounded-3xl p-8">
        <i class="fas fa-briefcase text-4xl text-ut-blue"></i>
        <h3 class="font-bold mt-4">
          Karier Alumni
        </h3>
      </div>

      <div class="service-card bg-white shadow rounded-3xl p-8">
        <i class="fas fa-users text-4xl text-ut-blue"></i>
        <h3 class="font-bold mt-4">
          Komunitas Alumni
        </h3>
      </div>

      <div class="service-card bg-white shadow rounded-3xl p-8">
        <i class="fas fa-certificate text-4xl text-ut-blue"></i>
        <h3 class="font-bold mt-4">
          Verifikasi Alumni
        </h3>
      </div>

      <div class="service-card bg-white shadow rounded-3xl p-8">
        <i class="fas fa-heart text-4xl text-ut-blue"></i>
        <h3 class="font-bold mt-4">
          Dana Abadi
        </h3>
      </div>

    </div>

  </div>

</section>



<!-- TRACER -->
<section id="tracer" class="py-24">

  <div class="max-w-7xl mx-auto px-4">

    <section id="tracer" class="py-20">
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

                <a href="https://sila.ut.ac.id"
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

      <a href="{{route('login')}}"
         class="inline-block mt-8 bg-ut-yellow text-ut-navy px-8 py-4 rounded-xl font-bold">
        Login Alumni
      </a>

    </div>

  </div>

</section>

<!-- FOOTER -->
<footer class="bg-slate-950 text-white py-16">

  <div class="max-w-7xl mx-auto px-4">

    <div class="grid lg:grid-cols-4 gap-8">

      <div>

        <h3 class="font-bold text-xl">
          Portal Alumni UT
        </h3>

        <p class="text-slate-400 mt-3">
          Universitas Terbuka
        </p>

      </div>

      <div>
        <h4 class="font-bold mb-4">Alumni</h4>
        <ul class="space-y-2 text-slate-400">
          <li>Tracer Study</li>
          <li>Karier</li>
          <li>Komunitas</li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold mb-4">Kontak</h4>
        <p>HALO UT 1500024</p>
        <p>alumni@ut.ac.id</p>
      </div>

      <div>
        <h4 class="font-bold mb-4">Media Sosial</h4>

        <div class="flex gap-4 text-xl">
          <i class="fab fa-facebook"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-youtube"></i>
          <i class="fab fa-linkedin"></i>
        </div>
      </div>

    </div>

  </div>

</footer>

</body
