<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\AdminUser;
use App\Models\Booking;
use App\Models\Service;
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

public function showServices()
{
    $services = Service::paginate(10); // Paginate the active services
    $softDeletedServices = Service::onlyTrashed()->paginate(10); // Paginate the soft deleted services
    return view('admin.services', compact('services', 'softDeletedServices'));
}



    public function storeService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_type' => 'required|unique:services',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Service::create([
            'service_type' => $request->service_type,
        ]);

        return redirect()->route('admin.services')->with('success', 'Service created successfully.');
    }
    public function editService($id)
{
    $editService = Service::findOrFail($id);
    return view('admin.edit_service', compact('editService'));
}


public function updateService(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'service_type' => 'required|unique:services,service_type,' . $id,
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $service = Service::findOrFail($id);
    $service->update([
        'service_type' => $request->service_type,
    ]);

    return redirect()->route('admin.services')->with('success', 'Service updated successfully.');
}


public function softDeleteService($id)
{
    $service = Service::findOrFail($id);
    $service->delete();
    return redirect()->route('admin.services')->with('success', 'Service soft deleted successfully.');
}

public function restoreService($id)
{
    $service = Service::withTrashed()->findOrFail($id);
    $service->restore();
    return redirect()->route('admin.services')->with('success', 'Service restored successfully.');
}


}
