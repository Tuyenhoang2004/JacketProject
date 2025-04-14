<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'ProductID';
    public $timestamps = false; // Giữ false nếu bảng không có created_at, updated_at

    protected $fillable = [
        'ProductName',
        'Description',
        'Price',
        'Stock',
        'CategoryID',
        'Discount',
        'ImageURL'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'CategoryID', 'CatalogID');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orderdetails', 'ProductID', 'OrderID');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetails::class, 'ProductID', 'ProductID');
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class, 'DiscountID', 'DiscountID');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'ProductID');
    }
}