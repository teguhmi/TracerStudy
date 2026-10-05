<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiaCad Digital - Portal Layanan Akademik & Administrasi Kelulusan</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        emerald: {
                            500: '#10b981',
                            600: '#059669',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .hero-gradient {
            background: radial-gradient(circle at 50% 0%, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.05) 50%, rgba(248, 250, 252, 0) 100%);
        }

        .custom-glow {
            box-shadow: 0 0 50px -12px rgba(59, 130, 246, 0.25);
        }

        /* Smooth tab transitions */
        .tab-content {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .tab-content.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body class="antialiased selection:bg-brand-500 selection:text-white">

<!-- Navigation Bar -->
<nav class="fixed top-0 left-0 right-0 z-50 glass-header border-b border-slate-200/80 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-brand-500/20 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <div>
                        <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-slate-900 via-brand-900 to-indigo-900 bg-clip-text text-transparent">
                            SiaCad<span class="text-brand-600">Digital</span>
                        </span>
                    <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Portal Akademik Terpadu</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-600">
                <a href="#beranda" class="hover:text-brand-600 transition-colors py-1">Beranda</a>
                <a href="#layanan" class="hover:text-brand-600 transition-colors py-1">Layanan Utama</a>
                <a href="#cek-status" class="hover:text-brand-600 transition-colors py-1">Cek Status NIM</a>
                <a href="#pengumuman" class="hover:text-brand-600 transition-colors py-1">Pengumuman</a>
                <a href="#statistik" class="hover:text-brand-600 transition-colors py-1">Statistik</a>
            </div>

            <!-- Action Buttons -->
            <div class="hidden lg:flex items-center space-x-3">
                <a href="#cek-status" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-brand-700 bg-brand-50 hover:bg-brand-100 transition-colors">
                    <i class="fa-solid fa-magnifying-glass mr-1.5 text-xs"></i>Cek Lulus/RPL
                </a>
                <a href="#" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 shadow-md shadow-brand-500/20 transition-all hover:-translate-y-0.5">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Login Portal
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-bars text-xl" id="menu-icon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Flyout -->
    <div id="mobile-menu" class="hidden md:hidden border-b border-slate-200 bg-white/95 backdrop-blur-xl px-4 pt-3 pb-6 space-y-3">
        <a href="#beranda" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Beranda</a>
        <a href="#layanan" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Layanan Utama</a>
        <a href="#cek-status" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Cek Status NIM</a>
        <a href="#pengumuman" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50">Pengumuman</a>
        <div class="pt-2 flex flex-col gap-2">
            <a href="#cek-status" class="w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-brand-700 bg-brand-50">
                Cek Kelulusan & RPL
            </a>
            <a href="#" class="w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600">
                Login Portal Akademik
            </a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="beranda" class="pt-32 pb-20 md:pt-40 md:pb-28 hero-gradient relative overflow-hidden">
    <!-- Floating Accent Orbs -->
    <div class="absolute top-1/4 left-10 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto space-y-6">
            <!-- Status Badge -->
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-brand-50 border border-brand-200 text-brand-700 text-xs sm:text-sm font-semibold shadow-xs">
                <span class="flex h-2 w-2 rounded-full bg-brand-600 animate-ping"></span>
                <span>Modul Integrasi LKAM & Administrasi Kelulusan v4.2</span>
            </div>

            <!-- Main Title -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                Layanan Akademik & <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">Status Kelulusan Terpadu</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal">
                Akses verifikasi cepat data **Rekognisi Pembelajaran Lampau (RPL)**, Lembar Kemajuan Akademik Mahasiswa (**LKAM**), serta informasi resmi **Administrasi Kelulusan** dalam satu pintu.
            </p>

            <!-- Global Search Box -->
            <div class="pt-4 max-w-xl mx-auto">
                <div class="relative glass-card rounded-2xl p-2 shadow-lg shadow-slate-200/60 flex items-center">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 ml-3 text-lg"></i>
                    <input type="text" id="global-search" placeholder="Cari layanan (misal: LKAM, RPL, Legalitas, Yudisium)..."
                           class="w-full bg-transparent px-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none text-sm sm:text-base">
                    <button onclick="scrollToSection('layanan')" class="px-5 py-2.5 rounded-xl bg-brand-600 text-white font-medium text-sm hover:bg-brand-700 transition-colors shadow-sm shrink-0">
                        Cari
                    </button>
                </div>
                <!-- Quick Tags -->
                <div class="flex flex-wrap items-center justify-center gap-2 mt-3 text-xs text-slate-500">
                    <span class="font-medium">Populer:</span>
                    <button onclick="quickFillSearch('Cek Kelulusan')" class="px-2.5 py-1 rounded-md bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 transition-all">Redaksi Kelulusan</button>
                    <button onclick="quickFillSearch('Transkrip RPL')" class="px-2.5 py-1 rounded-md bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 transition-all">SKS & IPK RPL</button>
                    <button onclick="quickFillSearch('Bebas Pustaka')" class="px-2.5 py-1 rounded-md bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 transition-all">Bebas Pustaka</button>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#cek-status" class="w-full sm:w-auto px-7 py-3.5 rounded-xl font-semibold text-white bg-slate-900 hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 flex items-center justify-center space-x-2">
                    <span>Cek Status NIM Mahasiswa</span>
                    <i class="fa-solid fa-arrow-down text-xs"></i>
                </a>
                <a href="#layanan" class="w-full sm:w-auto px-7 py-3.5 rounded-xl font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-all shadow-sm flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-grid-2 text-brand-600"></i>
                    <span>E-Layanan Lengkap</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- NIM Lookup Widget Section -->
<section id="cek-status" class="py-16 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <!-- Section Header -->
            <div class="text-center mb-10 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600 bg-brand-50 px-3 py-1 rounded-full">Pencarian Real-Time</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Cek Status Kelulusan & RPL Mahasiswa</h2>
                <p class="text-slate-500 text-sm sm:text-base">Masukkan Nomor Induk Mahasiswa (NIM) untuk memeriksa data LKAM, SKS/IPK RPL, serta informasi kelulusan.</p>
            </div>

            <!-- Checker Card -->
            <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-2xl custom-glow border border-slate-800">
                <form id="nim-form" onsubmit="handleNimLookup(event)" class="space-y-4">
                    <label for="nim-input" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Nomor Induk Mahasiswa (NIM)
                    </label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-grow">
                            <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" id="nim-input" placeholder="Masukkan 9 digit NIM (Contoh: 041234567)" required
                                   class="w-full pl-11 pr-4 py-3.5 bg-slate-800/90 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 font-mono tracking-wider">
                        </div>
                        <button type="submit" id="search-btn" class="px-7 py-3.5 bg-gradient-to-r from-brand-500 to-indigo-600 hover:from-brand-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md transition-all flex items-center justify-center space-x-2 shrink-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Periksa Data</span>
                        </button>
                    </div>
                </form>

                <!-- Presets / Quick Test Buttons -->
                <div class="mt-4 pt-3 border-t border-slate-800 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                    <span class="text-slate-500">Uji Coba Sample NIM:</span>
                    <button type="button" onclick="fillAndSearch('041234567')" class="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-emerald-400 font-mono border border-slate-700 transition-colors">
                        041234567 (Status Lulus)
                    </button>
                    <button type="button" onclick="fillAndSearch('049876543')" class="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-amber-400 font-mono border border-slate-700 transition-colors">
                        049876543 (Dalam Proses)
                    </button>
                    <button type="button" onclick="fillAndSearch('040000000')" class="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-rose-400 font-mono border border-slate-700 transition-colors">
                        040000000 (Tidak Ada)
                    </button>
                </div>

                <!-- Result Output Container -->
                <div id="result-container" class="hidden mt-8 pt-6 border-t border-slate-800 animate-fadeIn">

                    <!-- Student Profile Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 bg-slate-800/60 rounded-2xl border border-slate-700/60 gap-4 mb-6">
                        <div>
                            <div class="text-xs text-slate-400 uppercase font-mono tracking-wider" id="res-nim-display">NIM: -</div>
                            <h3 class="text-xl font-bold text-white mt-0.5" id="res-nama">Nama Mahasiswa</h3>
                            <p class="text-sm text-slate-300" id="res-prodi">Program Studi - Fakultas</p>
                        </div>
                        <div id="res-status-badge">
                            <!-- Dynamic Status Badge -->
                        </div>
                    </div>

                    <!-- Data Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        <!-- SKS RPL Card -->
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-700/50">
                            <div class="flex items-center justify-between text-slate-400 mb-1">
                                <span class="text-xs font-semibold uppercase">SKS RPL Diakui</span>
                                <i class="fa-solid fa-award text-brand-400"></i>
                            </div>
                            <div class="text-2xl font-extrabold text-white" id="res-sks-rpl">0 SKS</div>
                            <span class="text-[11px] text-slate-400">Hasil Konversi & Rekognisi</span>
                        </div>

                        <!-- IPK RPL Card -->
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-700/50">
                            <div class="flex items-center justify-between text-slate-400 mb-1">
                                <span class="text-xs font-semibold uppercase">IPK RPL</span>
                                <i class="fa-solid fa-chart-line text-indigo-400"></i>
                            </div>
                            <div class="text-2xl font-extrabold text-white" id="res-ipk-rpl">0.00</div>
                            <span class="text-[11px] text-slate-400">Indeks Prestasi Kumulatif RPL</span>
                        </div>

                        <!-- LKAM Synchronization -->
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-700/50 sm:col-span-2 lg:col-span-1">
                            <div class="flex items-center justify-between text-slate-400 mb-1">
                                <span class="text-xs font-semibold uppercase">Sinkronisasi LKAM</span>
                                <i class="fa-solid fa-arrows-rotate text-emerald-400"></i>
                            </div>
                            <div class="text-base font-bold text-emerald-400 flex items-center space-x-1.5" id="res-lkam-status">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                                <span>Tersinkronisasi</span>
                            </div>
                            <span class="text-[11px] text-slate-400" id="res-lkam-time">Terakhir diperbarui: Hari ini</span>
                        </div>
                    </div>

                    <!-- Redaksi Kelulusan Snippet Box -->
                    <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700/80 space-y-2">
                        <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-brand-400">
                            <i class="fa-solid fa-file-lines"></i>
                            <span>Informasi / Redaksi Kelulusan Resmi</span>
                        </div>
                        <p class="text-sm text-slate-200 leading-relaxed font-sans" id="res-redaksi-text">
                            -
                        </p>
                    </div>

                    <!-- Card Action Footer -->
                    <div class="mt-6 flex flex-wrap gap-3 justify-end">
                        <button onclick="window.print()" class="px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 transition-colors border border-slate-700">
                            <i class="fa-solid fa-print mr-1.5"></i>Cetak Ringkasan
                        </button>
                        <a href="#" id="res-download-btn" class="px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-500 text-xs font-semibold text-white transition-colors flex items-center">
                            <i class="fa-solid fa-download mr-1.5"></i>Unduh Surat Keterangan Lulus (SKL)
                        </a>
                    </div>
                </div>

                <!-- Not Found Output Container -->
                <div id="not-found-container" class="hidden mt-8 pt-6 border-t border-slate-800 text-center py-6">
                    <div class="w-14 h-14 bg-rose-500/10 text-rose-400 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white">Data Mahasiswa Tidak Ditemukan</h4>
                    <p class="text-slate-400 text-sm max-w-md mx-auto mt-1">
                        NIM yang Anda masukkan belum terdaftar dalam pangkalan data LKAM/RPL atau status administrasi belum diinput. Silakan hubungi Subbag Akademik Fakultas.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Academic Services Grid -->
<section id="layanan" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600 bg-brand-50 px-3 py-1 rounded-full">Layanan Mandiri</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Katalog Layanan Digital Utama</h2>
                <p class="text-slate-600 text-sm sm:text-base mt-1">Akses mudah dan efisien untuk kebutuhan akademik, transkrip, hingga administrasi wisuda.</p>
            </div>
            <a href="#" class="mt-4 md:mt-0 text-sm font-semibold text-brand-600 hover:text-brand-700 flex items-center space-x-1">
                <span>Lihat Semua Layanan</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        </div>

        <!-- Grid Items -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Service Card 1 -->
            <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80 group">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-brand-600 flex items-center justify-center text-xl mb-5 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-scroll"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">Transkrip & LKAM</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-700">Real-time</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Cetak dan tinjau Lembar Kemajuan Akademik Mahasiswa (LKAM) serta rekapitulasi SKS nilai secara transparan.
                </p>
                <a href="#cek-status" class="inline-flex items-center text-xs font-bold text-brand-600 hover:text-brand-700">
                    <span>Akses Layanan</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Service Card 2 -->
            <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80 group">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl mb-5 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-purple-600 transition-colors">Administrasi Kelulusan</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-700">Yudisium</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Pemeriksaan syarat kelulusan, penetapan SK Rektor, pendaftaran yudisium, dan penerbitan draft SKL.
                </p>
                <a href="#cek-status" class="inline-flex items-center text-xs font-bold text-purple-600 hover:text-purple-700">
                    <span>Cek Kelulusan</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Service Card 3 -->
            <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80 group">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl mb-5 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Pengajuan RPL</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-indigo-100 text-indigo-700">Rekognisi</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Portal konversi nilai Pengalaman Kerja & Pendidikan Formal/Informal melalui Jalur Rekognisi Pembelajaran Lampau.
                </p>
                <a href="#" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-700">
                    <span>Ajukan Berkas RPL</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Service Card 4 -->
            <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80 group">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-5 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition-colors">Bebas Pustaka & Lab</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-700">Otomatis</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Verifikasi bebas pinjaman perpustakaan dan laboratorium secara online tanpa perlu datang langsung.
                </p>
                <a href="#" class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-700">
                    <span>Verifikasi Pinjaman</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Service Card 5 -->
            <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80 group">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl mb-5 group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition-colors">Legalisir Digital</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-teal-100 text-teal-700">E-Signature</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Permohonan legalisir ijazah & transkrip bertanda tangan elektronik (TTE) terverifikasi QR Code resmi.
                </p>
                <a href="#" class="inline-flex items-center text-xs font-bold text-teal-600 hover:text-teal-700">
                    <span>Permohonan Legalisir</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Service Card 6 -->
            <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80 group">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl mb-5 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-file-contract"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-rose-600 transition-colors">Penerbitan SKPI</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-rose-100 text-rose-700">Bilingual</span>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Pengisian sertifikat kompetensi dan organisasi untuk Surat Keterangan Pendamping Ijazah standar nasional.
                </p>
                <a href="#" class="inline-flex items-center text-xs font-bold text-rose-600 hover:text-rose-700">
                    <span>Input Prestasi SKPI</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Announcement & News Section -->
<section id="pengumuman" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-600 bg-brand-50 px-3 py-1 rounded-full">Informasi Terkini</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Pengumuman & Agenda Akademik</h2>
            <p class="text-slate-500 text-sm sm:text-base mt-1">Dapatkan pembaruan terkini seputar batas kelulusan, jadwal yudisium, dan pendaftaran RPL.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            <button onclick="switchTab('semua')" class="tab-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-slate-900 text-white" data-tab="semua">
                Semua Pengumuman
            </button>
            <button onclick="switchTab('kelulusan')" class="tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-all" data-tab="kelulusan">
                🎓 Kelulusan & Yudisium
            </button>
            <button onclick="switchTab('rpl')" class="tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-all" data-tab="rpl">
                📜 Program RPL & LKAM
            </button>
            <button onclick="switchTab('beasiswa')" class="tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-all" data-tab="beasiswa">
                ⭐ Beasiswa
            </button>
        </div>

        <!-- News Grid -->
        <div id="news-container" class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Card 1: Kelulusan -->
            <div class="news-item kelulusan bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                        <span class="px-2.5 py-1 rounded-md bg-purple-100 text-purple-700 font-bold">Kelulusan</span>
                        <span><i class="fa-regular fa-calendar mr-1"></i>22 Sep 2026</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 hover:text-brand-600 cursor-pointer">
                        Jadwal Verifikasi Redaksi Kelulusan dan Yudisium Periode III Tahun 2026
                    </h3>
                    <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                        Seluruh calon wisudawan diimbau untuk memeriksa status LKAM dan memastikan tidak ada tanggungan administrasi sebelum tanggal 15 Oktober 2026.
                    </p>
                    <a href="#" class="text-xs font-bold text-brand-600 hover:underline inline-flex items-center">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: RPL -->
            <div class="news-item rpl bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                        <span class="px-2.5 py-1 rounded-md bg-indigo-100 text-indigo-700 font-bold">RPL & LKAM</span>
                        <span><i class="fa-regular fa-calendar mr-1"></i>18 Sep 2026</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 hover:text-brand-600 cursor-pointer">
                        Pembukaan Pendaftaran Jalur Rekognisi Pembelajaran Lampau (RPL) Semester Ganjil
                    </h3>
                    <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                        Kesempatan bagi praktisi dan profesional untuk melakukan konversi pengalaman kerja menjadi SKS akademik perguruan tinggi.
                    </p>
                    <a href="#" class="text-xs font-bold text-brand-600 hover:underline inline-flex items-center">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3: Beasiswa -->
            <div class="news-item beasiswa bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                        <span class="px-2.5 py-1 rounded-md bg-amber-100 text-amber-700 font-bold">Beasiswa</span>
                        <span><i class="fa-regular fa-calendar mr-1"></i>10 Sep 2026</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 hover:text-brand-600 cursor-pointer">
                        Program Beasiswa Prestasi Akademik & Bantuan Yudisium Akhir
                    </h3>
                    <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                        Pendaftaran bantuan dana pendidikan bagi mahasiswa tingkat akhir yang berprestasi dan sedang menyelesaikan tugas akhir/RPL.
                    </p>
                    <a href="#" class="text-xs font-bold text-brand-600 hover:underline inline-flex items-center">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Animated Statistics Banner -->
<section id="statistik" class="py-16 bg-slate-900 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">

            <!-- Stat 1 -->
            <div class="space-y-2 p-4">
                <div class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-indigo-400 font-mono">
                    <span class="counter" data-target="45280">0</span>+
                </div>
                <div class="text-xs sm:text-sm text-slate-400 font-medium uppercase tracking-wider">Mahasiswa Aktif</div>
            </div>

            <!-- Stat 2 -->
            <div class="space-y-2 p-4">
                <div class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-mono">
                    <span class="counter" data-target="84">0</span>
                </div>
                <div class="text-xs sm:text-sm text-slate-400 font-medium uppercase tracking-wider">Program Studi</div>
            </div>

            <!-- Stat 3 -->
            <div class="space-y-2 p-4">
                <div class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400 font-mono">
                    <span class="counter" data-target="128500">0</span>+
                </div>
                <div class="text-xs sm:text-sm text-slate-400 font-medium uppercase tracking-wider">Alumni Lulus</div>
            </div>

            <!-- Stat 4 -->
            <div class="space-y-2 p-4">
                <div class="text-3xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-400 font-mono">
                    99.8%
                </div>
                <div class="text-xs sm:text-sm text-slate-400 font-medium uppercase tracking-wider">Akurasi LKAM & RPL</div>
            </div>

        </div>
    </div>
</section>

<!-- Info & FAQ Accordion Section -->
<section class="py-20 bg-slate-50 border-t border-slate-200/80">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Panduan Administrasi Kelulusan & RPL</h2>
            <p class="text-slate-500 text-sm mt-1">Informasi penting mengenai syarat, prosedur, dan redaksi penetapan kelulusan.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 flex items-center justify-between">
                    <span>Bagaimana cara memeriksa perhitungan SKS dan IPK RPL?</span>
                    <i class="fa-solid fa-circle-question text-brand-600"></i>
                </h3>
                <p class="text-slate-600 text-sm mt-2 leading-relaxed">
                    Mahasiswa dapat memasukkan NIM pada widget "Cek Status NIM" di atas. Sistem akan terhubung ke layanan backend LKAM/RPL untuk mengambil rincian total SKS konversi serta Indeks Prestasi Kumulatif RPL secara terstruktur.
                </p>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 flex items-center justify-between">
                    <span>Apa yang dimaksud dengan Redaksi Kelulusan pada sistem?</span>
                    <i class="fa-solid fa-circle-question text-brand-600"></i>
                </h3>
                <p class="text-slate-600 text-sm mt-2 leading-relaxed">
                    Redaksi Kelulusan adalah formulasi kalimat resmi yang ditetapkan oleh Panitia Yudisium / Subbag Akademik yang menyatakan predikat dan keabsahan kelulusan mahasiswa berdasarkan Nomor SK Rektor.
                </p>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 flex items-center justify-between">
                    <span>Apa yang harus dilakukan jika data mahasiswa tidak ditemukan?</span>
                    <i class="fa-solid fa-circle-question text-brand-600"></i>
                </h3>
                <p class="text-slate-600 text-sm mt-2 leading-relaxed">
                    Jika pencarian menampilkan "Data Mahasiswa Tidak Tersedia", pastikan NIM yang diinput sudah benar. Jika NIM sudah sesuai, berkas pengajuan Anda kemungkinan sedang dalam proses input oleh staf operator administrasi.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-slate-950 text-slate-400 pt-16 pb-12 border-t border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">

            <!-- Brand Info -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white font-bold">
                        <i class="fa-solid fa-graduation-cap text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">SiaCad Digital</span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Sistem Informasi Akademik dan Portal Administrasi Kelulusan Terpadu Perguruan Tinggi. Transparan, terakreditasi, dan terintegrasi secara real-time.
                </p>
                <div class="flex space-x-3 pt-2">
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Links 1 -->
            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Layanan Utama</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#layanan" class="hover:text-white transition-colors">Transkrip & LKAM</a></li>
                    <li><a href="#cek-status" class="hover:text-white transition-colors">Cek Kelulusan (SKL)</a></li>
                    <li><a href="#layanan" class="hover:text-white transition-colors">Pengajuan Berkas RPL</a></li>
                    <li><a href="#layanan" class="hover:text-white transition-colors">Bebas Perpustakaan</a></li>
                    <li><a href="#layanan" class="hover:text-white transition-colors">Legalisir Digital TTE</a></li>
                </ul>
            </div>

            <!-- Links 2 -->
            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Portal Internal</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Login Dosen & Operator</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Administrasi Kelulusan Staf</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Verifikasi Dokumen Ijazah</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Panduan Sistem (Knowledge Base)</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Kontak Layanan</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start space-x-2.5">
                        <i class="fa-solid fa-location-dot mt-1 text-brand-500"></i>
                        <span>Gedung Rektorat Lt. 1, Jl. Pendidikan Tinggi No. 100</span>
                    </li>
                    <li class="flex items-center space-x-2.5">
                        <i class="fa-solid fa-envelope text-brand-500"></i>
                        <span>layanan.akademik@siacad.ac.id</span>
                    </li>
                    <li class="flex items-center space-x-2.5">
                        <i class="fa-solid fa-phone text-brand-500"></i>
                        <span>(021) 789-0123 / Ext. 402</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <p>&copy; 2026 SiaCad Digital. Seluruh hak cipta dilindungi undang-undang.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-slate-400">Kebijakan Privasi</a>
                <a href="#" class="hover:text-slate-400">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-slate-400">Peta Situs</a>
            </div>
        </div>
    </div>
</footer>

<!-- Embedded Interactive JavaScript -->
<script>
    // Mock Database simulating LKAM/RPL backend API responses
    const MOCK_DATABASE = {
        '041234567': {
            nama: 'Budi Santoso',
            prodi: 'S1 Teknik Informatika - Fakultas Ilmu Komputer',
            sksRpl: 24,
            ipkRpl: '3.82',
            status: 'LULUS',
            statusLabel: 'Dinyatakan Lulus (Cumlaude)',
            badgeClass: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
            redaksi: 'Berdasarkan Keputusan SK Rektor No. 842/UN/2026, mahasiswa bersangkutan telah memenuhi seluruh persyaratan akademik dan dinyatakan **LULUS** dengan Predikat Pujian (Cumlaude).'
        },
        '049876543': {
            nama: 'Siti Aminah',
            prodi: 'S1 Sistem Informasi - Fakultas Ilmu Komputer',
            sksRpl: 18,
            ipkRpl: '3.45',
            status: 'PROSES',
            statusLabel: 'Dalam Process Evaluasi RPL',
            badgeClass: 'bg-amber-500/10 text-amber-400 border-amber-500/30',
            redaksi: 'Berkas verifikasi Administrasi Kelulusan & RPL sedang dievaluasi oleh Subbag Akademik Fakultas. Harap melengkapi dokumen bebas pustaka.'
        }
    };

    // Handle NIM Form Search
    function handleNimLookup(event) {
        event.preventDefault();
        const nimInput = document.getElementById('nim-input').value.trim();
        const resultContainer = document.getElementById('result-container');
        const notFoundContainer = document.getElementById('not-found-container');

        if (!nimInput) return;

        // Simulate API lookup delay
        const searchBtn = document.getElementById('search-btn');
        searchBtn.disabled = true;
        searchBtn.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i><span>Memuat...</span>`;

        setTimeout(() => {
            searchBtn.disabled = false;
            searchBtn.innerHTML = `<i class="fa-solid fa-magnifying-glass"></i><span>Periksa Data</span>`;

            if (MOCK_DATABASE[nimInput]) {
                const data = MOCK_DATABASE[nimInput];

                document.getElementById('res-nim-display').innerText = `NIM: ${nimInput}`;
                document.getElementById('res-nama').innerText = data.nama;
                document.getElementById('res-prodi').innerText = data.prodi;
                document.getElementById('res-sks-rpl').innerText = `${data.sksRpl} SKS`;
                document.getElementById('res-ipk-rpl').innerText = data.ipkRpl;
                document.getElementById('res-redaksi-text').innerText = data.redaksi;

                document.getElementById('res-status-badge').innerHTML = `
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider border ${data.badgeClass}">
                            ${data.statusLabel}
                        </span>
                    `;

                notFoundContainer.classList.add('hidden');
                resultContainer.classList.remove('hidden');
                resultContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else if (nimInput === '040000000') {
                resultContainer.classList.add('hidden');
                notFoundContainer.classList.remove('hidden');
            } else {
                // Generate dynamic plausible data for any other custom 9-digit NIM entered
                document.getElementById('res-nim-display').innerText = `NIM: ${nimInput}`;
                document.getElementById('res-nama').innerText = 'Mahasiswa Terdaftar';
                document.getElementById('res-prodi').innerText = 'S1 Manajemen - Fakultas Ekonomi';
                document.getElementById('res-sks-rpl').innerText = '12 SKS';
                document.getElementById('res-ipk-rpl').innerText = '3.25';
                document.getElementById('res-redaksi-text').innerText = 'Data LKAM dan Administrasi Kelulusan aktif. Pengajuan predikat yudisium sedang diproses.';

                document.getElementById('res-status-badge').innerHTML = `
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider border bg-blue-500/10 text-blue-400 border-blue-500/30">
                            Aktif / Terverifikasi
                        </span>
                    `;

                notFoundContainer.classList.add('hidden');
                resultContainer.classList.remove('hidden');
            }
        }, 400);
    }

    // Preset Helper
    function fillAndSearch(nim) {
        document.getElementById('nim-input').value = nim;
        document.getElementById('nim-form').dispatchEvent(new Event('submit'));
    }

    // Global Search Helper
    function quickFillSearch(term) {
        document.getElementById('global-search').value = term;
        scrollToSection('layanan');
    }

    function scrollToSection(id) {
        const el = document.getElementById(id);
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    }

    // Mobile Navigation Toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Tab Switching for News
    function switchTab(tabName) {
        const buttons = document.querySelectorAll('.tab-btn');
        const items = document.querySelectorAll('.news-item');

        buttons.forEach(btn => {
            if (btn.getAttribute('data-tab') === tabName) {
                btn.classList.add('bg-slate-900', 'text-white');
                btn.classList.remove('text-slate-600', 'hover:bg-slate-100');
            } else {
                btn.classList.remove('bg-slate-900', 'text-white');
                btn.classList.add('text-slate-600', 'hover:bg-slate-100');
            }
        });

        items.forEach(item => {
            if (tabName === 'semua' || item.classList.contains(tabName)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Animated Statistics Counter on Scroll
    let animated = false;
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const duration = 1500;
            const increment = target / (duration / 16);

            let current = 0;
            const updateCount = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = Math.ceil(current).toLocaleString('id-ID');
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target.toLocaleString('id-ID');
                }
            };
            updateCount();
        });
    }

    // Intersection Observer for Statistics
    const statsSection = document.getElementById('statistik');
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && !animated) {
            animateCounters();
            animated = true;
        }
    }, { threshold: 0.3 });

    if (statsSection) {
        observer.observe(statsSection);
    }
</script>
</body>
</html>
