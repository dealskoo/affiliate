<?php
return [
    'route' => [
        'prefix' => env('AFFILIATE_ROUTE_PREFIX', 'affiliate')
    ],
    'title' => 'Affiliate',
    'logo' => '/vendor/affiliate/images/logo.svg',
    'logo_dark' => '/vendor/affiliate/images/logo_dark.svg',
    'logo_sm' => '/vendor/affiliate/images/logo_sm.svg',
    'logo_sm_dark' => '/vendor/affiliate/images/logo_sm_dark.svg',
    'password_length' => 8,
    'copyright' => '2014 - ' . date('Y') . ' ' . config('app.name'),
    'footer_menus' => [[
        'name' => 'about',
        'url' => 'affiliate.dashboard'
    ], [
        'name' => 'support',
        'url' => 'affiliate.register'
    ], [
        'name' => 'contact_us',
        'url' => 'affiliate.login'
    ]],
    'terms_and_conditions_url' => 'affiliate.login',
    'languages' => ['en' => [
        'icon' => '/vendor/affiliate/images/flags/us.svg',
        'name' => 'English'
    ], 'zh_CN' => [
        'icon' => '/vendor/affiliate/images/flags/cn.svg',
        'name' => '简体中文'
    ]],
];
