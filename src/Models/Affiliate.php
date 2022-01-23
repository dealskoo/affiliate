<?php

namespace Dealskoo\Affiliate\Models;

use Dealskoo\Affiliate\Notifications\ResetAffiliatePassword;
use Dealskoo\Affiliate\Notifications\VerifyAffiliateEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;

class Affiliate extends Authentication implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $appends = ['avatar_url'];

    protected $fillable = [
        'avatar',
        'name',
        'bio',
        'email',
        'password',
        'company_name',
        'website',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function getAvatarUrlAttribute()
    {
        return empty($this->avatar) ?
            Avatar::create($this->email)->toGravatar(['d' => 'identicon', 'r' => 'pg', 's' => 100]) :
            Storage::url($this->avatar);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetAffiliatePassword($token));
    }

    public function routeNotificationForMail($notification)
    {
        return [$this->email => $this->name];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyAffiliateEmail());
    }

}
