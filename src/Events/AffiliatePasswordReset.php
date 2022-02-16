<?php

namespace Dealskoo\Affiliate\Events;

use Dealskoo\Affiliate\Models\Affiliate;
use Illuminate\Queue\SerializesModels;

class AffiliatePasswordReset
{
    use SerializesModels;

    public $affiliate;

    public function __construct(Affiliate $affiliate)
    {
        $this->affiliate = $affiliate;
    }
}
