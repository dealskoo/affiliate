<?php

namespace Dealskoo\Affiliate\Http\Controllers\Auth;

use Dealskoo\Affiliate\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail() ? redirect()->intended(route('affiliate.dashboard')) : view('affiliate::auth.verify-email');
    }
}
