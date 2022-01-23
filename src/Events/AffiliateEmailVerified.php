<?php

namespace Dealskoo\Affiliate\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AffiliateEmailVerified
{
    use SerializesModels;

    public $affiliate;

    public function __construct($affiliate)
    {
        $this->affiliate = $affiliate;
    }
}
