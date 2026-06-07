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
        // Hanya Petani (bukan admin) yang ditampilkan di daftar Petani,
        // dan hanya hitung/sum data panen yang sudah Verified.
        $petani = User::where('role', 'petani')
            ->where('id', '!=', auth()->id())
            ->withCount(['panen' => function ($query) {
                $query->where('status', 'Verified');
            }])
            ->withSum(['panen' => function ($query) {
                $query->where('status', 'Verified');
            }], 'volume')
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

        $query = Panen::where('user_id', $petani->id)
                      ->where('status', 'Verified');

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

        // Statistik ringkas petani ini (hanya Verified)
        $totalVolume     = Panen::where('user_id', $petani->id)->where('status', 'Verified')->sum('volume');
        $totalPanen      = Panen::where('user_id', $petani->id)->where('status', 'Verified')->count();
        $variasTerbanyak = Panen::where('user_id', $petani->id)
            ->where('status', 'Verified')
            ->select('jenis_padi', DB::raw('SUM(volume) as total_volume'))
            ->groupBy('jenis_padi')
            ->orderByDesc('total_volume')
            ->get();

        $jenisPadi = \App\Models\Varietas::orderBy('nama')->pluck('nama')->toArray();

        return view('petani.show', compact(
            'petani', 'panen', 'totalVolume', 'totalPanen',
            'variasTerbanyak', 'jenisPadi'
        ));
    }
}
