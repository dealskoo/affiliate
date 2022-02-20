<?php

namespace Dealskoo\Affiliate\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Dealskoo\Affiliate\Contracts\Dashboard;
use Dealskoo\Affiliate\Contracts\Searcher;
use Dealskoo\Affiliate\Contracts\Support\DefaultDashboard;
use Dealskoo\Affiliate\Contracts\Support\DefaultSearcher;
use Dealskoo\Affiliate\Contracts\Support\DefaultWelcome;
use Dealskoo\Affiliate\Contracts\Welcome;
use Dealskoo\Affiliate\Menu\AffiliatePresenter;
use Illuminate\Support\ServiceProvider;
use Nwidart\Menus\Facades\Menu;

class AffiliateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/affiliate.php', 'affiliate');
        $this->app->bind(Welcome::class, DefaultWelcome::class);
        $this->app->bind(Dashboard::class, DefaultDashboard::class);
        $this->app->bind(Searcher::class, DefaultSearcher::class);
        $this->app->singleton('affiliate_menu', function () {
            Menu::create('affiliate_navbar', function ($menu) {
                $menu->enableOrdering();
                $menu->setPresenter(AffiliatePresenter::class);
                $menu->route('affiliate.dashboard', 'affiliate::affiliate.dashboard', [], ['icon' => 'uil-dashboard me-1']);
            });

            return Menu::instance('affiliate_navbar');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);

            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/affiliate.php' => config_path('affiliate.php')
            ], 'config');

            $this->publishes([
                __DIR__ . '/../../public' => public_path('vendor/affiliate')
            ], 'public');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/affiliate')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'affiliate');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'affiliate');

        AdminMenu::dropdown('affiliate::affiliate.affiliates_management', function ($menu) {
            $menu->route('admin.affiliates.index', 'affiliate::affiliate.affiliates', [], ['permission' => 'affiliates.index'])->order(1);
        }, ['icon' => 'uil-share-alt', 'permission' => 'affiliates.management'])->order(6);

        PermissionManager::add(new Permission('affiliates.management', 'Affiliates Management'));
        PermissionManager::add(new Permission('affiliates.index', 'Affiliates List'), 'affiliates.management');
        PermissionManager::add(new Permission('affiliates.show', 'View Affiliate'), 'affiliates.index');
        PermissionManager::add(new Permission('affiliates.edit', 'Edit Affiliate'), 'affiliates.index');

    }
}
