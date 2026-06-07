<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Varietas;
use Illuminate\Http\Request;

class VarietasController extends Controller
{
    public function index()
    {
        $varietas = Varietas::orderBy('nama')->paginate(20);
        return view('admin.varietas.index', compact('varietas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:varietas,nama'],
        ], [
            'nama.unique' => 'Varietas dengan nama tersebut sudah ada.',
        ]);

        Varietas::create(['nama' => $request->nama]);

        return back()->with('success', "Varietas \"{$request->nama}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Varietas $varieta)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100', "unique:varietas,nama,{$varieta->id}"],
        ], [
            'nama.unique' => 'Varietas dengan nama tersebut sudah ada.',
        ]);

        $varieta->update(['nama' => $request->nama]);

        return back()->with('success', "Varietas berhasil diperbarui.");
    }

    public function destroy(Varietas $varieta)
    {
        $varieta->delete();
        return back()->with('success', "Varietas berhasil dihapus.");
    }
}
