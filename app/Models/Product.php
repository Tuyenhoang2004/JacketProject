<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // đảm bảo trỏ đúng bảng
    protected $primaryKey = 'ProductID'; // nếu primary key không phải là 'id'
    public $timestamps = false; // nếu bảng không có created_at, updated_at
    public function discount()
        {
            return $this->belongsTo(Discount::class, 'DiscountID', 'DiscountID');
        }
}
