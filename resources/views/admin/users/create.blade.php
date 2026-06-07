<x-app-layout>
    <x-slot name="title">Tambah Pengguna</x-slot>

    <div style="max-width: 580px;">
        <div style="margin-bottom: 28px;">
            <a href="{{ route('admin.users.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; margin-bottom: 12px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar Pengguna
            </a>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0; display: flex; align-items: center; gap: 8px;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Tambah Pengguna
            </h1>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">Buat akun baru untuk petani atau administrator.</p>
        </div>

        <div class="stat-card" style="padding: 32px;">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama lengkap pengguna" autocomplete="off">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email <span style="color: #dc2626;">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@contoh.com" autocomplete="off">
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role <span style="color: #dc2626;">*</span></label>
                    <select id="role" name="role" class="form-control">
                        <option value="petani" {{ old('role') === 'petani' ? 'selected' : '' }}>Petani</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password <span style="color: #dc2626;">*</span></label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span style="color: #dc2626;">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                </div>

                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Buat Pengguna
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="justify-content: center; padding: 12px 20px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
