<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.[a-z]{2,}$/', // Validasi email untuk semua domain Gmail
                'max:255',
                'unique:' . User::class,
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|string',
            'kelas' => 'required_if:role,siswa|string|max:255',
            'token' => 'required_if:role,guru|string|nullable',
            'school_name' => ['required', 'string'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048', // Validasi untuk image (opsional)
        ]);

        if ($request->role === 'guru') {
            // Token tetap yang diharapkan
            $expectedToken = 'Guru123';

            // Validasi token
            if ($request->token !== $expectedToken) {
                return redirect()->back()->withErrors(['token' => 'Token tidak valid'])->withInput();
            }
        }

        // Proses penyimpanan image (jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'school_name' => $request->school_name,
            'kelas' => $request->kelas,
            'token' => $request->role === 'guru' ? $request->token : null, //hanya simpan token jika role adalah guru
            'image' => $imagePath, // Simpan path gambar jika ada
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Pendaftaran Berhasil');
    }
}
