<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Page Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0;">Dashboard</h1>
            <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">Selamat datang, {{ auth()->user()->name }}! Berikut ringkasan data panen Anda.</p>
        </div>
        <a href="{{ route('panen.create') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Catat Panen Baru
        </a>
    </div>

    <!-- Stat Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
        <div class="stat-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Total Panen</span>
                <div style="width: 40px; height: 40px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #16a34a;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
            <div style="font-size: 32px; font-weight: 800; color: #14532d; line-height: 1;">{{ number_format($totalPanen) }}</div>
            <div style="font-size: 13px; color: #64748b; margin-top: 4px;">catatan panen</div>
        </div>

        <div class="stat-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Total Volume</span>
                <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #d97706;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
            </div>
            <div style="font-size: 32px; font-weight: 800; color: #14532d; line-height: 1;">{{ number_format($totalVolume, 0, ',', '.') }}</div>
            <div style="font-size: 13px; color: #64748b; margin-top: 4px;">kilogram hasil panen</div>
        </div>

        <div class="stat-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Bulan Ini</span>
                <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div style="font-size: 32px; font-weight: 800; color: #14532d; line-height: 1;">{{ number_format($panenBulanIni) }}</div>
            <div style="font-size: 13px; color: #64748b; margin-top: 4px;">panen di {{ now()->translatedFormat('F Y') }}</div>
        </div>

        <div class="stat-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Varietas Terbaik</span>
                <div style="width: 40px; height: 40px; background: #fce7f3; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #db2777;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a4 4 0 004-4V5H8v6a4 4 0 004 4zm0 0v4m-4 0h8M4 9h4m12 0h-4"/>
                    </svg>
                </div>
            </div>
            <div style="font-size: 20px; font-weight: 800; color: #14532d; line-height: 1.2;">{{ $variasTerbanyak?->jenis_padi ?? '—' }}</div>
            <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
                {{ $variasTerbanyak ? number_format($variasTerbanyak->total_volume, 0, ',', '.') . ' kg' : 'belum ada data' }}
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 28px;">
        <!-- Grafik Produksi Bulanan -->
        <div class="stat-card" style="padding: 24px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Produksi 6 Bulan Terakhir</h3>
                    <p style="font-size: 13px; color: #64748b; margin: 4px 0 0;">Total volume panen per bulan (kg)</p>
                </div>
                <span class="badge badge-green">Bar Chart</span>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="chartBulanan"></canvas>
            </div>
        </div>

        <!-- Grafik Distribusi Varietas -->
        <div class="stat-card" style="padding: 24px;">
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Distribusi Varietas</h3>
                <p style="font-size: 13px; color: #64748b; margin: 4px 0 0;">Perbandingan hasil per jenis padi</p>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="chartVarietas"></canvas>
            </div>
        </div>
    </div>

    <!-- Peringkat Varietas -->
    @if($grafikVarietas->count() > 0)
    <div class="stat-card" style="margin-bottom: 28px; padding: 24px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 16px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: #d97706;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a4 4 0 004-4V5H8v6a4 4 0 004 4zm0 0v4m-4 0h8M4 9h4m12 0h-4"/>
            </svg>
            Peringkat Varietas Padi
        </h3>
        <div style="display: grid; gap: 12px;">
            @foreach($grafikVarietas->take(5) as $idx => $item)
            @php $pct = $grafikVarietas->first()->total_volume > 0 ? ($item->total_volume / $grafikVarietas->first()->total_volume) * 100 : 0; @endphp
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $idx === 0 ? '#fef3c7' : ($idx === 1 ? '#f1f5f9' : '#f0fdf4') }}; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: {{ $idx === 0 ? '#d97706' : ($idx === 1 ? '#64748b' : '#16a34a') }}; flex-shrink: 0;">
                    {{ $loop->iteration }}
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ $item->jenis_padi }}</span>
                        <span style="font-size: 13px; font-weight: 700; color: #16a34a;">{{ number_format($item->total_volume, 0, ',', '.') }} kg</span>
                    </div>
                    <div style="height: 6px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $pct }}%; background: linear-gradient(90deg, #16a34a, #4ade80); border-radius: 10px; transition: width 1s ease;"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Panen Terakhir -->
    <div class="table-wrapper">
        <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Panen Terakhir</h3>
            <a href="{{ route('panen.index') }}" class="btn-secondary" style="padding: 7px 14px; font-size: 13px;">Lihat Semua</a>
        </div>
        @if($panenTerakhir->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    @if(auth()->user()->isAdmin())<th>Petani</th>@endif
                    <th>Jenis Padi</th>
                    <th>Volume</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panenTerakhir as $p)
                <tr>
                    <td>{{ $p->tanggal->format('d M Y') }}</td>
                    @if(auth()->user()->isAdmin())<td>{{ $p->user->name }}</td>@endif
                    <td><span class="badge badge-green">{{ $p->jenis_padi }}</span></td>
                    <td style="font-weight: 600; color: #16a34a;">{{ number_format($p->volume, 2, ',', '.') }} kg</td>
                    <td style="color: #94a3b8;">{{ $p->keterangan ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="padding: 48px; text-align: center; color: #94a3b8;">
            <div style="color: #16a34a; margin-bottom: 12px; display: inline-flex; align-items: center; justify-content: center;">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M12 7c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1m6 4c2-1 4-1 6 1m-6-1c-2-1-4-1-6 1"/>
                </svg>
            </div>
            <p style="font-size: 15px; font-weight: 600; color: #64748b;">Belum ada data panen</p>
            <p style="font-size: 13px;">Mulai catat hasil panen pertama Anda!</p>
            <a href="{{ route('panen.create') }}" class="btn-primary" style="margin-top: 12px;">Catat Sekarang</a>
        </div>
        @endif
    </div>

    <!-- Chart.js Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const colors = ['#16a34a','#22c55e','#4ade80','#86efac','#bbf7d0','#dcfce7','#15803d','#166534'];

        // Grafik Bulanan
        const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
        new Chart(ctxBulanan, {
            type: 'bar',
            data: {
                labels: @json($labelBulan),
                datasets: [{
                    label: 'Volume (kg)',
                    data: @json($grafikBulanan),
                    backgroundColor: 'rgba(22, 163, 74, 0.15)',
                    borderColor: '#16a34a',
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(22, 163, 74, 0.3)',
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 12 } } },
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 12 } } }
                }
            }
        });

        // Grafik Varietas
        const ctxVarietas = document.getElementById('chartVarietas').getContext('2d');
        const varietasLabels = @json($grafikVarietas->pluck('jenis_padi'));
        const varietasData = @json($grafikVarietas->pluck('total_volume'));
        new Chart(ctxVarietas, {
            type: 'doughnut',
            data: {
                labels: varietasLabels,
                datasets: [{
                    data: varietasData,
                    backgroundColor: colors.slice(0, varietasLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverBorderColor: '#fff',
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 }, color: '#64748b' } }
                }
            }
        });
    });
    </script>
</x-app-layout>
