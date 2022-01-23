<?php

namespace Dealskoo\Affiliate\Http\Controllers;

use Dealskoo\Affiliate\Contracts\Searcher;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function handle(Request $request, Searcher $searcher)
    {
        return $searcher->handle($request);
    }
}
