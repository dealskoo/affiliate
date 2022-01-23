<?php

namespace Dealskoo\Affiliate\Tests\Notifications;

use Dealskoo\Affiliate\Notifications\AffiliateNotification;

class AffiliateNotificationDemo extends AffiliateNotification
{
    protected function title($notifiable)
    {
        return '';
    }

    public function icon($notifiable)
    {
        return '';
    }

    public function message($notifiable)
    {
        return '';
    }

    public function data($notifiable)
    {
        return [];
    }

    public function view($notifiable)
    {
        return 'affiliate::nodata';
    }
}
