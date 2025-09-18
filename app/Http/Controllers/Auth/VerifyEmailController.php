<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        $request->fulfill();

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
    public function verifyOtp(Request $request) : RedirectResponse
{
    $request->validate([
        'code' => 'required|string',
    ]);

    $user = $request->user();

    $record = \App\Models\EmailVerification::where('user_id', $user->id)
        ->where('code', $request->code)
        ->latest()
        ->first();

    if (!$record) {
        return back()->withErrors(['code' => 'Invalid code.']);
    }

    if (now()->greaterThan($record->expire_date)) {
        return back()->withErrors(['code' => 'Code expired.']);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified(); 
    }

    session(['2fa_passed' => true]);

    $record->delete();

    return redirect()->route('dashboard')->with('status', 'Email verified!');
}

}
