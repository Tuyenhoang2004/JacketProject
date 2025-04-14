<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orderdetails'; // Tên bảng (nếu không theo chuẩn Laravel)

    protected $primaryKey = 'OrderDetailID'; // Khóa chính

    public $timestamps = false; // Nếu không có created_at và updated_at

    protected $fillable = [
        'OrderID',
        'ProductID',
        'Quantity',
        'UnitPrice',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID');
    }
}