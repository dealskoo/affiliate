<?php

namespace Dealskoo\Affiliate\Traits;

use Dealskoo\Affiliate\Models\Affiliate;

trait HasAffiliate
{
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
