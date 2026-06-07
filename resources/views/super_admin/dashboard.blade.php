<x-app-layout>
    <x-slot name="title">Dashboard Global Super Admin</x-slot>

    {{-- Header --}}
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 26px; font-weight: 800; color: #14532d; margin: 0;">Dashboard Global</h1>
        <p style="font-size: 14px; color: #64748b; margin: 4px 0 0;">Monitoring sistem secara keseluruhan — semua user, semua panen.</p>
    </div>

    {{-- Stat Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px;">

        <div class="stat-card" style="border-left: 4px solid #6366f1;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#6366f1;text-transform:uppercase;letter-spacing:0.05em;">Total User</span>
                <div style="background:#ede9fe;padding:6px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <div style="font-size:30px;font-weight:800;color:#1e293b;">{{ $totalUsers }}</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:4px;">{{ $totalPetani }} petani, {{ $totalAdmin }} admin</div>
        </div>

        <div class="stat-card" style="border-left: 4px solid #16a34a;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#16a34a;text-transform:uppercase;letter-spacing:0.05em;">Total Panen</span>
                <div style="background:#dcfce7;padding:6px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div style="font-size:30px;font-weight:800;color:#1e293b;">{{ $totalPanen }}</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:4px;">catatan panen</div>
        </div>

        <div class="stat-card" style="border-left: 4px solid #0ea5e9;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#0ea5e9;text-transform:uppercase;letter-spacing:0.05em;">Total Volume</span>
                <div style="background:#e0f2fe;padding:6px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#0ea5e9" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                </div>
            </div>
            <div style="font-size:26px;font-weight:800;color:#1e293b;">{{ number_format($totalVolume, 0, ',', '.') }}</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:4px;">kilogram</div>
        </div>

        <div class="stat-card" style="border-left: 4px solid #f59e0b;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#d97706;text-transform:uppercase;letter-spacing:0.05em;">Pending</span>
                <div style="background:#fef3c7;padding:6px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div style="font-size:30px;font-weight:800;color:#1e293b;">{{ $totalPending }}</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:4px;">belum diverifikasi</div>
        </div>

        <div class="stat-card" style="border-left: 4px solid #10b981;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#10b981;text-transform:uppercase;letter-spacing:0.05em;">Verified</span>
                <div style="background:#d1fae5;padding:6px;border-radius:8px;">
                    <svg width="18" height="18" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div style="font-size:30px;font-weight:800;color:#1e293b;">{{ $totalVerified }}</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:4px;">sudah terverifikasi</div>
        </div>

    </div>

    {{-- Grafik + Top Petani --}}
    <div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; margin-bottom: 28px;">

        {{-- Grafik Volume Bulanan --}}
        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 8px rgba(0,0,0,0.04);">
            <h3 style="font-size:15px;font-weight:700;color:#1e293b;margin:0 0 16px;">Volume Panen Global (6 Bulan Terakhir)</h3>
            <div style="position:relative;height:280px;">
                <canvas id="chartGlobal"></canvas>
            </div>
        </div>

        {{-- Top 5 Petani --}}
        <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 8px rgba(0,0,0,0.04);">
            <h3 style="font-size:15px;font-weight:700;color:#1e293b;margin:0 0 16px;">Top 5 Petani (Volume)</h3>
            @forelse($topPetani as $i => $p)
            <div style="display:flex;align-items:center;gap:12px;padding:10px 0;{{ !$loop->last ? 'border-bottom:1px solid #f8fafc;' : '' }}">
                <div style="width:28px;height:28px;border-radius:50%;background:{{ $i === 0 ? '#fbbf24' : ($i === 1 ? '#94a3b8' : ($i === 2 ? '#cd7c2f' : '#f1f5f9')) }};display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;color:{{ $i < 3 ? '#fff' : '#64748b' }};flex-shrink:0;">
                    {{ $i + 1 }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:14px;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->name }}</div>
                    <div style="font-size:12px;color:#94a3b8;">{{ $p->panen_count }} catatan panen</div>
                </div>
                <div style="font-weight:700;font-size:14px;color:#16a34a;white-space:nowrap;">
                    {{ number_format($p->panen_sum_volume, 0, ',', '.') }} kg
                </div>
            </div>
            @empty
            <p style="color:#94a3b8;font-size:14px;text-align:center;padding:20px 0;">Belum ada data panen.</p>
            @endforelse
        </div>
    </div>

    {{-- Tabel Panen Terbaru --}}
    <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 8px rgba(0,0,0,0.04);margin-bottom:28px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="font-size:15px;font-weight:700;color:#1e293b;margin:0;">Panen Terbaru (Semua User)</h3>
            <a href="{{ route('admin.verifikasi.index') }}" style="font-size:13px;color:#16a34a;text-decoration:none;font-weight:600;">Lihat verifikasi →</a>
        </div>
        <div class="table-wrapper" style="border-radius:10px;">
            <table>
                <thead>
                    <tr>
                        <th>Petani</th>
                        <th>Jenis Padi</th>
                        <th>Volume (kg)</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($panenTerbaru as $item)
                    <tr>
                        <td style="font-weight:600;">{{ $item->user->name }}</td>
                        <td>{{ $item->jenis_padi }}</td>
                        <td style="font-weight:700;color:#14532d;">{{ number_format($item->volume, 2) }}</td>
                        <td>{{ $item->tanggal->format('d M Y') }}</td>
                        <td>
                            @if($item->status === 'Verified')
                                <span class="badge badge-green">Verified</span>
                            @else
                                <span class="badge badge-yellow">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Daftar Admin --}}
    <div style="background:#fff;border-radius:16px;padding:24px;border:1px solid #f1f5f9;box-shadow:0 1px 8px rgba(0,0,0,0.04);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <h3 style="font-size:15px;font-weight:700;color:#1e293b;margin:0;">Akun Admin & Super Admin</h3>
            <a href="{{ route('super_admin.users') }}" style="font-size:13px;color:#16a34a;text-decoration:none;font-weight:600;">Kelola semua akun →</a>
        </div>
        <div class="table-wrapper" style="border-radius:10px;">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adminList as $a)
                    <tr>
                        <td style="font-weight:600;">{{ $a->name }}</td>
                        <td style="color:#64748b;font-size:13px;">{{ $a->email }}</td>
                        <td>
                            @if($a->role === 'super_admin')
                                <span class="badge" style="background:#ede9fe;color:#7c3aed;">Super Admin</span>
                            @else
                                <span class="badge badge-blue">Admin</span>
                            @endif
                        </td>
                        <td style="color:#94a3b8;font-size:13px;">{{ $a->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('chartGlobal').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labelBulan),
            datasets: [{
                label: 'Volume (kg)',
                data: @json($grafikBulanan),
                backgroundColor: 'rgba(99, 102, 241, 0.15)',
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });
    </script>

</x-app-layout>
