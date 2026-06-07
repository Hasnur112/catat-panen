<x-app-layout>
    <x-slot name="title">Edit Data Panen</x-slot>

    <div style="max-width: 640px;">
        <div style="margin-bottom: 20px;">
            <a href="{{ route('admin.verifikasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:14px;text-decoration:none;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Verifikasi
            </a>
        </div>

        <h1 style="font-size: 22px; font-weight: 800; color: #14532d; margin-bottom: 6px;">Edit Data Panen</h1>
        <p style="font-size:14px;color:#64748b;margin-bottom:24px;">
            Koreksi data panen milik <strong>{{ $panen->user->name }}</strong>
        </p>

        <div style="background:#fff;border-radius:16px;padding:28px;border:1px solid #f1f5f9;box-shadow:0 1px 8px rgba(0,0,0,0.05);">
            <form method="POST" action="{{ route('admin.verifikasi.update', $panen) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label">Jenis Padi</label>
                    <select name="jenis_padi" class="form-control">
                        @foreach($jenisPadi as $j)
                            <option value="{{ $j }}" {{ old('jenis_padi', $panen->jenis_padi) === $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                    @error('jenis_padi')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Volume (kg)</label>
                    <input type="number" name="volume" step="0.01" min="0.01"
                           class="form-control" value="{{ old('volume', $panen->volume) }}">
                    @error('volume')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Panen</label>
                    <input type="date" name="tanggal" class="form-control"
                           value="{{ old('tanggal', $panen->tanggal->format('Y-m-d')) }}">
                    @error('tanggal')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Pending" {{ old('status', $panen->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Verified" {{ old('status', $panen->status) === 'Verified' ? 'selected' : '' }}>Verified</option>
                    </select>
                    @error('status')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan...">{{ old('keterangan', $panen->keterangan) }}</textarea>
                    @error('keterangan')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.verifikasi.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
