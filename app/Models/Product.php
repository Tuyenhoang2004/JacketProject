<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'ProductID';
    public $timestamps = true;

    protected $fillable = ['ProductName', 'Description', 'Price', 'Stock', 'CategoryID', 'Discount', 'ImageURL'];

    public function orders()
        {
            return $this->belongsToMany(Order::class, 'orderdetails', 'ProductID', 'OrderID');
        }
    public function orderDetails()
        {
            return $this->hasMany(OrderDetails::class, 'ProductID', 'ProductID');
        }
    public function discount()
        {
            return $this->belongsTo(Discount::class, 'DiscountID', 'DiscountID');
        }
}
