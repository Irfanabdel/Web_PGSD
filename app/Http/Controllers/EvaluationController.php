<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Module;
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
     * @param  \App\Models\Module $module
     * @return \Illuminate\View\View
     */
    public function createStep3(Learning $learning, Module $module)
    {

        return view('learnings.create.step3', compact('learning', 'module'));
    }

    /**
     * Menyimpan evaluasi baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStep3(Request $request, Learning $learning, Module $module)
    {
        // Validasi data permintaan
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'nullable|date_format:Y-m-d\TH:i',
            'end_datetime' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        // Mengonversi start_datetime dan end_datetime ke zona waktu Asia/Jakarta
        $startDatetime = Carbon::parse($request->start_datetime, 'Asia/Jakarta')->toDateTimeString();
        $endDatetime = Carbon::parse($request->end_datetime, 'Asia/Jakarta')->toDateTimeString();

        try {
            // Buat evaluasi baru
            Evaluation::create([
                'learning_id' => $learning->id,
                'module_id' => $module->id,
                'title' => $request->title,
                'description' => $request->description,
                'start_datetime' => $startDatetime,
                'end_datetime' => $endDatetime,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        // Redirect ke halaman detail pembelajaran
        return redirect()->route('learnings.show', $learning->id);
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

    /**
     * Menampilkan formulir untuk mengedit evaluasi.
     *
     * @param  \App\Models\Learning $learning
     * @param  \App\Models\Module $module
     * @param  \App\Models\Evaluation $evaluation
     * @return \Illuminate\View\View
     */
    public function editStep3(Learning $learning, Module $module, Evaluation $evaluation)
    {
        // Pastikan evaluasi sesuai dengan learning dan module terkait
        if ($evaluation->learning_id !== $learning->id || $evaluation->module_id !== $module->id) {
            abort(404, 'Evaluasi tidak ditemukan.');
        }

        return view('learnings.edit.step3', compact('learning', 'module', 'evaluation'));
    }

    public function updateStep3(Request $request, Learning $learning, Module $module, Evaluation $evaluation)
    {
        // Pastikan evaluasi terkait dengan learning dan module yang benar
        if ($evaluation->learning_id !== $learning->id || $evaluation->module_id !== $module->id) {
            abort(404, 'Evaluasi tidak ditemukan.');
        }
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

    public function destroy(Learning $learning, Module $module, Evaluation $evaluation)
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
