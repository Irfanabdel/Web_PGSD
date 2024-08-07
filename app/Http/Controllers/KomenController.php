<?php

namespace App\Http\Controllers;

use App\Models\Komen;
use Illuminate\Http\Request;

class KomenController extends Controller
{
    public function index()
    {
        $komen = Komen::all();
        return view('nilai.komen', compact('komen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'Desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        Komen::create([
            'title' => $request->title,
            'Desc' => $request->Desc,
            'image' => $path,
        ]);

        return redirect()->route('komen.index');
    }
}
