<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\ApartmentImages;
use App\Models\ApartmentInfo;
use Illuminate\Support\Facades\App;
class ApartmentController extends Controller
{

    private function authorizeAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }
    }
    // Display all apartments
    public function index()
    {
        if (session()->has('locale')) {
        App::setLocale(session('locale'));
        }
        $this->authorizeAdmin(); // Admin authorization check

        $apartments = Apartment::with(['apartmentImages', 'apartmentInfos'])->get();
        return view('apartments.index', compact('apartments'));

    }

    // Show form to create a new apartment
    public function create()
    {
        $this->authorizeAdmin(); // Admin authorization check

        return view('apartments.create');
    }

    // Store a new apartment
    public function store(Request $request)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'images.*' => 'nullable|image',
            'infos' => 'nullable|array',
            'infos.*' => 'nullable|string',
        ]);

        $apartment = Apartment::create($validated);

        if (!empty($validated['infos'])) {
            foreach ($validated['infos'] as $info) {
                ApartmentInfo::create([
                    'content' => $info,
                    'apartment_id' => $apartment->id,
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('apartment_images', 'public');
                ApartmentImages::create([
                    'image' => $path,
                    'apartment_id' => $apartment->id,
                ]);
            }
        }

        return redirect()->route('apartments.edit', $apartment->id)->with('success', 'Apartment created successfully!');
    }

    // Display a single apartment
    public function show($id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $apartment = Apartment::with(['apartmentImages', 'apartmentInfos'])->findOrFail($id);
        $allApartments = Apartment::all();
        return view('apartments.show', compact('apartment', 'allApartments'));

    }

    // Show form to edit an apartment
    public function edit($id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $apartment = Apartment::findOrFail($id);
        return view('apartments.edit', compact('apartment'));
    }

    // Update an apartment
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $apartment = Apartment::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string',
            'price' => 'nullable|numeric',
            'capacity' => 'nullable|integer',
            'images.*' => 'nullable|image',
            'infos' => 'nullable|array',
            'infos.*' => 'nullable|string',
        ]);

        $apartment->update($validated);

        if (isset($validated['infos'])) {
            ApartmentInfo::where('apartment_id', $apartment->id)->delete();
            foreach ($validated['infos'] as $info) {
                ApartmentInfo::create([
                    'content' => $info,
                    'apartment_id' => $apartment->id,
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('apartment_images', 'public');
                ApartmentImages::create([
                    'image' => $path,
                    'apartment_id' => $apartment->id,
                ]);
            }
        }

        return redirect()->route('apartments.edit', $apartment->id)->with('success', 'Apartment updated successfully!');
    }

    // Delete an apartment
    public function destroy($id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $apartment = Apartment::findOrFail($id);
        $apartment->delete();

        return redirect()->route('apartments.index')->with('success', 'Apartment deleted successfully!');
    }

    // Delete an image
    public function deleteImage($id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $image = ApartmentImages::findOrFail($id);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    // Store apartment info
    public function storeInfo(Request $request)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'content_hr' => 'nullable|string|max:255',
            'content_en' => 'nullable|string|max:255',
            'content_de' => 'nullable|string|max:255',
            'content_it' => 'nullable|string|max:255',
        ]);

        if ($request->content_hr) {
            ApartmentInfo::create([
                'apartment_id' => $request->apartment_id,
                'content' => $request->content_hr,
                'locale' => 'hr',
            ]);
        }

        if ($request->content_en) {
            ApartmentInfo::create([
                'apartment_id' => $request->apartment_id,
                'content' => $request->content_en,
                'locale' => 'en',
            ]);
        }

        if ($request->content_de) {
            ApartmentInfo::create([
                'apartment_id' => $request->apartment_id,
                'content' => $request->content_de,
                'locale' => 'de',
            ]);
        }

        if ($request->content_it) {
            ApartmentInfo::create([
                'apartment_id' => $request->apartment_id,
                'content' => $request->content_it,
                'locale' => 'it',
            ]);
        }

        return redirect()->back()->with('success', 'Info added successfully.');
    }

    // Update apartment info
    public function updateInfo(Request $request, $id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $info = ApartmentInfo::findOrFail($id);
        $info->update($validated);

        return redirect()->back()->with('success', 'Information updated successfully!');
    }

    // Delete apartment info
    public function deleteInfo($id)
    {
        $this->authorizeAdmin(); // Admin authorization check

        $info = ApartmentInfo::findOrFail($id);
        $info->delete();

        return redirect()->back()->with('success', 'Information deleted successfully!');
    }
}
