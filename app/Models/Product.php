<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'ProductID';
    public $timestamps = false;

    protected $fillable = [
        'ProductName',
        'Description',
        'Price',
        'Stock',
        'CategoryID',
        'Discount',
        'ImageURL'
    ];

    public function category()
    {
        return $this->belongsTo(Catalog::class, 'CategoryID', 'CatalogID');
    }

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
