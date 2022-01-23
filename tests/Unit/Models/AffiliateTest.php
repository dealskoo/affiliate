<?php

namespace Dealskoo\Affiliate\Tests\Unit\Models;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Notifications\ResetAffiliatePassword;
use Dealskoo\Affiliate\Notifications\VerifyAffiliateEmail;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class AffiliateTest extends TestCase
{
    use RefreshDatabase;

    public function test_avatar_url()
    {
        $affiliate = Affiliate::factory()->create();
        $affiliate->avatar = 'avatar.png';
        $this->assertEquals($affiliate->avatar_url, Storage::url($affiliate->avatar));
    }

    public function test_send_password_reset_notification()
    {
        Notification::fake();
        $affiliate = Affiliate::factory()->create();
        $affiliate->sendPasswordResetNotification('aaa');
        Notification::assertSentTo($affiliate, ResetAffiliatePassword::class);
    }

    public function test_send_email_verification_notification()
    {
        Notification::fake();
        $affiliate = Affiliate::factory()->create();
        $affiliate->sendEmailVerificationNotification();
        Notification::assertSentTo($affiliate, VerifyAffiliateEmail::class);
    }
}
