<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    // Menampilkan data biodata
    public function index()
    {
        $biodatas = Biodata::latest()->get();

        return view('welcome', compact('biodatas'));
    }

    // Menambahkan biodata
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:biodatas,nim',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'nama',
            'nim',
            'deskripsi'
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('biodata', 'public');
        }

        Biodata::create($data);

        return redirect('/')
            ->with('success', 'Biodata berhasil ditambahkan!');
    }

    // Mengedit biodata
    public function update(Request $request, Biodata $biodata)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:biodatas,nim,' . $biodata->id,
            'deskripsi' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'nama',
            'nim',
            'deskripsi'
        ]);

        if ($request->hasFile('foto')) {

            if ($biodata->foto) {
                Storage::disk('public')->delete($biodata->foto);
            }

            $data['foto'] = $request->file('foto')
                ->store('biodata', 'public');
        }

        $biodata->update($data);

        return redirect('/')
            ->with('success', 'Biodata berhasil diperbarui!');
    }

    // Menghapus biodata
    public function destroy(Biodata $biodata)
    {
        if ($biodata->foto) {
            Storage::disk('public')->delete($biodata->foto);
        }

        $biodata->delete();

        return redirect('/')
            ->with('success', 'Biodata berhasil dihapus!');
    }
}