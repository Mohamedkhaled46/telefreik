<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'email',
        'mobile',
        'SUUID', // Social Media Unique User Identifer
        'loggedBy', // 'facebook' , 'google' , 'default'
        'country_id',
        'name',
        'image',
    ];

    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function customerDetails(): HasOne
    {
        return $this->hasOne(CustomerDetails::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function pnotifications(): HasMany
    {
        return $this->hasMany(Pnotification::class, 'id', 'customer_id');
    }

    public function latestOTPToken(): HasOne
    {
        return $this->hasOne(CustomerOTP::class)->latestOfMany();
    }

    public function OTPTokens(): HasMany
    {
        return $this->hasMany(CustomerOTP::class)->where('used', false)->latest();
    }
}
