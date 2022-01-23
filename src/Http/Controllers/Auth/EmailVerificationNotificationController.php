<?php

namespace Dealskoo\Affiliate\Http\Controllers\Auth;

use Dealskoo\Affiliate\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('affiliate.dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
