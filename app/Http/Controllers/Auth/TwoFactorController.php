<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function index()
    {
        return inertia('auth/TwoFactor'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $userId = session('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Session expired. Please login again.']);
        }

        $record = EmailVerification::where('user_id', $userId)
            ->where('code', $request->code)
            ->latest()
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Invalid code']);
        }

        if ($record->expire_date->isPast()) {
            return back()->withErrors(['code' => 'Code expired']);
        }

        //  Success
        Auth::loginUsingId($userId);

        session()->forget(['2fa:user:id', '2fa:otp']);
        $record->delete();

        return redirect()->route('dashboard')->with('status', 'Two-factor authentication successful!');
    }
}
