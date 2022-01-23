<?php

namespace Dealskoo\Affiliate\Facades;

use Illuminate\Support\Facades\Facade;

class AffiliateMenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'affiliate_menu';
    }

}
