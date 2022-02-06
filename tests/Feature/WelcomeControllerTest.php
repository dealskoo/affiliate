<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome()
    {
        $response = $this->get(route('affiliate.welcome'));
        $response->assertRedirect(route('affiliate.dashboard'));
    }
}
