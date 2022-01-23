<?php

namespace Dealskoo\Affiliate\Contracts\Support;

use Dealskoo\Affiliate\Contracts\Dashboard;
use Illuminate\Http\Request;

class DefaultDashboard implements Dashboard
{
    public function handle(Request $request)
    {
        return view('affiliate::dashboard');
    }
}
