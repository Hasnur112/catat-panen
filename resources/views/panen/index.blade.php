<x-app-layout>
    <x-slot name="title">Data Panen</x-slot>

    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0; display: flex; align-items: center; gap: 8px;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Data Panen
            </h1>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">
                {{ auth()->user()->isAdminOrSuper() ? 'Semua catatan panen dari seluruh petani' : 'Catatan panen Anda' }}
            </p>
        </div>
        <a href="{{ route('panen.create') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Catat Panen Baru
        </a>
    </div>

    <!-- Filter -->
    <div class="stat-card" style="margin-bottom: 20px; padding: 20px 24px;">
        <form method="GET" action="{{ route('panen.index') }}" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 180px;">
                <label class="form-label">Jenis Padi</label>
                <select name="jenis_padi" class="form-control">
                    <option value="">Semua Varietas</option>
                    @foreach($jenisPadi as $jenis)
                        <option value="{{ $jenis }}" {{ request('jenis_padi') === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 180px;">
                <label class="form-label">Bulan</label>
                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-primary">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    Filter
                </button>
                @if(request()->hasAny(['jenis_padi','bulan']))
                    <a href="{{ route('panen.index') }}" class="btn-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 14px; color: #64748b;">
                Menampilkan <strong>{{ $panen->firstItem() ?? 0 }}–{{ $panen->lastItem() ?? 0 }}</strong> dari <strong>{{ $panen->total() }}</strong> catatan
            </span>
        </div>

        @if($panen->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    @if(auth()->user()->isAdminOrSuper())<th>Petani</th>@endif
                    <th>Jenis Padi</th>
                    <th>Volume (kg)</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panen as $idx => $p)
                <tr>
                    <td style="color: #94a3b8; font-size: 13px;">{{ $panen->firstItem() + $idx }}</td>
                    <td style="font-weight: 500;">{{ $p->tanggal->format('d M Y') }}</td>
                    @if(auth()->user()->isAdminOrSuper())<td>{{ $p->user->name }}</td>@endif
                    <td><span class="badge badge-green">{{ $p->jenis_padi }}</span></td>
                    <td style="font-weight: 700; color: #16a34a;">{{ number_format($p->volume, 2, ',', '.') }}</td>
                    <td>
                        @if($p->status === 'Verified')
                            <span class="badge badge-green">Verified</span>
                        @else
                            <span class="badge badge-yellow">Pending</span>
                        @endif
                    </td>
                    <td style="color: #94a3b8; max-width: 200px;">
                        <span title="{{ $p->keterangan }}">{{ Str::limit($p->keterangan, 40) ?? '—' }}</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            @can('update', $p)
                            <a href="{{ route('panen.edit', $p) }}" class="btn-edit">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            @endcan
                            @can('delete', $p)
                            <form method="POST" action="{{ route('panen.destroy', $p) }}" onsubmit="return confirm('Hapus data panen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
            {{ $panen->links() }}
        </div>
        @else
        <div style="padding: 60px; text-align: center;">
            <div style="color: #16a34a; margin-bottom: 16px; display: inline-flex; align-items: center; justify-content: center;">
                <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M12 7c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1"/>
                </svg>
            </div>
            <p style="font-size: 16px; font-weight: 600; color: #64748b; margin: 0 0 8px;">Belum ada data panen</p>
            <p style="font-size: 14px; color: #94a3b8; margin: 0 0 20px;">{{ request()->hasAny(['jenis_padi','bulan']) ? 'Coba ubah filter pencarian' : 'Mulai catat hasil panen pertama Anda!' }}</p>
            <a href="{{ route('panen.create') }}" class="btn-primary">Catat Sekarang</a>
        </div>
        @endif
    </div>
</x-app-layout>
