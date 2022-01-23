<?php

namespace Dealskoo\Affiliate\Listeners;

use Dealskoo\Affiliate\Events\AffiliateRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailVerificationNotification
{
    public function handle(AffiliateRegistered $event)
    {
        if ($event->affiliate instanceof MustVerifyEmail && !$event->affiliate->hasVerifiedEmail()) {
            $event->affiliate->sendEmailVerificationNotification();
        }
    }
}
