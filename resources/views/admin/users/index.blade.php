<x-app-layout>
    <x-slot name="title">Kelola Pengguna</x-slot>

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
            <h1 style="font-size:24px;font-weight:800;color:#14532d;margin:0;display:flex;align-items:center;gap:8px;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Kelola Pengguna
            </h1>
            <p style="color:#64748b;font-size:14px;margin:4px 0 0;">
                Manajemen akun pengguna sistem CatatPanen.
                <span style="color:#94a3b8;font-size:13px;">
                    (Admin hanya dapat membuat/edit akun Petani dan Admin)
                </span>
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna
        </a>
    </div>

    {{-- Tabel --}}
    <div class="table-wrapper">
        <div style="padding:16px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:14px;color:#64748b;">
                Total <strong>{{ $users->total() }}</strong> pengguna terdaftar
            </span>
        </div>

        @if($users->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Jumlah Panen</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $idx => $user)
                <tr>
                    <td style="color:#94a3b8;font-size:13px;">{{ $users->firstItem() + $idx }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;
                                background:{{
                                    $user->role === 'super_admin' ? 'linear-gradient(135deg,#7c3aed,#a78bfa)' :
                                    ($user->role === 'admin'      ? 'linear-gradient(135deg,#0ea5e9,#38bdf8)' :
                                                                    'linear-gradient(135deg,#16a34a,#4ade80)')
                                }};
                                display:flex;align-items:center;justify-content:center;
                                font-weight:800;font-size:13px;color:#fff;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:14px;color:#1e293b;">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <div style="font-size:11px;color:#94a3b8;">(Akun Anda)</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:#475569;">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'super_admin')
                            <span class="badge" style="background:#ede9fe;color:#7c3aed;">Super Admin</span>
                        @elseif($user->role === 'admin')
                            <span class="badge badge-blue">Admin</span>
                        @else
                            <span class="badge badge-green">Petani</span>
                        @endif
                    </td>
                    <td style="font-weight:600;color:#16a34a;text-align:center;">{{ $user->panen_count }}</td>
                    <td style="color:#94a3b8;font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            {{-- Super admin hanya bisa diedit oleh super admin --}}
                            @if($user->role !== 'super_admin')
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit" style="padding:5px 12px;font-size:12px;display:inline-flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus pengguna {{ addslashes($user->name) }}? Data panen mereka juga akan terhapus!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" style="padding:5px 12px;font-size:12px;display:inline-flex;align-items:center;gap:4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                            @else
                            {{-- Akun Super Admin tidak bisa diedit oleh Admin biasa --}}
                            <span style="font-size:12px;color:#94a3b8;padding:5px 4px;font-style:italic;">
                                Dikelola Super Admin
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 24px;border-top:1px solid #f1f5f9;">
            {{ $users->links() }}
        </div>
        @else
        <div style="padding:60px;text-align:center;color:#94a3b8;">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;opacity:0.4;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <p style="font-size:15px;font-weight:600;margin:0;">Belum ada pengguna</p>
        </div>
        @endif
    </div>
</x-app-layout>
