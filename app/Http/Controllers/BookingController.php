<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\TimeSlot;

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
        'status' => 'required|in:pending,approved,rejected', 
        'pet_id' => 'required|exists:pets,id',
        'pet_type'=>'required'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create a new booking
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
        'status' => $request->status,
        'pet_id' => $request->pet_id,
        'pet_type' => $request->pet_type,
    ]);

    $booking->save();

    // Update availability in time_slots table
    TimeSlot::where('date', $request->date)
            ->where('start_time', $request->time)
            ->update(['availability' => 'booked', 'user_id' => auth()->id(), 'user_email' => Auth::user()->email]);

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
