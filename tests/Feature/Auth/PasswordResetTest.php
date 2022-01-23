<?php

namespace Dealskoo\Affiliate\Tests\Feature\Auth;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Notifications\ResetAffiliatePassword;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get(route('affiliate.password.request'));

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $affiliate = Affiliate::factory()->create();

        $this->post(route('affiliate.password.email'), ['email' => $affiliate->email]);

        Notification::assertSentTo($affiliate, ResetAffiliatePassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $affiliate = Affiliate::factory()->create();

        $this->post(route('affiliate.password.email'), ['email' => $affiliate->email]);

        Notification::assertSentTo($affiliate, ResetAffiliatePassword::class, function ($notification) {
            $response = $this->get(route('affiliate.password.reset', $notification->token));

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $affiliate = Affiliate::factory()->create();

        $this->post(route('affiliate.password.email'), ['email' => $affiliate->email]);

        Notification::assertSentTo($affiliate, ResetAffiliatePassword::class, function ($notification) use ($affiliate) {
            $response = $this->post(route('affiliate.password.update'), [
                'token' => $notification->token,
                'email' => $affiliate->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
