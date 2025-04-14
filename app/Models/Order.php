<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'OrderID';
    // Các thuộc tính mà bạn muốn Mass Assignment
    protected $fillable = [
        'UserID',
        'OrderDate',
        'TotalAmount',
        'StatusOrders',
        'customer_name',
        'address',
        'phone',
        'note',
        'created_at',     
        'updated_at',
    ];
    
    // Nếu bạn muốn sử dụng các thời gian như created_at và updated_at, bạn có thể thêm:
    
    public $timestamps = true;
}
