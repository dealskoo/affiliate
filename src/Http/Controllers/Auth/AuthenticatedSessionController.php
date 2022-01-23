<?php

namespace Dealskoo\Affiliate\Http\Controllers\Auth;

use Dealskoo\Affiliate\Http\Controllers\Controller;
use Dealskoo\Affiliate\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('affiliate::auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(route('affiliate.dashboard'));
    }

    public function destroy(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('affiliate.login'));
    }
}
