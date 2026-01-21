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

        // Verify the user is an admin
        if (!$user->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            throw ValidationException::withMessages([
                Fortify::username() => ['Please use the customer login page.'],
            ]);
        }

        // Use our custom LoginResponse for redirect
        $loginResponse = app(LoginResponse::class);
        return $loginResponse->toResponse($request);
    }
}