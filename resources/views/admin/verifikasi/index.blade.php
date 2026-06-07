<x-app-layout>
    <x-slot name="title">Verifikasi Panen</x-slot>

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

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#14532d;margin:0;">Verifikasi Data Panen</h1>
            <p style="font-size:14px;color:#64748b;margin:4px 0 0;">
                Periksa dan verifikasi data panen yang diinput petani.
                @if($totalPending > 0)
                    <span style="background:#fef3c7;color:#d97706;padding:2px 10px;border-radius:20px;font-weight:700;font-size:13px;">{{ $totalPending }} menunggu</span>
                @endif
            </p>
        </div>
        @if($totalPending > 0 && $statusFilter !== 'Verified')
        <form method="POST" action="{{ route('admin.verifikasi.verifyAll') }}" onsubmit="return confirm('Verifikasi semua {{ $totalPending }} data yang pending sekaligus?')">
            @csrf
            <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);display:inline-flex;align-items:center;gap:8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Verifikasi Semua ({{ $totalPending }})
            </button>
        </form>
        @endif
    </div>

    {{-- Tab Status --}}
    <div style="display:flex;gap:4px;margin-bottom:20px;background:#f8fafc;border-radius:12px;padding:4px;width:fit-content;">
        @foreach(['Pending' => ['label'=>'Pending','color'=>'#d97706','bg'=>'#fef3c7'], 'Verified' => ['label'=>'Verified','color'=>'#16a34a','bg'=>'#dcfce7'], '' => ['label'=>'Semua','color'=>'#475569','bg'=>'#e2e8f0']] as $val => $tab)
        <a href="{{ route('admin.verifikasi.index', array_merge(request()->except('status','page'), ['status'=>$val])) }}"
           style="padding:7px 18px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;transition:all 0.2s;
                  {{ $statusFilter === $val ? 'background:#fff;color:'.$tab['color'].';box-shadow:0 1px 4px rgba(0,0,0,0.08);' : 'color:#94a3b8;' }}">
            {{ $tab['label'] }}
            @if($val === 'Pending') <span style="background:#fef3c7;color:#d97706;font-size:11px;padding:1px 6px;border-radius:10px;margin-left:4px;">{{ $totalPending }}</span>
            @elseif($val === 'Verified') <span style="background:#dcfce7;color:#16a34a;font-size:11px;padding:1px 6px;border-radius:10px;margin-left:4px;">{{ $totalVerified }}</span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- Filter --}}
    <form method="GET" style="background:#fff;border-radius:14px;padding:18px 20px;margin-bottom:20px;border:1px solid #f1f5f9;display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <input type="hidden" name="status" value="{{ $statusFilter }}">
        <div style="flex:1;min-width:180px;">
            <label class="form-label">Filter Petani</label>
            <select name="petani_id" class="form-control" style="padding:9px 12px;">
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
        <button type="submit" class="btn-primary" style="padding:9px 20px;">Filter</button>
        @if(request()->anyFilled(['petani_id','tanggal_dari','tanggal_sampai']))
            <a href="{{ route('admin.verifikasi.index', ['status' => $statusFilter]) }}" class="btn-secondary" style="padding:9px 16px;">Reset</a>
        @endif
    </form>

    {{-- Tabel --}}
    @if($panen->isEmpty())
        <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;padding:48px;text-align:center;">
            <svg width="56" height="56" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" style="margin:0 auto 16px;display:block;opacity:0.5;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p style="font-size:16px;font-weight:600;color:#475569;margin:0;">
                @if($statusFilter === 'Pending') Tidak ada data yang menunggu verifikasi.
                @elseif($statusFilter === 'Verified') Belum ada data yang terverifikasi.
                @else Belum ada data panen sama sekali.
                @endif
            </p>
            <p style="font-size:13px;color:#94a3b8;margin-top:6px;">
                @if($statusFilter === 'Pending') Semua data panen telah terverifikasi.
                @else Coba ubah filter atau tab status di atas.
                @endif
            </p>
        </div>
    @else
    <div class="table-wrapper">
        <div style="padding:12px 20px;border-bottom:1px solid #f1f5f9;">
            <span style="font-size:13px;color:#64748b;">
                Menampilkan <strong>{{ $panen->firstItem() ?? 0 }}–{{ $panen->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $panen->total() }}</strong> data
            </span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Petani</th>
                    <th>Jenis Padi</th>
                    <th>Volume (kg)</th>
                    <th>Tanggal Panen</th>
                    <th>Status</th>
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
                    <td>
                        @if($item->status === 'Verified')
                            <span class="badge badge-green">Verified</span>
                        @else
                            <span class="badge badge-yellow">Pending</span>
                        @endif
                    </td>
                    <td style="font-size:13px;color:#94a3b8;">{{ $item->created_at->diffForHumans() }}</td>
                    <td>
                        <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                            {{-- Tombol Verifikasi (hanya untuk status Pending) --}}
                            @if($item->status === 'Pending')
                            <form method="POST" action="{{ route('admin.verifikasi.verify', $item) }}">
                                @csrf
                                <button type="submit" style="background:#dcfce7;color:#16a34a;border:1px solid #86efac;padding:5px 10px;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:4px;transition:all 0.2s;" onmouseover="this.style.background='#16a34a';this.style.color='#fff'" onmouseout="this.style.background='#dcfce7';this.style.color='#16a34a'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Verifikasi
                                </button>
                            </form>
                            @endif
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.verifikasi.edit', $item) }}" class="btn-edit" style="padding:5px 10px;font-size:12px;display:inline-flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            {{-- Tombol Hapus --}}
                            <form method="POST" action="{{ route('admin.verifikasi.destroy', $item) }}" onsubmit="return confirm('Hapus data panen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" style="padding:5px 10px;font-size:12px;display:inline-flex;align-items:center;gap:4px;">
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
