<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
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
                ? new JsonResponse('', 204)
                : redirect()->intended(route('admin.dashboard'));
        }

        // Default to landing page for customers
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect()->intended(route('landing'));
    }
}
