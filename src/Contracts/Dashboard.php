<?php

namespace Dealskoo\Affiliate\Contracts;

use Illuminate\Http\Request;

interface Dashboard
{
    public function handle(Request $request);
}
