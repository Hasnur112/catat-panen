<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Varietas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanenController extends Controller
{
    // Tambahkan method ini agar error hilang
    public function create()
    {
        return view('panen.create', [
            'jenisPadi' => Varietas::orderBy('nama')->pluck('nama')->toArray(),
        ]);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->isAdminOrSuper()
            ? Panen::with('user')
            : Panen::where('user_id', $user->id)->with('user');

        // Tambahkan filter jika diperlukan
        if ($request->filled('jenis_padi')) {
            $query->where('jenis_padi', $request->jenis_padi);
        }

        return view('panen.index', [
            'panen' => $query->latest()->paginate(10),
            'jenisPadi' => Varietas::orderBy('nama')->pluck('nama')->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_padi' => 'required',
            'volume' => 'required|numeric',
            'tanggal' => 'required|date',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto_bukti');
        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti_panen', 'public');
        }

        // Status default saat baru dibuat
        $data['status'] = 'Pending';
        auth()->user()->panen()->create($data);

        return redirect()->route('panen.index')->with('success', 'Data berhasil dikirim!');
    }

    public function updateStatus(Request $request, Panen $panen)
    {
        if (!auth()->user()->isAdminOrSuper()) abort(403);

        $request->validate([
            'status' => 'required|in:Verified,Rejected',
            'catatan_penolakan' => 'nullable|string'
        ]);
        
        $panen->update([
            'status' => $request->status,
            'catatan_penolakan' => $request->catatan_penolakan
        ]);

        return redirect()->back()->with('success', 'Status berhasil diupdate.');
    }

    public function edit(Panen $panen)
    {
        if (auth()->user()->isPetani() && $panen->status !== 'Rejected') {
            abort(403, 'Data tidak bisa diedit.');
        }
        
        return view('panen.edit', [
            'panen' => $panen,
            'jenisPadi' => Varietas::orderBy('nama')->pluck('nama')->toArray()
        ]);
    }

    public function update(Request $request, Panen $panen)
    {
        $request->validate(['foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048']);
        
        $data = $request->except('foto_bukti');
        if ($request->hasFile('foto_bukti')) {
            if ($panen->foto_bukti) Storage::disk('public')->delete($panen->foto_bukti);
            $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti_panen', 'public');
        }
        
        $data['status'] = 'Pending';
        $data['catatan_penolakan'] = null;

        $panen->update($data);

        return redirect()->route('panen.index')->with('success', 'Data berhasil diperbarui.');
    }
}