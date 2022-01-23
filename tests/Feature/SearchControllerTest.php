<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.search'));
        $response->assertStatus(200);
    }
}
