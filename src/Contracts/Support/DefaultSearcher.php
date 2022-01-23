<?php

namespace Dealskoo\Affiliate\Contracts\Support;

use Dealskoo\Affiliate\Contracts\Searcher;
use Illuminate\Http\Request;

class DefaultSearcher implements Searcher
{
    public function handle(Request $request)
    {
        return view('affiliate::dashboard');
    }
}
