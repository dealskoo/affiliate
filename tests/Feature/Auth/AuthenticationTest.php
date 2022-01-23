<?php

namespace Dealskoo\Affiliate\Tests\Feature\Auth;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get(route('affiliate.login'));

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $affiliate = Affiliate::factory()->create();

        $response = $this->post(route('affiliate.login'), [
            'email' => $affiliate->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('affiliate');
        $response->assertRedirect(route('affiliate.dashboard'));
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $affiliate = Affiliate::factory()->create();

        $this->post(route('affiliate.login'), [
            'email' => $affiliate->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_not_authenticate_inactive()
    {
        $response = $this->get(route('affiliate.banned'));
        $response->assertStatus(200);
    }

    public function test_user_authenticate_inactive()
    {
        $affiliate = Affiliate::factory()->inactive()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.dashboard'));
        $response->assertRedirect(route('affiliate.banned'));
    }

    public function test_user_logout()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.logout'));
        $response->assertRedirect(route('affiliate.login'));
    }
}
