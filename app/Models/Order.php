<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'OrderID';
    public $timestamps = false;

    protected $fillable = ['UserID', 'OrderDate', 'TotalAmount', 'StatusOrders'];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'orderdetails', 'OrderID', 'ProductID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function orderDetails()
        {
            return $this->hasMany(OrderDetails::class, 'OrderDetailID');
        }



}