<?php

namespace Dealskoo\Affiliate\Contracts;

use Illuminate\Http\Request;

interface Welcome
{
    public function handle(Request $request);
}
