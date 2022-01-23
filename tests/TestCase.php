<?php

namespace Dealskoo\Affiliate\Tests;

use Dealskoo\Affiliate\Facades\AffiliateMenu;
use Dealskoo\Affiliate\Providers\AffiliateServiceProvider;
use Dealskoo\Affiliate\Tests\Http\Kernel;
use Illuminate\Encryption\Encrypter;

class TestCase extends \Orchestra\Testbench\TestCase
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

    public function ignorePackageDiscoveriesFrom()
    {
        return [];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:' . base64_encode(Encrypter::generateKey('AES-256-CBC')));
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);
        $app['config']->set('auth.guards.admin', [
            'driver' => 'session',
            'provider' => 'admins',
        ]);
        $app['config']->set('auth.providers.admins', [
            'driver' => 'eloquent',
            'model' => \Dealskoo\Admin\Models\Admin::class,
        ]);
        $app['config']->set('auth.passwords.admins', [
            'provider' => 'admins',
            'table' => 'admin_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]);

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

        $app['config']->set('auth.password_length', 8);
    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton(\Illuminate\Contracts\Http\Kernel::class, Kernel::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
