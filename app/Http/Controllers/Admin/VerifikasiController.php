<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Panen;
use App\Models\User;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    /**
     * Daftar data panen yang menunggu verifikasi (status = Pending).
     */
    public function index(Request $request)
    {
        $statusFilter = $request->get('status', 'Pending');

        $query = Panen::with('user');

        if ($statusFilter !== '') {
            $query->where('status', $statusFilter);
        }

        // Filter opsional
        if ($request->filled('petani_id')) {
            $query->where('user_id', $request->petani_id);
        }
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $panen = $query->latest('tanggal')->paginate(15)->withQueryString();
        $petani = User::where('role', 'petani')->orderBy('name')->get();
        $totalPending = Panen::where('status', 'Pending')->count();
        $totalVerified = Panen::where('status', 'Verified')->count();

        return view('admin.verifikasi.index', compact(
            'panen', 'petani', 'totalPending', 'totalVerified', 'statusFilter'
        ));
    }

    /**
     * Memperbarui status panen (Verified atau Rejected).
     * Ini menggantikan fungsi verify(), edit(), dan destroy().
     */
    public function updateStatus(Request $request, Panen $panen)
    {
        $request->validate([
            'status' => 'required|in:Verified,Rejected',
            'catatan_penolakan' => 'nullable|string|max:255',
        ]);

        $panen->update([
            'status' => $request->status,
            'catatan_penolakan' => $request->status == 'Rejected' ? $request->catatan_penolakan : null,
        ]);

        $message = $request->status == 'Verified' 
            ? "Data panen milik {$panen->user->name} telah diverifikasi." 
            : "Data panen milik {$panen->user->name} telah ditolak.";

        return back()->with('success', $message);
    }

    /**
     * Verifikasi massal semua yang Pending.
     */
    public function verifyAll(Request $request)
    {
        $count = Panen::where('status', 'Pending')->update(['status' => 'Verified']);

        return back()->with('success', "{$count} data panen berhasil diverifikasi sekaligus.");
    }
}