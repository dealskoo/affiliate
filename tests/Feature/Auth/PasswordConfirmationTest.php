<?php

namespace Dealskoo\Affiliate\Tests\Feature\Auth;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $affiliate = Affiliate::factory()->create();

        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.password.confirm'));

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $affiliate = Affiliate::factory()->create();

        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.password.confirm'), [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $affiliate = Affiliate::factory()->create();

        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.password.confirm'), [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
