<x-app-layout>
    <x-slot name="title">Verifikasi Panen</x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;padding:14px 18px;border-radius:12px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;">
        {{ session('success') }}
    </div>
    @endif

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#14532d;margin:0;">Verifikasi Data Panen</h1>
            <p style="font-size:14px;color:#64748b;margin:4px 0 0;">Kelola status validasi data panen petani.</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="table-wrapper" style="background:#fff;border-radius:14px;border:1px solid #f1f5f9;overflow:hidden;">
        <table>
            <thead>
                <tr style="background:#f8fafc;text-align:left;">
                    <th style="padding:15px;color:#475569;">Petani</th>
                    <th style="padding:15px;color:#475569;">Jenis</th>
                    <th style="padding:15px;color:#475569;">Volume</th>
                    <th style="padding:15px;color:#475569;">Bukti</th>
                    <th style="padding:15px;color:#475569;">Tanggal</th>
                    <th style="padding:15px;color:#475569;">Status</th>
                    <th style="padding:15px;color:#475569;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($panen as $item)
                <tr>
                    <td style="padding:15px;">
                        <div style="font-weight:600;color:#1e293b;">{{ $item->user->name }}</div>
                    </td>
                    <td style="padding:15px;">{{ $item->jenis_padi }}</td>
                    <td style="padding:15px;font-weight:700;">{{ number_format($item->volume, 0) }} kg</td>
                    
                    {{-- Kolom Bukti --}}
                    <td style="padding:15px;">
                        @if($item->foto_bukti)
                            <a href="{{ asset('storage/'.$item->foto_bukti) }}" target="_blank" style="color:#2563eb;text-decoration:underline;font-size:13px;font-weight:600;">
                                Lihat Foto
                            </a>
                        @else
                            <span style="color:#94a3b8;font-size:13px;">N/A</span>
                        @endif
                    </td>

                    <td style="padding:15px;">{{ $item->tanggal->format('d M Y') }}</td>
                    <td style="padding:15px;">
                        <span style="padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;
                            {{ $item->status == 'Verified' ? 'background:#dcfce7;color:#16a34a;' : 
                               ($item->status == 'Rejected' ? 'background:#fee2e2;color:#dc2626;' : 'background:#fef3c7;color:#d97706;') }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td style="padding:15px;text-align:center;">
                        @if($item->status === 'Pending')
                            <div style="display:flex;gap:8px;justify-content:center;">
                                {{-- Tombol Verifikasi --}}
                                <form method="POST" action="{{ route('admin.panen.updateStatus', $item->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Verified">
                                    <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:6px 12px;border-radius:6px;font-size:12px;cursor:pointer;">
                                        Verifikasi
                                    </button>
                                </form>

                                {{-- Tombol Tolak --}}
                                <form method="POST" action="{{ route('admin.panen.updateStatus', $item->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Rejected">
                                    <input type="hidden" name="catatan_penolakan" value="Data tidak valid. Silahkan periksa kembali.">
                                    <button type="submit" style="background:#dc2626;color:#fff;border:none;padding:6px 12px;border-radius:6px;font-size:12px;cursor:pointer;">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="font-size:12px;color:#94a3b8;">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:20px;">
        {{ $panen->links() }}
    </div>
</x-app-layout>