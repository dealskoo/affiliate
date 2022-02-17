<?php

namespace Dealskoo\Affiliate\Events;

use Dealskoo\Affiliate\Models\Affiliate;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AffiliateRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $affiliate;

    public function __construct(Affiliate $affiliate)
    {
        $this->affiliate = $affiliate;
    }
}
