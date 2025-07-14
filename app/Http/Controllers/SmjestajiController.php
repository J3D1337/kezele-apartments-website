<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment; // Import the Apartment model

class SmjestajiController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all apartments for the dropdown
        $allApartments = Apartment::all();

        // Get the selected apartment or default to the first one
        $selectedApartmentId = $request->query('apartment', $allApartments->first()->id ?? null);

        $apartment = Apartment::with(['apartmentImages', 'apartmentInfos'])->findOrFail($selectedApartmentId);

        return view('smjestaji', compact('allApartments', 'apartment'));
    }
}
