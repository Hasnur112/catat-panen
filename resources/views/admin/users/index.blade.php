<x-app-layout>
    <x-slot name="title">Kelola Pengguna</x-slot>

    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0;">👥 Kelola Pengguna</h1>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">Manajemen akun seluruh pengguna sistem CatatPanen.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna
        </a>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9;">
            <span style="font-size: 14px; color: #64748b;">
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
                    <td style="color: #94a3b8; font-size: 13px;">{{ $users->firstItem() + $idx }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 50%; background: {{ $user->isAdmin() ? '#dcfce7' : '#dbeafe' }}; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; color: {{ $user->isAdmin() ? '#16a34a' : '#2563eb' }}; flex-shrink: 0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 14px; color: #1e293b;">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <div style="font-size: 11px; color: #94a3b8;">(Akun Anda)</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color: #475569;">{{ $user->email }}</td>
                    <td>
                        @if($user->isAdmin())
                            <span class="badge badge-green">👑 Admin</span>
                        @else
                            <span class="badge badge-blue">🌾 Petani</span>
                        @endif
                    </td>
                    <td style="font-weight: 600; color: #16a34a; text-align: center;">{{ $user->panen_count }}</td>
                    <td style="color: #94a3b8; font-size: 13px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna {{ $user->name }}? Data panen mereka juga akan terhapus!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
        <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
            {{ $users->links() }}
        </div>
        @else
        <div style="padding: 60px; text-align: center; color: #94a3b8;">
            <div style="font-size: 48px; margin-bottom: 12px;">👤</div>
            <p style="font-size: 15px; font-weight: 600;">Belum ada pengguna</p>
        </div>
        @endif
    </div>
</x-app-layout>
