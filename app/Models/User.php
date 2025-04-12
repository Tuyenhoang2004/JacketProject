<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function getAuthPassword()
        {
            return $this->UserPassword; // Tên cột password thật trong database
        }

    public function getAuthIdentifierName()
        {
            return 'UserEmail';
        }
        
    // Chỉ định cột khóa chính nếu không phải là 'id'
    protected $primaryKey = 'UserID';  // Thay 'UserID' bằng tên cột khóa chính của bạn

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'UserName',      // Tên người dùng
        'UserEmail',     // Email
        'UserPassword',  // Mật khẩu
        'UserPhone',     // Số điện thoại
        'UserAddress',   // Địa chỉ
    ];
    
    protected $hidden = [
        'UserPassword',  // Ẩn mật khẩu
        'remember_token',
    ];
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'UserEmail_verified_at' => 'datetime',
    ];
    public $timestamps = false; 
    // app/Models/User.php

    public function getEmailForPasswordReset()
    {
        return $this->UserEmail;
    }

    public function routeNotificationForMail($notification)
    {
        return $this->UserEmail;
    }

}

