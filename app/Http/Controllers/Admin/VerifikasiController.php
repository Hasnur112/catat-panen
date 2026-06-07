<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Panen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    /**
     * Daftar data panen yang menunggu verifikasi (status = Pending).
     */
    public function index(Request $request)
    {
        $query = Panen::with('user')->where('status', 'Pending');

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

        $panen   = $query->latest('tanggal')->paginate(15)->withQueryString();
        $petani  = User::where('role', 'petani')->orderBy('name')->get();
        $total   = Panen::where('status', 'Pending')->count();

        return view('admin.verifikasi.index', compact('panen', 'petani', 'total'));
    }

    /**
     * Verifikasi (approve) satu data panen.
     */
    public function verify(Panen $panen)
    {
        $panen->update(['status' => 'Verified']);

        return back()->with('success', "Data panen {$panen->user->name} berhasil diverifikasi.");
    }

    /**
     * Verifikasi massal semua yang Pending (sesuai filter halaman).
     */
    public function verifyAll(Request $request)
    {
        $count = Panen::where('status', 'Pending')->update(['status' => 'Verified']);

        return back()->with('success', "{$count} data panen berhasil diverifikasi sekaligus.");
    }

    /**
     * Edit data panen dari halaman verifikasi (admin bisa koreksi).
     */
    public function edit(Panen $panen)
    {
        $jenisPadi = [
            'Ciherang', 'Inpari 32', 'Inpari 42', 'Mekongga',
            'IR64', 'Situ Bagendit', 'Logawa', 'Cibogo',
            'Memberamo', 'Lainnya',
        ];
        return view('admin.verifikasi.edit', compact('panen', 'jenisPadi'));
    }

    /**
     * Simpan koreksi data panen oleh admin.
     */
    public function update(Request $request, Panen $panen)
    {
        $data = $request->validate([
            'jenis_padi' => ['required', 'string', 'max:100'],
            'volume'     => ['required', 'numeric', 'min:0.01'],
            'tanggal'    => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:500'],
            'status'     => ['required', 'in:Pending,Verified'],
        ]);

        $panen->update($data);

        return redirect()->route('admin.verifikasi.index')
            ->with('success', 'Data panen berhasil diperbarui.');
    }

    /**
     * Hapus / tolak data panen.
     */
    public function destroy(Panen $panen)
    {
        $name = $panen->user->name;
        $panen->delete();

        return back()->with('success', "Data panen milik {$name} berhasil dihapus.");
    }
}
