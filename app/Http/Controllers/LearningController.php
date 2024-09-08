<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\User;
use App\Models\Learning;
use Illuminate\Support\Facades\Storage;

class LearningController extends Controller
{
    /**
     * Tampilkan daftar semua tema.
     */
    public function index()
    {
        // Ambil semua data learning beserta relasinya ke tema
        $learnings = Learning::with('theme')->get();

        return view('learnings.index', compact('learnings'));
    }

    /**
     * Menampilkan halaman formulir untuk menambahkan pembelajaran (Langkah 1).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil data dari sesi
        $learningData = session('learning_data', []);

        // Ambil data pengguna dan ekstrak kelas yang unik
        $users = User::all();
        $kelas = $users->pluck('kelas')->unique()->sort()->values();

        $themes = Theme::all(); // Ambil tema yang tersedia

        return view('learnings.create.step1', compact('themes', 'kelas', 'learningData'));
    }

    /**
     * Menyimpan data formulir pembelajaran (Langkah 1).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStep1(Request $request)
    {
        // Validasi data
        $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'user_kelas' => 'required|string',
            'element' => 'required|string',
            'goals' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg', // Maksimal 5 MB
        ]);

        // Menyimpan gambar cover jika ada
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('cover_images', 'public');
        }

        // Menyimpan data ke sesi dengan ID pembelajaran
        $request->session()->put('learning_data', [
            'theme_id' => $request->theme_id,
            'user_kelas' => $request->user_kelas,
            'element' => $request->element,
            'goals' => $request->goals,
            'cover_image' => $coverImagePath,
        ]);

        // Redirect ke langkah berikutnya
        return redirect()->route('learnings.create.step2');
    }

    public function createStep2()
    {
        // Ambil data dari sesi
        $learningData = session('learning_data');

        if (!$learningData) {
            return redirect()->route('learnings.create')->with('error', 'Data pembelajaran tidak ditemukan. Silakan mulai ulang.');
        }

        // Tampilkan formulir untuk langkah kedua
        return view('learnings.create.step2', compact('learningData'));
    }

    public function resetStep1Data(Request $request)
    {
        // Ambil data dari sesi
        $learningData = session('learning_data');

        if (!$learningData || !isset($learningData['learnings_id'])) {
            return redirect()->route('learnings.create')->with('error', 'Data pembelajaran tidak ditemukan. Silakan mulai ulang.');
        }

        // Hapus data dari database jika ada
        Learning::where('id', $learningData['learnings_id'])->delete();

        // Hapus data dari sesi
        $request->session()->forget('learning_data');

        // Redirect kembali ke langkah 1
        return redirect()->route('learnings.create');
    }

    /**
     * Menampilkan halaman detail learning beserta modul terkait.
     *
     * @param \App\Models\Learning $learning
     * @return \Illuminate\View\View
     */
    public function show(Learning $learning)
    {
        // Eager load the 'modules' relationship to reduce queries
        $learning->load('modules', 'evaluations.works');

        // Mendapatkan user yang sedang login
        $user = auth()->user();

        // Mengirimkan entitas Learning dan modul-modul terkait ke tampilan
        return view('learnings.show', [
            'learning' => $learning,
            'modules' => $learning->modules, // Kirimkan modul-modul terkait ke tampilan
            'evaluations' => $learning->evaluations, // Kirimkan evaluasi terkait ke tampilan
            'works' => $learning->evaluations->flatMap->works, // Kirimkan works terkait ke tampilan
        ]);
    }

    /**
     * Menampilkan halaman edit untuk pembelajaran.
     *
     * @param \App\Models\Learning $learning
     * @return \Illuminate\View\View
     */
    public function edit(Learning $learning)
    {
        $themes = Theme::all(); // Ambil semua tema
        $users = User::all();
        $kelas = $users->pluck('kelas')->unique()->sort()->values();

        return view('learnings.edit.step1', compact('learning', 'themes', 'kelas'));
    }

    /**
     * Memperbarui data pembelajaran.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Learning $learning
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Learning $learning)
    {
        // Validasi data
        $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'user_kelas' => 'required|string',
            'element' => 'required|string',
            'goals' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg', // Maksimal 5 MB
        ]);

        // Menghapus gambar lama jika ada dan mengganti dengan yang baru
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($learning->cover_image && Storage::disk('public')->exists($learning->cover_image)) {
                Storage::disk('public')->delete($learning->cover_image);
            }
            // Simpan gambar baru
            $learning->cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        // Perbarui data pembelajaran
        $learning->update([
            'theme_id' => $request->theme_id,
            'user_kelas' => $request->user_kelas,
            'element' => $request->element,
            'goals' => $request->goals,
            'cover_image' => $learning->cover_image,
        ]);

        // Redirect kembali ke halaman detail pembelajaran
        return redirect()->route('learnings.show', $learning->id)->with('success', 'Data pembelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus data pembelajaran.
     *
     * @param \App\Models\Learning $learning
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Learning $learning)
    {
        // Hapus gambar cover jika ada
        if ($learning->cover_image && Storage::disk('public')->exists($learning->cover_image)) {
            Storage::disk('public')->delete($learning->cover_image);
        }

        // Hapus modul-modul terkait
        foreach ($learning->modules as $module) {
            // Hapus file modul utama jika ada
            if ($module->file && Storage::disk('public')->exists($module->file)) {
                Storage::disk('public')->delete($module->file);
            }

            // Hapus file siswa terkait
            if ($module->student_files) {
                foreach ($module->student_files as $filePath) {
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }

            // Hapus modul dari database
            $module->delete();
        }

        // Hapus data pembelajaran dari database
        $learning->delete();

        // Redirect ke halaman daftar pembelajaran dengan pesan sukses
        return redirect()->route('learnings.index')->with('success', 'Data pembelajaran berhasil dihapus.');
    }
}
