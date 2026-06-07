<x-app-layout>
    <x-slot name="title">Edit Data Panen</x-slot>

    <div style="max-width: 640px;">
        <!-- Header -->
        <div style="margin-bottom: 28px;">
            <a href="{{ route('panen.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; margin-bottom: 12px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Data Panen
            </a>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0; display: flex; align-items: center; gap: 8px;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Data Panen
            </h1>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">Perbarui informasi catatan panen.</p>
        </div>

        <!-- Form Card -->
        <div class="stat-card" style="padding: 32px;">
            <form method="POST" action="{{ route('panen.update', $panen) }}">
                @csrf @method('PUT')

                <!-- Jenis Padi -->
                <div class="form-group">
                    <label for="jenis_padi" class="form-label">Jenis Padi <span style="color: #dc2626;">*</span></label>
                    <select id="jenis_padi" name="jenis_padi" class="form-control">
                        <option value="">— Pilih varietas padi —</option>
                        @foreach($jenisPadi as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_padi', $panen->jenis_padi) === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis_padi')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Volume -->
                <div class="form-group">
                    <label for="volume" class="form-label">Volume Panen (kg) <span style="color: #dc2626;">*</span></label>
                    <div style="position: relative;">
                        <input type="number" id="volume" name="volume" step="0.01" min="0.01" max="99999"
                               class="form-control" value="{{ old('volume', $panen->volume) }}"
                               style="padding-right: 48px;">
                        <span style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; font-weight: 600;">kg</span>
                    </div>
                    @error('volume')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal Panen <span style="color: #dc2626;">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control"
                           value="{{ old('tanggal', $panen->tanggal->format('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}">
                    @error('tanggal')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan <span style="color: #94a3b8; font-weight: 400;">(opsional)</span></label>
                    <textarea id="keterangan" name="keterangan" rows="3" class="form-control"
                              placeholder="Catatan tambahan...">{{ old('keterangan', $panen->keterangan) }}</textarea>
                    @error('keterangan')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('panen.index') }}" class="btn-secondary" style="justify-content: center; padding: 12px 20px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
