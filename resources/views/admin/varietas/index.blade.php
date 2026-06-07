<x-app-layout>
    <x-slot name="title">Master Varietas</x-slot>

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

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0;">Master Data Varietas</h1>
            <p style="font-size: 14px; color: #64748b; margin: 4px 0 0;">Kelola daftar varietas padi yang tersedia untuk dipilih petani.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 340px 1fr; gap: 24px; align-items: start;">

        {{-- Form Tambah --}}
        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 8px rgba(0,0,0,0.05);">
            <h3 style="font-size:16px;font-weight:700;color:#1e293b;margin:0 0 16px;">Tambah Varietas Baru</h3>
            <form method="POST" action="{{ route('admin.varietas.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Varietas</label>
                    <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'border-red-500' : '' }}"
                           placeholder="Contoh: Ciherang, Inpari 32..."
                           value="{{ old('nama') }}" maxlength="100">
                    @error('nama')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Varietas
                </button>
            </form>
        </div>

        {{-- Tabel Daftar --}}
        <div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Nama Varietas</th>
                            <th>Ditambahkan</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($varietas as $v)
                        <tr>
                            <td style="color:#94a3b8;font-size:13px;">{{ $varietas->firstItem() + $loop->index }}</td>
                            <td style="font-weight:600;color:#1e293b;">{{ $v->nama }}</td>
                            <td style="color:#94a3b8;font-size:13px;">{{ $v->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display:flex;gap:8px;justify-content:center;align-items:center;">
                                    {{-- Inline Edit Form --}}
                                    <button onclick="toggleEditVarietas({{ $v->id }})" class="btn-edit" style="padding:5px 12px;font-size:12px;">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.varietas.destroy', $v) }}" onsubmit="return confirm('Hapus varietas {{ $v->nama }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger" style="padding:5px 12px;font-size:12px;">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                {{-- Inline Edit Row --}}
                                <div id="edit-varietas-{{ $v->id }}" style="display:none;margin-top:8px;">
                                    <form method="POST" action="{{ route('admin.varietas.update', $v) }}" style="display:flex;gap:8px;">
                                        @csrf @method('PUT')
                                        <input type="text" name="nama" value="{{ $v->nama }}" class="form-control" style="padding:6px 10px;font-size:13px;" maxlength="100">
                                        <button type="submit" class="btn-primary" style="padding:6px 14px;font-size:12px;white-space:nowrap;">Simpan</button>
                                        <button type="button" onclick="toggleEditVarietas({{ $v->id }})" class="btn-secondary" style="padding:6px 12px;font-size:12px;">Batal</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;color:#94a3b8;padding:32px;">Belum ada varietas. Tambahkan yang pertama!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($varietas->hasPages())
            <div style="margin-top:16px;">{{ $varietas->links() }}</div>
            @endif
        </div>
    </div>

    <script>
        function toggleEditVarietas(id) {
            const el = document.getElementById('edit-varietas-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</x-app-layout>
