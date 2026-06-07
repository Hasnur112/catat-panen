<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Panen;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GlobalDashboardController extends Controller
{
    public function index()
    {
        // Statistik global
        $totalUsers      = User::count();
        $totalPetani     = User::where('role', 'petani')->count();
        $totalAdmin      = User::whereIn('role', ['admin', 'super_admin'])->count();
        $totalPanen      = Panen::count();
        $totalVolume     = Panen::sum('volume');
        $totalPending    = Panen::where('status', 'Pending')->count();
        $totalVerified   = Panen::where('status', 'Verified')->count();

        // Volume per bulan (6 bulan terakhir) — semua user
        $labelBulan    = [];
        $grafikBulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labelBulan[] = $date->translatedFormat('M Y');
            $grafikBulanan[] = round((float) Panen::whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('volume'), 2);
        }

        // Top 5 petani berdasarkan total volume
        $topPetani = User::where('role', 'petani')
            ->withSum('panen', 'volume')
            ->withCount('panen')
            ->orderByDesc('panen_sum_volume')
            ->take(5)
            ->get();

        // Distribusi per varietas (global)
        $grafikVarietas = Panen::select('jenis_padi', DB::raw('SUM(volume) as total_volume'))
            ->groupBy('jenis_padi')
            ->orderByDesc('total_volume')
            ->get();

        // Data panen terbaru (semua user)
        $panenTerbaru = Panen::with('user')->latest('tanggal')->take(10)->get();

        // Semua admin
        $adminList = User::whereIn('role', ['admin', 'super_admin'])->orderBy('name')->get();

        return view('super_admin.dashboard', compact(
            'totalUsers', 'totalPetani', 'totalAdmin',
            'totalPanen', 'totalVolume', 'totalPending', 'totalVerified',
            'labelBulan', 'grafikBulanan',
            'topPetani', 'grafikVarietas',
            'panenTerbaru', 'adminList'
        ));
    }

    /**
     * Kelola akun (daftar semua user + tambah/edit/hapus)
     */
    public function users(\Illuminate\Http\Request $request)
    {
        $query = User::withCount('panen')->withSum('panen', 'volume')->orderBy('name');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(20);
        return view('super_admin.users', compact('users'));
    }


    /**
     * Update role user
     */
    public function updateRole(\Illuminate\Http\Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:petani,admin,super_admin'],
        ]);

        // Jangan bisa downgrade diri sendiri
        if ($user->id === auth()->id() && $request->role !== 'super_admin') {
            return back()->with('error', 'Kamu tidak bisa mengubah role dirimu sendiri.');
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}.");
    }

    /**
     * Hapus user beserta semua data panennya
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }
        $name = $user->name;
        $user->delete();
        return back()->with('success', "Akun {$name} beserta semua data panennya berhasil dihapus.");
    }
}
