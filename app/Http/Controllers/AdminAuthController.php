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
use App\Models\Pet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


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
            'email' => 'required|email|unique:admin_users,email', // Ensure unique email addresses
            'password' => 'required|confirmed'
        ])->validate();

        $user = AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'Admin'
        ]);

        // Generate and save remember token
        $rememberToken = Str::random(60);
        $user->forceFill(['remember_token' => hash('sha256', $rememberToken)])->save();

        // Store remember token in localStorage
        session(['remember_token' => $rememberToken]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }




    public function login()
    {
        if (Auth::guard('admin_users')->check()) {
            return redirect()->route('dashboard'); // Redirect if already authenticated
        }
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        if (Auth::guard('admin_users')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard'); 
        }

        return redirect()->route('login')->with('error', 'Login failed. Please check your credentials.');
    }



    public function logout(Request $request)
    {
        // Clear authentication state
        Auth::guard('admin_users')->logout();

        // Remove remember token from database
        $user = $request->user('admin_users');
        if ($user) {
            $user->forceFill(['remember_token' => null])->save();
        }

        // Remove remember token from localStorage
        $request->session()->forget('remember_token');

        // Redirect to login page
        return redirect()->route('login');
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

    public function deletePermanentlyService($id)
{
    $service = Service::withTrashed()->findOrFail($id);
    
    
    if ($service->trashed()) {
        $service->forceDelete();
        return redirect()->route('admin.services')->with('success', 'Service permanently deleted successfully.');
    } else {
        // If the service is not soft deleted, you can handle this case based on your application logic
        return redirect()->route('admin.services')->with('error', 'Service not found or already permanently deleted.');
    }
}


    //Pet


    public function showPets()
    {
        $pets = Pet::paginate(10); // Paginate the active pets
        $softDeletedPets = Pet::onlyTrashed()->paginate(10); // Paginate the soft deleted pets
        return view('admin.pets', compact('pets', 'softDeletedPets'));
    }




    public function storePet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pet_type' => 'required|unique:pets',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       Pet::create([
            'pet_type' => $request->pet_type,
        ]);

        return redirect()->route('admin.pets')->with('success', 'Pet type created successfully.');
    }
    public function editPet($id)
    {
        $editPet = Pet::findOrFail($id);
        return view('admin.edit_pet', compact('editPet'));
    }


    public function updatePet(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pet_type' => 'required|unique:pets,pet_type,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pet = Pet::findOrFail($id);
        $pet->update([
            'pet_type' => $request->pet_type,
        ]);

        return redirect()->route('admin.pets')->with('success', 'Pet updated successfully.');
    }


    public function softDeletePet($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();
        return redirect()->route('admin.pets')->with('success', 'Pet soft deleted successfully.');
    }

    public function restorePet($id)
    {
        $pet = Pet::withTrashed()->findOrFail($id);
        $pet->restore();
        return redirect()->route('admin.pets')->with('success', 'Pet restored successfully.');
    }

    public function deletePermanentlyPet($id)
{
    $pet = Pet::withTrashed()->findOrFail($id);
    
    // If the pet exists and is soft deleted, permanently delete it
    if ($pet->trashed()) {
        $pet->forceDelete();
        return redirect()->route('admin.pets')->with('success', 'Pet permanently deleted successfully.');
    } else {
        // If the pet is not soft deleted, you can handle this case based on your application logic
        return redirect()->route('admin.pets')->with('error', 'Pet not found or already permanently deleted.');
    }
}

    public function getBookingCounts()
    {
        $pendingCount = Booking::where('status', 'pending')->count();
        $approvedCount = Booking::where('status', 'approved')->count();
        $rejectedCount = Booking::where('status', 'rejected')->count();

        return [
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ];
    }


    // Method to display the forgot password form
    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    // Method to send the password reset link
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admin_users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = AdminUser::where('email', $request->email)->first();

        // Generate random token and PIN code
        $token = Str::random(60);
        $pinCode = mt_rand(10000, 99999); 

        // Update user's reset_password_token in database
        $user->update(['reset_password_token' => $token]);

        // Send email with password reset link and PIN code
        Mail::send('emails.reset_password', ['token' => $token, 'pin' => $pinCode], function ($message) use ($request) {
            $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            $message->to($request->email);
            $message->subject('Password Reset Request');
        });

        return redirect()->route('login')->with('success', 'Password reset link has been sent to your email.');
    }

    // Method to display the password reset form
    public function showResetPasswordForm($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

   


// Method to reset the password
// Method to reset the password
public function resetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:admin_users,email',
        'password' => 'required|confirmed|min:8',
        'token' => 'required'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find user by email and reset token
    $user = AdminUser::where('email', $request->email)
                     ->where('reset_password_token', $request->token)
                     ->first();

    if (!$user) {
        return redirect()->back()->with('error', 'Invalid token or email address.');
    }

    // Update user's password and clear reset token
    $user->update([
        'password' => Hash::make($request->password),
        'reset_password_token' => null
    ]);

    // Set success message in the session
    return redirect()->route('login')->with('success', 'Password has been reset successfully.');
}










public function index()
{
    $adminUsers = AdminUser::paginate(10);
    $softDeletedAdminUsers = AdminUser::onlyTrashed()->paginate(10); // Retrieve soft deleted admin users
    return view('admin.users', compact('adminUsers', 'softDeletedAdminUsers'));
}


    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:admin_users,email',
        'password' => 'required|min:8',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = AdminUser::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    if ($user) {
        return redirect()->route('admin.users.index')->with('success', 'Admin user created successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to create admin user. Please try again.');
    }
}
    public function edit($id)
    {
        $user = AdminUser::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admin_users,email,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = AdminUser::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin user updated successfully.');
    }

    public function destroy($id)
    {
        $user = AdminUser::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Admin user deleted successfully.');
    }

    public function softDelete($id)
    {
        $user = AdminUser::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Admin user soft deleted successfully.');
    }

    public function restore($id)
    {
        $user = AdminUser::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'Admin user restored successfully.');
    }
    public function deletePermanently($id)
{
    $user = AdminUser::withTrashed()->findOrFail($id);
    
    // Check if the user is already soft deleted
    if ($user->trashed()) {
        $user->forceDelete(); // Permanently delete the user
        return redirect()->route('admin.users.index')->with('success', 'Admin user permanently deleted successfully.');
    } else {
        return redirect()->route('admin.users.index')->with('error', 'Admin user cannot be permanently deleted as it is not soft deleted.');
    }
}
}
