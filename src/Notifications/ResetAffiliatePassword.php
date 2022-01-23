<?php

namespace Dealskoo\Affiliate\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetAffiliatePassword extends ResetPassword
{
    public function __construct($token)
    {
        parent::__construct($token);
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Reset Affiliate Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.affiliates.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }

    protected function resetUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route('affiliate.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
