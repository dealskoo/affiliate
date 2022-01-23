<?php

namespace Dealskoo\Affiliate\Http\Controllers\Auth;

use Dealskoo\Affiliate\Events\AffiliatePasswordReset;
use Dealskoo\Affiliate\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    public function create(Request $request)
    {
        return view('affiliate::auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::min(config('affiliate.password_length'))],
        ]);

        $status = Password::broker('affiliates')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($affiliate) use ($request) {
                $affiliate->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new AffiliatePasswordReset($affiliate));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('affiliate.login')->withInput($request->only('email'))->with('status', __($status))
            : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }
}
