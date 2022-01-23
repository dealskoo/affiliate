<?php

namespace Dealskoo\Affiliate\Tests\Feature\Auth;

use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('affiliate.register'));

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post(route('affiliate.register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated('affiliate');
        $response->assertRedirect(route('affiliate.dashboard'));
    }
}
