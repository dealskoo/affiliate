<?php

namespace Dealskoo\Affiliate\Tests\Feature\Auth;

use Dealskoo\Affiliate\Events\AffiliateEmailVerified;
use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Notifications\VerifyAffiliateEmail;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
        $affiliate = Affiliate::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.verification.notice'));

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        $affiliate = Affiliate::factory()->create([
            'email_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'affiliate.verification.verify',
            now()->addMinutes(60),
            ['id' => $affiliate->id, 'hash' => sha1($affiliate->email)]
        );

        $response = $this->actingAs($affiliate, 'affiliate')->get($verificationUrl);

        Event::assertDispatched(AffiliateEmailVerified::class);
        $this->assertTrue($affiliate->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('affiliate.dashboard'));
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $affiliate = Affiliate::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'affiliate.verification.verify',
            now()->addMinutes(60),
            ['id' => $affiliate->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($affiliate, 'affiliate')->get($verificationUrl);

        $this->assertFalse($affiliate->fresh()->hasVerifiedEmail());
    }

    public function test_resend_email()
    {
        Notification::fake();
        $affiliate = Affiliate::factory()->unverified()->create();

        $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.verification.send'));

        Notification::assertSentTo($affiliate, VerifyAffiliateEmail::class);
    }
}
