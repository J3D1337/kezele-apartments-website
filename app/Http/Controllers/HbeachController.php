<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Hbeach;
use App\Models\Beach;
use Illuminate\Support\Facades\Storage;

class HbeachController extends Controller
{
    private function authorizeAdmin()
    {
        // Ensure the user is logged in and is an admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }
    }

    // Display all images
    public function index()
    {
        $this->authorizeAdmin(); // Admin authorization check

        $hbeaches = Hbeach::all();
        $beaches = Beach::all();
        return view('hbeaches.index', compact('hbeaches'));
    }

    // Show form to upload a new image
    public function create()
    {
        $this->authorizeAdmin(); // Admin authorization check

        $beaches = Beach::all(); // Fetch all beaches
        return view('hbeaches.create', compact('beaches'));
    }

    // Store a new image
    public function store(Request $request)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:20480', // Validate each image
            'beach_id' => 'required|exists:beaches,id', // Ensure a valid beach ID is provided
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Save each image to storage
                $path = $file->store('hbeaches', 'public');

                // Create a record in the database for each image
                Hbeach::create([
                    'image' => $path,
                    'beach_id' => $request->beach_id, // Include the associated beach ID
                ]);
            }
        }

        return redirect()->route('hbeaches.index')->with('success', 'Images uploaded successfully.');
    }

    // Show form to edit an image
    public function edit($id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $hbeach = Hbeach::findOrFail($id);
        return view('hbeaches.edit', compact('hbeach'));
    }

    // Update an image
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:20480',
        ]);

        $hbeach = Hbeach::findOrFail($id);

        // Delete the old image
        Storage::disk('public')->delete($hbeach->image);

        // Save the new image to storage
        $path = $request->file('image')->store('hbeaches', 'public');

        // Update the database record
        $hbeach->update([
            'image' => $path,
        ]);

        return redirect()->route('hbeaches.index')->with('success', 'Image updated successfully.');
    }

    // Delete an image
    public function destroy($id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $hbeach = Hbeach::findOrFail($id);

        // Debug the image path
        if (is_null($hbeach->image)) {
            return redirect()->route('hbeaches.index')->withErrors('Image path is missing.');
        }

        // Delete the image file from storage
        Storage::disk('public')->delete($hbeach->image);

        // Delete the record from the database
        $hbeach->delete();

        return redirect()->route('hbeaches.index')->with('success', 'Image deleted successfully.');
    }
}
