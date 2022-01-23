<?php

namespace Dealskoo\Affiliate\Http\Controllers\Auth;

use Dealskoo\Affiliate\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    public function show()
    {
        return view('affiliate::auth.confirm-password');
    }

    public function store(Request $request)
    {
        if (!$this->guard()->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            return back()->withErrors([
                'password' => [__('The provided password does not match our records.')]
            ]);
        }

        $request->session()->passwordConfirmed();
        return redirect()->intended(route('affiliate.dashboard'));
    }
}
