<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSlotController extends Controller
{public function index(Request $request)
{
    try {
        $selectedDate = $request->input('date', date('Y-m-d'));

        $timeSlots = TimeSlot::select('start_time', 'end_time')
                             ->whereDate('date', $selectedDate)
                             ->where('availability', 'available')
                             ->distinct()
                             ->get();

        return response()->json($timeSlots);
    } catch (\Exception $e) {
        // Handle any exceptions and return a meaningful error message
        return response()->json(['message' => 'Error fetching time slots'], 500);
    }
}
public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'availability' => 'required|in:available,booked',
        ]);

        $timeSlot = TimeSlot::create([
            'date' => $validatedData['date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'availability' => $validatedData['availability'],
            'user_id' => auth()->id(),
            'user_email' => Auth::user()->email,
        ]);

        return response()->json($timeSlot, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'availability' => 'required|in:available,booked',
        ]);

        $timeSlot = TimeSlot::findOrFail($id);

        $timeSlot->update([
            'date' => $validatedData['date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'availability' => $validatedData['availability'],
            'user_id' => auth()->id(), 
            'user_email' => Auth::user()->email,
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