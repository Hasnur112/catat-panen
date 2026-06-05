<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaniController extends Controller
{
    /**
     * Daftar semua petani (kecuali diri sendiri).
     */
    public function index()
    {
        $petani = User::where('id', '!=', auth()->id())
            ->withCount('panen')
            ->withSum('panen', 'volume')
            ->orderBy('name')
            ->get();

        return view('petani.index', compact('petani'));
    }

    /**
     * Lihat detail panen milik petani tertentu (read-only).
     */
    public function show(User $petani, Request $request)
    {
        // Jangan tampilkan halaman diri sendiri lewat sini
        if ($petani->id === auth()->id()) {
            return redirect()->route('panen.index');
        }

        $query = Panen::where('user_id', $petani->id);

        // Filter jenis padi
        if ($request->filled('jenis_padi')) {
            $query->where('jenis_padi', $request->jenis_padi);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            [$year, $month] = explode('-', $request->bulan);
            $query->whereYear('tanggal', $year)->whereMonth('tanggal', $month);
        }

        $panen = $query->latest('tanggal')->paginate(10)->withQueryString();

        // Statistik ringkas petani ini
        $totalVolume     = Panen::where('user_id', $petani->id)->sum('volume');
        $totalPanen      = Panen::where('user_id', $petani->id)->count();
        $variasTerbanyak = Panen::where('user_id', $petani->id)
            ->select('jenis_padi', DB::raw('SUM(volume) as total_volume'))
            ->groupBy('jenis_padi')
            ->orderByDesc('total_volume')
            ->get();

        $jenisPadi = ['Ciherang', 'Inpari 32', 'Inpari 42', 'Mekongga',
                      'IR64', 'Situ Bagendit', 'Logawa', 'Cibogo', 'Memberamo', 'Lainnya'];

        return view('petani.show', compact(
            'petani', 'panen', 'totalVolume', 'totalPanen',
            'variasTerbanyak', 'jenisPadi'
        ));
    }
}
