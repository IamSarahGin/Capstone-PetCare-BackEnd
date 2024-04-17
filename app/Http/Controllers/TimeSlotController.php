<?php

namespace App\Http\Controllers;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TimeSlotController extends Controller
{
    public function index(Request $request)
{
    $selectedDate = $request->input('date', date('Y-m-d'));

    $timeSlots = TimeSlot::whereDate('date', $selectedDate)
                         ->where('availability', 'available')
                         ->get();

    return response()->json($timeSlots);
}

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'startTime' => 'required|date_format:H:i:s',
            'endTime' => 'required|date_format:H:i:s|after:startTime',
            'availability' => 'required|in:available,booked',
        ]);

        // Create the time slot
        $timeSlot = TimeSlot::create([
            'date' => $validatedData['date'],
            'startTime' => $validatedData['startTime'],
            'endTime' => $validatedData['endTime'],
            'availability' => $validatedData['availability'],
            'user_id' => Auth::id(), // Save the authenticated user's ID
            'user_email' => Auth::user()->email, // Save the authenticated user's email
        ]);

        return response()->json($timeSlot, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'date' => 'required|date',
            'startTime' => 'required|date_format:H:i:s',
            'endTime' => 'required|date_format:H:i:s|after:startTime',
            'availability' => 'required|in:available,booked',
        ]);

        // Find the time slot
        $timeSlot = TimeSlot::findOrFail($id);

        // Update the time slot
        $timeSlot->update([
            'date' => $validatedData['date'],
            'startTime' => $validatedData['startTime'],
            'endTime' => $validatedData['endTime'],
            'availability' => $validatedData['availability'],
            'user_id' => Auth::id(), // Update the authenticated user's ID
            'user_email' => Auth::user()->email, // Update the authenticated user's email
        ]);

        return response()->json($timeSlot, 200);
    }

    public function destroy($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        $timeSlot->delete();

        return response()->json(null, 204);
    }
}
