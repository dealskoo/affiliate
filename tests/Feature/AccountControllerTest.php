<?php

namespace Dealskoo\Affiliate\Tests\Feature;

use Dealskoo\Affiliate\Models\Affiliate;
use Dealskoo\Affiliate\Notifications\EmailChangeNotification;
use Dealskoo\Affiliate\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.account.profile'));
        $response->assertStatus(200);
    }

    public function test_update_profile()
    {
        $affiliate = Affiliate::factory()->create();
        $affiliate1 = Affiliate::factory()->make();
        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.account.profile'), $affiliate1->only([
            'name',
            'bio',
            'company_name',
            'website'
        ]));
        $response->assertStatus(302);
        $affiliate->refresh();
        $this->assertEquals($affiliate1->name, $affiliate->name);
    }

    public function test_avatar()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.account.avatar'), [
            'file' => UploadedFile::fake()->image('file.jpg')
        ]);
        $response->assertStatus(200);
    }

    public function test_email()
    {
        $affiliate = Affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.account.email'));
        $response->assertStatus(200);
    }

    public function test_update_email()
    {
        Notification::fake();
        $affiliate = Affiliate::factory()->create();
        $affiliate1 = Affiliate::factory()->make();
        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.account.email'), $affiliate1->only([
            'email'
        ]));
        $response->assertStatus(302);
        Notification::assertSentTo(Notification::route('mail', $affiliate1->email), EmailChangeNotification::class);
    }

    public function test_email_verify()
    {
        Notification::fake();
        $affiliate = Affiliate::factory()->create();
        $affiliate1 = Affiliate::factory()->make();
        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.account.email'), $affiliate1->only([
            'email'
        ]));
        $response->assertStatus(302);
        Notification::assertSentTo(Notification::route('mail', $affiliate1->email), EmailChangeNotification::class, function ($notification) use ($affiliate) {
            $response = $this->actingAs($affiliate, 'affiliate')->get($notification->url);
            $response->assertSessionHasNoErrors();
            return true;
        });
    }

    public function test_password()
    {
        $affiliate = affiliate::factory()->create();
        $response = $this->actingAs($affiliate, 'affiliate')->get(route('affiliate.account.password'));
        $response->assertStatus(200);
    }

    public function test_update_password()
    {
        $password = '12345678';
        $new_password = '23456789';
        $affiliate = affiliate::factory()->create();
        $affiliate->password = bcrypt($password);
        $affiliate->save();
        $response = $this->actingAs($affiliate, 'affiliate')->post(route('affiliate.account.password'), [
            'password' => $password,
            'new_password' => $new_password,
            'new_password_confirmation' => $new_password
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
    }
}
