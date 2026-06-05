<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CatatPanen — Solusi Digitalisasi Hasil Pertanian</title>
    <meta name="description" content="CatatPanen membantu petani Polewali Mandar mencatat dan menganalisis data hasil panen secara digital, akurat, dan mudah.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f0fdf4; color: #1e293b; }

        /* Hero */
        .hero {
            background: linear-gradient(135deg, #14532d 0%, #166534 40%, #15803d 70%, #16a34a 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            top: -200px; right: -100px;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
            bottom: -100px; left: -50px;
        }

        /* Navbar */
        nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 60px; position: relative; z-index: 10;
        }
        .logo { display: flex; align-items: center; gap: 12px; }
        .logo-icon { width: 44px; height: 44px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .logo-text { color: #fff; font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
        .nav-links { display: flex; gap: 12px; }
        .btn-nav-outline { color: rgba(255,255,255,0.85); border: 1.5px solid rgba(255,255,255,0.3); padding: 9px 22px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .btn-nav-outline:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .btn-nav-solid { color: #14532d; background: #fff; padding: 9px 22px; border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn-nav-solid:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0,0,0,0.2); }

        /* Hero Content */
        .hero-body {
            flex: 1; display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 60px 20px; position: relative; z-index: 10;
        }
        .hero-badge {
            display: inline-block; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
            color: rgba(255,255,255,0.9); padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 500;
            margin-bottom: 24px; backdrop-filter: blur(10px);
        }
        .hero-title { font-size: 64px; font-weight: 900; color: #fff; line-height: 1.1; letter-spacing: -2px; margin-bottom: 20px; }
        .hero-title span { color: #86efac; }
        .hero-sub { font-size: 18px; color: rgba(255,255,255,0.75); max-width: 540px; margin: 0 auto 40px; line-height: 1.6; font-weight: 400; }
        .hero-cta { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .btn-cta-main {
            background: #fff; color: #14532d; padding: 14px 32px; border-radius: 12px; font-size: 15px; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2); transition: all 0.2s;
        }
        .btn-cta-main:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,0.25); }
        .btn-cta-outline {
            color: #fff; border: 2px solid rgba(255,255,255,0.4); padding: 14px 32px; border-radius: 12px;
            font-size: 15px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-cta-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.6); }

        /* Stats strip */
        .stats-strip {
            background: rgba(0,0,0,0.2); backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex; justify-content: center; gap: 60px;
            padding: 24px 40px; position: relative; z-index: 10;
        }
        .stat-item { text-align: center; }
        .stat-num { font-size: 28px; font-weight: 800; color: #fff; }
        .stat-lbl { font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 2px; }

        /* Features */
        .section { padding: 80px 60px; max-width: 1100px; margin: 0 auto; }
        .section-badge { display: inline-block; background: #dcfce7; color: #16a34a; padding: 4px 14px; border-radius: 20px; font-size: 13px; font-weight: 700; margin-bottom: 16px; }
        .section-title { font-size: 40px; font-weight: 800; color: #14532d; letter-spacing: -1px; margin-bottom: 12px; }
        .section-sub { font-size: 16px; color: #64748b; max-width: 500px; line-height: 1.6; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 48px; }
        .feature-card {
            background: #fff; border-radius: 20px; padding: 28px; border: 1px solid #f1f5f9;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,0.08); }
        .feature-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 16px; }
        .feature-title { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .feature-desc { font-size: 14px; color: #64748b; line-height: 1.6; }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #14532d, #16a34a);
            margin: 0 60px 80px; border-radius: 24px; padding: 60px;
            text-align: center; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: '🌾'; font-size: 200px; position: absolute; right: -20px; top: -20px;
            opacity: 0.05; line-height: 1;
        }

        /* Footer */
        footer { background: #14532d; color: rgba(255,255,255,0.6); text-align: center; padding: 24px; font-size: 13px; }

        @media (max-width: 768px) {
            .hero-title { font-size: 36px; }
            nav { padding: 16px 20px; }
            .section { padding: 60px 20px; }
            .features-grid { grid-template-columns: 1fr; }
            .stats-strip { gap: 30px; flex-wrap: wrap; }
            .cta-section { margin: 0 20px 60px; padding: 40px 24px; }
        }
    </style>
</head>
<body>
    <!-- Hero -->
    <section class="hero">
        <nav>
            <div class="logo">
                <div class="logo-icon">🌾</div>
                <span class="logo-text">CatatPanen</span>
            </div>
            <div class="nav-links">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nav-solid">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav-outline">Masuk</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nav-solid">Daftar Gratis</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <div class="hero-body">
            <div>
                <div class="hero-badge">📍 Polewali Mandar, Sulawesi Barat</div>
                <h1 class="hero-title">Catat Hasil Panen<br><span>Lebih Cerdas</span></h1>
                <p class="hero-sub">Digitalisasi pencatatan hasil panen Anda. Analisis produktivitas lahan, bandingkan varietas padi, dan buat keputusan pertanian yang lebih akurat.</p>
                <div class="hero-cta">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-cta-main">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-cta-main">
                            🚀 Mulai Sekarang — Gratis
                        </a>
                        <a href="{{ route('login') }}" class="btn-cta-outline">
                            Sudah punya akun? Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Stats Strip -->
        <div class="stats-strip">
            <div class="stat-item">
                <div class="stat-num">10+</div>
                <div class="stat-lbl">Varietas Padi</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">GRATIS</div>
                <div class="stat-lbl">Tanpa Biaya</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">Real-time</div>
                <div class="stat-lbl">Analisis Data</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">RBAC</div>
                <div class="stat-lbl">Multi-role Sistem</div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <div style="background: #f0fdf4; padding: 0;">
        <div class="section">
            <div class="section-badge">✨ Fitur Unggulan</div>
            <h2 class="section-title">Semua yang dibutuhkan<br>untuk manajemen panen</h2>
            <p class="section-sub">Dirancang khusus untuk kebutuhan petani dan pengurus kelompok tani di wilayah Polewali Mandar.</p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon" style="background: #dcfce7;">📋</div>
                    <div class="feature-title">Pencatatan CRUD Lengkap</div>
                    <div class="feature-desc">Tambah, lihat, ubah, dan hapus catatan panen dengan mudah. Dukung pencatatan tanggal, volume, varietas, dan keterangan tambahan.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: #fef3c7;">📊</div>
                    <div class="feature-title">Dashboard Analitik</div>
                    <div class="feature-desc">Visualisasi data produksi bulanan dengan grafik interaktif dan peringkat varietas padi berdasarkan total produksi.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: #dbeafe;">🔐</div>
                    <div class="feature-title">Kontrol Akses Berbasis Peran</div>
                    <div class="feature-desc">Dua level akses: Administrator untuk manajemen penuh, dan Petani untuk mengelola data panen mereka sendiri.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: #fce7f3;">🌾</div>
                    <div class="feature-title">Analisis Varietas</div>
                    <div class="feature-desc">Bandingkan produktivitas berbagai varietas padi seperti Ciherang, Inpari 32, Mekongga, dan lainnya secara langsung.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: #f3e8ff;">👥</div>
                    <div class="feature-title">Manajemen Pengguna</div>
                    <div class="feature-desc">Admin dapat membuat, mengedit, dan mengelola akun seluruh petani di kelompok tani dengan mudah.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: #ecfdf5;">🔍</div>
                    <div class="feature-title">Filter & Pencarian</div>
                    <div class="feature-desc">Saring data panen berdasarkan jenis padi atau periode bulan untuk analisis yang lebih fokus dan akurat.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div style="background: #f0fdf4; padding-bottom: 0;">
        <div style="max-width: 1100px; margin: 0 auto; padding: 0 60px 80px;">
            <div class="cta-section">
                <h2 style="font-size: 40px; font-weight: 900; color: #fff; margin-bottom: 16px; letter-spacing: -1px;">Mulai digitalisasi<br>panen Anda hari ini</h2>
                <p style="color: rgba(255,255,255,0.75); font-size: 16px; margin-bottom: 32px;">Bergabunglah dan rasakan kemudahan pencatatan hasil panen berbasis data.</p>
                @guest
                <a href="{{ route('register') }}" style="background: #fff; color: #14532d; padding: 14px 36px; border-radius: 12px; font-size: 16px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                    Daftar Sekarang — Gratis 🚀
                </a>
                @endguest
                @auth
                <a href="{{ url('/dashboard') }}" style="background: #fff; color: #14532d; padding: 14px 36px; border-radius: 12px; font-size: 16px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                    Buka Dashboard 📊
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>© {{ date('Y') }} CatatPanen — Proyek MPPL | Polewali Mandar, Sulawesi Barat</p>
        <p style="margin-top: 4px;">Dikembangkan oleh Muhammad Ali Sadikin · Manajer: Hasnur</p>
    </footer>
</body>
</html>
