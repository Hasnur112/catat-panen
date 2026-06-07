<x-app-layout>
    <x-slot name="title">Catat Panen</x-slot>

    <div style="max-width: 640px;">
        <!-- Header -->
        <div style="margin-bottom: 28px;">
            <a href="{{ route('panen.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 500; text-decoration: none; margin-bottom: 12px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Data Panen
            </a>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0; display: flex; align-items: center; gap: 8px;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Catat Panen Baru
            </h1>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">Isi formulir berikut untuk mencatat hasil panen Anda.</p>
        </div>

        <!-- Form Card -->
        <div class="stat-card" style="padding: 32px;">
            <form method="POST" action="{{ route('panen.store') }}">
                @csrf

                <!-- Jenis Padi -->
                <div class="form-group">
                    <label for="jenis_padi" class="form-label">Jenis Padi <span style="color: #dc2626;">*</span></label>
                    <select id="jenis_padi" name="jenis_padi" class="form-control {{ $errors->has('jenis_padi') ? 'border-red-500' : '' }}">
                        <option value="">— Pilih varietas padi —</option>
                        @foreach($jenisPadi as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_padi') === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis_padi')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Volume -->
                <div class="form-group">
                    <label for="volume" class="form-label">Volume Panen (kg) <span style="color: #dc2626;">*</span></label>
                    <div style="position: relative;">
                        <input type="number" id="volume" name="volume" step="0.01" min="0.01" max="99999"
                               class="form-control {{ $errors->has('volume') ? 'border-red-500' : '' }}"
                               value="{{ old('volume') }}" placeholder="Contoh: 1250.50"
                               style="padding-right: 48px;">
                        <span style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; font-weight: 600;">kg</span>
                    </div>
                    @error('volume')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal Panen <span style="color: #dc2626;">*</span></label>
                    <input type="date" id="tanggal" name="tanggal"
                           class="form-control {{ $errors->has('tanggal') ? 'border-red-500' : '' }}"
                           value="{{ old('tanggal', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}">
                    @error('tanggal')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan <span style="color: #94a3b8; font-weight: 400;">(opsional)</span></label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                              class="form-control {{ $errors->has('keterangan') ? 'border-red-500' : '' }}"
                              placeholder="Catatan tambahan tentang kondisi panen, cuaca, dll.">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button type="submit" class="btn-primary" style="flex: 1; justify-content: center; padding: 12px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Data Panen
                    </button>
                    <a href="{{ route('panen.index') }}" class="btn-secondary" style="justify-content: center; padding: 12px 20px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
