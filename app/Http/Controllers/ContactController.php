<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Apartment;
use Illuminate\Support\Facades\App;
class ContactController extends Controller
{
    public function index()
    {
        if (session()->has('locale')) {
        App::setLocale(session('locale'));
        }
        $apartments = Apartment::all(); // Retrieve all apartments from the database
        return view('contact', compact('apartments'));
    }

    public function send(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|max:500',
            'apartment_id' => 'required|exists:apartments,id', // Validate the selected apartment exists
        ]);

        // Retrieve guest's input
        $guestEmail = $request->input('email');
        $message = $request->input('message');
        $apartmentId = $request->input('apartment_id');
        $toEmail = 'vuxii.kezo@gmail.com'; // Your email address


        // Retrieve the selected apartment
        $apartment = Apartment::find($apartmentId);

        // Append guest's email to the message body
        $fullMessage = "Sender's Email: $guestEmail\n\n";
        $fullMessage .= "Selected Apartment: {$apartment->name} ({$apartment->capacity} Guests) - $".number_format($apartment->price, 2)."\n\n";
        $fullMessage .= "Message:\n$message";

        // Send email
        Mail::raw($fullMessage, function ($mail) use ($toEmail, $guestEmail) {
            $mail->to('vuxii.kezo@gmail.com') // Your email
                 ->replyTo($guestEmail) // Set Reply-To to guest's email
                 ->subject('New Reservation Request');
        });

        return redirect()->route('contact')->with('success', 'Message sent successfully!');
    }
}
