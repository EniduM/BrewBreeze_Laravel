<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Auth as FirebaseAuth;

class FirebaseLoginController extends Controller
{
    public function login(Request $request, FirebaseAuth $firebaseAuth)
    {
        $idToken = $request->input('idToken');
        try {
            $verifiedIdToken = $firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $firebaseAuth->getUser($uid);
            $email = $firebaseUser->email;
            $name = $firebaseUser->displayName ?? $email;
            $phone = $firebaseUser->phoneNumber ?? null;

            // Find or create user
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $name,
                'phone' => $phone,
                'password' => bcrypt(str()->random(16)), // random password
            ]);
            Auth::login($user, true);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
    }
}
