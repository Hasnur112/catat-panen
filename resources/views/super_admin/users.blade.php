<x-app-layout>
    <x-slot name="title">Konfigurasi Akun — Super Admin</x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;padding:14px 18px;border-radius:12px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:14px 18px;border-radius:12px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#14532d;margin:0;display:flex;align-items:center;gap:10px;">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Konfigurasi Akun
            </h1>
            <p style="font-size:14px;color:#64748b;margin:4px 0 0;">Kelola semua akun — ubah role, tambah, atau hapus pengguna di seluruh sistem.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <a href="{{ route('admin.users.create') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Akun
            </a>
            <a href="{{ route('super_admin.dashboard') }}" class="btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Dashboard Global
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    @php
        $countPetani    = $users->getCollection()->where('role','petani')->count();
        $countAdmin     = $users->getCollection()->where('role','admin')->count();
        $countSuperAdmin= $users->getCollection()->where('role','super_admin')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px;margin-bottom:24px;">
        <div class="stat-card" style="padding:16px 20px;border-left:4px solid #6366f1;">
            <div style="font-size:11px;font-weight:600;color:#6366f1;text-transform:uppercase;letter-spacing:0.05em;">Total Akun</div>
            <div style="font-size:28px;font-weight:800;color:#1e293b;margin-top:4px;">{{ $users->total() }}</div>
            <div style="font-size:12px;color:#94a3b8;">pengguna terdaftar</div>
        </div>
        <div class="stat-card" style="padding:16px 20px;border-left:4px solid #16a34a;">
            <div style="font-size:11px;font-weight:600;color:#16a34a;text-transform:uppercase;letter-spacing:0.05em;">Petani</div>
            <div style="font-size:28px;font-weight:800;color:#1e293b;margin-top:4px;">{{ $countPetani }}</div>
            <div style="font-size:12px;color:#94a3b8;">di halaman ini</div>
        </div>
        <div class="stat-card" style="padding:16px 20px;border-left:4px solid #0ea5e9;">
            <div style="font-size:11px;font-weight:600;color:#0ea5e9;text-transform:uppercase;letter-spacing:0.05em;">Administrator</div>
            <div style="font-size:28px;font-weight:800;color:#1e293b;margin-top:4px;">{{ $countAdmin }}</div>
            <div style="font-size:12px;color:#94a3b8;">di halaman ini</div>
        </div>
        <div class="stat-card" style="padding:16px 20px;border-left:4px solid #7c3aed;">
            <div style="font-size:11px;font-weight:600;color:#7c3aed;text-transform:uppercase;letter-spacing:0.05em;">Super Admin</div>
            <div style="font-size:28px;font-weight:800;color:#1e293b;margin-top:4px;">{{ $countSuperAdmin }}</div>
            <div style="font-size:12px;color:#94a3b8;">di halaman ini</div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="stat-card" style="padding:16px 20px;margin-bottom:20px;">
        <form method="GET" action="{{ route('super_admin.users') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:2;min-width:180px;">
                <label class="form-label">Cari Nama / Email</label>
                <input type="text" name="search" class="form-control" placeholder="Ketik nama atau email..." value="{{ request('search') }}">
            </div>
            <div style="flex:1;min-width:150px;">
                <label class="form-label">Filter Role</label>
                <select name="role" class="form-control">
                    <option value="">Semua Role</option>
                    <option value="petani"      {{ request('role') === 'petani'      ? 'selected' : '' }}>Petani</option>
                    <option value="admin"       {{ request('role') === 'admin'       ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn-primary" style="padding:9px 18px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    Filter
                </button>
                @if(request()->hasAny(['search','role']))
                <a href="{{ route('super_admin.users') }}" class="btn-secondary" style="padding:9px 18px;">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel Akun --}}
    <div class="table-wrapper">
        <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:13px;color:#64748b;">
                Menampilkan <strong>{{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $users->total() }}</strong> akun
            </span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role Saat Ini</th>
                    <th>Total Panen</th>
                    <th>Total Volume</th>
                    <th>Bergabung</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;
                                background:{{ $user->role === 'super_admin' ? 'linear-gradient(135deg,#7c3aed,#a78bfa)' : ($user->role === 'admin' ? 'linear-gradient(135deg,#0ea5e9,#38bdf8)' : 'linear-gradient(135deg,#16a34a,#4ade80)') }};
                                display:flex;align-items:center;justify-content:center;
                                font-weight:800;font-size:13px;color:#fff;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;color:#1e293b;">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <span style="background:#ede9fe;color:#7c3aed;font-size:10px;font-weight:700;padding:1px 6px;border-radius:10px;">Anda</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:#64748b;font-size:13px;">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'super_admin')
                            <span class="badge" style="background:#ede9fe;color:#7c3aed;">Super Admin</span>
                        @elseif($user->role === 'admin')
                            <span class="badge badge-blue">Admin</span>
                        @else
                            <span class="badge badge-green">Petani</span>
                        @endif
                    </td>
                    <td style="font-weight:600;color:#374151;">{{ $user->panen_count ?? 0 }}</td>
                    <td style="font-weight:600;color:#14532d;">{{ number_format($user->panen_sum_volume ?? 0, 0, ',', '.') }} kg</td>
                    <td style="color:#94a3b8;font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">

                            {{-- Edit Akun --}}
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit" style="padding:5px 12px;font-size:12px;display:inline-flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>

                            {{-- Ubah Role --}}
                            <div style="position:relative;" id="role-btn-{{ $user->id }}">
                                <button onclick="toggleRoleForm({{ $user->id }})" class="btn-secondary" style="padding:5px 12px;font-size:12px;display:inline-flex;align-items:center;gap:4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                    Role
                                </button>
                                <div id="role-form-{{ $user->id }}" style="display:none;position:absolute;right:0;top:110%;z-index:100;background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;min-width:220px;box-shadow:0 8px 24px rgba(0,0,0,0.12);">
                                    <p style="font-size:13px;color:#64748b;margin:0 0 10px;font-weight:600;">Ubah role <strong>{{ $user->name }}</strong>:</p>
                                    <form method="POST" action="{{ route('super_admin.users.updateRole', $user) }}">
                                        @csrf @method('PATCH')
                                        <select name="role" class="form-control" style="margin-bottom:10px;padding:7px 10px;font-size:13px;">
                                            <option value="petani"      {{ $user->role === 'petani'      ? 'selected' : '' }}>Petani</option>
                                            <option value="admin"       {{ $user->role === 'admin'       ? 'selected' : '' }}>Admin</option>
                                            <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        </select>
                                        <div style="display:flex;gap:6px;">
                                            <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:7px;font-size:12px;">Simpan</button>
                                            <button type="button" onclick="toggleRoleForm({{ $user->id }})" class="btn-secondary" style="padding:7px 10px;font-size:12px;">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Hapus (tidak bisa hapus diri sendiri) --}}
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('super_admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }} beserta SEMUA data panennya?\n\nTindakan ini tidak bisa dibatalkan!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" style="padding:5px 12px;font-size:12px;display:inline-flex;align-items:center;gap:4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:50px;color:#94a3b8;">
                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;color:#cbd5e1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Tidak ada akun yang sesuai dengan filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
        <div style="padding:16px 20px;border-top:1px solid #f1f5f9;">
            {{ $users->withQueryString()->links() }}
        </div>
        @endif
    </div>

    <script>
        function toggleRoleForm(id) {
            document.querySelectorAll('[id^="role-form-"]').forEach(el => {
                if (el.id !== 'role-form-' + id) el.style.display = 'none';
            });
            const el = document.getElementById('role-form-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id^="role-btn-"]')) {
                document.querySelectorAll('[id^="role-form-"]').forEach(el => el.style.display = 'none');
            }
        });
    </script>
</x-app-layout>
