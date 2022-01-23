<?php

namespace Dealskoo\Affiliate\Contracts;

use Illuminate\Http\Request;

interface Searcher
{
    public function handle(Request $request);
}
