<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class NilaiController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with('user')->get();
        
        return view('nilai.index', compact('nilai'));
    }
    
    public function create()
    {
        $users = User::all();
        return view('nilai.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nilai_mapel_1' => 'required|numeric',
            'nilai_mapel_2' => 'required|numeric',
            'nilai_mapel_3' => 'required|numeric',
            'nama_sekolah' => 'required',
            'alamat_sekolah' => 'required',
            'projek_1' => 'required',
            'projek_2' => 'required',
        ]);
        
        Nilai::create($request->all());
        
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $users = User::all();
        return view('nilai.edit', compact('nilai', 'users'));
    }



    public function update(Request $request, $id)
    {
        
// Validasi input
$request->validate([
    // Aturan validasi
]);

// Temukan data Nilai berdasarkan ID
$nilai = Nilai::findOrFail($id);

// Perbarui data dengan data yang diterima dari permintaan
$nilai->update($request->all());

// Redirect dengan pesan sukses
return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');

    }
    
}


