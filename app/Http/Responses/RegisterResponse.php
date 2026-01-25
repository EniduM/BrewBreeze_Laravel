<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = auth()->user();

        // Redirect based on user role
        if ($user && $user->isAdmin()) {
            return $request->wantsJson()
                ? new JsonResponse('', 201)
                : redirect()->route('admin.dashboard');
        }

        // Default to landing page for customers
        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect()->route('landing');
    }
}
