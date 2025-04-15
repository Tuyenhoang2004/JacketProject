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
    protected $fillable = [
        'OrderID',
        'ProductID',
        'Quantity',
        'UnitPrice',
    ];
    public function product()
{
    return $this->belongsTo(Product::class, 'ProductID', 'ProductID');
}

    public function order() 
    {
        return $this->belongsTo(Order::class, 'OrderID');
    }




}
