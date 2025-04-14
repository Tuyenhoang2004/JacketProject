<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'UserID';
    public $incrementing = true;
    public $timestamps = false;


    protected $fillable = [
        'UserName',
        'email',
        'UserPassword',
        'UserPhone',
        'UserAddress',
        'role',
    ];

    protected $hidden = [
        'UserPassword',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->UserPassword;
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if ($user->isDirty('UserPassword')) {
                $user->UserPassword = Hash::make($user->UserPassword);
            }
        });
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'UserID');
    }
}
