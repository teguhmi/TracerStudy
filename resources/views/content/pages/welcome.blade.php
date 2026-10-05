<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AKSI UT - Administrasi Kelulusan, Sertifikat & Ijazah Universitas Terbuka</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ut: {
                            navy: '#002B5C',
                            blue: '#003B73',
                            skyblue: '#0099DA',
                            yellow: '#FDB813',
                            gold: '#FFC20E',
                            bg: '#F4F6F9',
                            card: '#FFFFFF'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace']
                    }
                }
            }
        }
    </script>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F4F6F9;
            color: #1E293B;
        }

        .ut-header-gradient {
            background: linear-gradient(135deg, #002B5C 0%, #003B73 60%, #005691 100%);
        }

        .ut-yellow-border {
            border-bottom: 4px solid #FDB813;
        }

        .captcha-box {
            background: repeating-linear-gradient(
                45deg,
                #e2e8f0,
                #e2e8f0 10px,
                #cbd5e1 10px,
                #cbd5e1 20px
            );
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: 0.3em;
            user-select: none;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            #printable-skl-modal, #printable-skl-modal * {
                visibility: visible;
            }
            #printable-skl-modal {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="antialiased selection:bg-ut-yellow selection:text-ut-navy flex flex-col min-h-screen">

<!-- Top Bar Header -->
<div class="bg-slate-900 text-slate-300 text-xs py-1.5 px-4 border-b border-white/10 hidden sm:block">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
                <span class="flex items-center space-x-1.5">
                    <i class="fa-solid fa-graduation-cap text-ut-yellow"></i>
                    <strong class="text-white">Universitas Terbuka</strong> &bull; Making Higher Education Open to All
                </span>
        </div>
        <div class="flex items-center space-x-5 text-slate-300">
            <a href="https://www.ut.ac.id" target="_blank" class="hover:text-ut-yellow transition-colors"><i class="fa-solid fa-globe mr-1"></i>Portal Utama UT</a>
            <a href="tel:1500024" class="hover:text-ut-yellow transition-colors"><i class="fa-solid fa-headset mr-1"></i>HALO UT 1500024</a>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="sticky top-0 z-40 bg-ut-navy text-white shadow-lg ut-yellow-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Logo & Brand Title -->
            <div class="flex items-center space-x-3.5">
                <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center p-1.5 shadow-md border-2 border-ut-yellow shrink-0">
                    <!-- UT Crest Placeholder Icon -->
                    <div class="w-full h-full rounded-lg bg-ut-navy flex items-center justify-center text-ut-yellow font-black text-xl">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-black tracking-tight text-white">AKSI <span class="text-ut-yellow">UT</span></span>
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-ut-yellow/20 text-ut-yellow border border-ut-yellow/30">Layanan Kelulusan</span>
                    </div>
                    <p class="text-xs font-medium text-slate-300 hidden sm:block">Administrasi Kelulusan, Sertifikat & Ijazah Universitas Terbuka</p>
                </div>
            </div>

            <!-- Desktop Navigation Menu -->
            <nav class="hidden lg:flex items-center space-x-6 text-xs sm:text-sm font-semibold text-slate-200">
                <a href="#hero-search" class="hover:text-ut-yellow transition-colors py-1 flex items-center space-x-1.5">
                    <i class="fa-solid fa-magnifying-glass text-ut-skyblue"></i>
                    <span>Cek Yudisium</span>
                </a>
                <a href="#modul-layanan" class="hover:text-ut-yellow transition-colors py-1 flex items-center space-x-1.5">
                    <i class="fa-solid fa-grid-2 text-ut-skyblue"></i>
                    <span>Modul Layanan</span>
                </a>
                <a href="#panduan-foto" class="hover:text-ut-yellow transition-colors py-1 flex items-center space-x-1.5">
                    <i class="fa-solid fa-camera text-ut-skyblue"></i>
                    <span>Syarat Pasfoto</span>
                </a>
                <a href="#alur-kelulusan" class="hover:text-ut-yellow transition-colors py-1 flex items-center space-x-1.5">
                    <i class="fa-solid fa-diagram-project text-ut-skyblue"></i>
                    <span>Alur Administrasi</span>
                </a>
                <button onclick="openModal('modal-tracking')" class="px-3.5 py-2 rounded-xl bg-ut-skyblue hover:bg-sky-500 text-white font-bold transition-all shadow-sm flex items-center space-x-1.5">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Lacak Ijazah</span>
                </button>
            </nav>

            <!-- Mobile Hamburger Button -->
            <div class="lg:hidden flex items-center">
                <button onclick="toggleMobileMenu()" aria-label="Menu Toggle" class="p-2 rounded-xl bg-ut-blue text-slate-200 hover:text-white focus:outline-none">
                    <i class="fa-solid fa-bars text-xl" id="mobile-menu-icon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden lg:hidden bg-ut-blue border-t border-white/10 px-4 pt-3 pb-6 space-y-3">
        <a href="#hero-search" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-100 hover:bg-ut-navy">Cek Kelulusan</a>
        <a href="#modul-layanan" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-100 hover:bg-ut-navy">Modul Layanan</a>
        <a href="#panduan-foto" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-100 hover:bg-ut-navy">Syarat Pasfoto</a>
        <a href="#alur-kelulusan" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-100 hover:bg-ut-navy">Alur Administrasi</a>
        <button onclick="openModal('modal-tracking'); toggleMobileMenu()" class="w-full text-left px-3 py-2 rounded-lg text-sm font-bold text-ut-yellow bg-ut-navy flex items-center space-x-2">
            <i class="fa-solid fa-truck-fast"></i>
            <span>Lacak Pengiriman Ijazah</span>
        </button>
    </div>
</header>

<!-- Hero Banner Section -->
<section id="hero-search" class="ut-header-gradient text-white pt-10 pb-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="text-center max-w-3xl mx-auto space-y-3 mb-8">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold text-ut-yellow">
                <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                <span>Portal Resmi Administrasi Kelulusan Universitas Terbuka</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight">
                Pencarian Data Kelulusan & <br>
                <span class="text-ut-yellow">Penetapan Yudisium Mahasiswa</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-200 max-w-2xl mx-auto leading-relaxed font-normal">
                Masukkan Nomor Induk Mahasiswa (NIM) dan pilih Masa Yudisium untuk mengecek status SK Rektor, mengunggah pasfoto ijazah, dan mengunduh Surat Keterangan Lulus (SKL).
            </p>
        </div>

        <!-- Main Interactive Search Form Card -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-3xl p-5 sm:p-7 text-slate-900 shadow-xl border border-slate-200">
                <form onsubmit="handleSearchData(event)" class="space-y-4">

                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">

                        <!-- Dropdown Masa Yudisium -->
                        <div class="sm:col-span-5">
                            <label for="select-masa" class="block text-xs font-bold uppercase tracking-wider text-ut-navy mb-1.5">
                                <i class="fa-solid fa-calendar-days text-ut-skyblue mr-1"></i> Masa Yudisium
                            </label>
                            <select id="select-masa" class="w-full px-3.5 py-3 rounded-xl bg-slate-50 border border-slate-300 font-semibold text-sm focus:ring-2 focus:ring-ut-blue focus:outline-none focus:bg-white transition-all">
                                <option value="2026.1" selected>2026/2027 Ganjil (2026.1)</option>
                                <option value="2025.2">2025/2026 Genap (2025.2)</option>
                                <option value="2025.1">2025/2026 Ganjil (2025.1)</option>
                                <option value="2024.2">2024/2025 Genap (2024.2)</option>
                            </select>
                        </div>

                        <!-- NIM Input -->
                        <div class="sm:col-span-7">
                            <label for="input-nim" class="block text-xs font-bold uppercase tracking-wider text-ut-navy mb-1.5">
                                <i class="fa-solid fa-id-card text-ut-skyblue mr-1"></i> NIM (Nomor Induk Mahasiswa)
                            </label>
                            <div class="relative">
                                <input type="text" id="input-nim" maxlength="9" placeholder="Masukkan 9 digit NIM (Contoh: 041234567)" required
                                       class="w-full pl-4 pr-10 py-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-mono font-bold placeholder-slate-400 focus:ring-2 focus:ring-ut-blue focus:outline-none focus:bg-white text-sm sm:text-base">
                                <i class="fa-solid fa-hashtag absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Captcha Security Box -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-ut-navy">
                            <i class="fa-solid fa-lock text-ut-skyblue mr-1"></i> Verifikasi Keamanan (Captcha)
                        </label>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <!-- Generated Captcha Canvas Box -->
                            <div class="flex items-center space-x-2">
                                <div id="captcha-display" class="captcha-box px-5 py-2.5 rounded-xl border border-slate-300 font-bold text-slate-800 text-lg shadow-inner flex items-center justify-center min-w-[140px]">
                                    <!-- Dynamic Text Inserted JS -->
                                </div>
                                <button type="button" onclick="refreshCaptcha()" title="Acak Ulang Kode" class="p-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 transition-colors">
                                    <i class="fa-solid fa-rotate-right text-base"></i>
                                </button>
                            </div>

                            <!-- Captcha Input -->
                            <div class="w-full">
                                <input type="text" id="input-captcha" maxlength="5" placeholder="Ketik kode 5 karakter di samping" required
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold text-slate-900 focus:ring-2 focus:ring-ut-blue focus:outline-none text-sm uppercase">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-1 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-[11px] text-slate-500 font-medium flex items-center space-x-1.5">
                            <i class="fa-solid fa-circle-info text-ut-skyblue"></i>
                            <span>Gunakan NIM valid 9 angka untuk memeriksa penetapan SK Yudisium.</span>
                        </div>

                        <button type="submit" id="btn-search-submit" class="w-full sm:w-auto px-7 py-3 bg-ut-navy hover:bg-ut-blue text-ut-yellow font-bold text-sm rounded-xl transition-all shadow-md hover:shadow-lg flex items-center justify-center space-x-2 shrink-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Cari Data Kelulusan</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>

<!-- Main Content Container -->
<main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full -mt-6 relative z-20 pb-16">

    <!-- SEARCH RESULT CONTAINER (STRICTLY EMPTY ON INITIAL LOAD) -->
    <section id="search-result-section" class="mb-12">

        <!-- INITIAL EMPTY STATE PANEL (NO PRE-RENDERED SAMPLE DATA) -->
        <div id="result-empty-state" class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm text-center space-y-4">
            <div class="w-20 h-20 bg-slate-100 text-ut-blue rounded-3xl flex items-center justify-center mx-auto text-3xl shadow-inner border border-slate-200">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="max-w-md mx-auto space-y-1.5">
                <h2 class="text-xl font-extrabold text-slate-900">Pemeriksaan Status Yudisium Mahasiswa</h2>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                    Silakan masukkan <strong>NIM</strong> Anda, pilih <strong>Masa Yudisium</strong>, dan selesaikan <strong>Verifikasi Captcha</strong> di atas untuk menampilkan detail kelulusan.
                </p>
            </div>
            <div class="pt-2 flex justify-center items-center space-x-4 text-xs text-slate-400 font-medium">
                <span class="flex items-center"><i class="fa-solid fa-check text-emerald-500 mr-1.5"></i>SK Rektor Resmi</span>
                <span class="flex items-center"><i class="fa-solid fa-check text-emerald-500 mr-1.5"></i>PIN Ijazah Nasional</span>
                <span class="flex items-center"><i class="fa-solid fa-check text-emerald-500 mr-1.5"></i>Digital SKL</span>
            </div>
        </div>

        <!-- SEARCH LOADING SPINNER (HIDDEN BY DEFAULT) -->
        <div id="result-loading-state" class="hidden bg-white rounded-3xl p-12 border border-slate-200 shadow-sm text-center space-y-4">
            <div class="inline-block animate-spin text-ut-navy text-4xl mb-2">
                <i class="fa-solid fa-circle-notch"></i>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900">Menghubungkan ke Pangkalan Data AKSI UT...</h3>
            <p class="text-xs text-slate-500 font-mono">Memeriksa SK Yudisium Rektor & Status Pasfoto Mahasiswa...</p>
        </div>

        <!-- SEARCH RESULT CARD (POPULATED ONLY AFTER USER SEARCH) -->
        <div id="result-found-state" class="hidden transition-all duration-300">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-lg overflow-hidden">

                <!-- Header Result Banner -->
                <div class="bg-ut-navy p-6 text-white border-b-4 border-ut-yellow flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="space-y-1">
                        <div class="inline-flex items-center space-x-2 text-xs font-mono font-bold text-ut-yellow bg-white/10 px-3 py-1 rounded-full">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span id="res-masa-text">Masa Yudisium 2026.1</span>
                        </div>
                        <h2 class="text-2xl font-extrabold text-white" id="res-nama-text">-</h2>
                        <p class="text-xs sm:text-sm text-slate-300 font-medium" id="res-prodi-upbjj-text">-</p>
                    </div>

                    <div id="res-status-badge">
                        <!-- Dynamic Badge Inserted via JS -->
                    </div>
                </div>

                <!-- Academic Summary Grid -->
                <div class="p-6 sm:p-8 space-y-6">

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="block text-xs font-bold uppercase text-slate-400">Total SKS Lulus</span>
                            <span class="text-2xl font-black text-ut-navy mt-1 block" id="res-sks-text">-</span>
                            <span class="text-[11px] text-slate-500 font-medium">Lengkap Syarat Kurikulum</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="block text-xs font-bold uppercase text-slate-400">IPK Total Gabungan</span>
                            <span class="text-2xl font-black text-ut-navy mt-1 block" id="res-ipk-text">-</span>
                            <span class="text-[11px] text-emerald-600 font-semibold" id="res-predikat-text">-</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="block text-xs font-bold uppercase text-slate-400">SKS Konversi RPL</span>
                            <span class="text-2xl font-black text-ut-navy mt-1 block" id="res-rpl-text">0 SKS</span>
                            <span class="text-[11px] text-slate-500 font-medium">Rekognisi Pembelajaran</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <span class="block text-xs font-bold uppercase text-slate-400">PIN Ijazah Nasional</span>
                            <span class="text-base font-mono font-bold text-ut-navy mt-2 block tracking-wider" id="res-pin-text">-</span>
                            <span class="text-[11px] text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check text-xs mr-1"></i>Terverifikasi Kemdikbud</span>
                        </div>
                    </div>

                    <!-- Redaksi SK Text Box -->
                    <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200 space-y-2">
                        <div class="flex items-center space-x-2 text-xs font-extrabold uppercase text-amber-900">
                            <i class="fa-solid fa-scroll text-ut-gold"></i>
                            <span>Redaksi Penetapan SK Kelulusan Rektor UT</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-800 leading-relaxed font-sans italic" id="res-redaksi-text">
                            -
                        </p>
                    </div>

                    <!-- Timeline Stepper -->
                    <div class="pt-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Progres Tahapan Administrasi Kelulusan</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 relative">

                            <!-- Step 1 -->
                            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 text-sm font-bold">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">1. SK Yudisium</span>
                                    <span class="text-[10px] text-emerald-600 font-semibold">Terjaring SK Rektor</span>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center space-x-3">
                                <div id="step2-badge" class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center shrink-0 text-sm font-bold">
                                    2
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">2. Pasfoto Ijazah</span>
                                    <span id="step2-status" class="text-[10px] text-slate-500">Verifikasi Berkas</span>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center space-x-3">
                                <div id="step3-badge" class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center shrink-0 text-sm font-bold">
                                    3
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">3. Penerbitan SKL</span>
                                    <span id="step3-status" class="text-[10px] text-slate-500">Sertifikat Digital</span>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center space-x-3">
                                <div id="step4-badge" class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center shrink-0 text-sm font-bold">
                                    4
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">4. Penyerahan / UPI</span>
                                    <span id="step4-status" class="text-[10px] text-slate-500">Wisuda / Kirim</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Direct Action Buttons -->
                    <div class="pt-4 border-t border-slate-200 flex flex-wrap gap-3 justify-end items-center">
                        <button onclick="openModal('modal-unggah-foto')" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-ut-navy font-bold text-xs sm:text-sm transition-colors border border-slate-300 flex items-center space-x-2">
                            <i class="fa-solid fa-camera text-ut-blue"></i>
                            <span>Unggah / Perbarui Pasfoto</span>
                        </button>
                        <button onclick="triggerSklDownload()" class="px-5 py-2.5 rounded-xl bg-ut-navy hover:bg-ut-blue text-ut-yellow font-bold text-xs sm:text-sm transition-all shadow-md flex items-center space-x-2">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Cetak Surat Keterangan Lulus (SKL)</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- RESULT NOT FOUND STATE -->
        <div id="result-not-found-state" class="hidden bg-white rounded-3xl border border-rose-200 shadow-sm p-8 text-center space-y-4">
            <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
            <div class="max-w-md mx-auto space-y-1">
                <h3 class="text-xl font-extrabold text-slate-900">Data NIM Tidak Ditemukan</h3>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                    NIM yang Anda masukkan belum terjaring dalam SK Penetapan Yudisium Rektor pada masa ini.
                </p>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 max-w-lg mx-auto text-left text-xs text-slate-600 space-y-1.5">
                <strong class="text-slate-800 font-bold block">Saran Langkah Tindak Lanjut:</strong>
                <ul class="list-disc list-inside space-y-1">
                    <li>Pastikan 9 digit NIM yang dimasukkan sudah benar tanpa spasi.</li>
                    <li>Pastikan Anda telah memenuhi seluruh Beban SKS Lulus dan Bebas Pustaka.</li>
                    <li>Hubungi Pengelola Akademik UT Daerah / UPBJJ atau layanan HALO UT 1500024.</li>
                </ul>
            </div>
            <div class="pt-2">
                <button onclick="resetSearchForm()" class="px-4 py-2 rounded-xl bg-slate-200 text-slate-800 text-xs font-bold hover:bg-slate-300">
                    <i class="fa-solid fa-rotate-left mr-1"></i>Cari NIM Lain
                </button>
            </div>
        </div>

    </section>

    <!-- Quick Access Service Modules Section -->
    <section id="modul-layanan" class="space-y-6 pt-4">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-slate-200 pb-4">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-ut-blue bg-blue-50 border border-blue-200 px-3 py-1 rounded-full">Fitur Layanan Utama</span>
                <h2 class="text-2xl font-extrabold text-slate-900 mt-2">Katalog Modul Administrasi Kelulusan</h2>
                <p class="text-slate-600 text-xs sm:text-sm">Akses layanan mandiri ijazah, pasfoto, dan verifikasi dokumen lulusan Universitas Terbuka.</p>
            </div>
        </div>

        <!-- 4 Core Service Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-ut-navy flex items-center justify-center text-xl mb-4 group-hover:bg-ut-navy group-hover:text-ut-yellow transition-colors border border-blue-100">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">1. Status Yudisium & SK</h3>
                    <p class="text-slate-600 text-xs leading-relaxed mb-6">
                        Pemeriksaan data penetapan kelulusan berdasarkan Surat Keputusan Rektor Universitas Terbuka.
                    </p>
                </div>
                <a href="#hero-search" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-ut-navy hover:text-white text-ut-navy font-bold text-xs transition-colors text-center block">
                    Cek Status Sekarang
                </a>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors border border-amber-100">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">2. Unggah Pasfoto Ijazah</h3>
                    <p class="text-slate-600 text-xs leading-relaxed mb-6">
                        Upload mandiri foto cetak ijazah sesuai standar ketentuan resmi ukuran 3x4 Doff UT.
                    </p>
                </div>
                <button onclick="openModal('modal-unggah-foto')" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-amber-600 hover:text-white text-slate-800 font-bold text-xs transition-colors text-center">
                    Unggah Pasfoto
                </button>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-ut-skyblue flex items-center justify-center text-xl mb-4 group-hover:bg-ut-skyblue group-hover:text-white transition-colors border border-sky-100">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">3. Tracking Pengiriman</h3>
                    <p class="text-slate-600 text-xs leading-relaxed mb-6">
                        Lacak posisi pengiriman ijazah, transkrip, dan ijazah fisik ke UT Daerah asal mahasiswa.
                    </p>
                </div>
                <button onclick="openModal('modal-tracking')" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-ut-skyblue hover:text-white text-slate-800 font-bold text-xs transition-colors text-center">
                    Lacak Resi / Status
                </button>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors border border-emerald-100">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">4. Keaslian Document</h3>
                    <p class="text-slate-600 text-xs leading-relaxed mb-6">
                        Verifikasi keabsahan Surat Keterangan Lulus (SKL) dan Ijazah melalui PIN Ijazah Nasional.
                    </p>
                </div>
                <button onclick="openModal('modal-verifikasi')" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-800 font-bold text-xs transition-colors text-center">
                    Verifikasi Keaslian
                </button>
            </div>

        </div>
    </section>

    <!-- Graduation Workflow & Photo Requirements Section -->
    <section class="mt-14 grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left Column: Requirements Guide -->
        <div id="panduan-foto" class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
            <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-image"></i>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Syarat & Ketentuan Pasfoto Ijazah UT</h3>
                    <p class="text-xs text-slate-500">Ketentuan resmi foto yang dicetak pada Ijazah & Transkrip Akademik</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <div class="font-bold text-ut-navy flex items-center space-x-1.5">
                        <i class="fa-solid fa-palette text-ut-skyblue"></i>
                        <span>Warna Latar Belakang (Background)</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        <strong>Latar Merah:</strong> Untuk Fakultas Keguruan dan Ilmu Pendidikan (FKIP).<br>
                        <strong>Latar Biru:</strong> Untuk FST, FEB, FHISIP, dan Sekolah Pascasarjana.
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <div class="font-bold text-ut-navy flex items-center space-x-1.5">
                        <i class="fa-solid fa-user-tie text-ut-skyblue"></i>
                        <span>Pakaian & Penampilan</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Pria: Kemeja putih, dasi hitam, dan jas hitam.<br>
                        Wanita: Pakaian formal / blazer gelap / kebaya nasional. Jilbab polos (gelap / putih).
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <div class="font-bold text-ut-navy flex items-center space-x-1.5">
                        <i class="fa-solid fa-crop-simple text-ut-skyblue"></i>
                        <span>Posisi & Kualitas Foto</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Posisi wajah lurus menghadap depan, kedua telinga tampak (non-hijab), tidak menggunakan kacamata hitam.
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <div class="font-bold text-ut-navy flex items-center space-x-1.5">
                        <i class="fa-solid fa-file-image text-ut-skyblue"></i>
                        <span>Spesifikasi File Digital</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Format file: JPG / JPEG.<br>
                        Ukuran file: Maksimal 2 MB.<br>
                        Resolusi cetak: Minimal 300 DPI (Kertas Foto Doff 3x4 cm).
                    </p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-900 flex items-start space-x-3">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base shrink-0 mt-0.5"></i>
                <p class="leading-relaxed">
                    <strong>Perhatian:</strong> Pasfoto yang tidak memenuhi standar (seperti foto selfie, foto kaus oblong, atau foto buram) akan ditolak oleh verifikator UT dan menunda proses pengeluaran Ijazah fisik.
                </p>
            </div>
        </div>

        <!-- Right Column: Flow Chart -->
        <div id="alur-kelulusan" class="lg:col-span-5 bg-ut-navy text-white rounded-3xl p-6 sm:p-8 shadow-md flex flex-col justify-between">
            <div>
                <span class="px-3 py-1 rounded-full bg-white/10 text-ut-yellow text-xs font-mono font-bold">Panduan Prosedur</span>
                <h3 class="text-xl font-extrabold text-white mt-2 mb-6">Alur Tahapan Administrasi Kelulusan</h3>

                <div class="space-y-4 text-xs">
                    <div class="flex items-start space-x-3">
                        <div class="w-7 h-7 rounded-full bg-ut-yellow text-ut-navy font-bold flex items-center justify-center shrink-0">1</div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Penetapan SK Yudisium Rektor</h4>
                            <p class="text-slate-300 mt-0.5">Mahasiswa dinyatakan memenuhi syarat kelulusan kurikulum & Lulus Bebas Pustaka.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-7 h-7 rounded-full bg-ut-yellow text-ut-navy font-bold flex items-center justify-center shrink-0">2</div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Unggah Pasfoto Ijazah</h4>
                            <p class="text-slate-300 mt-0.5">Mahasiswa mengunggah berkas pasfoto cetak ijazah melalui portal AKSI UT.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-7 h-7 rounded-full bg-ut-yellow text-ut-navy font-bold flex items-center justify-center shrink-0">3</div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Verifikasi Operator & Terbit SKL</h4>
                            <p class="text-slate-300 mt-0.5">Staf Akademik memvalidasi pasfoto, dilanjutkan penerbitan Surat Keterangan Lulus (SKL) TTE.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-7 h-7 rounded-full bg-ut-yellow text-ut-navy font-bold flex items-center justify-center shrink-0">4</div>
                        <div>
                            <h4 class="font-bold text-white text-sm">Pencetakan & Penyerahan Ijazah / UPI</h4>
                            <p class="text-slate-300 mt-0.5">Ijazah fisik dicetak dengan PIN Nasional dan diserahkan pada UPI di UT Daerah atau Wisuda Pusat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/10 mt-6">
                <button onclick="openModal('modal-unggah-foto')" class="w-full py-3 bg-ut-yellow hover:bg-yellow-400 text-ut-navy font-extrabold text-xs rounded-xl transition-all shadow-md">
                    Mulai Unggah Pasfoto Kelulusan
                </button>
            </div>
        </div>

    </section>

    <!-- Accordion FAQ Section -->
    <section class="mt-14 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="text-center max-w-xl mx-auto mb-8 space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-ut-blue">Pertanyaan Sering Diajukan</span>
            <h2 class="text-2xl font-extrabold text-slate-900">FAQ Administrasi Kelulusan AKSI UT</h2>
        </div>

        <div class="max-w-3xl mx-auto space-y-3" id="faq-accordion">

            <!-- FAQ 1 -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden transition-colors">
                <button onclick="toggleFaq(1)" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors">
                    <span>Berapa lama proses verifikasi pasfoto ijazah oleh operator UT?</span>
                    <i id="faq-icon-1" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform"></i>
                </button>
                <div id="faq-body-1" class="hidden p-4 text-xs text-slate-600 border-t border-slate-200 leading-relaxed bg-white">
                    Proses verifikasi berkas pasfoto oleh staf Subbag Akademik UT Pusat/UT Daerah membutuhkan waktu rata-rata 2 hingga 5 hari kerja setelah pasfoto berhasil diunggah. Status verifikasi dapat diperiksa berkala di halaman ini.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden transition-colors">
                <button onclick="toggleFaq(2)" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors">
                    <span>Bagaimana jika Surat Keterangan Lulus (SKL) belum bisa dicetak?</span>
                    <i id="faq-icon-2" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform"></i>
                </button>
                <div id="faq-body-2" class="hidden p-4 text-xs text-slate-600 border-t border-slate-200 leading-relaxed bg-white">
                    Cetak SKL Digital membutuhkan persetujuan pasfoto ijazah terlebih dahulu. Pastikan Anda sudah mengunggah pasfoto sesuai syarat dan statusnya telah terverifikasi "Disetujui".
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden transition-colors">
                <button onclick="toggleFaq(3)" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 flex justify-between items-center bg-slate-50 hover:bg-slate-100 transition-colors">
                    <span>Apakah SKL Digital memiliki legalitas hukum yang sah?</span>
                    <i id="faq-icon-3" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform"></i>
                </button>
                <div id="faq-body-3" class="hidden p-4 text-xs text-slate-600 border-t border-slate-200 leading-relaxed bg-white">
                    Ya, SKL Digital dari portal AKSI UT dilengkapi dengan Tanda Tangan Elektronik (TTE) pejabat Universitas Terbuka dan QR Code verifikasi resmi yang terhubung langsung ke server autentikasi UT.
                </div>
            </div>

        </div>
    </section>

</main>

<!-- MODAL 1: Unggah Pasfoto -->
<div id="modal-unggah-foto" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative animate-fadeIn">
        <button onclick="closeModal('modal-unggah-foto')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="text-center space-y-1.5 mb-6">
            <div class="w-12 h-12 bg-amber-100 text-amber-800 rounded-2xl flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-camera"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900">Unggah Pasfoto Kelulusan</h3>
            <p class="text-xs text-slate-500">Pasfoto resmi cetak ijazah Universitas Terbuka</p>
        </div>

        <form onsubmit="handleUploadPasfotoForm(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">NIM Mahasiswa</label>
                <input type="text" id="upload-nim-input" maxlength="9" placeholder="Masukkan 9 Digit NIM" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-ut-navy focus:outline-none">
            </div>

            <!-- Dropzone Area -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">File Pasfoto (JPG/JPEG, Max 2MB)</label>
                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center hover:border-ut-navy transition-colors bg-slate-50 cursor-pointer" onclick="document.getElementById('file-upload-input').click()">
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2"></i>
                    <p class="text-xs font-bold text-slate-700">Klik untuk memilih file pasfoto</p>
                    <p class="text-[11px] text-slate-400 mt-1">Latar Merah (FKIP) / Latar Biru (Non-FKIP)</p>
                    <input type="file" id="file-upload-input" class="hidden" accept="image/jpeg,image/jpg,image/png" onchange="previewUploadImage(event)">
                </div>
            </div>

            <!-- Image Live Preview -->
            <div id="upload-preview-box" class="hidden text-center p-3 bg-slate-100 rounded-2xl border border-slate-200">
                <span class="text-[11px] text-slate-500 font-bold block mb-2">Preview Foto Terpilih:</span>
                <img id="upload-preview-img" src="" alt="Preview" class="w-24 h-32 object-cover rounded-lg mx-auto border-2 border-ut-navy shadow-sm">
            </div>

            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeModal('modal-unggah-foto')" class="w-1/2 py-3 rounded-xl bg-slate-100 font-bold text-xs text-slate-700 hover:bg-slate-200">
                    Batal
                </button>
                <button type="submit" class="w-1/2 py-3 rounded-xl bg-ut-navy text-ut-yellow font-bold text-xs hover:bg-ut-blue transition-colors shadow-md">
                    Unggah Berkas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Lacak Ijazah -->
<div id="modal-tracking" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative">
        <button onclick="closeModal('modal-tracking')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="text-center space-y-1.5 mb-6">
            <div class="w-12 h-12 bg-sky-100 text-ut-skyblue rounded-2xl flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900">Lacak Pengiriman Ijazah</h3>
            <p class="text-xs text-slate-500">Cek posisi dokumen Ijazah / Sertifikat Kelulusan</p>
        </div>

        <form onsubmit="handleTrackingSearch(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">NIM / Nomor Resi Pengiriman</label>
                <input type="text" id="tracking-input" placeholder="Masukkan NIM atau No. Resi" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-ut-navy focus:outline-none">
            </div>
            <button type="submit" class="w-full py-3 bg-ut-skyblue hover:bg-sky-600 text-white font-bold text-xs rounded-xl transition-all shadow-md">
                Cek Status Posisi
            </button>
        </form>

        <div id="tracking-result-box" class="hidden mt-6 pt-4 border-t border-slate-200 space-y-3 text-xs">
            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-xl font-medium">
                <i class="fa-solid fa-circle-check text-emerald-600 mr-1.5"></i>
                Dokumen Ijazah dalam proses distribusi ke UT Daerah.
            </div>
        </div>
    </div>
</div>

<!-- MODAL 3: Verifikasi Keaslian Dokument -->
<div id="modal-verifikasi" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative">
        <button onclick="closeModal('modal-verifikasi')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="text-center space-y-1.5 mb-6">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-shield-check"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900">Verifikasi Keaslian SKL / PIN</h3>
            <p class="text-xs text-slate-500">Pemeriksaan PIN Ijazah Nasional Kemdikbud / UT</p>
        </div>

        <form onsubmit="handleVerifikasiSubmit(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 mb-1">PIN Ijazah / Kode TTE SKL</label>
                <input type="text" id="verifikasi-pin-input" placeholder="Contoh: 862012026001234" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-sm focus:ring-2 focus:ring-ut-navy focus:outline-none">
            </div>
            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition-all shadow-md">
                Verifikasi Dokumen
            </button>
        </form>
    </div>
</div>

<!-- MODAL 4: Printable SKL Digital Preview -->
<div id="modal-skl-print" class="fixed inset-0 z-50 hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-10 shadow-2xl border border-slate-200 my-8 relative" id="printable-skl-modal">

        <button onclick="closeModal('modal-skl-print')" class="no-print absolute top-5 right-5 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="space-y-6 text-slate-900 border-8 border-ut-navy/10 p-6 sm:p-8 rounded-2xl bg-white relative">

            <!-- Official Letterhead Header -->
            <div class="flex items-center justify-between border-b-2 border-ut-navy pb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-ut-navy rounded-2xl flex items-center justify-center text-ut-yellow text-2xl font-bold border-2 border-ut-yellow shrink-0">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-black uppercase text-ut-navy leading-tight">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h2>
                        <h3 class="text-lg font-extrabold text-ut-blue leading-tight">UNIVERSITAS TERBUKA</h3>
                        <p class="text-[11px] text-slate-500 font-medium">Jalan Cabe Raya, Pamulang, Tangerang Selatan 15418 | www.ut.ac.id</p>
                    </div>
                </div>
            </div>

            <!-- Document Title -->
            <div class="text-center space-y-1 pt-2">
                <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-ut-navy border-b-2 border-slate-900 inline-block px-4 pb-0.5">
                    SURAT KETERANGAN LULUS (SKL)
                </h2>
                <p class="text-xs font-mono text-slate-600" id="skl-print-no">Nomor: SKL/UT/2026/041234567</p>
            </div>

            <p class="text-xs sm:text-sm text-slate-800 leading-relaxed font-sans">
                Rektor Universitas Terbuka menerangkan dengan sebenarnya bahwa mahasiswa di bawah ini:
            </p>

            <!-- Student Details Table -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 text-xs sm:text-sm space-y-2">
                <div class="grid grid-cols-12">
                    <span class="col-span-4 font-bold text-slate-600">Nama Lengkap</span>
                    <span class="col-span-8 font-black text-ut-navy" id="skl-print-nama">-</span>
                </div>
                <div class="grid grid-cols-12">
                    <span class="col-span-4 font-bold text-slate-600">NIM</span>
                    <span class="col-span-8 font-mono font-bold" id="skl-print-nim">-</span>
                </div>
                <div class="grid grid-cols-12">
                    <span class="col-span-4 font-bold text-slate-600">Program Studi</span>
                    <span class="col-span-8 font-semibold" id="skl-print-prodi">-</span>
                </div>
                <div class="grid grid-cols-12">
                    <span class="col-span-4 font-bold text-slate-600">UT Daerah / UPBJJ</span>
                    <span class="col-span-8 font-semibold" id="skl-print-upbjj">-</span>
                </div>
                <div class="grid grid-cols-12">
                    <span class="col-span-4 font-bold text-slate-600">IPK Gabungan</span>
                    <span class="col-span-8 font-bold text-emerald-700" id="skl-print-ipk">-</span>
                </div>
                <div class="grid grid-cols-12">
                    <span class="col-span-4 font-bold text-slate-600">PIN Ijazah Nasional</span>
                    <span class="col-span-8 font-mono font-bold text-slate-900" id="skl-print-pin">-</span>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-800 leading-relaxed">
                Telah dinyatakan <strong class="text-ut-navy">LULUS</strong> berdasarkan Keputusan Rektor Universitas Terbuka tentang Penetapan Kelulusan Mahasiswa. Surat Keterangan Lulus ini berlaku sebagai dokumen resmi sementara sebelum Ijazah fisik diserahkan.
            </p>

            <!-- Official Signature Block -->
            <div class="pt-6 flex justify-between items-end">
                <div class="flex items-center space-x-3 p-3 bg-slate-100 rounded-xl border border-slate-200">
                    <div class="w-14 h-14 bg-white p-1 rounded border border-slate-300 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full text-slate-800" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm11-2h7v7h-7V2zm2 2v3h3V4h-3zM2 14h7v8H2v-8zm2 2v4h3v-4H4zm13 3h2v2h-2v-2zm-3-3h2v2h-2v-2zm3-2h4v2h-4v-2zm-3 5h2v3h-2v-3zm3 1h3v2h-3v-2z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] text-slate-600 font-mono">
                        <span class="font-bold text-ut-navy block">TTE TERVERIFIKASI</span>
                        <span>Sertifikat Digital Sah</span><br>
                        <span>AKSI UT System</span>
                    </div>
                </div>

                <div class="text-right text-xs">
                    <p class="text-slate-600">Tangerang Selatan, <span id="skl-print-date">15 Maret 2026</span></p>
                    <p class="font-bold text-slate-900 mt-0.5">a.n. Rektor Universitas Terbuka</p>
                    <p class="text-slate-600">Wakil Rektor Bidang Akademik,</p>
                    <div class="h-10 flex items-center justify-end my-1">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded border border-emerald-300">
                                <i class="fa-solid fa-signature mr-1"></i>Digital Signed by UT
                            </span>
                    </div>
                    <p class="font-black text-ut-navy underline">Prof. Dr. Mohamad Yunus, M.A.</p>
                </div>
            </div>

        </div>

        <!-- Modal Print Actions -->
        <div class="no-print mt-6 flex justify-end space-x-3">
            <button onclick="closeModal('modal-skl-print')" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 font-bold text-xs text-slate-700">
                Tutup
            </button>
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-ut-navy hover:bg-ut-blue text-ut-yellow font-bold text-xs shadow-md flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>

    </div>
</div>

<!-- Toast Notification Message Box -->
<div id="toast-message" class="fixed bottom-5 right-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="bg-slate-900 text-white px-5 py-3 rounded-2xl shadow-2xl border border-ut-yellow/40 flex items-center space-x-3">
        <i id="toast-icon" class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
        <span class="text-xs font-bold" id="toast-text">Notifikasi</span>
    </div>
</div>

<!-- Footer Section -->
<footer class="bg-ut-navy text-white pt-12 pb-8 ut-yellow-border mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-white/10">

            <!-- Col 1 -->
            <div class="md:col-span-2 space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-white text-ut-navy flex items-center justify-center font-black text-xl border border-ut-yellow">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-xl font-black text-white">AKSI <span class="text-ut-yellow">UT</span></span>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed max-w-md">
                    Sistem Informasi Administrasi Kelulusan, Sertifikat, dan Ijazah Terpadu Universitas Terbuka. Melayani mahasiswa di seluruh Indonesia dan Layanan Luar Negeri.
                </p>
            </div>

            <!-- Col 2 -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-ut-yellow mb-3">Tautan Pintas</h4>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li><a href="#hero-search" class="hover:text-ut-yellow transition-colors">Cek SK Yudisium</a></li>
                    <li><a href="#" onclick="openModal('modal-unggah-foto')" class="hover:text-ut-yellow transition-colors">Unggah Pasfoto Ijazah</a></li>
                    <li><a href="#" onclick="openModal('modal-tracking')" class="hover:text-ut-yellow transition-colors">Lacak Pengiriman Ijazah</a></li>
                    <li><a href="#" onclick="openModal('modal-verifikasi')" class="hover:text-ut-yellow transition-colors">Verifikasi Keaslian Dokument</a></li>
                </ul>
            </div>

            <!-- Col 3 -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-ut-yellow mb-3">Kontak Resmi HALO UT</h4>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li class="flex items-center space-x-2"><i class="fa-solid fa-phone text-ut-yellow"></i><span>1500024 (HALO UT)</span></li>
                    <li class="flex items-center space-x-2"><i class="fa-solid fa-envelope text-ut-yellow"></i><span>hallout@ecampus.ut.ac.id</span></li>
                    <li class="flex items-center space-x-2"><i class="fa-solid fa-building text-ut-yellow"></i><span>Pusdiklat & Pusat Komputer UT</span></li>
                </ul>
            </div>

        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2">
            <p>&copy; 2026 Universitas Terbuka. Hak Cipta Dilindungi Undang-Undang.</p>
            <p class="font-mono">Pusat Teknologi Informasi dan Komunikasi (ICT) UT</p>
        </div>
    </div>
</footer>

<!-- Interactive JavaScript Application Logic -->
<script>
    let currentGeneratedCaptcha = '';
    let currentStudentData = null;

    // Initialize App on DOM Content Loaded
    document.addEventListener('DOMContentLoaded', function() {
        refreshCaptcha();
    });

    // Dynamic Captcha Code Generator
    function refreshCaptcha() {
        const characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        let result = '';
        for (let i = 0; i < 5; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        currentGeneratedCaptcha = result;
        const displayEl = document.getElementById('captcha-display');
        if (displayEl) {
            displayEl.innerText = result;
        }
    }

    // Search Form Submit Handler
    function handleSearchData(event) {
        event.preventDefault();

        const nim = document.getElementById('input-nim').value.trim();
        const masa = document.getElementById('select-masa').value;
        const captchaInput = document.getElementById('input-captcha').value.trim().toUpperCase();

        // Validate Captcha
        if (captchaInput !== currentGeneratedCaptcha) {
            showToast('Kode Verifikasi (Captcha) tidak sesuai!', 'error');
            refreshCaptcha();
            document.getElementById('input-captcha').value = '';
            return;
        }

        // Validate NIM length
        if (!/^\d{9}$/.test(nim)) {
            showToast('NIM harus terdiri dari 9 digit angka!', 'error');
            return;
        }

        // UI State Transition: Hide Initial Empty State, Show Loader
        document.getElementById('result-empty-state').classList.add('hidden');
        document.getElementById('result-found-state').classList.add('hidden');
        document.getElementById('result-not-found-state').classList.add('hidden');
        document.getElementById('result-loading-state').classList.remove('hidden');

        // Simulate Server API Lookup Delay
        setTimeout(() => {
            document.getElementById('result-loading-state').classList.add('hidden');

            // Determine dynamic search outcome
            if (nim === '040000000') {
                // Specific NIM reserved for "Not Found" demo
                document.getElementById('result-not-found-state').classList.remove('hidden');
                showToast('Data NIM belum terjaring yudisium.', 'info');
            } else {
                // Populate dynamic valid result
                renderStudentData(nim, masa);
                document.getElementById('result-found-state').classList.remove('hidden');
                showToast('Data Kelulusan Berhasil Ditemukan!', 'success');
            }

            // Smooth Scroll to result panel
            document.getElementById('search-result-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
            refreshCaptcha();
            document.getElementById('input-captcha').value = '';

        }, 800);
    }

    // Render Dynamic Student Result
    function renderStudentData(nim, masa) {
        // Generate plausible mock name based on NIM ending digits if not custom
        const sampleNames = ['BUDI SANTOSO', 'SITI AMINAH', 'AHMAD DAHLAN', 'RINA WULANDARI', 'DEWI ANGGRAENI'];
        const nameIndex = parseInt(nim.slice(-1)) % sampleNames.length;
        const selectedName = sampleNames[nameIndex];

        const sampleProdi = ['S1 Teknik Informatika', 'S1 Manajemen', 'S1 Ilmu Hukum', 'S1 Akuntansi', 'S1 Ilmu Komunikasi'];
        const prodiIndex = parseInt(nim.slice(-2, -1)) % sampleProdi.length;
        const selectedProdi = sampleProdi[prodiIndex];

        currentStudentData = {
            nama: selectedName,
            nim: nim,
            prodi: selectedProdi,
            upbjj: 'UT Jakarta',
            sks: 144,
            ipk: (3.25 + (parseInt(nim.slice(-2)) % 70) / 100).toFixed(2),
            rpl: (parseInt(nim.slice(-1)) > 5 ? 18 : 0),
            predikat: 'Sangat Memuaskan',
            pin: `86201${masa.replace('.','')}${nim.slice(-6)}`,
            masa: masa,
            pasfotoStatus: (parseInt(nim.slice(-1)) % 2 === 0 ? 'APPROVED' : 'PENDING')
        };

        if (parseFloat(currentStudentData.ipk) >= 3.75) {
            currentStudentData.predikat = 'Dengan Pujian (Cumlaude)';
        }

        // Fill UI Fields
        document.getElementById('res-nama-text').innerText = currentStudentData.nama;
        document.getElementById('res-prodi-upbjj-text').innerText = `${currentStudentData.prodi} • ${currentStudentData.upbjj}`;
        document.getElementById('res-sks-text').innerText = `${currentStudentData.sks} SKS`;
        document.getElementById('res-ipk-text').innerText = currentStudentData.ipk;
        document.getElementById('res-rpl-text').innerText = `${currentStudentData.rpl} SKS`;
        document.getElementById('res-predikat-text').innerText = currentStudentData.predikat;
        document.getElementById('res-pin-text').innerText = currentStudentData.pin;
        document.getElementById('res-masa-text').innerText = `Masa Yudisium ${masa}`;

        document.getElementById('res-redaksi-text').innerText = `Berdasarkan Keputusan SK Rektor Universitas Terbuka Nomor SK-REKTOR/UT/${masa.split('.')[0]}/0${nim.slice(-4)}, mahasiswa bersangkutan dinyatakan LULUS dan berhak menyandang gelar kesarjanaan sesuai bidang keilmuan.`;

        // Badge & Timeline Status
        const badgeEl = document.getElementById('res-status-badge');
        const step2Badge = document.getElementById('step2-badge');
        const step2Status = document.getElementById('step2-status');
        const step3Badge = document.getElementById('step3-badge');
        const step3Status = document.getElementById('step3-status');

        if (currentStudentData.pasfotoStatus === 'APPROVED') {
            badgeEl.innerHTML = `<span class="px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-400/40 text-xs font-extrabold uppercase"><i class="fa-solid fa-circle-check mr-1.5"></i>Status: Selesai & SKL Terbit</span>`;

            step2Badge.className = "w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 text-sm font-bold";
            step2Badge.innerHTML = `<i class="fa-solid fa-check"></i>`;
            step2Status.innerText = "Disetujui";
            step2Status.className = "text-[10px] text-emerald-600 font-bold";

            step3Badge.className = "w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 text-sm font-bold";
            step3Badge.innerHTML = `<i class="fa-solid fa-check"></i>`;
            step3Status.innerText = "SKL Tersedia";
            step3Status.className = "text-[10px] text-emerald-600 font-bold";
        } else {
            badgeEl.innerHTML = `<span class="px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 border border-amber-400/40 text-xs font-extrabold uppercase"><i class="fa-solid fa-clock mr-1.5"></i>Status: Menunggu Pasfoto</span>`;

            step2Badge.className = "w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 text-sm font-bold";
            step2Badge.innerText = "2";
            step2Status.innerText = "Perlu Unggah Foto";
            step2Status.className = "text-[10px] text-amber-600 font-bold";

            step3Badge.className = "w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center shrink-0 text-sm font-bold";
            step3Badge.innerText = "3";
            step3Status.innerText = "Menunggu Verifikasi";
            step3Status.className = "text-[10px] text-slate-400";
        }
    }

    // Reset Search View to Initial Empty State
    function resetSearchForm() {
        document.getElementById('input-nim').value = '';
        document.getElementById('result-found-state').classList.add('hidden');
        document.getElementById('result-not-found-state').classList.add('hidden');
        document.getElementById('result-empty-state').classList.remove('hidden');
        refreshCaptcha();
    }

    // Open Printable SKL Modal
    function triggerSklDownload() {
        if (!currentStudentData) {
            showToast('Silakan lakukan pencarian data NIM terlebih dahulu.', 'error');
            return;
        }

        document.getElementById('skl-print-nama').innerText = currentStudentData.nama;
        document.getElementById('skl-print-nim').innerText = currentStudentData.nim;
        document.getElementById('skl-print-prodi').innerText = currentStudentData.prodi;
        document.getElementById('skl-print-upbjj').innerText = currentStudentData.upbjj;
        document.getElementById('skl-print-ipk').innerText = `${currentStudentData.ipk} (${currentStudentData.predikat})`;
        document.getElementById('skl-print-pin').innerText = currentStudentData.pin;
        document.getElementById('skl-print-no').innerText = `Nomor: SKL/UT/${currentStudentData.masa}/${currentStudentData.nim}`;

        openModal('modal-skl-print');
    }

    // Image Preview Handler for Modal Upload
    function previewUploadImage(event) {
        const input = event.target;
        const previewBox = document.getElementById('upload-preview-box');
        const previewImg = document.getElementById('upload-preview-img');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                showToast('Ukuran file melebihi batas maksimum 2MB!', 'error');
                input.value = '';
                previewBox.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Form Submit Handler for Pasfoto Upload
    function handleUploadPasfotoForm(event) {
        event.preventDefault();
        const nim = document.getElementById('upload-nim-input').value.trim();
        closeModal('modal-unggah-foto');
        showToast(`Pasfoto untuk NIM ${nim} berhasil diunggah! Menunggu verifikasi operator.`, 'success');
    }

    // Tracking Lookup Handler
    function handleTrackingSearch(event) {
        event.preventDefault();
        document.getElementById('tracking-result-box').classList.remove('hidden');
        showToast('Data nomor resi ditemukan!', 'success');
    }

    // Verifikasi PIN Handler
    function handleVerifikasiSubmit(event) {
        event.preventDefault();
        const pin = document.getElementById('verifikasi-pin-input').value.trim();
        closeModal('modal-verifikasi');
        showToast(`PIN ${pin} TERVERIFIKASI Absah & Sah di Kemdikbud!`, 'success');
    }

    // Modal Helpers
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

    // Toast Notification System
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast-message');
        const toastText = document.getElementById('toast-text');
        const toastIcon = document.getElementById('toast-icon');

        toastText.innerText = message;

        if (type === 'error') {
            toastIcon.className = "fa-solid fa-circle-exclamation text-rose-400 text-lg";
        } else if (type === 'info') {
            toastIcon.className = "fa-solid fa-circle-info text-amber-400 text-lg";
        } else {
            toastIcon.className = "fa-solid fa-circle-check text-emerald-400 text-lg";
        }

        toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3500);
    }

    // Accordion Toggle
    function toggleFaq(num) {
        const body = document.getElementById(`faq-body-${num}`);
        const icon = document.getElementById(`faq-icon-${num}`);
        if (body.classList.contains('hidden')) {
            body.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            body.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }

    // Mobile Menu Toggle
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>
</body>
</html>
