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
        $this->assertNotNull(AdminMenu::findBy('title', 'affiliate::affiliate.affiliates_management'));
        $childs = AdminMenu::findBy('title', 'affiliate::affiliate.affiliates_management')->getChilds();
        $menu = collect($childs)->where('title', 'affiliate::affiliate.affiliates');
        $this->assertNotEmpty($menu);
        $this->assertNotNull(AffiliateMenu::findBy('title', 'affiliate::affiliate.dashboard'));
    }
}
