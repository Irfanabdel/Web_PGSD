<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WorkController extends Controller
{
    /**
     * Menampilkan formulir kerja untuk evaluasi tertentu.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\View\View
     */
    public function createWork(Evaluation $evaluation)
    {
        // Cek apakah pengguna sudah mengerjakan evaluasi ini
        $existingWork = Work::where('evaluation_id', $evaluation->id)
            ->where('user_id', Auth::id())
            ->first();

        return view('learnings.work', [
            'evaluation' => $evaluation,
            'existingWork' => $existingWork
        ]);
    }

    /**
     * Menyimpan jawaban pekerjaan untuk evaluasi tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeWork(Request $request, Evaluation $evaluation)
    {
        // Validasi data permintaan
        $request->validate([
            'answers' => 'required|string',
        ]);

        // Cek apakah pengguna sudah mengerjakan evaluasi ini
        $existingWork = Work::where('evaluation_id', $evaluation->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingWork) {
            // Jika sudah ada pekerjaan, update pekerjaan yang ada
            $existingWork->update([
                'answers' => $request->answers,
            ]);
        } else {
            // Jika belum ada, buat pekerjaan baru
            Work::create([
                'evaluation_id' => $evaluation->id,
                'user_id' => Auth::id(),
                'answers' => $request->answers,
            ]);
        }

        // Redirect kembali ke halaman detail evaluasi dengan pesan sukses
        return redirect()->route('learnings.show', ['learning' => $evaluation->learning_id])
            ->with('success', 'Jawaban pekerjaan berhasil disimpan.');
    }
}
