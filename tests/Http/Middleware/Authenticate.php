<?php

namespace Dealskoo\Affiliate\Tests\Http\Middleware;

use Orchestra\Testbench\Http\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is(config('admin.route.prefix') . '/*')) {
                return route('admin.login');
            } elseif ($request->is(config('affiliate.route.prefix') . '/*')) {
                return route('affiliate.login');
            } else {
                return route('login');
            }
        }
    }
}
