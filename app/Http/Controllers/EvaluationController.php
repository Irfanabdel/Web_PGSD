<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Learning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EvaluationController extends Controller
{
    /**
     * Menampilkan formulir untuk membuat evaluasi baru.
     *
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\View\View
     */
    public function createStep3(Learning $learning)
    {
        return view('learnings.create.step3', ['learning' => $learning]);
    }

    /**
     * Menyimpan evaluasi baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStep3(Request $request)
    {
        // Validasi data permintaan
        $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'nullable|date_format:Y-m-d\TH:i',
            'end_datetime' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        // Mengonversi start_datetime dan end_datetime ke zona waktu Asia/Jakarta
        $startDatetime = Carbon::parse($request->start_datetime, 'Asia/Jakarta')->toDateTimeString();
        $endDatetime = Carbon::parse($request->end_datetime, 'Asia/Jakarta')->toDateTimeString();

        // Buat evaluasi baru
        Evaluation::create([
            'learning_id' => $request->learning_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
        ]);

        // Redirect ke halaman detail pembelajaran
        return redirect()->route('learnings.show', $request->learning_id);
    }

    /**
     * Meng-handle upload file untuk evaluasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function evaluationFiles(Request $request)
    {
        // Validasi file
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:20480', // Max file size 20MB
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }

        // Upload file
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName(); // Ambil nama asli file
        $path = $file->storeAs('evaluations', $fileName, 'public');

        // Kembalikan URL file ke TinyMCE
        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
            'file_name' => $fileName,
        ]);
    }

    public function editStep3(Learning $learning, Evaluation $evaluation)
    {
        return view('learnings.edit.step3', compact('learning', 'evaluation'));
    }

    public function updateStep3(Request $request, Learning $learning, Evaluation $evaluation)
    {
        // Validasi data permintaan
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'nullable|date_format:Y-m-d\TH:i',
            'end_datetime' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        // Mengonversi start_datetime dan end_datetime ke zona waktu Asia/Jakarta
        $startDatetime = $request->start_datetime ? Carbon::parse($request->start_datetime, 'Asia/Jakarta')->toDateTimeString() : $evaluation->start_datetime;
        $endDatetime = $request->end_datetime ? Carbon::parse($request->end_datetime, 'Asia/Jakarta')->toDateTimeString() : $evaluation->end_datetime;

        // Cek deskripsi lama dan baru
        $oldDescription = $evaluation->description;
        $newDescription = $request->description;

        // Hapus file lama dari deskripsi jika tidak ada di deskripsi baru
        if ($oldDescription !== $newDescription) {
            // Menemukan URL file di deskripsi lama
            preg_match_all('/src="(.*?)"/', $oldDescription, $matches);
            $oldFileUrls = $matches[1] ?? [];

            // Menemukan URL file di deskripsi baru
            preg_match_all('/src="(.*?)"/', $newDescription, $newMatches);
            $newFileUrls = $newMatches[1] ?? [];

            // Hapus file yang tidak ada di deskripsi baru
            foreach ($oldFileUrls as $url) {
                if (!in_array($url, $newFileUrls)) {
                    $filePath = str_replace('/storage/', '', $url);
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        // Update evaluasi
        $evaluation->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_datetime' => $startDatetime,
            'end_datetime' => $endDatetime,
        ]);

        // Redirect ke halaman detail pembelajaran
        return redirect()->route('learnings.show', $learning->id);
    }

    public function destroy(Learning $learning, Evaluation $evaluation)
    {
        // Hapus file dari deskripsi evaluasi
        $description = $evaluation->description;

        // Menemukan URL file di deskripsi
        preg_match_all('/src="(.*?)"/', $description, $matches);
        $fileUrls = $matches[1] ?? [];

        // Hapus file yang terkait dengan evaluasi
        foreach ($fileUrls as $url) {
            $filePath = str_replace('/storage/', '', $url);
            Storage::disk('public')->delete($filePath);
        }

        // Hapus evaluasi
        $evaluation->delete();

        return redirect()->route('learnings.show', $learning->id)->with('success', 'Evaluasi berhasil dihapus.');
    }
}
