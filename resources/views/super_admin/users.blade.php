<x-app-layout>
    <x-slot name="title">Kelola Semua Akun</x-slot>

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#14532d;margin:0;">Kelola Semua Akun</h1>
            <p style="font-size:14px;color:#64748b;margin:4px 0 0;">Ubah role atau hapus akun pengguna di seluruh sistem.</p>
        </div>
        <a href="{{ route('super_admin.dashboard') }}" class="btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Dashboard Global
        </a>
    </div>

    <div class="table-wrapper">
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
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="font-weight:600;color:#1e293b;">{{ $user->name }}</div>
                        @if($user->id === auth()->id())
                            <span style="background:#ede9fe;color:#7c3aed;font-size:10px;font-weight:700;padding:1px 6px;border-radius:10px;">Anda</span>
                        @endif
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
                            {{-- Ubah Role --}}
                            <div style="position:relative;" id="role-btn-{{ $user->id }}">
                                <button onclick="toggleRoleForm({{ $user->id }})" class="btn-edit" style="padding:5px 12px;font-size:12px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                    Ubah Role
                                </button>
                                <div id="role-form-{{ $user->id }}" style="display:none;position:absolute;right:0;top:110%;z-index:100;background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;min-width:220px;box-shadow:0 8px 24px rgba(0,0,0,0.12);">
                                    <p style="font-size:13px;color:#64748b;margin:0 0 10px;font-weight:600;">Ubah role {{ $user->name }}:</p>
                                    <form method="POST" action="{{ route('super_admin.users.updateRole', $user) }}">
                                        @csrf @method('PATCH')
                                        <select name="role" class="form-control" style="margin-bottom:10px;padding:7px 10px;font-size:13px;">
                                            <option value="petani" {{ $user->role === 'petani' ? 'selected' : '' }}>Petani</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        </select>
                                        <div style="display:flex;gap:6px;">
                                            <button type="submit" class="btn-primary" style="flex:1;justify-content:center;padding:7px;font-size:12px;">Simpan</button>
                                            <button type="button" onclick="toggleRoleForm({{ $user->id }})" class="btn-secondary" style="padding:7px 10px;font-size:12px;">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Hapus --}}
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('super_admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }} beserta SEMUA data panennya? Tindakan ini tidak bisa dibatalkan!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" style="padding:5px 12px;font-size:12px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="margin-top:20px;">{{ $users->links() }}</div>
    @endif

    <script>
        function toggleRoleForm(id) {
            // Tutup semua form lain
            document.querySelectorAll('[id^="role-form-"]').forEach(el => {
                if (el.id !== 'role-form-' + id) el.style.display = 'none';
            });
            const el = document.getElementById('role-form-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
        // Tutup saat klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id^="role-btn-"]')) {
                document.querySelectorAll('[id^="role-form-"]').forEach(el => el.style.display = 'none');
            }
        });
    </script>
</x-app-layout>
