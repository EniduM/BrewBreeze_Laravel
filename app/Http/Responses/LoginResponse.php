<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $loginRoute = $request->session()->get('login_route', 'customer');
        
        // Clear the login route from session
        $request->session()->forget('login_route');
        
        $user = $request->user();
        
        // If user is admin, redirect to admin dashboard
        if ($user && $user->isAdmin()) {
            // Validate that they used admin login route
            if ($loginRoute === 'admin' || $request->route()->getName() === 'admin.login.post') {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                // Admin trying to use customer login - logout and redirect to admin login
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->withErrors([
                    'email' => 'Please use the admin login page.'
                ]);
            }
        }
        
        // If user is customer, redirect to customer dashboard
        if ($user && $user->isCustomer()) {
            // Validate that they used customer login route
            if ($loginRoute === 'customer' || $request->route()->getName() === 'customer.login.post' || !$request->route()->getName()) {
                return redirect()->intended(route('dashboard'));
            } else {
                // Customer trying to use admin login - logout and redirect to customer login
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('customer.login')->withErrors([
                    'email' => 'Please use the customer login page.'
                ]);
            }
        }
        
        // Default redirect
        return redirect()->intended(route('dashboard'));
    }
}
