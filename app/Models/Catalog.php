<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalog'; // Đảm bảo tên bảng là đúng
    protected $primaryKey = 'CatalogID'; // Tên cột khóa chính
    public $timestamps = false;

    protected $fillable = ['CatalogID', 'CatalogName'];

    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryID', 'CatalogID'); // Đảm bảo khóa ngoại đúng
    }
}
