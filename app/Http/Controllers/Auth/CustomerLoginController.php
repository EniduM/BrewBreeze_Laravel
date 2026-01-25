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

        // Find the user by email/username
        $user = \App\Models\User::where(Fortify::username(), $request->input(Fortify::username()))->first();

        // Check if user exists and password is correct
        if (!$user || !\Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                Fortify::username() => [__('auth.failed')],
            ]);
        }

        // Verify the user is a customer
        if (!$user->isCustomer()) {
            throw ValidationException::withMessages([
                Fortify::username() => ['Please use the admin login page.'],
            ]);
        }

        // Check if 2FA is enabled for this user
        if ($user->two_factor_secret) {
            // Store user ID in session for 2FA challenge
            $request->session()->put([
                'login.id' => $user->id,
                'login.remember' => $request->boolean('remember'),
            ]);

            // Redirect to 2FA challenge page
            return redirect()->route('two-factor.login');
        }

        // If no 2FA, log them in directly
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Redirect to landing page
        return redirect()->route('landing');
    }
}