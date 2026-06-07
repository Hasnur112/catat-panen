<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistik utama
        $query = $user->isAdminOrSuper() ? Panen::query() : Panen::where('user_id', $user->id);

        $totalPanen   = (clone $query)->count();
        $totalVolume  = (clone $query)->sum('volume');
        $panenBulanIni = (clone $query)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Varietas terbanyak
        $variasTerbanyak = (clone $query)
            ->select('jenis_padi', DB::raw('SUM(volume) as total_volume'))
            ->groupBy('jenis_padi')
            ->orderByDesc('total_volume')
            ->first();

        // Data grafik: volume per bulan (6 bulan terakhir)
        $grafikBulanan = [];
        $labelBulan = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labelBulan[] = $date->translatedFormat('M Y');
            $totalBulan = (clone $query)
                ->whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('volume');
            $grafikBulanan[] = round((float) $totalBulan, 2);
        }

        // Data grafik: distribusi per jenis padi
        $grafikVarietas = (clone $query)
            ->select('jenis_padi', DB::raw('SUM(volume) as total_volume'))
            ->groupBy('jenis_padi')
            ->orderByDesc('total_volume')
            ->get();

        // Panen terakhir
        $panenTerakhir = (clone $query)
            ->with('user')
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPanen',
            'totalVolume',
            'panenBulanIni',
            'variasTerbanyak',
            'labelBulan',
            'grafikBulanan',
            'grafikVarietas',
            'panenTerakhir'
        ));
    }
}
