@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Enter OTP</h2>
        @if(session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <div class="mb-4">
                <label for="otp" class="block text-gray-700">OTP Code</label>
                <input id="otp" type="text" name="otp" required autofocus class="w-full border rounded px-3 py-2 mt-1" maxlength="6">
                @error('otp')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Verify OTP</button>
        </form>
        <form method="POST" action="{{ route('otp.send') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full bg-gray-200 text-gray-800 py-2 rounded">Resend OTP</button>
        </form>
    </div>
</div>
@endsection
