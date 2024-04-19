<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Add this line
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            Mail::to('petcareest.2024@gmail.com')->send(new ContactMail($details));
            return response()->json(['message' => 'Email sent successfully']);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to send email: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send email'], 500);
        }
    }
}
