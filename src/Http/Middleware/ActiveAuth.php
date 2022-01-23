<?php

namespace Dealskoo\Affiliate\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ActiveAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user('affiliate') && $request->user('affiliate')->status) {
            return $next($request);
        } else {
            Auth::guard('affiliate')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect(route('affiliate.banned'));
        }
    }
}
