<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Dalam Pengembangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #4f46e5);
            overflow: hidden;
            position: relative;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: .3;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: #38bdf8;
            top: -80px;
            left: -80px;
        }

        .circle-2 {
            width: 350px;
            height: 350px;
            background: #8b5cf6;
            bottom: -100px;
            right: -100px;
        }

        .glass-card {
            background: rgba(255,255,255,.10);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.20);
            border-radius: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,.25);
        }

        .icon-bounce {
            font-size: 90px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%,100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        .feature-card {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 20px;
            transition: .3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,.15);
        }

        .feature-icon {
            font-size: 36px;
        }

        .badge-custom {
            background: #facc15;
            color: #000;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 700;
        }

        .btn-home {
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .footer-text {
            color: rgba(255,255,255,.8);
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="bg-circle circle-1"></div>
<div class="bg-circle circle-2"></div>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-8">

            <div class="glass-card text-center p-5 text-white">

                <div class="icon-bounce">
                    🚧
                </div>

                <div class="mb-4">
                    <span class="badge-custom">
                        UNDER CONSTRUCTION
                    </span>
                </div>

                <h1 class="display-4 fw-bold mb-3">
                    Sedang Dalam Pengembangan
                </h1>

                <p class="lead text-light mb-5">
                    Mohon maaf, halaman yang Anda tuju saat ini masih dalam proses
                    pengembangan. Kami sedang menyiapkan fitur terbaik agar dapat
                    memberikan pengalaman yang lebih baik.
                </p>

                <div class="row g-4 mb-5">

                    <div class="col-md-4">
                        <div class="feature-card p-4 h-100">
                            <div class="feature-icon">⚡</div>
                            <h5 class="mt-3">Lebih Cepat</h5>
                            <small class="text-light">
                                Optimasi performa sistem dan akses data.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-card p-4 h-100">
                            <div class="feature-icon">🎨</div>
                            <h5 class="mt-3">Lebih Modern</h5>
                            <small class="text-light">
                                Desain antarmuka yang lebih nyaman digunakan.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-card p-4 h-100">
                            <div class="feature-icon">🔒</div>
                            <h5 class="mt-3">Lebih Aman</h5>
                            <small class="text-light">
                                Peningkatan keamanan dan perlindungan data.
                            </small>
                        </div>
                    </div>

                </div>

                <div class="mb-4">
                    <a href="{{ url('/') }}" class="btn btn-light btn-home">
                        ← Kembali ke Beranda
                    </a>
                </div>

                <div class="footer-text">
                    © {{ date('Y') }} Sistem Tracer Study
                </div>

            </div>

        </div>
    </div>
</div>
</body>
</html>
