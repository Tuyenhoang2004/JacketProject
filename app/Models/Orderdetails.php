<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderDetails extends Model
{
    protected $table = 'orderdetails';
    protected $primaryKey = 'OrderDetailID';
    public $timestamps = false;
    public function product()
{
    return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
}

    public function Order()
    {
        return $this->hasMany(Order::class, 'OrderID');
    }



}
