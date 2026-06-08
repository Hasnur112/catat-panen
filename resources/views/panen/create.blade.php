<x-app-layout>
    <x-slot name="title">Catat Panen</x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-green-900">Catat Panen Baru</h1>
            <p class="text-slate-600">Isi formulir berikut untuk mencatat hasil panen Anda.</p>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-slate-200">
            <form method="POST" action="{{ route('panen.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Padi *</label>
                    <select name="jenis_padi" class="w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500 @error('jenis_padi') border-red-500 @enderror" required>
                        <option value="">— Pilih varietas —</option>
                        @foreach($jenisPadi as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_padi') === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Volume (kg) *</label>
                    <input type="number" name="volume" step="0.01" value="{{ old('volume') }}" 
                           class="w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Panen *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" 
                           class="w-full rounded-lg border-slate-300 focus:border-green-500 focus:ring-green-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Bukti Foto Panen *</label>
                    <input type="file" name="foto_bukti" accept="image/*" 
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" required>
                    <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" class="w-full rounded-lg border-slate-300">{{ old('keterangan') }}</textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-lg transition">
                        Simpan Data
                    </button>
                    <a href="{{ route('panen.index') }}" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>