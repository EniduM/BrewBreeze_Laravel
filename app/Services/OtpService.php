<?php

namespace App\Services;

use App\Models\OtpCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OtpService
{
    public function generate($userId)
    {
        $code = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);

        // Remove any previous OTPs for this user
        OtpCode::where('user_id', $userId)->delete();

        $otp = OtpCode::create([
            'user_id' => $userId,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        return $code;
    }

    public function validate($userId, $code)
    {
        $otp = OtpCode::where('user_id', $userId)
            ->where('code', $code)
            ->first();

        if (!$otp || $otp->isExpired()) {
            return false;
        }

        // OTP is valid, delete it
        $otp->delete();
        return true;
    }
}
