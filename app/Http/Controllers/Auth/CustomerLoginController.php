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
        // Validate the request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Find the user by email
        $user = \App\Models\User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        // Verify the user is a customer
        if (!$user->isCustomer()) {
            return response()->json([
                'success' => false,
                'message' => 'Please use the admin login page.',
            ], 403);
        }

        // Log the user into the session
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Create Bearer token
        $tokenName = 'auth-token-' . now()->timestamp;
        $abilities = ['customer'];
        $token = $user->createToken($tokenName, $abilities)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }
}