<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {

    if (session()->has('locale')) {
        App::setLocale(session('locale'));
    }
        return view('dashboard');
    }

}
