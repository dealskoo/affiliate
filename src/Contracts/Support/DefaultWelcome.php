<?php

namespace Dealskoo\Affiliate\Contracts\Support;

use Dealskoo\Affiliate\Contracts\Welcome;
use Illuminate\Http\Request;
use function route;

class DefaultWelcome implements Welcome
{
    public function handle(Request $request)
    {
        return redirect(route('affiliate.dashboard'), 301);
    }
}
