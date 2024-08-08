<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Mapel;
use App\Models\User;



class NilaiController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with('user', 'mapels')->get(); // Mengambil semua data nilai beserta relasi user dan mapel
        return view('nilai.index', compact('nilai')); // Mengembalikan tampilan dengan data nilai
    }
    
    //Membuat Nilai
    public function create()
    {
        $users = User::all();
        return view('nilai.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nama_sekolah' => 'required',
            'alamat_sekolah' => 'required',
            'projek_1' => 'required',
            'projek_2' => 'required',
            'mapel' => 'required|array',
            'mapel.*.name' => 'required|string',
            'mapel.*.nilai' => 'required|integer|min:1|max:10',
        ]);

        $nilai = Nilai::create([
            'user_id' => $request->user_id,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
            'projek_1' => $request->projek_1,
            'projek_2' => $request->projek_2,
        ]);

        foreach ($request->mapel as $mapelData) {
            Mapel::create([
                'nilai_id' => $nilai->id,
                'name' => $mapelData['name'],
                'nilai' => $mapelData['nilai'],
            ]);
        }

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }
    
    //Menghapus Nilai
    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    public function edit($id)
    {
        $nilai = Nilai::with('mapels')->findOrFail($id);
        $users = User::all();
        return view('nilai.edit', compact('nilai', 'users'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:255',
            'projek_1' => 'nullable|string',
            'projek_2' => 'nullable|string',
            'mapel.*.name' => 'required|string|max:255',
            'mapel.*.nilai' => 'required|integer|min:1|max:10',
        ]);
    
        $nilai = Nilai::findOrFail($id);
    
        // Update data utama nilai
        $nilai->update([
            'user_id' => $request->user_id,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
            'projek_1' => $request->projek_1,
            'projek_2' => $request->projek_2,
        ]);
    
        // Update data mapel
        $nilai->mapels()->delete(); // Hapus semua mapel yang terkait dengan nilai ini
    
        foreach ($request->mapel as $mapelData) {
            $nilai->mapels()->create($mapelData);
        }
    
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }
    
}


