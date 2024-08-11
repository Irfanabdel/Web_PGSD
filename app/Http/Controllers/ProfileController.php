<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Update school_name and kelas fields
        $user->school_name = $request->input('school_name');
        $user->kelas = $request->input('kelas');

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateImage(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        if ($request->hasFile('image')) {
            if ($user->image) {
                // Hapus gambar lama jika ada
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('profile_images', 'public');
            $user->image = $path;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-image-updated');
    }

    /**
     * Delete the user's profile image.
     */
    public function deleteImage(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->image) {
            // Hapus gambar dari storage
            Storage::disk('public')->delete($user->image);

            // Set field image menjadi null
            $user->image = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-image-deleted');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
