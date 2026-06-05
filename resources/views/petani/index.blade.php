<x-app-layout>
    <x-slot name="title">Lihat Panen Petani Lain</x-slot>

    <!-- Header -->
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #14532d; margin: 0;">👨‍🌾 Data Panen Petani</h1>
        <p style="color: #64748b; font-size: 14px; margin: 4px 0 0;">Lihat hasil panen yang dicatat oleh petani lain.</p>
    </div>

    @if($petani->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @foreach($petani as $p)
        <a href="{{ route('petani.show', $p) }}"
           style="text-decoration: none; display: block; background: #fff; border-radius: 18px; padding: 24px;
                  border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                  transition: all 0.2s ease;">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 18px;">
                <!-- Avatar -->
                <div style="width: 52px; height: 52px; border-radius: 50%;
                            background: linear-gradient(135deg, #16a34a, #4ade80);
                            display: flex; align-items: center; justify-content: center;
                            font-weight: 800; font-size: 20px; color: #fff; flex-shrink: 0;">
                    {{ strtoupper(substr($p->name, 0, 1)) }}
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 16px; font-weight: 700; color: #1e293b;
                                white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $p->name }}
                    </div>
                    <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">
                        {{ $p->isAdmin() ? '👑 Administrator' : '🌾 Petani' }}
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div style="background: #f0fdf4; border-radius: 10px; padding: 12px; text-align: center;">
                    <div style="font-size: 22px; font-weight: 800; color: #16a34a;">
                        {{ $p->panen_count }}
                    </div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">Catatan Panen</div>
                </div>
                <div style="background: #fefce8; border-radius: 10px; padding: 12px; text-align: center;">
                    <div style="font-size: 18px; font-weight: 800; color: #ca8a04; line-height: 1.2;">
                        {{ $p->panen_count > 0 ? number_format($p->panen_sum_volume ?? 0, 0, ',', '.') : '0' }}
                    </div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">Total (kg)</div>
                </div>
            </div>

            <!-- CTA -->
            <div style="margin-top: 16px; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 13px; font-weight: 600; color: #16a34a;">
                    {{ $p->panen_count > 0 ? 'Lihat Detail →' : 'Belum ada data' }}
                </span>
                @if($p->panen_count === 0)
                    <span class="badge badge-yellow">Kosong</span>
                @else
                    <span class="badge badge-green">Aktif</span>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="stat-card" style="padding: 60px; text-align: center;">
        <div style="font-size: 56px; margin-bottom: 16px;">👥</div>
        <p style="font-size: 16px; font-weight: 600; color: #64748b; margin: 0 0 8px;">Belum ada pengguna lain</p>
        <p style="font-size: 14px; color: #94a3b8;">Belum ada petani lain yang terdaftar di sistem.</p>
    </div>
    @endif
</x-app-layout>
