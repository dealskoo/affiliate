<?php

namespace Dealskoo\Affiliate\Tests;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\Http\Kernel;

class TestCase extends \Dealskoo\Admin\Tests\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('auth.guards.affiliate', [
            'driver' => 'session',
            'provider' => 'affiliates',
        ]);
        $app['config']->set('auth.providers.affiliates', [
            'driver' => 'eloquent',
            'model' => Affiliate::class,
        ]);
        $app['config']->set('auth.passwords.affiliates', [
            'provider' => 'affiliates',
            'table' => 'affiliate_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]);
    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton(\Illuminate\Contracts\Http\Kernel::class, Kernel::class);
    }
}
