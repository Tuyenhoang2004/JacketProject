<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discount';
    use HasFactory;
    public function products()
        {
            return $this->hasMany(Product::class, 'DiscountID', 'DiscountID');
        }
}
