<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.dashboard'));
        $response->assertStatus(200);
    }
}
