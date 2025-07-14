<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hbeach;
use App\Models\Beach;
use Illuminate\Support\Facades\App;

class LokacijeController extends Controller
{
    public function index(Request $request)
    {
        if (session()->has('locale')) {
        App::setLocale(session('locale'));

        }

        $selectedBeachId = $request->input('beach_id', null); // Get the selected beach ID
        $hbeaches = $selectedBeachId ? Hbeach::where('beach_id', $selectedBeachId)->get() : Hbeach::all(); // Filter by beach_id if selected
        $beaches = Beach::all(); // Fetch all beaches for the dropdown

        return view('lokacije', compact('hbeaches', 'beaches', 'selectedBeachId'));
    }
}
