<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $departemens = Departemen::withCount('karyawans')
            ->when($q, fn($query) => $query->where('nama_departemen', 'like', "%{$q}%")
                ->orWhere('kode_departemen', 'like', "%{$q}%"))
            ->orderBy('nama_departemen')
            ->paginate(10)
            ->withQueryString();

        return view('departemen.index', compact('departemens', 'q'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_departemen' => 'required|string|max:20|unique:departemens,kode_departemen',
            'nama_departemen' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Departemen::create($validated);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Departemen $departemen)
    {
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $validated = $request->validate([
            'kode_departemen' => 'required|string|max:20|unique:departemens,kode_departemen,' . $departemen->id,
            'nama_departemen' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $departemen->update($validated);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Departemen $departemen)
    {
        if ($departemen->karyawans()->count() > 0) {
            return back()->with('error', 'Departemen tidak dapat dihapus karena masih memiliki karyawan.');
        }

        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
