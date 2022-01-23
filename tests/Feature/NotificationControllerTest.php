<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\Notifications\AffiliateNotificationDemo;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.notification.list'));
        $response->assertStatus(200);
    }

    public function test_unread()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.notification.unread'));
        $response->assertStatus(200);
    }

    public function test_all_read()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.notification.all_read'));
        $response->assertStatus(302);
    }

    public function test_show()
    {
        $affiliate = Affiliate::factory()->create();
        $affiliate->notify(new AffiliateNotificationDemo());
        $notification = $affiliate->notifications->last();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.notification.show', $notification));
        $response->assertStatus(200);
    }
}
