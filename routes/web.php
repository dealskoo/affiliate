<?php

use Dealskoo\Affiliate\Http\Controllers\AccountController;
use Dealskoo\Affiliate\Http\Controllers\Auth\AuthenticatedSessionController;
use Dealskoo\Affiliate\Http\Controllers\Auth\ConfirmablePasswordController;
use Dealskoo\Affiliate\Http\Controllers\Auth\EmailVerificationNotificationController;
use Dealskoo\Affiliate\Http\Controllers\Auth\EmailVerificationPromptController;
use Dealskoo\Affiliate\Http\Controllers\Auth\NewPasswordController;
use Dealskoo\Affiliate\Http\Controllers\Auth\PasswordResetLinkController;
use Dealskoo\Affiliate\Http\Controllers\Auth\RegisteredAffiliateController;
use Dealskoo\Affiliate\Http\Controllers\Auth\VerifyEmailController;
use Dealskoo\Affiliate\Http\Controllers\DashboardController;
use Dealskoo\Affiliate\Http\Controllers\LocalizationController;
use Dealskoo\Affiliate\Http\Controllers\NotificationController;
use Dealskoo\Affiliate\Http\Controllers\SearchController;
use Dealskoo\Affiliate\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'affiliate_locale'])->prefix(config('affiliate.route.prefix'))->name('affiliate.')->group(function () {

    Route::get('locale/{locale}', [LocalizationController::class, '__invoke'])->name('locale');

    Route::get('/banned', function () {
        return view('affiliate::auth.banned');
    })->name('banned');

    Route::middleware(['guest:affiliate'])->group(function () {
        Route::get('/', [WelcomeController::class, 'handle'])->name('welcome');

        Route::get('/register', [RegisteredAffiliateController::class, 'create'])->name('register');
        Route::post('/register', [RegisteredAffiliateController::class, 'store']);
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);
        Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
    });

    Route::middleware(['auth:affiliate'])->get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');

    Route::middleware(['auth:affiliate', 'signed', 'throttle:6,1'])->get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify');

    Route::middleware(['auth:affiliate', 'throttle:6,1'])->post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send');

    Route::middleware(['auth:affiliate', 'verified:affiliate.verification.notice', 'affiliate_active'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'handle'])->name('dashboard');

        Route::get('/search', [SearchController::class, 'handle'])->name('search');

        Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');

        Route::middleware(['throttle:6,1'])->post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::prefix('/account')->name('account.')->group(function () {
            Route::get('/', function () {
                return view('affiliate::account.profile');
            })->name('profile');

            Route::post('/', [AccountController::class, 'store'])->name('profile');

            Route::post('/avatar', [AccountController::class, 'avatar'])->name('avatar');

            Route::get('/email', function () {
                return view('affiliate::account.email');
            })->name('email');

            Route::middleware(['throttle:6,1'])->post('/email', [AccountController::class, 'email'])->name('email');

            Route::middleware(['signed', 'throttle:6,1'])->get('/email/verify/{hash}', [AccountController::class, 'emailVerify'])->name('email.verify');

            Route::get('/password', function () {
                return view('affiliate::account.password');
            })->name('password');

            Route::post('/password', [AccountController::class, 'password'])->name('password');
        });

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::name('notification.')->group(function () {
            Route::get('/notifications', [NotificationController::class, 'list'])->name('list');
            Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('unread');
            Route::get('/notifications/all_read', [NotificationController::class, 'allRead'])->name('all_read');
            Route::get('/notification/{notification}', [NotificationController::class, 'show'])->name('show');
        });

        Route::middleware(['password.confirm:affiliate.password.confirm'])->group(function () {

        });

    });
});
