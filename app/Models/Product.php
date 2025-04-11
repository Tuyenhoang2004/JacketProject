<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 

class Product extends Model 
{ 
    protected $table = 'products'; 
    protected $primaryKey = 'ProductID'; 
    public $timestamps = false; 
    protected $fillable = [ 
        'ProductName', 
        'Description', 
        'Price', 
        'Stock', 
        'CategoryegoryID', // Đảm bảo tên trường trùng khớp
        'ImageURL'
    ]; 

    public function category() 
    { 
        return $this->belongsTo(Catalog::class, 'CategoryID', 'CatalogID'); // Sử dụng CatalogID
    } 
}
