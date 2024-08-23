<?php

namespace App\Http\Controllers;

use App\Models\Komen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KomenController extends Controller
{
    public function index()
    {
        $komen = Komen::with('user')->get();

        // Mengonversi waktu komentar ke zona waktu lokal
        foreach ($komen as $item) {
            $item->created_at = Carbon::parse($item->created_at)->timezone('Asia/Jakarta');
        }

        return view('komen', compact('komen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'Desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        Komen::create([
            'title' => $request->title,
            'Desc' => $request->Desc,
            'image' => $path,
            'user_id' => auth()->id(), // Menambahkan user_id
        ]);

        return redirect()->route('komen.index');
    }

    // Method untuk menghapus komentar
    public function destroy($id)
    {
        $komen = Komen::findOrFail($id);

        // Hapus file gambar jika ada
        if ($komen->image) {
            \Storage::disk('public')->delete($komen->image);
        }

        $komen->delete();

        return redirect()->route('komen.index')->with('success', 'Komentar berhasil dihapus.');
    }
}
