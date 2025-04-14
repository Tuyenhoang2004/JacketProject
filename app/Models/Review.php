<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $timestamps = false;


    // Các trường có thể mass assign
    protected $table = 'reviews';
    protected $fillable = ['ProductID', 'UserID', 'Rating', 'Comment', 'ReviewDate'];

    // Mối quan hệ với model Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID'); // Quan hệ ngược, mỗi review thuộc về một sản phẩm
    }

    // Mối quan hệ với model User (nếu có)
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

}
