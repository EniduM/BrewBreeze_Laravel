<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\LoginResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        // If already authenticated as admin, redirect to admin dashboard
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.admin-login');
    }

    /**
     * Handle admin login.
     */
    public function store(Request $request)
    {
        // Store login route in session
        $request->session()->put('login_route', 'admin');

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

        // Verify the user is an admin
        if (!$user->isAdmin()) {
            throw ValidationException::withMessages([
                Fortify::username() => ['Please use the customer login page.'],
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

        // Redirect to admin dashboard
        return redirect()->route('admin.dashboard');
    }
}