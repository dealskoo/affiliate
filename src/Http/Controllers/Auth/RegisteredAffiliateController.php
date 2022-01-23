<?php

namespace Dealskoo\Affiliate\Http\Controllers\Auth;

use Dealskoo\Affiliate\Events\AffiliateRegistered;
use Dealskoo\Affiliate\Http\Controllers\Controller;
use Dealskoo\Affiliate\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisteredAffiliateController extends Controller
{
    public function create()
    {
        return view('affiliate::auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:affiliates'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:affiliates'],
            'password' => ['required', 'confirmed', Rules\Password::min(config('affiliate.password_length'))],
        ]);

        $affiliate = Affiliate::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new AffiliateRegistered($affiliate));

        $this->guard()->login($affiliate);

        return redirect(route('affiliate.dashboard'));
    }
}
