<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Beach;
use App\Models\Hbeach;
use Illuminate\Support\Facades\Storage;

class BeachController extends Controller
{
    public function index()
    {
        // Enforce authentication and admin check
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $beaches = Beach::all();
        return view('beaches.index', compact('beaches'));
    }

    public function create()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        return view('beaches.create');
    }

    public function store(Request $request)
{
    if (!Auth::check() || !Auth::user()->is_admin) {
        abort(403, 'Unauthorized access.');
    }

    $request->validate([
        'name' => 'nullable|string|max:255',
        'beach_id' => 'nullable|exists:beaches,id',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
    ]);

    // Determine the beach
    if ($request->filled('name')) {
        $beach = Beach::create(['name' => $request->name]);
    } elseif ($request->filled('beach_id')) {
        $beach = Beach::findOrFail($request->beach_id);
    } else {
        return back()->withErrors(['name' => 'You must provide a beach name or select an existing beach.']);
    }

    // Upload images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('hbeaches', 'public');
            Hbeach::create([
                'image' => $path,
                'beach_id' => $beach->id,
            ]);
        }
    }

    // Redirect to the edit page with the correct ID
    return redirect()->route('beaches.edit', $beach->id)
        ->with('success', 'Beach created or updated successfully.');
}
    public function edit($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $beach = Beach::findOrFail($id);
        return view('beaches.edit', compact('beach'));
    }

    public function update(Request $request, $id)
{
    if (!Auth::check() || !Auth::user()->is_admin) {
        abort(403, 'Unauthorized access.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $beach = Beach::findOrFail($id);
    $beach->update(['name' => $request->name]);

    // Redirect to the edit page with the correct ID
    return redirect()->route('beaches.edit', $beach->id)
        ->with('success', 'Beach updated successfully.');
}

    public function destroy($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $beach = Beach::findOrFail($id);
        $beach->delete();

        return redirect()->route('beaches.index')->with('success', 'Beach deleted successfully.');
    }

    public function deleteImage($id)
{
    // Ensure the user is authorized
    if (!Auth::check() || !Auth::user()->is_admin) {
        abort(403, 'Unauthorized access.');
    }

    // Find the image by ID
    $image = Hbeach::findOrFail($id);

    // Delete the image file from storage
    if ($image->image && Storage::disk('public')->exists($image->image)) {
        Storage::disk('public')->delete($image->image);
    }

    // Delete the record from the database
    $image->delete();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Image deleted successfully.');
}
}
