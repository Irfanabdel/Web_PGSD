<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Learning;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Menampilkan halaman form langkah 2 untuk modul terkait dengan ID Learning.
     *
     * @param int $learning_id
     * @return \Illuminate\View\View
     */
    public function createStep2($learning_id)
    {
        // Ambil data Learning berdasarkan ID
        $learning = Learning::findOrFail($learning_id);

        // Passing data ke view create.step2
        return view('learnings.create.step2', compact('learning'));
    }

    /**
     * Menyimpan data formulir pembelajaran (Langkah 2).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStep2(Request $request, $learning_id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'links' => 'nullable|array',
            'links.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'student_files' => 'nullable|array',
            'student_files.*' => 'file|mimes:pdf,doc,docx,ppt,pptx', // Validasi file siswa
            'student_files_titles' => 'nullable|array',
            'student_files_titles.*' => 'nullable|string|max:255', // Validasi judul file siswa
        ]);

        // Menyimpan file siswa jika ada
        $studentFilesPaths = [];
        if ($request->hasFile('student_files')) {
            foreach ($request->file('student_files') as $file) {
                try {
                    $studentFilesPaths[] = $file->storeAs(
                        'student_files',
                        $file->getClientOriginalName(),
                        'public'
                    );
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Gagal mengunggah salah satu file siswa. Silakan coba lagi.');
                }
            }
        }

        // Menyimpan data modul ke database
        try {
            Module::create([
                'learning_id' => $learning_id, // Menggunakan ID pembelajaran yang diberikan
                'title' => $validatedData['title'],
                'links' => $request->input('links', []),
                'videos' => $request->input('videos', []),
                'student_files' => ($studentFilesPaths),
                'student_files_titles' => $request->input('student_files_titles', []),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data modul. Silakan coba lagi.');
        }

        // Mengalihkan ke halaman indeks dengan pesan sukses
        return redirect()->route('learnings.show', ['learning' => $learning_id])->with('success', 'Data modul berhasil disimpan.');
    }

    /**
     * Menampilkan halaman edit untuk pembelajaran (Langkah 2 - Modul).
     *
     * @param \App\Models\Learning $learning
     * @return \Illuminate\View\View
     */
    public function editStep2($learning_id, $module_id)
    {
        // Ambil modul berdasarkan ID
        $module = Module::findOrFail($module_id);

        // Ambil data lain yang mungkin diperlukan (seperti data pembelajaran terkait)
        $learning = Learning::findOrFail($module->learning_id);

        // Mengembalikan view dengan data modul dan pembelajaran
        return view('learnings.edit.step2', compact('learning', 'module'));
    }

    public function updateStep2(Request $request, $module_id)
    {
        // Ambil modul berdasarkan ID
        $module = Module::find($module_id);

        // Cek apakah modul ditemukan
        if (!$module) {
            return redirect()->back()->withErrors(['error' => 'Modul tidak ditemukan.']);
        }

        // Validasi data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'links' => 'nullable|array',
            'links.*' => 'nullable|url',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|url',
            'student_files' => 'nullable|array',
            'student_files.*' => 'file|mimes:pdf,doc,docx,ppt,pptx',
            'student_files_titles' => 'nullable|array',
            'student_files_titles.*' => 'nullable|string|max:255',
            'existing_student_files' => 'nullable|array', // Validasi file siswa yang ada
        ]);

        // Mengelola file siswa lama dan baru
        $existingStudentFiles = $module->student_files ?? [];
        $newStudentFiles = [];
        $studentFilesTitles = $request->input('student_files_titles', []);
        $existingStudentFilesInput = $request->input('existing_student_files', []);

        // Simpan file baru dengan nama asli
        if ($request->hasFile('student_files')) {
            foreach ($request->file('student_files') as $file) {
                $filePath = $file->storeAs('student_files', $file->getClientOriginalName(), 'public');
                $newStudentFiles[] = $filePath;
            }
        }

        // Periksa dan hapus file yang tidak dipertahankan
        $finalStudentFiles = [];
        $finalStudentFilesTitles = [];

        foreach ($existingStudentFiles as $index => $existingFile) {
            if (in_array($existingFile, $existingStudentFilesInput)) {
                $finalStudentFiles[] = $existingFile;
                $finalStudentFilesTitles[] = $studentFilesTitles[$index] ?? '';
            } else {
                if (Storage::disk('public')->exists($existingFile)) {
                    Storage::disk('public')->delete($existingFile);
                }
            }
        }

        // Gabungkan file lama dan baru
        $finalStudentFiles = array_merge($finalStudentFiles, $newStudentFiles);
        $finalStudentFilesTitles = array_merge(
            $finalStudentFilesTitles,
            array_slice($studentFilesTitles, count($finalStudentFilesTitles))
        );

        // Perbarui data modul menggunakan metode update()
        $module->update([
            'title' => $validatedData['title'],
            'links' => $request->input('links', []),
            'videos' => $request->input('videos', []),
            'student_files' => $finalStudentFiles,
            'student_files_titles' => $finalStudentFilesTitles,
        ]);

        // Redirect kembali ke halaman detail pembelajaran
        return redirect()
            ->route('learnings.show', $module->learning_id)
            ->with('success', 'Data pembelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus data modul (Langkah 2).
     *
     * @param \App\Models\Module $module
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($learning_id, Module $module)
    {
        // Hapus file modul utama jika ada
        if ($module->file && Storage::disk('public')->exists($module->file)) {
            Storage::disk('public')->delete($module->file);
        }

        // Hapus file siswa jika ada
        if ($module->student_files) {
            foreach ($module->student_files as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        // Hapus data modul dari database
        try {
            $module->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data modul. Silakan coba lagi.');
        }

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('learnings.show', ['learning' => $learning_id])->with('success', 'Data modul berhasil dihapus.');
    }
}
