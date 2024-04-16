<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class BookingController extends Controller
{
 // Get all bookings// Get all bookings
    public function index()
    {
        return Booking::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time' => 'required',
            'pet_name' => 'required',
            'breed' => 'required',
            'age' => 'required|integer',
            'color' => 'required',
            'symptoms' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking = new Booking([
            'user_id' => auth()->id(), // Associate the authenticated user's ID with the booking
            'user_email' => Auth::user()->email, // Store the user's email
            'date' => $request->date,
            'time' => $request->time,
            'pet_name' => $request->pet_name,
            'breed' => $request->breed,
            'age' => $request->age,
            'color' => $request->color,
            'symptoms' => $request->symptoms,
        ]);

        $booking->save();

        return response()->json($booking, 201);
    }




    // Get a specific booking
    public function show($id)
    {
        return Booking::findOrFail($id);
    }

    // Update a booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return $booking;
    }

    // Delete a booking
    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
