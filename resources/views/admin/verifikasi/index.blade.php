<x-app-layout>
    <x-slot name="title">Verifikasi Panen</x-slot>

    {{-- Header --}}
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0;">Verifikasi Data Panen</h1>
            <p style="font-size: 14px; color: #64748b; margin: 4px 0 0;">
                Periksa dan verifikasi data panen yang diinput petani.
                @if($total > 0)
                    <span style="background:#fef3c7;color:#d97706;padding:2px 10px;border-radius:20px;font-weight:700;font-size:13px;">{{ $total }} menunggu</span>
                @endif
            </p>
        </div>
        @if($total > 0)
        <form method="POST" action="{{ route('admin.verifikasi.verifyAll') }}" onsubmit="return confirm('Verifikasi semua {{ $total }} data sekaligus?')">
            @csrf
            <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Verifikasi Semua ({{ $total }})
            </button>
        </form>
        @endif
    </div>

    {{-- Filter --}}
    <form method="GET" style="background:#fff;border-radius:14px;padding:18px 20px;margin-bottom:20px;border:1px solid #f1f5f9;display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div style="flex:1;min-width:180px;">
            <label class="form-label">Filter Petani</label>
            <select name="petani_id" class="form-control" style="padding: 9px 12px;">
                <option value="">Semua Petani</option>
                @foreach($petani as $p)
                    <option value="{{ $p->id }}" {{ request('petani_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="flex:1;min-width:160px;">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
        </div>
        <div style="flex:1;min-width:160px;">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
        </div>
        <button type="submit" class="btn-primary" style="padding: 9px 20px;">Filter</button>
        @if(request()->anyFilled(['petani_id','tanggal_dari','tanggal_sampai']))
            <a href="{{ route('admin.verifikasi.index') }}" class="btn-secondary" style="padding: 9px 16px;">Reset</a>
        @endif
    </form>

    {{-- Tabel --}}
    @if($panen->isEmpty())
        <div style="background:#f0fdf4;border:1.5px solid #86efac;border-radius:14px;padding:48px;text-align:center;">
            <svg width="56" height="56" fill="none" stroke="#16a34a" viewBox="0 0 24 24" style="margin:0 auto 16px;display:block;opacity:0.5;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="font-size:16px;font-weight:600;color:#166534;margin:0;">Tidak ada data yang menunggu verifikasi.</p>
            <p style="font-size:13px;color:#64748b;margin-top:6px;">Semua data panen telah terverifikasi.</p>
        </div>
    @else
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Petani</th>
                    <th>Jenis Padi</th>
                    <th>Volume (kg)</th>
                    <th>Tanggal Panen</th>
                    <th>Keterangan</th>
                    <th>Diinput</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panen as $item)
                <tr>
                    <td>
                        <div style="font-weight:600;color:#1e293b;">{{ $item->user->name }}</div>
                        <div style="font-size:12px;color:#94a3b8;">{{ $item->user->email }}</div>
                    </td>
                    <td><span class="badge badge-green">{{ $item->jenis_padi }}</span></td>
                    <td style="font-weight:700;color:#14532d;">{{ number_format($item->volume, 2) }}</td>
                    <td>{{ $item->tanggal->format('d M Y') }}</td>
                    <td style="color:#64748b;font-size:13px;">{{ $item->keterangan ?? '-' }}</td>
                    <td style="font-size:13px;color:#94a3b8;">{{ $item->created_at->diffForHumans() }}</td>
                    <td>
                        <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                            {{-- Tombol Verifikasi --}}
                            <form method="POST" action="{{ route('admin.verifikasi.verify', $item) }}">
                                @csrf
                                <button type="submit" title="Verifikasi" style="background:#dcfce7;color:#16a34a;border:1px solid #86efac;padding:5px 10px;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:4px;transition:all 0.2s;" onmouseover="this.style.background='#16a34a';this.style.color='#fff'" onmouseout="this.style.background='#dcfce7';this.style.color='#16a34a'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Verifikasi
                                </button>
                            </form>
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.verifikasi.edit', $item) }}" class="btn-edit" style="padding:5px 10px;font-size:12px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            {{-- Tombol Hapus --}}
                            <form method="POST" action="{{ route('admin.verifikasi.destroy', $item) }}" onsubmit="return confirm('Hapus data panen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" style="padding:5px 10px;font-size:12px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($panen->hasPages())
    <div style="margin-top:20px;">{{ $panen->links() }}</div>
    @endif
    @endif

</x-app-layout>
