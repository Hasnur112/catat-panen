<x-app-layout>
    <x-slot name="title">Data Panen</x-slot>

    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-green-900">Data Panen</h1>
                <p class="text-sm text-slate-500">
                    {{ auth()->user()->isAdminOrSuper() ? 'Daftar data panen seluruh petani' : 'Catatan panen Anda' }}
                </p>
            </div>
            @if(!auth()->user()->isAdminOrSuper())
                <a href="{{ route('panen.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition text-sm font-semibold">
                    + Catat Panen Baru
                </a>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Bukti</th>
                            <th class="px-6 py-4">Jenis</th>
                            <th class="px-6 py-4">Volume</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($panen as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $p->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($p->foto_bukti)
                                    <a href="{{ asset('storage/'.$p->foto_bukti) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                                @else - @endif
                            </td>
                            <td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">{{ $p->jenis_padi }}</span></td>
                            <td class="px-6 py-4 font-bold">{{ $p->volume }} kg</td>
                            <td class="px-6 py-4">
                                <span class="font-medium 
                                    {{ $p->status == 'Verified' ? 'text-green-600' : 
                                       ($p->status == 'Rejected' ? 'text-red-600' : 'text-amber-600') }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{-- Aksi hanya untuk petani jika statusnya Rejected --}}
                                @if(!auth()->user()->isAdminOrSuper() && $p->status == 'Rejected')
                                    <a href="{{ route('panen.edit', $p->id) }}" class="text-amber-600 hover:text-amber-800 font-bold">Edit Ulang</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>