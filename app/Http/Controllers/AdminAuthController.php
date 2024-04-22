<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\AdminUser;
use App\Models\Booking;
class AdminAuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    
    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();

        AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'Admin'
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    public function login()
    {
        return view('auth.login');
    }
    public function loginAction(Request $request)
{
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    if (Auth::guard('admin_users')->attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard'); // Corrected dashboard route
    }

    return redirect()->route('login')->with('error', 'Login failed. Please check your credentials.');
}


    public function logout(Request $request)
    {
        Auth::guard('admin_users')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    //profile
    public function profile()
    {
        return view('profile');
    }
//to get all the pending bookings
public function showBookings()
{
    $pendingBookings = Booking::where('status', 'pending')->paginate(10); // Change '10' to the desired number of items per page
    return view('admin.bookings', compact('pendingBookings'));
}


//to update the update bookings status
public function updateBookingStatus(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = $request->status;
    $booking->save();

    return redirect()->back()->with('success', 'Booking status updated successfully');
}
//to get all the approved booking
//to get all the approved booking
public function showApprovedBookings()
{
    $approvedBookings = Booking::where('status', 'approved')->paginate(10); // Change '10' to the desired number of items per page
    return view('admin.approved_bookings', compact('approvedBookings'));
}

//to get all the rejected booking
public function showRejectedBookings()
{
    $rejectedBookings = Booking::where('status', 'rejected')->paginate(10); // Change '10' to the desired number of items per page
    return view('admin.rejected_bookings', compact('rejectedBookings'));
}


}
