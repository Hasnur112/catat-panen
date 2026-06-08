<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CatatPanen') }} — {{ $title ?? 'Dashboard' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Sidebar */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(160deg, #14532d 0%, #166534 50%, #15803d 100%);
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }
        #main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: #f0fdf4;
        }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 20px; border-radius: 10px; margin: 2px 12px;
            color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 500;
            transition: all 0.2s ease; cursor: pointer; text-decoration: none;
        }
        .nav-item:hover, .nav-item.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .nav-item.active {
            background: rgba(255,255,255,0.2);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }

        /* Stat cards */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 24px rgba(0,0,0,0.1); }

        /* Alert flash */
        .alert-success {
            background: #dcfce7; border: 1px solid #86efac; color: #166534;
            padding: 12px 16px; border-radius: 10px; font-size: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-error {
            background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b;
            padding: 12px 16px; border-radius: 10px; font-size: 14px;
            display: flex; align-items: center; gap: 8px;
        }

        /* Btn */
        .btn-primary {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff; padding: 9px 20px; border-radius: 10px; font-size: 14px;
            font-weight: 600; border: none; cursor: pointer; display: inline-flex;
            align-items: center; gap: 7px; text-decoration: none;
            transition: all 0.2s; box-shadow: 0 2px 8px rgba(22,163,74,0.3);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(22,163,74,0.4); color: #fff; }
        .btn-secondary {
            background: #f1f5f9; color: #475569; padding: 9px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 600; border: 1px solid #e2e8f0; cursor: pointer;
            display: inline-flex; align-items: center; gap: 7px; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-secondary:hover { background: #e2e8f0; color: #475569; }
        .btn-danger {
            background: #fee2e2; color: #dc2626; padding: 7px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600; border: 1px solid #fca5a5; cursor: pointer;
            display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-danger:hover { background: #dc2626; color: #fff; }
        .btn-edit {
            background: #fef3c7; color: #d97706; padding: 7px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600; border: 1px solid #fde68a; cursor: pointer;
            display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-edit:hover { background: #f59e0b; color: #fff; }

        /* Table */
        .table-wrapper { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #f8fafc; padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; }
        tbody td { padding: 14px 16px; font-size: 14px; color: #374151; border-bottom: 1px solid #f8fafc; }
        tbody tr:hover { background: #f0fdf4; }
        tbody tr:last-child td { border-bottom: none; }

        /* Badge */
        .badge { padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #16a34a; }
        .badge-yellow { background: #fef3c7; color: #d97706; }
        .badge-blue { background: #dbeafe; color: #2563eb; }

        /* Form */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 14px; color: #1e293b; background: #fff; transition: border 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-control:focus { border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,0.1); }
        .form-error { font-size: 13px; color: #dc2626; margin-top: 4px; }

        /* Sidebar mobile toggle */
        #sidebar-overlay { display: none; }
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-content { margin-left: 0; }
            #sidebar-overlay.open { display: block; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 40; }
        }
    </style>
</head>
<body>
    <aside id="sidebar">
        <div style="padding: 24px 20px 16px; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M12 7c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1"/>
                    </svg>
                </div>
                <div>
                    <div style="color: #fff; font-size: 16px; font-weight: 700; line-height: 1;">CatatPanen</div>
                    <div style="color: rgba(255,255,255,0.6); font-size: 11px; margin-top: 2px;">Manajemen Hasil Panen</div>
                </div>
            </a>
        </div>

        <nav style="flex: 1; padding: 16px 0; overflow-y: auto;">
            <div style="padding: 0 12px; margin-bottom: 8px;">
                <span style="color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; padding: 0 8px;">Menu Utama</span>
            </div>

            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

         
            <a href="{{ route('panen.index') }}"
               class="nav-item {{ request()->routeIs('panen.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Data Panen
            </a>
   @if(!auth()->user()->isAdminOrSuper())
            <a href="{{ route('panen.create') }}"
               class="nav-item {{ request()->routeIs('panen.create') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Catat Panen
            </a>
            @endif

            <a href="{{ route('petani.index') }}"
               class="nav-item {{ request()->routeIs('petani.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Panen Petani Lain
            </a>

            @if(auth()->user()->isAdminOrSuper())
            <div style="padding: 0 12px; margin: 16px 0 8px;">
                <span style="color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; padding: 0 8px;">Administrasi</span>
            </div>
            <a href="{{ route('admin.verifikasi.index') }}"
               class="nav-item {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Verifikasi Panen
                @php $pendingCount = \App\Models\Panen::where('status','Pending')->count(); @endphp
                @if($pendingCount > 0)
                <span style="background: #ef4444; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 20px; margin-left: auto;">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.varietas.index') }}"
               class="nav-item {{ request()->routeIs('admin.varietas.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Master Varietas
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Kelola Pengguna
            </a>
            @endif

            @if(auth()->user()->isSuperAdmin())
            <div style="padding: 0 12px; margin: 16px 0 8px;">
                <span style="color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; padding: 0 8px;">Super Admin</span>
            </div>
            <a href="{{ route('super_admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('super_admin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6m-6 0a3 3 0 00-3 3v12a3 3 0 003 3h6a3 3 0 003-3V6a3 3 0 00-3-3m-6 0V1m6 2V1M3 9h18"/>
                </svg>
                Dashboard Global
            </a>
            <a href="{{ route('super_admin.users') }}"
               class="nav-item {{ request()->routeIs('super_admin.users*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Konfigurasi Akun
            </a>
            @endif
        </nav>

        <div style="padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #fff; font-size: 14px; flex-shrink: 0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="overflow: hidden;">
                    <div style="color: #fff; font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name }}</div>
                    <div style="color: rgba(255,255,255,0.55); font-size: 11px;">
                        @if(auth()->user()->isSuperAdmin()) Super Admin
                        @elseif(auth()->user()->isAdmin()) Administrator
                        @else Petani
                        @endif
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%; text-align: left; background: transparent; border: none; margin: 0; padding: 9px 8px;">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div id="main-content">
        <div style="display: none; align-items: center; justify-content: space-between; padding: 14px 20px; background: #fff; border-bottom: 1px solid #f1f5f9; position: sticky; top: 0; z-index: 30;" id="mobile-header">
            <button onclick="toggleSidebar()" style="background: none; border: none; cursor: pointer; padding: 4px;">
                <svg width="24" height="24" fill="none" stroke="#374151" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span style="font-weight: 700; color: #16a34a; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M12 7c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1"/>
                </svg>
                CatatPanen
            </span>
            <div></div>
        </div>

        <div style="padding: 32px;">
            @if(session('success'))
                <div class="alert-success" style="margin-bottom: 20px;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error" style="margin-bottom: 20px;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebar-overlay').classList.toggle('open');
        }
        // Show mobile header on small screens
        if (window.innerWidth <= 768) {
            document.getElementById('mobile-header').style.display = 'flex';
        }
        window.addEventListener('resize', () => {
            document.getElementById('mobile-header').style.display = window.innerWidth <= 768 ? 'flex' : 'none';
        });
    </script>
</body>
</html>