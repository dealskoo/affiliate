# Affiliate Center of [Dealskoo](https://www.dealskoo.com)

## Install

```base
$ composer require dealskoo\affiliate
```

### Publish vendor

```base 
$ php artisan vendor:publish --provider="Dealskoo\Affiliate\Providers\AffiliateServiceProvider" --tag=public
```

### Publish config

```base 
$ php artisan vendor:publish --provider="Dealskoo\Affiliate\Providers\AffiliateServiceProvider" --tag=config
```

### Publish lang

```base 
$ php artisan vendor:publish --provider="Dealskoo\Affiliate\Providers\AffiliateServiceProvider" --tag=lang
```

## Register Guards

Edit `config\auth.php`

```php
return [
    'guards' => [
        'affiliate' => [
            'driver' => 'session',
            'provider' => 'affiliates'
        ]
    ],
    'providers' => [
        'driver' => 'eloquent',
        'affiliates' => Dealskoo\Affiliate\Models\Affiliate::class
    ],
    'passwords' => [
        'affiliates' => [
            'provider' => 'affiliates',
            'table' => 'affiliate_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]
    ],
    
    'password_length' => 8,
];
```

```php
namespace App\Http\Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
       if (!$request->expectsJson()) {
            if ($request->is(config('affiliate.route.prefix') . '/*')) {
                return route('affiliate.login');
            } else {
                return route('login');
            }
       }
    }
```

```php
namespace App\Http\Middleware;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string|null ...$guards
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard == 'affiliate') {
                    return redirect(route('affiliate.dashboard'));
                } else {
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
```

## Add Listen

```php
<?php

namespace App\Providers;

use Dealskoo\Affiliate\Events\AffiliateRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AffiliateRegistered::class => [
            \Dealskoo\Affiliate\Listeners\SendEmailVerificationNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

```

## Add Middleware

`App\Http\Kernel.php`

```php
    protected $routeMiddleware = [
        'affiliate_locale' => \Dealskoo\Affiliate\Http\Middleware\AffiliateLocalization::class,
        'affiliate_active'=> \Dealskoo\Affiliate\Http\Middleware\ActiveAuth::class,
        'affiliate'=> \Dealskoo\Affiliate\Http\Middleware\Affiliate::class,
    ];
```

## Support

- [Dealskoo](https://www.dealskoo.com)
- [Best Deals](https://www.dealskoo.com/best_deals)
- [Promo Codes](https://www.dealskoo.com/promo_codes)
