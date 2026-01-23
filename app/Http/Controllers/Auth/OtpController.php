<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function showForm(Request $request)
    {
        if (!Session::has('otp:user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function send(Request $request, OtpService $otpService, SmsService $smsService)
    {
        $userId = Session::get('otp:user_id');
        $user = User::findOrFail($userId);
        $code = $otpService->generate($userId);
        $smsService->send($user->phone, "Your OTP code is: $code");
        return back()->with('status', 'OTP sent to your mobile number.');
    }

    public function verify(Request $request, OtpService $otpService)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $userId = Session::get('otp:user_id');
        if (!$userId) {
            return redirect()->route('login');
        }
        if ($otpService->validate($userId, $request->otp)) {
            Auth::loginUsingId($userId);
            Session::forget('otp:user_id');
            return redirect()->route('landing');
        }
        throw ValidationException::withMessages(['otp' => 'Invalid or expired OTP.']);
    }
}
