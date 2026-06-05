<x-app-layout>
    <x-slot name="title">Edit Pengguna</x-slot>

    <div style="max-width: 580px;">
        <div style="margin-bottom: 28px;">
            <a href="{{ route('admin.users.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; margin-bottom: 12px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar Pengguna
            </a>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0;">✏️ Edit Pengguna</h1>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">Memperbarui data akun <strong>{{ $user->name }}</strong>.</p>
        </div>

        <div class="stat-card" style="padding: 32px;">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email <span style="color: #dc2626;">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role <span style="color: #dc2626;">*</span></label>
                    <select id="role" name="role" class="form-control">
                        <option value="petani" {{ old('role', $user->role) === 'petani' ? 'selected' : '' }}>🌾 Petani</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>👑 Administrator</option>
                    </select>
                    @error('role')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 20px;">
                    <p style="font-size: 13px; color: #64748b; margin: 0 0 12px; font-weight: 600;">Ganti Password (opsional)</p>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label for="password" class="form-label" style="font-size: 13px;">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="password_confirmation" class="form-label" style="font-size: 13px;">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="justify-content: center; padding: 12px 20px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
