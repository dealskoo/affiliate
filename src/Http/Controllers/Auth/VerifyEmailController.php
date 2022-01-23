<?php

namespace Dealskoo\Affiliate\Http\Controllers\Auth;

use Dealskoo\Affiliate\Events\AffiliateEmailVerified;
use Dealskoo\Affiliate\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('affiliate.dashboard'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new AffiliateEmailVerified($request->user()));
        }

        return redirect()->intended(route('affiliate.dashboard'));
    }
}
