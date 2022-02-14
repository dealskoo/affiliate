<?php

namespace Dealskoo\Affiliate\Tests;

use Dealskoo\Affiliate\Facades\AffiliateMenu;
use Dealskoo\Affiliate\Providers\AffiliateServiceProvider;
use Dealskoo\Affiliate\Tests\Http\Kernel;

class TestCase extends \Dealskoo\Admin\Tests\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AffiliateServiceProvider::class
        ];
    }

    public function getPackageAliases($app)
    {
        return [
            'AffiliateMenu' => AffiliateMenu::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('auth.guards.affiliate', [
            'driver' => 'session',
            'provider' => 'affiliates',
        ]);
        $app['config']->set('auth.providers.affiliates', [
            'driver' => 'eloquent',
            'model' => \Dealskoo\Affiliate\Models\Affiliate::class,
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

    protected function setUp(): void
    {
        parent::setUp();
    }
}
