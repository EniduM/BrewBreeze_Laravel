<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login user and return API token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        // Create token with scopes based on user role
        $tokenName = 'api-token-' . now()->timestamp;
        $abilities = $user->isAdmin() 
            ? ['admin'] 
            : ['customer'];

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

    /**
     * Logout user and revoke token.
     * 
     * This method ensures proper token invalidation by:
     * 1. Using currentAccessToken() - gets the exact token used for this request
     * 2. Calling delete() - permanently removes token from database (personal_access_tokens table)
     * 3. Once deleted, any future requests with this token will fail with 401 Unauthenticated
     * 4. Other tokens issued to this user or other users remain valid
     * 
     * Why this works:
     * - Sanctum validates tokens by checking the database on every request
     * - If token doesn't exist in DB, authentication fails
     * - delete() is Sanctum's recommended method (vs revoke() which is for Passport)
     */
    public function logout(Request $request): JsonResponse
    {
        // Delete the current access token from the database
        // This immediately invalidates the token - subsequent requests will get 401
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ], 200);
    }
}
