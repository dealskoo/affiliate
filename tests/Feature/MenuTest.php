<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Affiliate\Facades\AffiliateMenu;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        self::assertNotNull(AdminMenu::findBy('title', 'affiliate::affiliate.affiliates'));
        self::assertNotNull(AffiliateMenu::findBy('title', 'affiliate::affiliate.dashboard'));
    }
}
