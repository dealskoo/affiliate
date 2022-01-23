<?php

namespace Dealskoo\Affiliate\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AffiliateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.affiliates.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.affiliates.index', ['HTTP_X-Requested-With' => 'XMLHttpRequest']));
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.affiliates.show', $affiliate));
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.affiliates.edit', $affiliate));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.affiliates.update', $affiliate), [
            'status' => false
        ]);
        $response->assertStatus(302);
        $affiliate->refresh();
        $this->assertEquals(false, $affiliate->status);
    }
}
