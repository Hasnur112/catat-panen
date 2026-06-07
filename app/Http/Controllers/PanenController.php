<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePanenRequest;
use App\Models\Panen;
use Illuminate\Http\Request;

class PanenController extends Controller
{
    private array $jenisPadi = [
        'Ciherang', 'Inpari 32', 'Inpari 42', 'Mekongga',
        'IR64', 'Situ Bagendit', 'Logawa', 'Cibogo',
        'Memberamo', 'Lainnya',
    ];

    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = $user->isAdmin()
            ? Panen::with('user')
            : Panen::where('user_id', $user->id)->with('user');

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

        return view('panen.index', [
            'panen'     => $panen,
            'jenisPadi' => $this->jenisPadi,
        ]);
    }

    public function create()
    {
        return view('panen.create', ['jenisPadi' => $this->jenisPadi]);
    }

    public function store(StorePanenRequest $request)
    {
        auth()->user()->panen()->create(array_merge(
            $request->validated(),
            ['status' => 'Pending']
        ));

        return redirect()->route('panen.index')
            ->with('success', 'Data panen berhasil dicatat! Menunggu verifikasi admin.');
    }

    public function edit(Panen $panen)
    {
        $this->authorize('update', $panen);
        return view('panen.edit', ['panen' => $panen, 'jenisPadi' => $this->jenisPadi]);
    }

    public function update(StorePanenRequest $request, Panen $panen)
    {
        $this->authorize('update', $panen);
        $panen->update($request->validated());

        return redirect()->route('panen.index')
            ->with('success', 'Data panen berhasil diperbarui!');
    }

    public function destroy(Panen $panen)
    {
        $this->authorize('delete', $panen);
        $panen->delete();

        return redirect()->route('panen.index')
            ->with('success', 'Data panen berhasil dihapus!');
    }
}
