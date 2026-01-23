<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\LoginResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class CustomerLoginController extends Controller
{
    /**
     * Show the customer login form.
     */
    public function showLoginForm()
    {
        // If already authenticated as customer, redirect to dashboard
        if (Auth::check() && Auth::user()->isCustomer()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.customer-login');
    }

    /**
     * Handle customer login.
     */
    public function store(Request $request)
    {
        // Store login route in session
        $request->session()->put('login_route', 'customer');

        // Validate the request
        $request->validate([
            Fortify::username() => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt authentication
        if (!Auth::attempt(
            $request->only(Fortify::username(), 'password'),
            $request->boolean('remember')
        )) {
            throw ValidationException::withMessages([
                Fortify::username() => [__('auth.failed')],
            ]);
        }

        $user = Auth::user();

        // Verify the user is a customer
        if (!$user->isCustomer()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            throw ValidationException::withMessages([
                Fortify::username() => ['Please use the admin login page.'],
            ]);
        }

        // MFA: If user has phone, require OTP
        if ($user->phone) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->put('otp:user_id', $user->id);
            return redirect()->route('otp.form');
        }

        // Redirect straight to landing page after successful login
        return redirect()->route('landing');
    }
}