<?php

namespace Dealskoo\Affiliate\Http\Controllers;

use Dealskoo\Affiliate\Contracts\Dashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function handle(Request $request, Dashboard $dashboard)
    {
        return $dashboard->handle($request);
    }
}
