<?php

namespace Dealskoo\Affiliate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Affiliate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('af')) {
            cookie('af_source', $request->get('af'), 1440);
        }
        return $next($request);
    }
}
