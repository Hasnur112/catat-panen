<x-app-layout>
    <x-slot name="title">Panen {{ $petani->name }}</x-slot>

    <!-- Back + Header -->
    <div style="margin-bottom: 28px;">
        <a href="{{ route('petani.index') }}"
           style="display: inline-flex; align-items: center; gap: 6px; color: #64748b;
                  font-size: 13px; font-weight: 500; text-decoration: none; margin-bottom: 16px;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Petani
        </a>

        <!-- Profil Petani -->
        <div class="stat-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; margin-bottom: 24px;">
            <div style="width: 64px; height: 64px; border-radius: 50%;
                        background: linear-gradient(135deg, #16a34a, #4ade80);
                        display: flex; align-items: center; justify-content: center;
                        font-weight: 800; font-size: 26px; color: #fff; flex-shrink: 0;">
                {{ strtoupper(substr($petani->name, 0, 1)) }}
            </div>
            <div style="flex: 1;">
                <h1 style="font-size: 22px; font-weight: 800; color: #14532d; margin: 0;">
                    {{ $petani->name }}
                </h1>
                <p style="color: #64748b; font-size: 13px; margin: 4px 0 0;">
                    {{ $petani->isAdmin() ? 'Administrator' : 'Petani' }} · {{ $petani->email }}
                </p>
            </div>
            <!-- Info badge -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px 16px; text-align: center; flex-shrink: 0;">
                <div style="font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Mode</div>
                <div style="font-size: 13px; font-weight: 700; color: #16a34a; margin-top: 2px; display: inline-flex; align-items: center; gap: 4px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Saja
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
            <div class="stat-card">
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Total Catatan</div>
                <div style="font-size: 30px; font-weight: 800; color: #14532d;">{{ number_format($totalPanen) }}</div>
                <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">panen tercatat</div>
            </div>
            <div class="stat-card">
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Total Volume</div>
                <div style="font-size: 30px; font-weight: 800; color: #14532d;">{{ number_format($totalVolume, 0, ',', '.') }}</div>
                <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">kilogram</div>
            </div>
            <div class="stat-card">
                <div style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Varietas Terbanyak</div>
                <div style="font-size: 20px; font-weight: 800; color: #14532d; line-height: 1.2;">
                    {{ $variasTerbanyak->first()?->jenis_padi ?? '—' }}
                </div>
                <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">
                    {{ $variasTerbanyak->first() ? number_format($variasTerbanyak->first()->total_volume, 0, ',', '.') . ' kg' : 'belum ada data' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Peringkat Varietas -->
    @if($variasTerbanyak->count() > 0)
    <div class="stat-card" style="padding: 24px; margin-bottom: 24px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px; display: flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: #d97706;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a4 4 0 004-4V5H8v6a4 4 0 004 4zm0 0v4m-4 0h8M4 9h4m12 0h-4"/>
            </svg>
            Varietas yang Pernah Dipanen
        </h3>
        <div style="display: grid; gap: 10px;">
            @foreach($variasTerbanyak as $item)
            @php $pct = $variasTerbanyak->first()->total_volume > 0 ? ($item->total_volume / $variasTerbanyak->first()->total_volume) * 100 : 0; @endphp
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 26px; height: 26px; border-radius: 50%;
                            background: {{ $loop->first ? '#fef3c7' : '#f0fdf4' }};
                            display: flex; align-items: center; justify-content: center;
                            font-size: 12px; font-weight: 700;
                            color: {{ $loop->first ? '#d97706' : '#16a34a' }}; flex-shrink: 0;">
                    {{ $loop->iteration }}
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-size: 13px; font-weight: 600; color: #1e293b;">{{ $item->jenis_padi }}</span>
                        <span style="font-size: 13px; font-weight: 700; color: #16a34a;">{{ number_format($item->total_volume, 0, ',', '.') }} kg</span>
                    </div>
                    <div style="height: 5px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $pct }}%; background: linear-gradient(90deg, #16a34a, #4ade80); border-radius: 10px;"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filter & Tabel -->
    <div class="stat-card" style="padding: 20px 24px; margin-bottom: 20px;">
        <form method="GET" action="{{ route('petani.show', $petani) }}"
              style="display: flex; gap: 14px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 160px;">
                <label class="form-label">Jenis Padi</label>
                <select name="jenis_padi" class="form-control">
                    <option value="">Semua Varietas</option>
                    @foreach($jenisPadi as $jenis)
                        <option value="{{ $jenis }}" {{ request('jenis_padi') === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 160px;">
                <label class="form-label">Bulan</label>
                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter
                </button>
                @if(request()->hasAny(['jenis_padi', 'bulan']))
                    <a href="{{ route('petani.show', $petani) }}" class="btn-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Panen (Read-Only) -->
    <div class="table-wrapper">
        <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 14px; color: #64748b;">
                Menampilkan <strong>{{ $panen->firstItem() ?? 0 }}–{{ $panen->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $panen->total() }}</strong> catatan
            </span>
            <!-- Badge read-only -->
            <span style="display: inline-flex; align-items: center; gap: 5px; background: #fef3c7;
                         color: #d97706; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Hanya Bisa Dilihat
            </span>
        </div>

        @if($panen->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Jenis Padi</th>
                    <th>Volume (kg)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panen as $idx => $p)
                <tr>
                    <td style="color: #94a3b8; font-size: 13px;">{{ $panen->firstItem() + $idx }}</td>
                    <td style="font-weight: 500;">{{ $p->tanggal->format('d M Y') }}</td>
                    <td><span class="badge badge-green">{{ $p->jenis_padi }}</span></td>
                    <td style="font-weight: 700; color: #16a34a;">{{ number_format($p->volume, 2, ',', '.') }}</td>
                    <td style="color: #94a3b8;">{{ Str::limit($p->keterangan, 50) ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
            <p style="font-size: 15px; font-weight: 600; color: #64748b; margin: 0 0 6px;">
                {{ request()->hasAny(['jenis_padi','bulan']) ? 'Data tidak ditemukan' : 'Belum ada catatan panen' }}
            </p>
            <p style="font-size: 13px; color: #94a3b8;">
                {{ request()->hasAny(['jenis_padi','bulan']) ? 'Coba ubah filter pencarian.' : $petani->name . ' belum mencatat hasil panen.' }}
            </p>
        </div>
        @endif
    </div>
</x-app-layout>
